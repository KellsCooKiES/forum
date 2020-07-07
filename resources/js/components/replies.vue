<template>
<div class="mb-4">
    <div v-for="(reply, index) in items" >
        <reply :data="reply" @deleted="remove(index)"></reply>
    </div>
</div>
</template>

<script>
    import reply from './Reply.vue';

    export default {
       props:['data'],
        components:{
           reply,
        },

        data(){
           return {
               items: this.data
           }
        },
        methods:{
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
