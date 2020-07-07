<template>
    <div>
<!--    @if(auth()->check())-->
<!--    <form method="POST" action="/threads/{{$thread->id}}/replies">-->
        <div v-if="signedIn">
            <div class="form-group">
            <textarea class="form-control" id="body"
                      rows="5"
                      name="body"
                      placeholder="Have something to say?"
                      v-model="body"

            ></textarea>
            </div>
            <div class="align-items-end">
                <button type="submit"
                        class="btn btn-outline-primary"
                        @click="addReply">Post
                </button>
            </div>
        </div>


        <p class="text-center" v-else >
            Please <a href="/login">sign in</a>
            to participate in this discussion </p>


    </div>
</template>

<script>
    export default {
        props:[
            'endpoint'
        ],
        data(){
            return{
                body:'',

            }
        },
        computed:{
            signedIn(){
                return window.App.signedIn;
            }
        },
        methods:{
            addReply(){
                axios.post(this.endpoint,{ body:this.body })
                .then(response =>{
                    this.body = '';

                    flash('Your reply has been posted!');

                    this.$emit('created',response.data);
                } )
            }
        }

    }
</script>

<style scoped>

</style>
