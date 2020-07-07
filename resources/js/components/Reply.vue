
<template>
    <div :id="'reply-'+id" class="card mt-4">
        <div class="card-header">
            <div class="level">
            <span class="flex">
                <a :href="'/profiles/'+data.owner.name"
                   v-text="data.owner.name">

                </a>
                said {{ data.created_at }}
            </span>
                <div v-if="singedIn">
                    <favorite :reply="data"></favorite>
                </div>

            </div>
        </div>
        <div class="card-body">
            <div v-if="editing">
                <div class="form-group">
                    <textarea class="form-control" v-model="body"></textarea>
                </div>
                <button class="btn btn-sm btn-primary" @click="update">Update</button>
                <button class="btn btn-sm btn-link" @click="editing = false">Cancel</button>
            </div>
            <div v-else v-text="body"></div>
        </div>
        <div class="card-footer level" v-if="canUpdate">
            <button class="btn btn-outline-dark btn-sm mr-1" @click="editing = true">Edit</button>
            <button type="submit" class="btn btn-outline-danger btn-sm" @click="destroy">Delete</button>
        </div>
    </div>


</template>
<script>
    import favorite from './Favorite.vue';
    export default {

        props:['data'],
        components :{
            favorite,
        },

        data() {
            return {
                id: this.data.id,
                editing: false,
                body: this.data.body
            }
        },
        computed:{
            singedIn(){
              return    window.App.singedIn;
            },
            canUpdate(){
              return  this.authorize(user => this.data.user_id == user.id);
            }
        },
        methods: {
            update() {
                axios.patch('/replies/'+ this.data.id,{
                    body: this.body
                });
                this.editing = false;

                flash('Updated!');
            },
            destroy(){
                axios.delete('/replies/'+this.data.id);
                this.$emit('deleted',this.data.id)
            },

        }
    }
</script>

