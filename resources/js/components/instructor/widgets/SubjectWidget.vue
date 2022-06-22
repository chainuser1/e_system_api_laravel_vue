<template>
    <div class="small-box" :class="randomClass">
        <div class="inner">
            <p>
                <strong>{{ subject.name }}</strong>
            </p>
            <p>{{ subject.code }}</p>
        </div>
        <div class="icon">
            <i class="ion ion-bag"></i>
        </div>
        <router-link class="small-box-footer" 
            :to="{name:'instructor-subject-ilearn',params:{id:this.subject.id}}">
            More info 
            <i class="fas fa-arrow-circle-right">
            </i>
        </router-link>
    </div>
</template>

<script>
export default {
    name: 'SubjectWidget',
    props: ['subject'],
    computed:{
        randomClass() {
            let classes = ['bg-primary', 'bg-success', 'bg-info', 'bg-warning', 'bg-danger'];
            return classes[Math.floor(Math.random() * classes.length)];
        }
    }
}
</script>

<style>

</style>