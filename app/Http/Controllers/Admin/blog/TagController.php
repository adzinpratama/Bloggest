<?php

namespace App\Http\Controllers\Admin\blog;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tags = Tag::orderBy('created_at', 'DESC');
        // $tags = Tag::when($request->input('search', 'false'), function ($query) use ($request) {
        //     $query->where('title', 'like', "%$request->search%");
        // })->orderByDesc('created_at')->get();
        if ($request->ajax()) {
            if ($request->has('search')) {
                $tags->where('title', 'like', "%{$request->search}%");
            }
            return view(
                'pages._admin.tags.list',
                ['tags' => $tags->paginate(7)]
            )->render();
        }
        return view(
            'pages._admin.tags.index',
            ['tags' => $tags->paginate(6)]
        )->render();
    }

    public function list()
    {
        $tags = Tag::orderBy('title')->get();
        return response()->json($tags);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $request->validate([
        //     'title' => 'required|string|max:20',
        //     'slug' => 'unique:tags,slug|unique:categories,slug',
        //     'description' => 'required|string|max:250'
        // ]);
        $validate = Validator::make($request->all(), [
            'title' => 'required|string|max:20',
            'slug' => 'unique:tags,slug|unique:categories,slug',
        ], [], $this->attributes());

        if ($validate->fails()) {
            return response()->json($validate->messages(), 400);
        }
        try {
            Tag::create($request->all());
            $response['status'] = 'success';
            $response['message'] = trans(
                'alert.form.message.success',
                [
                    'name' => $request->title
                ]
            );
            return response()->json($response);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    private function attributes()
    {
        return [
            'title' => trans('form.input.title'),
            'slug' => trans('form.input.slug'),
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'title' => 'required|string|max:20',
            'slug' => 'unique:tags,slug|unique:categories,slug',
        ], [], $this->attributes());

        if ($validate->fails()) {
            return response()->json($validate->messages(), 400);
        }
        try {
            Tag::find(decrypt($id))->update($request->all());
            $response['status'] = 'success';
            $response['message'] = trans(
                'alert.form.message.updating',
                [
                    'name' => $request->title
                ]
            );
            return response()->json($response);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tag  $tag
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
            Tag::destroy($id);
            $response['status'] = 'success';
            $response['message'] = trans(
                'alert.form.message.deleting',
                [
                    'name' => 'Tag'
                ]
            );
            return response()->json($response);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
        // $ids = explode(",", $id);
        // return response()->json(['id' => $ids]);
    }
}
