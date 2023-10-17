<!-- Modal "Create Department" -->
<div class="modal fade" id="createDepartmentModal" tabindex="-1" role="dialog" aria-labelledby="createDepartmentModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createDepartmentModalLabel">{{ __('Create Department') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('department.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <!-- Form untuk membuat department -->
                    <div class="form-group">
                        <label for="name">{{ __('Name') }}</label>
                        <input class="form-control" type="text" id="name" name="name">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('Create') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal "Edit Department" -->
<div class="modal fade" id="editDepartmentModal-{{ $department->id }}" tabindex="-1" role="dialog"
    aria-labelledby="editDepartmentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDepartmentModalLabel">Rename Department</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editDepartmentForm-{{ $department->id }}" action="{{ route('department.update', $department->id) }}"
                method="POST">
                @csrf
                @method('PUT')
                <!-- Method HTTP untuk mengirim perubahan -->
                <div class="modal-body">
                    <!-- Form untuk mengedit nama department -->
                    <div class="col-12">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input class="form-control" type="text" id="name" name="name"
                                value="{{ $department->name }}">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Rename</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal konfirmasi hapus data -->
<div class="modal fade" id="delete-modal-{{ $department->id }}" tabindex="-1" role="dialog"
    aria-labelledby="delete-modal-label-{{ $department->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="delete-modal-label-{{ $department->id }}">
                    Confirm Delete Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this department {{ $department->name }}?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <form action="{{ route('department.destroy', $department->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
