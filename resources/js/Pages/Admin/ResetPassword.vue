<template>
    <div class="container mt-5 pb-5">
      <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7">
          <div class="card bg-secondary shadow border-0">
            <div class="card-header bg-primary ">
              <div class="text-black-5 text-center mt-2 mb-3">
                  <h3>Reset Password</h3>
              </div>
            </div>
            <div class="card-body px-lg-5 py-lg-5">
              <form role="form" @submit.prevent="login">
                <div class="form-group mb-3">
                  <div class="input-group input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                    </div>
                    <input class="form-control" v-model="email" placeholder="Email" type="email" :class="{'border-danger':errors.email}">
                    <small v-show='errors.email' class="text-danger">{{errors.email}}</small>
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                    </div>
                    <input class="form-control" v-model="password" placeholder="New Password" type="password" :class="{'border-danger':errors.password}">
                    <small v-show='errors.password' class="text-danger">{{errors.password}}</small>
                  </div>
                </div>
                <div class="text-center">
                  <button type="submit" class="btn btn-primary" :disabled='loading'>
                    <div v-show="loading" class="spinner-border spinner-border-sm" role="status">
                    <span class="sr-only">Loading...</span>
                    </div>
                    Confirm
                    </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
</template>

<script>

export default {
    name:'Login',
    props:{errors:Object},
    data(){
        return{
            email:'',
            password:'',
            loading: false,

        }
    },
    created(){
        // For Notification
        const{success,error,info} = this.$page.props;
        if(success){
            this.$toastr.s(success);
        }else if(error){
            this.$toastr.e(error);
        }else if(info){
            this.$toastr.i(info);
        }
    },
    methods:{
        login(){
            const data = {'email':this.email,'password':this.password};
            this.$inertia.post('/reset/password',data,{
                onStart:()=>this.loading=true,
                onFinish:() => this.loading = false
            })
        }

    },

}
</script>
