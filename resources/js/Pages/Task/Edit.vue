<template>
    <Master>
        <vue-confirm-dialog></vue-confirm-dialog>
        <div class="row">
            <div class="col-md-10">
            <div class="card-header bg-primary">
                    <h3 class="text-white">
                        Update Task
                    </h3>
            </div>
            <div class="card">
                <div class="card-body">
                    <inertia-link class="btn btn-sm btn-dark" href='/task'>Back</inertia-link>
                    <form @submit.prevent="store">
                        <div class="form-group">
                            <label for="">Enter Title</label>
                            <input type="text" name='title' v-model="title" class="form-control" :class="{'border-danger':errors.title}">
                            <small v-show='errors.title' class="text-danger">{{errors.title}}</small>
                        </div>
                        <div class="form-group">
                            <label>Choose Schedule Date</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"></span>
                                </div>
                                <input class="form-control" placeholder="Select date" type="date" name='schedule_date' v-model='schedule_date' :class="{'border-danger':errors.schedule_date}">
                                <small v-show='errors.schedule_date' class="text-danger">{{errors.schedule_date}}</small>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Choose Complete Date</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                <span class="input-group-text"></span>
                            </div>
                            <input class="form-control" placeholder="Select date" type="date" name='complete_date' v-model='complete_date' :class="{'border-danger':errors.complete_date}">
                            <small v-show='errors.complete_date' class="text-danger">{{errors.complete_date}}</small>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Choose Priority</label>
                            <select class="browser-default custom-select" v-model="priority" @change="onChange($event)"  :class="{'border-danger':errors.priority}">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                            <small v-show='errors.priority' class="text-danger">{{errors.priority}}</small>
                        </div>
                        <div class='text-center'>
                            <button type="submit" class="btn btn-primary" :disabled='loading'>
                                <div  v-show='loading' class="spinner-border spinner-border-sm" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                                Update
                            </button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
       </div>
    </Master>
</template>

<script>
import Master from '../Master.vue'
export default {
    name:'UpdateTask',
    components:{Master},
     props: {errors:Object,task:Object},
    data(){
        return{
            title: '',
            schedule_date: '',
            complete_date: '',
            priority: '',
            loading:false
        }
    },
    created(){
        this.title = this.task.title;
        this.schedule_date = this.task.schedule_date;
        this.complete_date = this.task.complete_date;
        this.priority = this.task.priority;

    },
    methods:{
        store(){
             this.$confirm(
                {
                    message: 'Are you sure to update?',
                    button: {
                        no: 'No',
                        yes: 'Yes'
                    },
                    callback: confirm => {
                        if (confirm) {
                            this.loading = true;
                            const data = new FormData();
                            data.append('title',this.title);
                            data.append('schedule_date',this.schedule_date);
                            data.append('complete_date',this.complete_date);
                            data.append('priority',this.priority);
                            data.append('_method','PUT');
                            this.$inertia.post('/task/'+this.task.id,data,{
                                onStart:()=>this.loading=true,
                                onFinish:() => this.loading = false})
                            }
                        }
                });
        },
         watch:{
        '$page.props.success' : function(value){
            this.$toastr.s(value);
        },
        '$page.props.danger' :function(value){
            this.$toastr.e(value);
        },
        '$page.props.info' :function(value){
            this.$toastr.i(value);
        }
         }
    }
}
</script>


