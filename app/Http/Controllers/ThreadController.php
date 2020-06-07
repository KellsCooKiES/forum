<?php

namespace App\Http\Controllers;

use App\Thread;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ThreadController extends Controller
{



    public function __construct()
    {
        $this->middleware('auth')->except(['index','show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param null $channelId
     * @return Response
     */
    public function index($channelId = null)
    {
        if ($channelId) {
            $threads = Thread::where('channel_id', $channelId)->latest()->get();
            return view('threads.index', compact('threads'));
        } else {
            $threads = Thread::latest()->get();
            return view('threads.index', compact('threads'));
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('threads.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
     $thread = new Thread;

     $request->validate([
        'title'=>'required',
         'body'=>'required',
         'channel_id'=>'required|exists:channels,id',
     ]);
     $thread = $thread->create([
         'user_id' => auth()->id(),
        'title' => $request['title'],
         'body' => $request['body'],
         'channel_id'=>$request['channel_id']
     ]);
     return redirect($thread->path());
    }

    /**
     * Display the specified resource.
     *
     * @param $channelId
     * @param Thread $thread
     * @return Response
     */
    public function show($channelId,Thread $thread)
    {

        return view('threads.show', compact('thread'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Thread $thread
     * @return Response
     */
    public function edit(Thread $thread)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Thread $thread
     * @return Response
     */
    public function update(Request $request, Thread $thread)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Thread $thread
     * @return Response
     */
    public function destroy(Thread $thread)
    {
        //
    }
}
