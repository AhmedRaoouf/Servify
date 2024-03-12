
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                <div class="card shadow my-4">

                    <div class="card-body">

                    <!-- Page Heading -->
                    <h3 class="h3 my-3 text-gray-800 ">{{__('admin.newAdmin')}}</h3>
                    @include('dashboard/inc/msg')

                    <form method="post" action="{{url("dashboard/admins")}}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label >{{__('admin.name')}}</label>
                            <input type="text" name="name"  class="form-control"  autofocus>
                        </div>
                        <div class="form-group">
                            <label >{{__('admin.email')}}</label>
                            <input type="email" name="email"  class="form-control" >
                        </div>

                        <div class="form-group">
                            <label >{{__('admin.password')}}</label>
                            <input  name="password"  class="form-control" type="password" >
                        </div>
                        <div class="form-group">
                            <label >{{__('admin.phone')}}</label>
                            <input type="text" name="phone"  class="form-control" >
                        </div>
                        <div class="form-group">
                            <label >{{__('admin.image')}}</label>
                            <input type="file" name="image">
                        </div>
                        <br>

                        <button type="submit" class="btn btn-primary">{{__('admin.confirm')}}</button>
                        <a href="{{url('dashboard/admins')}}" class="btn btn-danger">{{__('admin.cancel')}}</a>
                        </form>
                    </div>
                    </div>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

