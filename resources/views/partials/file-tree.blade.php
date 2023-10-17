<ul class="folder-tree file">
    @foreach ($files as $file)
        <li class="folder">
            @if (
                $file->dept_id == auth()->user()->department->id ||
                    $file->dept_id == null ||
                    auth()->user()->role->name == 'Administrator' || auth()->user()->role->name == 'Superuser')
                <span data-toggle="tooltip" data-placement="top" title="{{ $file->name . '.' . $file->ext }}"><i
                        class="fas fa-file"></i></span>
                <a href="{{ route('home.nested.file.viewer', ['slug' => $slug, 'file' => $file, 'ext' => $file->ext]) }}"
                    target="_blank">{{ $file->name . '.' . $file->ext }}</a>
            @elseif ($file->dept_id != auth()->user()->department->id)
            <span data-toggle="tooltip" data-placement="top" title="{{ $file->name . '.' . $file->ext }}"><i
                class="fas fa-file"></i></span>
                <a>{{ $file->name . '.' . $file->ext }}</a>
            @endif
        </li>
    @endforeach
</ul>
