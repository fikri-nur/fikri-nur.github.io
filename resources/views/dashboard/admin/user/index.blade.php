@extends('dashboard.layout.app', [
    'title' => 'Manage User',
])

@section('content')
    <div class="card shadow">
        <div class="card-header py-3 d-flex">
            <h3 class="m-0 font-weight-bold text-primary">
                {{ __('Manage Users') }}
            </h3>

            <div class="ml-auto btn-group" role="group" aria-label="User Actions">
                <a href="{{ route('user-permissions') }}" class="btn rounded btn-primary mr-2">
                    <i class="fa fa-key"></i>
                    <span class="text">{{ __('Edit Permission') }}</span>
                </a>
                <a href="{{ route('user.create') }}" class="btn rounded btn-primary">
                    <i class="fa fa-circle-plus"></i>
                    <span class="text">{{ __('Create') }}</span>
                </a>
            </div>
        </div>

        <div class="card-body">
            @include('partials.alert')

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>NIP</th>
                            <th>Role</th>
                            <th>Department</th>
                            <th>Permissions</th>
                            <th>Date Created</th>
                            <th>Date Modified</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($users as $index => $user)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->nip }}</td>
                                <td>{{ $user->role->name }}</td>
                                <td>{{ $user->department->name }}</td>
                                <td>
                                    @foreach ($permissions as $permission)
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" disabled
                                                id="permission{{ $user->id }}-{{ $permission->id }}"
                                                name="permissions[{{ $user->id }}][]" value="{{ $permission->id }}"
                                                {{ in_array($permission->id, $user->permissions->pluck('id')->toArray()) ? 'checked' : '' }}>
                                            <label class="custom-control-label checkbox-label"
                                                for="permission{{ $user->id }}-{{ $permission->id }}">
                                                {{ $permission->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </td>
                                <td>{{ $user->formatted_created_at }}</td>
                                <td>{{ $user->formatted_updated_at }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('user.edit', $user) }}"
                                            class="btn rounded btn-sm btn-success mr-1">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <button type="button" class="btn rounded btn-sm btn-danger" data-toggle="modal"
                                            data-target="#delete-modal-{{ $user->id }}">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            @include('dashboard.admin.user.modal')
                        @endforeach
                    </tbody>
                </table>
                {{-- Table Footer --}}
                <tfoot>
                    <tr>
                    </tr>
                </tfoot>
            </div>
        </div>
    </div>
@endsection
