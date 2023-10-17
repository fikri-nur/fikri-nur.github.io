@extends('dashboard.layout.app', [
    'title' => 'Manage Users Permissions',
])

@section('content')
    <div class="container">
        <div class="card shadow mb-4">

            <div class="card-header py-3 d-flex">
                <h3 class="m-0 font-weight-bold text-primary">
                    {{ __('Manage Users Permissions') }}
                </h3>
                <div class="ml-auto btn-group" role="group" aria-label="User Actions">
                    <a href="{{ route('user.index') }}" class="btn rounded btn-primary">
                        <span class="icon text-white-50">
                            <i class="fa fa-arrow-left"></i>
                        </span>
                        <span class="text">{{ __('Back') }}</span>
                    </a>
                </div>
            </div>

            <div class="card-body">
                @include('partials.alert')

                <form action="{{ route('user-permissions.update') }}" method="POST">
                    @csrf
                    <!-- Button Save in Card Body -->
                    <div class="text-right mb-2">
                        <button type="submit" class="btn rounded btn-primary">
                            <i class="fa fa-save"></i> Save
                        </button>
                    </div>

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
                                                    <input type="checkbox" class="custom-control-input"
                                                        id="permission{{ $user->id }}-{{ $permission->id }}"
                                                        name="permissions[{{ $user->id }}][]"
                                                        value="{{ $permission->id }}"
                                                        {{ in_array($permission->id, $user->permissions->pluck('id')->toArray()) ? 'checked' : '' }}>
                                                    <label class="custom-control-label checkbox-label"
                                                        for="permission{{ $user->id }}-{{ $permission->id }}">
                                                        {{ $permission->name }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </td>
                                    </tr>   
                                @endforeach
                            </tbody>
                            {{-- Table Footer --}}
                            <tfoot>
                                <tr>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
