@component('profile.activities.activity')
    @slot('heading')
        <span class="font-weight-bold">{{$profileUser->name}}</span> reply to <a href="{{$activity->subject->thread->path()}}">
            "{{$activity->subject->thread->title}}"</a>
    @endslot
    @slot('body')
        {{ $activity->subject->body }}
    @endslot
@endcomponent
