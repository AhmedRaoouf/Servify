
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
                    <form method="post" action="{{ url("dashboard/services/$service->id") }}" enctype="multipart/form-data">
                        @csrf
                        @method("PUT")
                        <div class="form-group">
                            <label>{{__('admin.name')}} (en)</label>
                            <input type="text" name="name_en"  value="{{$service->description(1)->name}}" class="form-control" autofocus>
                        </div>
                        <div class="form-group">
                            <label>{{__('admin.name')}} (ar)</label>
                            <input type="text" name="name_ar" value="{{$service->description(2)->name}}" class="form-control" >
                        </div>

                        <div class="form-group">
                            <label>{{__('admin.description')}} (en)</label>
                            <textarea name="description_en"   class="form-control" rows="3">{{$service->description(1)->description}}
                            </textarea>
                        </div>
                        <div class="form-group">
                            <label>{{__('admin.description')}} (ar)</label>
                            <textarea name="description_ar" class="form-control" rows="3">{{$service->description(2)->description}}
                            </textarea>
                        </div>
                        <div class="form-group">
                            <label>{{__('admin.status')}}</label>
                            <select name="status" class="form-control">
                                <option value="true">{{__('admin.true')}}</option>
                                <option value="false">{{__('admin.false')}}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>{{__('admin.image')}}</label>
                            <input type="file" name="image">
                        </div>
                        <br>

                        <button type="submit" class="btn btn-primary">{{__('admin.confirm')}}</button>
                        <a href="{{ url('dashboard/services') }}" class="btn btn-danger">{{__('admin.cancel')}}</a>
                    </form>
                    </div>
                    </div>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

