<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Reply;
use App\Thread;
use Illuminate\Http\Request;

class ReplyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Channel $channel,Thread $thread)
    {

      $data = \request()->validate([
          'body'=>'required'
      ]);
      $reply= $thread->addReply([
            'body' => $data['body'],
            'user_id' => auth()->id()
        ]);

        if (\request()->expectsJson()){
            return $reply->load('owner');
        }
        return back()->with('flash','Your reply has been left.');
    }

    public function delete(Reply $reply)
    {
//        if ($reply->user_id != auth()->id()){
//            return response([],403);
//        }
        $this->authorize('update',$reply);
        $reply->delete();

        if( \request()->expectsJson()){
            return  response(['status'=>'Reply deleted']);
        }
        return back();
    }

    public function update(Reply $reply)
    {
        $this->authorize('update',$reply);
       $reply->update(['body'=>\request('body')]);
    }

}
