@extends('dashboard.layout.app', [
    'title' => 'Manage Department',
])

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h3 class="m-0 font-weight-bold text-primary">
                {{ __('Manage Departments') }}
            </h3>

            <div class="ml-auto btn-group" role="group" aria-label="User Actions">
                <a href="#" class="btn rounded btn-primary" data-toggle="modal" data-target="#createDepartmentModal">
                    <i class="fa fa-circle-plus"></i>
                    <span class="text">{{ __('Create') }}</span>
                </a>
            </div>
        </div>

        <div class="card-body">
            @include('partials.alert')

            {{-- Alert untuk validasi --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    Error validation
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <ul class="ml-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>

                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Date Created</th>
                            <th>Date Modified</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($departments as $index => $department)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $department->name }}</td>
                                <td>{{ $department->formatted_created_at }}</td>
                                <td>{{ $department->formatted_updated_at }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="#" class="btn rounded btn-sm btn-success mr-1 edit-department-button"
                                            data-toggle="modal" data-target="#editDepartmentModal-{{ $department->id }}"
                                            data-department-name="{{ $department->name }}">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <button type="button" class="btn rounded btn-sm btn-danger" data-toggle="modal"
                                            data-target="#delete-modal-{{ $department->id }}">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            @include('dashboard.admin.department.modal', [
                                'department' => $department,
                            ])
                        @endforeach
                    </tbody>
                    {{-- Table Footer --}}
                    <tfoot>
                        <tr>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection
