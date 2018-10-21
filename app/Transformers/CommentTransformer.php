<?php
namespace App\Transformers;

use App\Models\Comment;
use App\Models\User;
use League\Fractal\TransformerAbstract;

class CommentTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['user','av','replies'];

    public function transform(Comment $comment){
        return [
            'id' => $comment->id,
            'comment' => $comment->comment,
            'user_id' => $comment->user_id,
            'av_id' => $comment->av_id,
            'parent_id' => $comment->parent_id,
            'target_id' => $comment->target_id,
            'created_at' => $comment->created_at->toDateTimeString(),
            'updated_at' => $comment->updated_at->toDateTimeString(),
        ];
    }

    public function includeUser(Comment $comment){
        return $this->item($comment->user,new UserTransformer());
    }

    public function includeAv(Comment $comment){
        return $this->item($comment->av,new AvTransformer());
    }

    public function includeReplies(Comment $comment){
        return $this->collection($comment->replies,new ReplyTransformer());
    }

}