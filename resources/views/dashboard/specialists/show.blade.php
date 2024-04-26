<div id="content-wrapper" class="d-flex flex-column">
    <!-- Main Content -->
    <div id="content">
        <div class="container-fluid">
            <div class="card shadow my-4">
                <div class="card">
                    <div class="card-header">{{ __('admin.showSpecialist') }}</div>
                    <div class="card-body">
                        <h5 class="form-control"> {{ __('admin.name') }} : {{ $specialist->user->name }}</h5>
                        <p class="form-control"> {{ __('admin.description') }} : {{ $specialist->description }}</p>
                        <p class="form-control">{{ __('admin.num_of_years_experience') }} :
                            {{ $specialist->num_of_experience }}</p>
                        <p class="form-control"> {{ __('admin.num_of_customers') }} :
                            {{ $specialist->num_of_customers }}</p>
                        <p class="form-control">{{ __('admin.rating') }} : {{ $specialist->average_rating }}</p>
                        <p class="card-subtitle mb-2 text-muted form-control">{{ __('admin.personalCard') }}
                            <div class="form-controll">
                                 @if ($specialist->personal_card)
                                @foreach (json_decode($specialist->personal_card) as $file)
                                    <div class="border d-table rounded attach-container-width my-4 p3">
                                        <div class="d-sm-flex align-items-center file-attach-uhelp">
                                            <div class="me-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-filetype-png" viewBox="0 0 16 16">
                                                    <!-- SVG content for file icon -->
                                                </svg>
                                            </div>
                                            <div class="d-flex align-items-center text-muted fs-12 me-3">
                                                <p class="file-attach-name text-truncate mb-0">{{ $file }}</p>
                                            </div>
                                            <div class="d-flex mt-2 mt-sm-0">
                                                <a href="{{ asset("uploads/$file") }}" target="_blank"
                                                    class="uhelp-attach-acion p-2 rounded border lh-1 me-1 d-flex align-items-center justify-content-center">
                                                    <i class="fas fa-eye"></i></a>
                                                <a href="{{ asset("uploads/$file") }}" download="{{ $file }}"
                                                    class="uhelp-attach-acion p-2 rounded border lh-1 d-flex align-items-center justify-content-center"><i
                                                        class="fas fa-download"></i></a>

                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <p>@lang('admin.notUploaded')</p>
                            @endif
                            </div>
                        </p>
                        <p class="card-subtitle mb-2 text-muted form-control">{{ __('admin.personalImage') }}
                            @if ($specialist->personal_image)
                                <div class="border d-table rounded attach-container-width my-4 p3">
                                    <div class="d-sm-flex align-items-center file-attach-uhelp">
                                        <div class="me-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-filetype-png" viewBox="0 0 16 16">
                                                <!-- SVG content for file icon -->
                                            </svg>
                                        </div>
                                        <div class="d-flex align-items-center text-muted fs-12 me-3">
                                            <p class="file-attach-name text-truncate mb-0">{{ $file }}</p>
                                        </div>
                                        <div class="d-flex mt-2 mt-sm-0">
                                            <a href="{{ asset("uploads/$specialist->personal_image") }}"
                                                target="_blank"
                                                class="uhelp-attach-acion p-2 rounded border lh-1 me-1 d-flex align-items-center justify-content-center">
                                                <i class="fas fa-eye"></i></a>
                                            <a href="{{ asset("uploads/$specialist->personal_image") }}"
                                                download="{{ $specialist->personal_image }}"
                                                class="uhelp-attach-acion p-2 rounded border lh-1 d-flex align-items-center justify-content-center"><i
                                                    class="fas fa-download"></i></a>

                                        </div>
                                    </div>
                                </div>
                            @else
                                <p>@lang('admin.notUploaded')</p>
                            @endif
                        </p>


                    </div>
                    <div class="card-footer">
                        <br>
                        <form method="POST" action="{{ route('specialists.activate', $specialist) }}">
                            @csrf
                            @method('POST')
                            <button type="submit" class="btn btn-primary">{{ __('admin.active') }}</button>
                            <a href="{{ url('dashboard/specialists') }}"
                                class="btn btn-danger">{{ __('admin.cancel') }}</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
