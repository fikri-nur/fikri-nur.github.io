@if ($currentPath == null)
    <td data-clickable={{ $data->dept_id == auth()->user()->department->id || $data->dept_id == null || auth()->user()->role->name == 'Administrator' || auth()->user()->role->name == 'Superuser' ? 'true' : '' }}
        data-source="{{ $data->source }}" class="name-cell" data-toggle="tooltip" data-placement="top"
        title="{{ $data->name . '.' . $data->ext }}"
        data-href="{{ route('home.file.viewer', ['file' => $data, 'ext' => $data->ext]) }}"><i class="fas fa-file"
            style="color: #C41230"></i>
        {{ $data->name . '.' . $data->ext }}
    </td>
    <td data-clickable={{ $data->dept_id == auth()->user()->department->id || $data->dept_id == null || auth()->user()->role->name == 'Administrator' || auth()->user()->role->name == 'Superuser' ? 'true' : '' }}
        data-source="{{ $data->source }}"
        data-href="{{ route('home.file.viewer', ['file' => $data, 'ext' => $data->ext]) }}">{{ $data->ext }}</td>
    <td data-clickable={{ $data->dept_id == auth()->user()->department->id || $data->dept_id == null || auth()->user()->role->name == 'Administrator' || auth()->user()->role->name == 'Superuser' ? 'true' : '' }}
        data-source="{{ $data->source }}"
        data-href="{{ route('home.file.viewer', ['file' => $data, 'ext' => $data->ext]) }}">{{ $data->user->name }}
    </td>
    <td data-clickable={{ $data->dept_id == auth()->user()->department->id || $data->dept_id == null || auth()->user()->role->name == 'Administrator' || auth()->user()->role->name == 'Superuser' ? 'true' : '' }}
        data-source="{{ $data->source }}"
        data-href="{{ route('home.file.viewer', ['file' => $data, 'ext' => $data->ext]) }}">
        {{ $data->formatted_created_at }}</td>
    <td data-clickable={{ $data->dept_id == auth()->user()->department->id || $data->dept_id == null || auth()->user()->role->name == 'Administrator' || auth()->user()->role->name == 'Superuser' ? 'true' : '' }}
        data-source="{{ $data->source }}"
        data-href="{{ route('home.file.viewer', ['file' => $data, 'ext' => $data->ext]) }}">
        {{ $data->formatted_updated_at }}</td>
@else
    <td data-clickable={{ $data->dept_id == auth()->user()->department->id || $data->dept_id == null || auth()->user()->role->name == 'Administrator' || auth()->user()->role->name == 'Superuser' ? 'true' : '' }}
        data-source="{{ $data->source }}" class="name-cell" data-toggle="tooltip" data-placement="top"
        title="{{ $data->name . '.' . $data->ext }}"
        data-href="{{ route('home.nested.file.viewer', ['slug' => $currentPath, 'file' => $data, 'ext' => $data->ext]) }}">
        <i class="fas fa-file" style="color: #C41230"></i>
        {{ $data->name . '.' . $data->ext }}
    </td>
    <td data-clickable={{ $data->dept_id == auth()->user()->department->id || $data->dept_id == null || auth()->user()->role->name == 'Administrator' || auth()->user()->role->name == 'Superuser' ? 'true' : '' }}
        data-source="{{ $data->source }}"
        data-href="{{ route('home.nested.file.viewer', ['slug' => $currentPath, 'file' => $data, 'ext' => $data->ext]) }}">
        {{ $data->ext }}</td>
    <td data-clickable={{ $data->dept_id == auth()->user()->department->id || $data->dept_id == null || auth()->user()->role->name == 'Administrator' || auth()->user()->role->name == 'Superuser' ? 'true' : '' }}
        data-source="{{ $data->source }}"
        data-href="{{ route('home.nested.file.viewer', ['slug' => $currentPath, 'file' => $data, 'ext' => $data->ext]) }}">
        {{ $data->user->name }}</td>
    <td data-clickable={{ $data->dept_id == auth()->user()->department->id || $data->dept_id == null || auth()->user()->role->name == 'Administrator' || auth()->user()->role->name == 'Superuser' ? 'true' : '' }}
        data-source="{{ $data->source }}"
        data-href="{{ route('home.nested.file.viewer', ['slug' => $currentPath, 'file' => $data, 'ext' => $data->ext]) }}">
        {{ $data->formatted_created_at }}</td>
    <td data-clickable={{ $data->dept_id == auth()->user()->department->id || $data->dept_id == null || auth()->user()->role->name == 'Administrator' || auth()->user()->role->name == 'Superuser' ? 'true' : '' }}
        data-source="{{ $data->source }}"
        data-href="{{ route('home.nested.file.viewer', ['slug' => $currentPath, 'file' => $data, 'ext' => $data->ext]) }}">
        {{ $data->formatted_updated_at }}</td>
@endif

@if (auth()->user()->role->name == 'Administrator' || auth()->user()->role->name == 'Superuser')
    <td>
        <div class="btn-group btn-group-sm">

            <a href="#" class="btn rounded btn-sm btn-success mr-1 edit-file-button" data-toggle="modal"
                data-target="#editFileModal-{{ $data->id }}" data-file-name="{{ $data->name }}">
                <i class="fa fa-pencil"></i>
            </a>
            <button type="button" class="btn rounded btn-sm btn-danger" data-toggle="modal"
                data-target="#delete-modal-file-{{ $data->id }}">
                <i class="fa fa-trash"></i>
            </button>
        </div>
    </td>
@elseif (auth()->user()->role->name == 'User')
    @if (auth()->user()->permissions->contains('name', 'Edit Delete File'))
        <td>
            <div class="btn-group btn-group-sm">

                <a href="#" class="btn rounded btn-sm btn-success mr-1 edit-file-button" data-toggle="modal"
                    data-target="#editFileModal-{{ $data->id }}" data-file-name="{{ $data->name }}">
                    <i class="fa fa-pencil"></i>
                </a>
                <button type="button" class="btn rounded btn-sm btn-danger" data-toggle="modal"
                    data-target="#delete-modal-file-{{ $data->id }}">
                    <i class="fa fa-trash"></i>
                </button>
            </div>
        </td>
    @else
    @endif
@elseif (
    $data->dept_id == auth()->user()->department->id &&
        auth()->user()->permissions->contains('name', 'Edit Delete File'))
    <td>
        <div class="btn-group btn-group-sm">
            <a href="#" class="btn rounded btn-sm btn-success mr-1 edit-file-button" data-toggle="modal"
                data-target="#editFileModal-{{ $data->id }}" data-file-name="{{ $data->name }}">
                <i class="fa fa-pencil"></i>
            </a>

            <button type="button" class="btn rounded btn-sm btn-danger" data-toggle="modal"
                data-target="#delete-modal-file-{{ $data->id }}">
                <i class="fa fa-trash"></i>
            </button>
        </div>
    </td>
@elseif ($data->dept_id == null && auth()->user()->role->name == 'Administrator')
    <td>
        <div class="btn-group btn-group-sm">
            <a href="#" class="btn rounded btn-sm btn-success mr-1 edit-file-button" data-toggle="modal"
                data-target="#editFileModal-{{ $data->id }}" data-file-name="{{ $data->name }}">
                <i class="fa fa-pencil"></i>
            </a>

            <button type="button" class="btn rounded btn-sm btn-danger" data-toggle="modal"
                data-target="#delete-modal-file-{{ $data->id }}">
                <i class="fa fa-trash"></i>
            </button>
        </div>
    </td>
@else
    <td>
        <div class="btn-group btn-group-sm">
            <a class="btn rounded btn-sm btn-success mr-1 edit-file-button">
                <i class="fa fa-lock"></i>
            </a>

            <button type="button" class="btn rounded btn-sm btn-danger">
                <i class="fa fa-lock"></i>
            </button>
        </div>
    </td>
@endif
