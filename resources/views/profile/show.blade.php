
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
                @forelse($activities as $date => $activityCollection)
                    <h3 class="mt-3">{{ $date }}</h3>
                    <hr>
                    @foreach($activityCollection as $activity)
                        @if (view()->exists("profile.activities.{$activity->type}"))
                            @include("profile.activities.{$activity->type}")
                        @endif
                    @endforeach
                @empty
                    <p>There is no activity yet.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection
