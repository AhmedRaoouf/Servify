<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <span class="text-bold"> {{ __('admin.adminsTable') }} </span>
                    <a class="btn btn-primary" style="float: right" href="{{ url('dashboard/admins/create') }}">
                        {{ __('admin.addAdmin') }}
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
                                        {{ __('admin.email') }}</th>
                                    <th class="text-uppercase text-secondary font-weight-bolder opacity-7">
                                        {{ __('admin.phone') }}</th>
                                    <th class=" text-uppercase text-secondary font-weight-bolder opacity-7">
                                        {{ __('admin.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($admins as $i => $admin)
                                    <tr>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0 ps-3">{{ $i + 1 }}</p>
                                        </td>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div>
                                                    @if ($admin->image)
                                                        <img src="{{ url('') }}/uploads/{{ $admin->image }}"
                                                            class="avatar avatar-sm me-3">
                                                    @else
                                                        <img src="{{ url('') }}/uploads/users/defualt.jpg"
                                                            class="avatar avatar-sm me-3">
                                                    @endif
                                                </div>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $admin->name }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $admin->email }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $admin->phone }}</p>
                                        </td>
                                        <td>
                                            <a class="btn btn-success"
                                                href="{{ url("dashboard/admins/$admin->id/edit") }}">{{ __('admin.edit') }}</a>
                                            <button type="button" class="btn btn-danger deleteModal"
                                                data-toggle="modal" data-target="#modal{{ $admin->id }}"
                                                data-id="{{ $admin->id }}" data-name="{{ $admin->name }}">
                                                {{ __('admin.delete') }}
                                            </button>

                                        </td>
                                    </tr>
                                    <!-- Modal -->
                                    <div class="modal fade" id="modal{{ $admin->id }}" tabindex="-1" role="dialog"
                                        aria-labelledby="modalTitle" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalTitle">
                                                        {{ __('admin.deleteAdminMsg') }}
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    {{ __('admin.deleteAdmin') }}
                                                    : <span
                                                        class="text-danger font-weight-bold name">{{ $admin->name }}</span>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal"> {{ __('admin.cancel') }}
                                                    </button>
                                                    <form action="{{ url("dashboard/admins/$admin->id") }}"
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
