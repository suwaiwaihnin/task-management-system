<template>
    <Master>
        <vue-confirm-dialog></vue-confirm-dialog>
        <!-- Complete Task -->
        <div class="row">
            <div class="col-md-12">
            <h3>Complete Task</h3>
                <div class="table-responsive">
                <!-- Projects table -->
                    <table class="table align-items-center table-striped">
                        <thead class="thead">
                            <tr>
                                <th scope="col">
                                    <!-- <input :disabled='emptyData()' type="checkbox" v-model="isSelect"> -->
                                </th>
                                <th scope="col">Title</th>
                                <th scope="col">Schedule_Date</th>
                                <th scope="col">Complete_Date</th>
                                <th scope="col">Priority</th>
                                <th scope="col">Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="t in complete_task.data" :key="t.id">
                                <td>
                                    <input :disabled='emptyData()' type="checkbox" v-model="selected" :value="`${t.id}`">
                                </td>
                                <td>{{t.title}}</td>
                                <td>{{t.schedule_date}}</td>
                                <td>{{t.complete_date}}</td>
                                <td>{{t.priority}}</td>
                                <td>
                                    <inertia-link :href='`/task/${t.id}/edit`' class="btn btn-sm btn-info">Edit</inertia-link>
                                </td>
                            </tr>
                            <!-- Check Data Exist-->
                            <tr v-if="emptyData()">
                                <td>
                                    <h4 class="text-danger text-center">Data Not Found!</h4>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Pagination and Actions -->
        <div class="row">
            <div class="col-md-6" v-if='!emptyData()'>
                <div class="">
                    <button class="btn btn-primary dropdown-toggle mr-4" :disabled='!isSelect' type="button" data-toggle="dropdown">Action</button>
                    <div class="dropdown-menu" >
                        <button  @click='remove(selected)'  type="button" class="dropdown-item">Delete</button>
                    </div>
                </div>
            </div>
            <div class="col-md-6 justify-content-end align-items-end">
                <Pagination :data='complete_task.links' />
            </div>
        </div>


        <!-- Divider -->
        <div class="wrapper">
            <div class="divider div-transparent div-dot"></div>
        </div>


        <!-- Incomplete Task -->
        <div class="row">
            <div class="col-md-12">
            <h3>Incomplete Task</h3>
                <div class="table-responsive">

                <!-- Projects table -->
                    <table class="table align-items-center table-striped">
                        <thead class="thead">
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">Title</th>
                                <th scope="col">Schedule_Date</th>
                                <th scope="col">Complete_Date</th>
                                <th scope="col">Priority</th>
                                <th scope="col">Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="t in incomplete_task.data" :key="t.id">
                                <td>
                                    <input :disabled='emptyIncompleteData()' type="checkbox" v-model="incompleteSelected" :value="`${t.id}`">
                                </td>
                                <td>{{t.title}}</td>
                                <td>{{t.schedule_date}}</td>
                                <td>{{t.complete_date}}</td>
                                <td>{{t.priority}}</td>
                                <td>
                                    <inertia-link :href='`/task/${t.id}/edit`'  class="btn btn-sm btn-info">Edit</inertia-link>
                                </td>
                            </tr>
                            <!-- Check Data Exist -->
                            <tr v-if="emptyIncompleteData()">
                                <td>
                                    <h4 class="text-danger text-center">Data Not Found!</h4>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Pagination and Actions -->
        <div class="row">
            <div class="col-md-6" v-if='!emptyIncompleteData()'>
                <div class="">
                    <button class="btn btn-primary dropdown-toggle mr-4" :disabled='!isSelectIncomplete' type="button" data-toggle="dropdown">Action</button>
                    <div class="dropdown-menu" >
                        <button  @click='removeIncomplete(incompleteSelected)'  type="button" class="dropdown-item">Delete</button>
                        <button  @click='makeComplete(incompleteSelected)'  type="button" class="dropdown-item">Make Complete</button>
                    </div>
                </div>
            </div>
            <div class="col-md-6 justify-content-end align-items-end">
                <Pagination :data='incomplete_task.links' />
            </div>
        </div>
    </Master>
</template>

<script>
import Master from '../Master.vue';
import Pagination from '../Pagination.vue'
export default {
    name:'Index',
    components:{Master,Pagination},
    props:{complete_task:Object,incomplete_task:Object},
    data(){
        return{
            selected:[],
            allSelected:false,
            isSelect:false,
            selectIncomplete:false,
            incompleteSelected : [],
            isSelectIncomplete: false,
        }
    },
    watch:{
        // Check values select or not
        selected : function(selected){
            if(this.selected.length > 0)
               this.isSelect = true;
            else
                this.isSelect = false;
        },
        incompleteSelected : function(incompleteSelected){
            if(this.incompleteSelected.length > 0)
               this.isSelectIncomplete = true;
            else
                this.isSelectIncomplete = false;
        }
    },
    methods:{
        selectAll()
        { if(!this.isSelect){
                    this.complete_task.forEach(t => {
                      this.selected.push(t.id)
                    });
                }else{
                    this.isSelect = false
                    this.selected = []
                }
            },
        // selectAll(){
        //     if(!allSelected){
        //         this.complete_task.forEach(t => {
        //               this.selected.push(t.id)
        //             });
        //     }else{
        //         this.isSelect = false;
        //         this.complete_task.forEach(t => {
        //               this.selected.push(t.id)
        //             });
        //     }
        // },
        emptyData(){
            if (this.complete_task.data.length < 1)
                return true;
        },
        remove(selected){
             this.$confirm(
                {
                    message: 'Are you sure to delete?',
                    button: {
                        no: 'No',
                        yes: 'Yes'
                    },
                    callback: confirm => {
                        const data = {data:selected};
                        if (confirm) {
                            this.$inertia.post('/task/delete',data);
                        }
                    }
                });
        },
        emptyIncompleteData(){
            if (this.incomplete_task.data.length < 1)
                return true;
        },
        selectIncompleteData()
        { if(this.isSelectIncomplete == false){
                    this.incomplete_task.forEach(t => {
                      this.isSelectIncomplete.push(t.id)
                    });
                }else{
                    this.isSelectIncomplete = false
                    this.isSelectIncomplete = []
                }
            },
            removeIncomplete(incompleteSelected){
                 this.$confirm(
                {
                    message: 'Are you sure to delete?',
                    button: {
                        no: 'No',
                        yes: 'Yes'
                    },
                    callback: confirm => {
                        const data = {data:incompleteSelected};
                        if (confirm) {
                            this.$inertia.post('/task/delete',data);
                        }
                    }
                });
        },
        makeComplete(incompleteSelected){
             this.$confirm(
                {
                    message: 'Are you sure to change status?',
                    button: {
                        no: 'No',
                        yes: 'Yes'
                    },
                    callback: confirm => {
                        const data = {data:incompleteSelected};
                        if (confirm) {
                            this.$inertia.post('/task/complete',data);
                        }
                    }
                });
        }
    }
}
</script>
