<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <span class="text-bold"> {{ __('admin.specialistsTable') }} </span>
                    <a class="btn btn-primary" style="float: right" href="{{ route('specialists.create') }}">
                        {{ __('admin.addSpecialist') }}
                    </a>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary font-weight-bolder opacity-7">
                                        {{ __('admin.id') }}
                                    </th>
                                    <th class="text-uppercase text-secondary font-weight-bolder opacity-7">
                                        {{ __('admin.name') }}
                                    </th>
                                    <th class=" text-uppercase text-secondary font-weight-bolder opacity-7">
                                        {{ __('admin.service') }}
                                    </th>
                                    <th class=" text-uppercase text-secondary font-weight-bolder opacity-7">
                                        {{ __('admin.average_rating') }}
                                    </th>
                                    <th class=" text-uppercase text-secondary font-weight-bolder opacity-7">
                                        {{ __('admin.status') }}
                                    </th>
                                    <th class=" text-uppercase text-secondary font-weight-bolder opacity-7">
                                        {{ __('admin.actions') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($specialists as $specialist)
                                    <tr>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0 ps-3">{{ $specialist->id }}</p>
                                        </td>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div>
                                                    @if ($specialist->user->image)
                                                        <img src="{{ url('') }}/uploads/{{ $specialist->user->image}}"
                                                            class="avatar avatar-sm me-3">
                                                    @else
                                                        <img src="{{ url('') }}/uploads/users/defualt.jpg"
                                                            class="avatar avatar-sm me-3">
                                                    @endif
                                                </div>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $specialist->user->name }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $specialist->service->description()->name }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $specialist->average_rating}}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $specialist->user->is_specialist == 'true' ? __('admin.true') : __('admin.false') }}
                                            </p>
                                        </td>

                                        <td>
                                            <a class="btn btn-info"
                                            href="{{ url("dashboard/specialists/$specialist->id") }}">{{ __('admin.show') }}</a>
                                            <a class="btn btn-success"
                                                href="{{ url("dashboard/specialists/$specialist->id/edit") }}">{{ __('admin.edit') }}</a>
                                            <button type="button" class="btn btn-danger deleteModal"
                                                data-toggle="modal" data-target="#modal{{ $specialist->id }}"
                                                data-id="{{ $specialist->id }}" data-name="{{ $specialist->name }}">
                                                {{ __('admin.delete') }}
                                            </button>

                                        </td>
                                    </tr>
                                    <!-- Modal -->
                                    <div class="modal fade" id="modal{{ $specialist->id }}" tabindex="-1"
                                        role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalTitle">
                                                        {{ __('admin.deleteSpecialist') }}
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    {{ __('admin.deleteSpecialist') }}
                                                    : <span
                                                        class="text-danger font-weight-bold name">{{ $specialist->user->name }}</span>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal"> {{ __('admin.cancel') }}
                                                    </button>
                                                    <form action="{{ url("dashboard/specialists/$specialist->id") }}"
                                                        method="POST" style="display: inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">
                                                            {{ __('admin.delete') }}
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
