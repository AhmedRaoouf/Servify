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
                    <h3 class="h3 my-3 text-gray-800 ">{{ __('admin.newSpecialist') }}</h3>
                    @include('dashboard/inc/msg')

                    <form method="post" action="{{ route('specialists.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>{{ __('admin.user') }}</label>
                            <select class="form-control form-control-user" name="user_id">
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>{{ __('admin.service') }}</label>
                            <select class="form-control form-control-user"  name="service_id">
                                @foreach ($services as $service)
                                    <option value="{{ $service->id }}">{{ $service->description()->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>{{ __('admin.description') }}</label>
                            <textarea name="description" class="form-control form-control-user" ></textarea>
                        </div>
                        <div class="form-group">
                            <label>{{ __('admin.num_of_years_experience') }}</label>
                            <input type="number" name="num_of_experience" class="form-control form-control-user" >
                        </div>
                        <div class="form-group">
                            <label>{{ __('admin.personalCard') }}</label>
                            <input type="file" name="personal_card[]" class="form-control form-control-user" multiple>
                        </div>
                        <div class="form-group">
                            <label>{{ __('admin.personalImage') }}</label>
                            <input type="file" name="personal_image" class="form-control form-control-user">
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary">{{ __('admin.confirm') }}</button>
                        <a href="{{ route('specialists.index') }}" class="btn btn-danger">{{ __('admin.cancel') }}</a>
                    </form>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->
