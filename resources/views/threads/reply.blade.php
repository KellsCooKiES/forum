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
                    <favorite :reply="{{ $reply }}"></favorite>
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
                <button type="submit" class="btn btn-outline-danger btn-sm" @click="destroy" >Delete</button>
            </div>
        @endcan
    </div>
</reply>
