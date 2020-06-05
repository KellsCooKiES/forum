
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center ">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        <a href="">{{$thread->creator->name}}</a> posted:
                        {{$thread->title}}
                    </div>
                    <div class="card-body">
                        {{ $thread->body }}
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center pb-3">
            <div class="col-md-8 offset-md-2 ">

                @foreach($thread->replies as $reply)
                    @include('threads.reply')
                @endforeach
            </div>
        </div>
        @if(auth()->check())
            <div class="row justify-content-center">
                <div class="col-md-8 offset-md-2 ">
                    <form method="POST" action="/threads/{{$thread->id}}/replies">
                        @csrf
                        <div class="form-group">
                            <textarea class="form-control" id="body" rows="5" name="body" placeholder="Have something to say?"></textarea>
                        </div>
                        <div class="align-items-end">
                            <button type="submit" class="btn btn-outline-primary">Post</button>
                        </div>
                    </form>
                </div>
            </div>
        @else
            <div class="row justify-content-center pt-lg-2 ">
                <p>Please <a href="{{route('login')}}">sign in</a> to participate in this discussion </p>
            </div>
        @endif
    </div>
@endsection
