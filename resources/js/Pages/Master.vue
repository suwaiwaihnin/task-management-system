<template>
    <div>
        <nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
        <div class="container-fluid">
      <!-- Toggler -->
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <!-- Collapse -->
      <div class="collapse navbar-collapse" id="sidenav-collapse-main">
        <!-- Collapse header -->
        <div class="navbar-collapse-header d-md-none">
          <div class="row">
            <div class="col-6 collapse-close">
              <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                <span></span>
                <span></span>
              </button>
            </div>
          </div>
        </div>
        <!-- Navigation -->
        <ul class="navbar-nav">
          <li class="nav-item  active ">
            <inertia-link class="nav-link  active " href="/task">
              <i class="ni ni-tv-2 text-primary"></i> All Task List
            </inertia-link>
          </li>
          <li class="nav-item  active ">
            <inertia-link class="nav-link  active " href="/create">
              <i class="ni ni-air-baloon  text-primary"></i> Create Task
            </inertia-link>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="main-content">
    <!-- Navbar -->
    <nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
      <div class="container-fluid">
        <!-- Brand -->
        <inertia-link class="h4 mb-0 text-white text-uppercase d-none d-lg-inline-block" href="/task">Task Management System</inertia-link>
        <!--  Search Form -->
        <form  @submit.prevent='searchTask' class="navbar-search navbar-search-dark form-inline mr-3 d-none d-md-flex ml-lg-auto">
          <div class="form-group mb-0">
            <div class="input-group input-group-alternative">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-search"></i></span>
              </div>
              <input class="form-control" placeholder="Search by Title" type="text" v-model="search">
            </div>
          </div>
        </form>
        <!-- User -->
        <ul class="navbar-nav align-items-center d-none d-md-flex">
          <li class="nav-item dropdown">
            <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <div class="media align-items-center">
                    <div class="media-body ml-2 d-none d-lg-block">
                        <span class="mb-0 text-sm  font-weight-bold">{{$page.props.auth.name}}</span>
                    </div>
              </div>
            </a>
            <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
              <div class=" dropdown-header noti-title">
                <h6 class="text-overflow m-0">Welcome!</h6>
              </div>
              <div class="dropdown-divider"></div>
              <inertia-link href="/logout" class="dropdown-item">
                <i class="ni ni-user-run"></i>
                <span>Logout</span>
              </inertia-link>
            </div>
          </li>
        </ul>
      </div>
    </nav>
    <!-- End Navbar -->

    <!-- Header -->
    <div class="header bg-gradient-primary pb-2 pt-5 pt-md-6">
    </div>

    <!-- Body -->
    <div class="container-fluid mt-5">
        <div class="header-body">
            <slot />
        </div>
    </div>
  </div>
</div>
</template>

<script>
export default {
    name:'Master',
    data(){
        return{
            search: ''
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
        searchTask(){
            this.$inertia.get('/task/search/'+this.search);
        }
    },
     watch:{
        '$page.props.success' :function(value){
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
</script>
