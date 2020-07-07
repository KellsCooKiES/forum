<template>
<div class="mb-4">
    <div v-for="(reply, index) in items" >
        <reply :data="reply" @deleted="remove(index)"></reply>
    </div>
    <new-reply class="mt-4" :endpoint="endpoint"  @created="add"></new-reply>
</div>
</template>

<script>
    import reply from './Reply.vue';
    import NewReply from "./NewReply";

    export default {
       props:['data'],
        components:{
           reply,NewReply
        },

        data(){
           return {
               items: this.data,
               endpoint: location.pathname+'/replies'
           }
        },
        methods:{
           add(reply){
                this.items.push(reply);

                this.$emit('added');
           },
           remove(index){
                this.items.splice(index,1);
                this.$emit('removed');
                flash('Reply was deleted!');
           }
        }
    }
</script>

<style scoped>

</style>
