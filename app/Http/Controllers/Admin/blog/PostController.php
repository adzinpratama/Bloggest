<?php

namespace App\Http\Controllers\Admin\blog;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $posts = Post::all();
        if ($request->ajax()) {
            return view('pages._admin.post.list', compact('posts'));
        }
        return view('pages._admin.post.main', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return Auth()->user()->id;
        return view('pages._admin.post.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return response()->json($request->all());
        $rules = [
            'title' => 'required|string|max:200',
            'slug' => 'required|unique:posts,slug',
        ];
        if ($request->id) {
            $rules['slug'] = 'required|unique:posts,slug,' . decrypt($request->id);
        }
        $validate = Validator::make($request->all(), $rules);
        if ($validate->fails()) {
            return response()->json($validate->messages(), 400);
        }

        DB::beginTransaction();
        try {
            $data = [
                'title' => $request->title,
                'slug' => $request->slug,
                'status' => 'pending',
                'type' => 'post',
                'user_id' => Auth::user()->id
            ];
            if ($request->thumbnail) {
                $data['thumbnail'] = parse_url($request->thumbnail)['path'];
            }
            $data['description'] = $request->description ?? '';
            $data['content'] = $request->content ?? '';
            if (!$request->id) {
                $post = Post::create($data);
                if ($request->tag) $post->tags()->attach($request->tag);
                if ($request->category) $post->categories()->attach($request->category);
                $response['message'] = $request->title . ' Telah Dibuat';
            } else {
                $update = Post::find(decrypt($request->id));
                $update->update($data);
                $update->tags()->sync($request->tag);
                $update->categories()->sync($request->category);
                $response['message'] = $request->title . ' Telah Diperbarui';
            }

            $response['success'] = true;
            return response()->json($response);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json($th->getMessage(), 400);
        } finally {
            DB::commit();
        }
    }

    public function tinyupload(Request $request)
    {
        $imgpath = $request->file('file')->store('blog', 'public');
        return response()->json(['location' => '/' . $imgpath]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::where('id', decrypt($id))->first();
        return view('pages._admin.post.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function parentChild($categories, $checked)
    {
        $ctgs = [];
        foreach ($categories as $category) {
            $ctg['id'] = $category->id;
            $ctg['text'] = $category->title;
            if (@$category->node) {
                $ctg['state']['opened'] = true;
                $ctg['children'] = $this->parentChild($category->node, $checked);
            }
            if ($checked->contains($category->id)) {
                $ctg['state']['checked'] = true;
                // $current_checked = array_splice($checked, $category->id, 1);
            } else {
                $ctg['state']['checked'] = false;
            }
            $ctgs[] = $ctg;
        }
        return $ctgs;
    }
    public function list($id)
    {
        $categories = Category::with('node')->orderBy('sort')->onlyParent();;
        $post = Post::where('id', decrypt($id))->first();
        $checked = $post->categories()->get();
        $ctg = $this->parentChild($categories->get(), $checked);
        return response()->json($ctg);
    }

    public function edit($id)
    {
        $post = Post::where('id', decrypt($id))->first();
        $tags = $post->tags()->get();
        return view('pages._admin.post.create', [
            'post' => $post,
            'tags' => $tags
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $ids = explode(",", $id);
            $id = [];
            foreach ($ids as $idn) {
                $id[] = decrypt($idn);
            }
            Post::destroy($id);
            $response['status'] = 'success';
            $response['message'] = trans(
                'alert.form.message.deleting',
                [
                    'name' => 'Post'
                ]
            );
            return response()->json($response);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }
}
