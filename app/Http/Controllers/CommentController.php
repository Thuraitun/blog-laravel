<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

use Illuminate\Support\Facades\Gate;


class CommentController extends Controller
{
    public function delete($id)
    {
        $comment = Comment::find($id);
        if(Gate::allows("comment-delete", $comment)){
            $comment->delete();
            return back()->with('info', "A comment deleted");
        }

        return back()->with("info", "Unauthorize to delete");
    }

    public function create()
    {
        $comment = new Comment;
        $comment->content = request()->content;
        $comment->article_id = request()->article_id;
        $comment->user_id = auth()->user()->id;
        $comment->save();

        return back()->with("info", "New comment added");
    }
}
