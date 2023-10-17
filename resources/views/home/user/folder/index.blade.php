<td data-clickable={{ $data->dept_id == auth()->user()->department->id || $data->dept_id == null || auth()->user()->role->name == 'Administrator' || auth()->user()->role->name == 'Superuser' ? 'true' : '' }}
    data-source="{{ $data->source }}" class="name-cell" data-toggle="tooltip" data-placement="top"
    title="{{ $data->name }}" data-href="{{ route('home.folder.nested', $data->slug) }}"><i class="fas fa-folder"
        style="color: #416DB6"></i>
    {{ $data->name }}
</td>
<td data-clickable={{ $data->dept_id == auth()->user()->department->id || $data->dept_id == null || auth()->user()->role->name == 'Administrator' || auth()->user()->role->name == 'Superuser' ? 'true' : '' }}
    data-source="{{ $data->source }}" data-href="{{ route('home.folder.nested', $data->slug) }}">
    {{ $data->source }}</td>
<td data-clickable={{ $data->dept_id == auth()->user()->department->id || $data->dept_id == null || auth()->user()->role->name == 'Administrator' || auth()->user()->role->name == 'Superuser' ? 'true' : '' }}
    data-source="{{ $data->source }}" data-href="{{ route('home.folder.nested', $data->slug) }}">
    {{ $data->user->name }}</td>
<td data-clickable={{ $data->dept_id == auth()->user()->department->id || $data->dept_id == null || auth()->user()->role->name == 'Administrator' || auth()->user()->role->name == 'Superuser' ? 'true' : '' }}
    data-source="{{ $data->source }}" data-href="{{ route('home.folder.nested', $data->slug) }}">
    {{ $data->formatted_created_at }}</td>
<td data-clickable={{ $data->dept_id == auth()->user()->department->id || $data->dept_id == null || auth()->user()->role->name == 'Administrator' || auth()->user()->role->name == 'Superuser' ? 'true' : '' }}
    data-source="{{ $data->source }}" data-href="{{ route('home.folder.nested', $data->slug) }}">
    {{ $data->formatted_updated_at }}</td>

@if (auth()->user()->role->name == 'Administrator' || auth()->user()->role->name == 'Superuser')
    <td>
        <div class="btn-group btn-group-sm">
            <a href="#" class="btn rounded btn-sm btn-success mr-1 edit-folder-button" data-toggle="modal"
                data-target="#editFolderModal-{{ $data->id }}" data-folder-name="{{ $data->name }}">
                <i class="fa fa-pencil"></i>
            </a>
            <button type="button" class="btn rounded btn-sm btn-danger" data-toggle="modal"
                data-target="#delete-modal-folder-{{ $data->id }}">
                <i class="fa fa-trash"></i>
            </button>
        </div>
    </td>
@elseif (auth()->user()->role->name == 'User')
    @if (auth()->user()->permissions->contains('name', 'Edit Delete Folder'))
        <td>
            <div class="btn-group btn-group-sm">
                <a href="#" class="btn rounded btn-sm btn-success mr-1 edit-folder-button" data-toggle="modal"
                    data-target="#editFolderModal-{{ $data->id }}" data-folder-name="{{ $data->name }}">
                    <i class="fa fa-pencil"></i>
                </a>
                <button type="button" class="btn rounded btn-sm btn-danger" data-toggle="modal"
                    data-target="#delete-modal-folder-{{ $data->id }}">
                    <i class="fa fa-trash"></i>
                </button>
            </div>
        </td>
    @else
    @endif
@elseif (
    $data->dept_id == auth()->user()->department->id &&
        auth()->user()->permissions->contains('name', 'Edit Delete Folder'))
    <td>
        <div class="btn-group btn-group-sm">
            <a href="#" class="btn rounded btn-sm btn-success mr-1 edit-folder-button" data-toggle="modal"
                data-target="#editFolderModal-{{ $data->id }}" data-folder-name="{{ $data->name }}">
                <i class="fa fa-pencil"></i>
            </a>

            <button type="button" class="btn rounded btn-sm btn-danger" data-toggle="modal"
                data-target="#delete-modal-folder-{{ $data->id }}">
                <i class="fa fa-trash"></i>
            </button>
        </div>
    </td>
@elseif ($data->dept_id == null && auth()->user()->role->name == 'Administrator')
    <td>
        <div class="btn-group btn-group-sm">
            <a href="#" class="btn rounded btn-sm btn-success mr-1 edit-folder-button" data-toggle="modal"
                data-target="#editFolderModal-{{ $data->id }}" data-folder-name="{{ $data->name }}">
                <i class="fa fa-pencil"></i>
            </a>

            <button type="button" class="btn rounded btn-sm btn-danger" data-toggle="modal"
                data-target="#delete-modal-folder-{{ $data->id }}">
                <i class="fa fa-trash"></i>
            </button>
        </div>
    </td>
@else
    <td>
        <div class="btn-group btn-group-sm">
            <a class="btn rounded btn-sm btn-success mr-1 edit-folder-button">
                <i class="fa fa-lock"></i>
            </a>

            <button type="button" class="btn rounded btn-sm btn-danger">
                <i class="fa fa-lock"></i>
            </button>
        </div>
    </td>
@endif
