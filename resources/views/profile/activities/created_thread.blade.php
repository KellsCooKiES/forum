@component('profile.activities.activity')
    @slot('heading')
        <span class="font-weight-bold">{{$profileUser->name}}</span> published a
        <a href="{{$activity->subject->path()}}">{{$activity->subject->title}}</a>
    @endslot
    @slot('body')
        {{ $activity->subject->body }}
    @endslot
@endcomponent
