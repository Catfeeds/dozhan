<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\CategoryRequest;
use App\Models\Category;
use App\Models\Resource;
use App\Transformers\CategoryTransformer;
use App\Transformers\WorkTransformer;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function __construct()
    {
        $this->middleware('api.auth')->except(['index','show']);
    }

    //获取分类列表
    public function index(){
        return $this->response->collection(Category::all(),new CategoryTransformer());
    }

    //新增分类
    public function store(CategoryRequest $request,Category $category){
        //权限验证
        $this->authorize('create',Category::class);

        $category->fill($request->all())->save();

        return $this->response->created();
    }

    //删除分类
    public function destroy(Category $category){
        //权限验证
        $this->authorize('destroy',$category);

        //删除分类
        $category->delete();

        //返回响应
        return $this->response->noContent();
    }

    //修改分类
    public function update(Category $category,CategoryRequest $request){
        //权限验证
        $this->authorize('update',Category::class);

        $data = $request->only(['name','icon_id','description']);

        $category->update($data);

        return $this->response->item($category,new CategoryTransformer());
    }

    public function show(Category $category){
        return $this->response->item($category,new CategoryTransformer());
    }

}
