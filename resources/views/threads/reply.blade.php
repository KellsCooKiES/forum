<reply :attributes="{{$reply}}" inline-template>
    <div id="reply-{{$reply->id}}" class="card mt-4">
        <div class="card-header">
            <div class="level">
            <span class="flex"><a href="/profiles/{{$reply->owner->name}}">
                    {{$reply->owner->name}}
                </a>
                said {{$reply->created_at->diffForHumans()}}
            </span>

                <div>

                    <form method="POST" action="/replies/{{$reply->id}}/favorites">
                        @csrf
                        <button type="submit"
                                class="btn btn-outline-secondary" {{ $reply->isFavorited() ? 'disabled':'' }}>
                            {{$reply->favorites_count}}
                            {{Str::plural('Favorite',$reply->favorites_count)}}
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div v-if="editing">
                <div class="form-group">
                    <textarea class="form-control" v-model="body"></textarea>
                </div>
                <button class="btn btn-sm btn-primary" @click="update" >Update</button>
                <button class="btn btn-sm btn-link" @click="editing = false">Cancel</button>
            </div>
            <div v-else v-text="body"></div>
        </div>
        @can('update',$reply)
            <div class="card-footer level ">
                <button class="btn btn-outline-dark btn-sm mr-1" @click="editing = true">Edit</button>

                <form method="post" action="/replies/{{$reply->id}}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger btn-sm">Delete reply</button>
                </form>
            </div>
        @endcan
    </div>
</reply>
