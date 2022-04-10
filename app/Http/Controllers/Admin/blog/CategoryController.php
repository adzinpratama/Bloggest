<?php

namespace App\Http\Controllers\Admin\blog;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Expr\Cast\Object_;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $data['categories'] = Category::onlyParent()->orderBy('sort')->get();
        // if ($request->ajax()) {
        //     return view('pages._admin.category._category-list', $data);
        // }
        $categories = Category::with('node')->orderBy('sort');
        if ($request->has('keyword') && trim($request->keyword)) {
            $categories->search($request->keyword);
        } else {
            $categories->onlyParent();
        }
        $data['categories'] = $categories->paginate(5);
        return view('pages._admin.category.index', $data);
    }
    public function parentChild($categories)
    {
        $ctgs = [];
        foreach ($categories as $category) {
            $ctg['id'] = $category->id;
            $ctg['text'] = $category->title;
            if (!empty($category->node)) {
                $ctg['children'] = $this->parentChild($category->node);
            }
            $ctgs[] = $ctg;
        }
        return $ctgs;
    }

    public function list()
    {
        try {
            $categories = Category::with('node')->orderBy('sort')->onlyParent();
            $ctg = $this->parentChild($categories->get());
            return response()->json($ctg);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }

    public function select(Request $request)
    {
        $categories = [];
        if ($request->has('q')) {
            $search = $request->q;
            $categories = Category::select('id', 'title')->where('title', 'LIKE', "%$search%")->get();
        } else {
            $categories = Category::select('id', 'title')->onlyParent()->get();
        }
        return response()->json($categories);
    }

    public function sort(Request $request)
    {
        try {
            $data = $request->input('orderAll');
            foreach ($data as $sort => $id) {
                Category::find($id)->update(['sort' => $sort + 1]);
            }
            return response()->json([
                "status" => true,
                'alert_title' => trans('category.alert.sort.success.title'),
                'message' => trans('category.alert.sort.success.message')
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'alert_title' => trans('category.alert.sort.failed.title'),
                'message' => $th->getMessage()
            ], 400);
        }
    }

    public function hasNode($slug)
    {
        return Category::where('slug', $slug)->first()->parent_id ? true : false;
    }

    private function attributes()
    {
        return [
            'title' => trans('category.form.title'),
            'slug' => trans('category.form.slug'),
            'description' => trans('category.form.description')
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'title' => 'required|string|max:60',
            'slug' => 'unique:categories,slug',
            'description' => 'required|string|max:120'
        ], [], $this->attributes());
        if ($validate->fails()) {
            return response()->json($validate->messages(), Response::HTTP_BAD_REQUEST);
        }
        try {
            $category = Category::create([
                'title' => $request->title,
                'slug' => $request->slug,
                'description' =>  $request->description,
                'parent_id' => $request->parent
            ]);
            $response = [
                'hasNode' => $request->has('parent'),
                'created' => true,
                'id' => $category->id,
                'alert' => 'success',
                'alert_title' => trans('category.alert.create.title'),
                'message' => trans('category.alert.create.message', ['name' => $category->title])
            ];
            return response()->json($response);
        } catch (\Throwable $th) {
            $response = ['error' => true, 'message' => $th->getMessage()];
            return response()->json($response, 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        if ($category->parent_id) {
            $parent = Category::select('id', 'title')->where('id', $category->parent_id)->first();
        }
        return response()->json([
            'category' => $category,
            'parent' => $category->parent_id ? $parent : false
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        if ($category->parent_id) {
            $parent = Category::select('id', 'title')->where('id', $category->parent_id)->first();
        }
        return response()->json([
            'category' => $category,
            'parent' => $category->parent_id ? $parent : false
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $validate = Validator::make($request->all(), [
            'title' => 'required|string|max:60',
            'slug' => 'unique:categories,slug,' . $category->id,
            'description' => 'required|string|max:120'
        ], [], $this->attributes());
        if ($validate->fails()) {
            return response()->json($validate->messages(), Response::HTTP_BAD_REQUEST);
        }
        try {
            $category->update([
                'title' => $request->title,
                'slug' => $request->slug,
                'description' =>  $request->description,
                'parent_id' => $request->parent
            ]);
            $response = [
                'hasNode' => $request->has('parent'),
                'updated' => true,
                'id' => $category->id,
                'title' => $category->title,
                'move' => $category->wasChanged('parent_id'),
                'alert' => 'info',
                'alert_title' => trans('category.alert.update.title'),
                'message' => trans('category.alert.update.message', ['name' => $request->title])
            ];
            return response()->json($response);
        } catch (\Throwable $th) {
            $response = ['error' => true, 'message' => $th->getMessage()];
            return response()->json($response, 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        // $ids = explode(",", $id);
        // Category::destroy($ids);
        try {
            $category->delete();
            $response = [
                'alert' => 'success',
                'alert_title' => trans('category.alert.delete.title'),
                'message' => trans('category.alert.delete.message')
            ];
            return response()->json($response, 200);
        } catch (\Throwable $th) {
            $response = [
                'alert' => 'error',
                'message' => $th->getMessage(),
                'report' => report($th)
            ];
            return response()->json($response, 400);
        }
    }
}
