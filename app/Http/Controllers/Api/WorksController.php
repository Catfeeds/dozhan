<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\WorkRequest;
use App\Models\Resource;
use App\Models\Tag;
use App\Models\User;
use App\Models\Work;
use App\Transformers\WorkTransformer;

class WorksController extends Controller
{
    /*
     * 获取作品列表
     */
    public function index(WorkRequest $request,Work $work){
        //分页携带参数
        $appends['limit'] = (int)$request->limit ?? 20;

        //如果传递的作用域有效
        if (($scope = $request->scope) && (in_array($request->scope,$work->scopes))){
            $work = $work->$scope();
            //分页携带参数加上作用域
            $appends['scope'] = $scope;
        }

        $paginates = $work->paginate($appends['limit'])->appends($appends);

        //返回数据
        return $this->response->paginator($paginates,new WorkTransformer());
    }

    /*
     * 发布作品
     */
    public function store(WorkRequest $request,Work $work){
        //todo 由于更新了资源表的多态关联，这里需要在入库前赋值多态关联表数据
//        return '数据验证成功';
        //接收作品相关数据
        $work->fill($request->validated());

        //写入用户id
        $work->user_id = $this->user()->id;

        //入库
        $work->save();

        //这样做的目的就是为了填充modelable_id和modelable_type字段
        $work->resources()->saveMany([
            Resource::find($request->video_id),
            Resource::find($request->cover_id),
        ]);

        //标签数据
        if ($request->tags = json_decode($request->tags,true)){
            //进行一次数据过滤格式转换
            foreach ($request->tags as $k => $v){
                $request->tags[$k] = trim($v);
            }

            $tag_ids = [];

            foreach ($request->tags as $tag){
                $tag_ids[] = Tag::firstOrCreate(['name' => $tag])->toArray()['id'];
            }

            $work->tags()->sync($tag_ids);
        }

        return $this->response->created();
    }

    /*
     * 修改作品
     */
    public function update(Work $work,WorkRequest $request){
        //权限验证
        $this->authorize('update',$work);

        //更新作品数据
        $work->update(collect($request->validated())->only(['name','description','category_id','cover_id'])->toArray());

        //这样做的目的就是为了填充modelable_id和modelable_type字段
        if ($request->has('cover_id')){
            $work->resources()->saveMany([
                Resource::find($request->cover_id),
            ]);
        }

        //标签数据
        if ($request->tags = json_decode($request->tags,true)){
            //进行一次数据过滤格式转换
            foreach ($request->tags as $k => $v){
                $request->tags[$k] = trim($v);
            }

            $tag_ids = [];

            foreach ($request->tags as $tag){
                $tag_ids[] = Tag::firstOrCreate(['name' => $tag])->toArray()['id'];
            }

            $work->tags()->sync($tag_ids);
        }

        //返回Transformer
        return $this->response->item($work,new WorkTransformer());
    }

    /*
     * 软删除作品
     */
    public function destroy(Work $work){
        //权限验证
        $this->authorize('destroy',$work);

        //执行删除
        $work->delete();

        return $this->response->noContent();
    }

    /*
     * 获取被软删除的作品
     */
    public function destroys(){
        //权限验证
        $this->authorize('destroy',Work::class);

        return $this->response->paginator($this->user()->works()->withTrashed()->where('deleted_at','!=',null)->paginate(20),new WorkTransformer());
    }

    /*
     * 恢复已软删除的作品
     */
    public function restore($workId){
        if (!$work = Work::withTrashed()->find($workId)){
            return $this->response->errorNotFound();
        }

        //权限验证
        $this->authorize('destroy',$work);

        //恢复
        $work->restore();

        return $this->response->created();
    }

    /*
     * 彻底删除作品
     */
    public function forceDestroy($workId){

        if (!$work = Work::withTrashed()->find($workId)){
            return $this->response->errorNotFound();
        }

        //权限验证
        $this->authorize('destroy',$work);

        //执行删除
        $work->forceDelete();

        return $this->response->noContent();
    }

    /*
     * 作品详情
     */
    public function show(Work $work){
        return $this->response->item($work,new WorkTransformer());
    }

    /*
     * 获取某用户发布的作品列表
     */
    public function userIndex(User $user,WorkRequest $request){

        //分页携带参数
        $appends['limit'] = (int)$request->limit ?? 20;

        $work = $user->works();
        //如果传递的作用域有效
        if (($scope = $request->scope) && (in_array($request->scope,$work->first()->scopes))){
            $work = $work->$scope();
            //分页携带参数加上作用域
            $appends['scope'] = $scope;
        }

        $paginates = $work->paginate($appends['limit'])->appends($appends);

        return $this->response->paginator($paginates,new WorkTransformer());
    }
}
