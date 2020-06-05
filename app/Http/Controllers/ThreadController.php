<?php

namespace App\Http\Controllers;

use App\Thread;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ThreadController extends Controller
{



    public function __construct()
    {
        $this->middleware('auth')->only('store');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $threads= Thread::latest()->get();

         return view('threads.index', compact('threads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request)
    {



     $thread = new Thread;
     $thread->create([
         'user_id' => auth()->id(),
        'title' => request('title'),
         'body' => request('body'),
     ]);
     return redirect('/thread/'.$thread->id);
    }

    /**
     * Display the specified resource.
     *
     * @param Thread $thread
     * @return Response
     */
    public function show(Thread $thread)
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
     * @param  \Illuminate\Http\Request  $request
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
