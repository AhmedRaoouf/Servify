
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
                    <h3 class="h3 my-3 text-gray-800 ">Edit Service</h3>
                    @include('dashboard/inc/msg')

                    <form method="post" action="{{url("dashboard/services/$service->id")}}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>Language</label>
                            <select name="language_id" class="form-control">
                                <option value="1">English</option>
                                <option value="2">Arabic</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" value="{{$service->name}}" class="form-control" autofocus>
                        </div>

                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" class="form-control" rows="3">{{$service->description}}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="true">true</option>
                                <option value="false">false</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Image</label>
                            <input type="file" name="image">
                        </div>
                        <br>

                        <button type="submit" class="btn btn-primary">Confirm</button>
                        <a href="{{url('dashboard/services')}}" class="btn btn-danger">Cancle</a>
                    </form>
                    </div>
                    </div>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

