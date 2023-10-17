<ul class="folder-tree collapsed">
    @foreach ($folders as $folder)
        <li class="folder">
            @if ($data->source === 'folder')
                @if (
                    $folder->dept_id == auth()->user()->department->id ||
                        $folder->dept_id == null ||
                        auth()->user()->role->name == 'Administrator' || auth()->user()->role->name == 'Superuser')
                    <span class="toggle-button" data-toggle="tooltip" data-placement="top" title="{{ $folder->name }}"><i
                            class="fas fa-folder"></i></span>
                    <a href="{{ route('home.folder.nested', $slug . '/' . $folder->slug) }}">{{ $folder->name }}</a>
                @elseif ($folder->dept_id != auth()->user()->department->id)
                    <span data-toggle="tooltip" data-placement="top" title="{{ $folder->name }}"><i
                            class="fas fa-folder"></i></span>
                    <a>{{ $folder->name }}</a>
                @endif
            @endif


            @if ($folder->childFolders->count() > 0)
                @include('partials.folder-tree', [
                    'folders' => $folder->childFolders,
                    'slug' => $slug . '/' . $folder->slug,
                ])
            @endif
            @if ($folder->files->count() > 0)
                @include('partials.file-tree', [
                    'files' => $folder->files,
                    'slug' => $slug . '/' . $folder->slug,
                ])
            @endif
        </li>
    @endforeach
</ul>
