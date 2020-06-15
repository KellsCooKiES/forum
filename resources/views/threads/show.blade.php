
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row  ">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="level">
                            <span class="flex"><a href="/profiles/{{{$thread->creator->name}}}">
                                    {{$thread->creator->name}}</a> posted:
                                    {{$thread->title}}
                            </span>
                            @can('update', $thread)
                                <form action="{{$thread->path()}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger">Delete Thread</button>
                                </form>
                            @endcan
                        </div>
                    </div>
                    <div class="card-body">
                        {{ $thread->body }}
                    </div>
                </div>
                <div class="mb-4">
                    @foreach($replies as $reply)
                        @include('threads.reply')
                    @endforeach
                </div>
                {{$replies->links()}}

                @if(auth()->check())
                    <form method="POST" action="/threads/{{$thread->id}}/replies">
                        @csrf
                        <div class="form-group">
                            <textarea class="form-control" id="body" rows="5" name="body"
                                      placeholder="Have something to say?"></textarea>
                        </div>
                        <div class="align-items-end">
                            <button type="submit" class="btn btn-outline-primary">Post</button>
                        </div>
                    </form>
                @else
                    <div class="row justify-content-center pt-lg-2 ">
                        <p>Please <a href="{{route('login')}}">sign in</a> to participate in this discussion </p>
                    </div>
                @endif
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <p>This thread was published {{$thread->created_at->diffForHumans()}} by
                            <a href="">{{ $thread->creator->name }}
                                , and currently has {{$thread->replies_count}} {{ Str::plural('comment',$thread->replies_count) }} .
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
