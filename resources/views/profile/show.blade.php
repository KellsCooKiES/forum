
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="modal-header">
                    <h1>
                        {{$profileUser->name}}
                    </h1>
                </div>
                @foreach($activities as $date => $activityCollection)
                    <h3 class="mt-3" >{{ $date }}</h3>
                    <hr>
                    @foreach($activityCollection as $activity)
                        @include("profile.activities.{$activity->type}")
                    @endforeach
                @endforeach
{{--                {{$threads->links()}}--}}
            </div>
        </div>
    </div>
@endsection
