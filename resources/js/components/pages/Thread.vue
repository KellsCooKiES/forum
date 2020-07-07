<template>

</template>

<script>
    import replies from "../replies.vue";
    export default {
        props: [
            'initialRepliesCount'
        ],
        components:{
            replies
        },
        data(){
            return {
                repliesCount: this.initialRepliesCount
            }
        }
    }
</script>

<style scoped>

</style>
