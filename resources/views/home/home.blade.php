@extends('home.layout.app', [
    'title' => 'Home',
])

@push('css')
    <link rel="stylesheet" href="{{ asset('vendor/dropzone.js/unpkg.com_dropzone@5.9.3_dist_min_dropzone.min.css') }}">
    <style>
        /* CSS untuk tombol expand/collapse */
        .toggle-button {
            cursor: pointer;
        }

        /* CSS untuk mengatur lebar folder tree */
        .folder-tree-container {
            height: 85vh;
            overflow-x: auto;
            white-space: nowrap;
        }
    </style>
@endpush

@push('js')
    <script src="{{ asset('vendor/dropzone.js/unpkg.com_dropzone@5.9.3_dist_min_dropzone.min.js') }}"></script>
    <script>
        Dropzone.autoDiscover = false;

        // Inisialisasi Dropzone.js dengan opsi
        var myDropzone = new Dropzone("#my-dropzone", {
            autoProcessQueue: false, // Tidak unggah otomatis
            maxFilesize: 1000000, // 1000 GB
            parallelUploads: 3, // Jumlah file yang diunggah secara paralel
            uploadMultiple: true, // Mengizinkan unggahan beberapa file
            // acceptedFiles: "image/*,application/pdf, .doc, .docx, .xls, .xlsx, .csv, audio/*,video/*, .rar, .zip",
            addRemoveLinks: true,
            dictDefaultMessage: "Choose or Drop files here to upload",
        });

        // Tombol untuk memulai unggahan
        document.querySelector("#upload-button").addEventListener("click", function() {
            myDropzone.processQueue(); // Memulai unggahan
        });

        myDropzone.on("uploadprogress", function(file, progress) {
            var progressBar = document.getElementById('upload-progress-bar');
            progressBar.style.width = progress.toFixed(2) + "%";
            progressBar.innerHTML = progress.toFixed(2) + "%";
        });

        myDropzone.on('complete', function(file) {
            myDropzone.removeFile(file);
            var progressBar = document.getElementById('upload-progress-bar');
            progressBar.style.width = "0%";
            progressBar.innerHTML = "0%";
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.folder-tree ul.folder-tree.collapsed').hide();
        });


        $(document).ready(function() {
            $('.toggle-button').click(function() {
                const icon = $(this).find('i');
                icon.toggleClass('fa-folder fa-folder-open');
                $(this).toggleClass('collapsed');
                $(this).parent().children('ul').toggle();
                // Ganti ikon (jika diperlukan)
            });
        });
    </script>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-3 col-md-offset-2">

            <!-- Card -->
            <div class="card shadow mb-4">

                <!-- Card Header-->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h5 class="m-0 font-weight-bold text-primary">Folder Directory</h6>
                </div>

                <!-- Tambahkan class folder-tree-container di container folder tree -->
                <div class="card-body folder-tree-container">

                    <!-- Folder tree -->
                    <ul class="folder-tree">
                        <li>
                            <span class="toggle-button"><i class="fas fa-folder-open" style="color: #416DB6"></i></i></span>
                            <a href="{{ route('home') }}">Root Folder</a>
                            @if (auth()->user()->permissions->contains('name', 'Open Folder'))
                                <ul class="folder-tree">
                                    @foreach ($combinedData as $data)
                                        <li class="folder">
                                            @if ($data->source === 'folder')
                                                @if (
                                                    $data->dept_id == auth()->user()->department->id ||
                                                        $data->dept_id == null ||
                                                        auth()->user()->role->name == 'Administrator' || auth()->user()->role->name == 'Superuser')
                                                    <span class="toggle-button" data-toggle="tooltip" data-placement="top"
                                                        title="{{ $data->name }}"><i class="fas fa-folder"></i></span>
                                                    <a
                                                        href="{{ route('home.folder.nested', ['slug' => $data->slug]) }}">{{ $data->name }}</a>
                                                @elseif ($data->dept_id != auth()->user()->department->id)
                                                    <span data-toggle="tooltip" data-placement="top"
                                                        title="{{ $data->name }}"><i class="fas fa-folder"></i></span>
                                                    <a>{{ $data->name }}</a>
                                                @endif
                                            @else
                                                <span data-toggle="tooltip" data-placement="top"
                                                    title="{{ $data->name . '.' . $data->ext }}"><i class="fas fa-file"
                                                        style="color: #C41230"></i></span>
                                                <a href="{{ route('home.file.viewer', ['file' => $data, 'ext' => $data->ext]) }}"
                                                    target="_blank">{{ $data->name . '.' . $data->ext }}</a>
                                            @endif

                                            @if (is_countable($data->childFolders) && $data->childFolders->count() > 0)
                                                @include('partials.folder-tree', [
                                                    'folders' => $data->childFolders,
                                                    'slug' => $data->slug,
                                                ])
                                            @endif
                                            @if (is_countable($data->files) && $data->files->count() > 0)
                                                @include('partials.file-tree', [
                                                    'files' => $data->files,
                                                    'slug' => $data->slug,
                                                ])
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    </ul>
                </div>

            </div>
        </div>

        <div class="col-md-9 col-md-offset-2">

            <!-- Card -->
            <div class="card shadow mb-4">

                <!-- Card Header -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h5 class="m-0 font-weight-bold text-primary">
                        @isset($dataSlug)
                            @foreach ($dataSlug as $index => $slug)
                                @if ($index === count($dataSlug) - 1)
                                    {{ $folderNames[$index] }}
                                @endif
                            @endforeach
                        @else
                            Root Folder
                        @endisset
                    </h5>

                    <div class="ml-auto btn-group" role="group" aria-label="User Actions">
                        @if (auth()->user()->role->name == 'Administrator' || auth()->user()->role->name == 'Superuser')
                            <button id="uploadFileButton" class="btn rounded btn-sm btn-primary" data-toggle="modal"
                                data-target="#uploadFileModal">
                                <i class="fa fa-upload"></i>
                                <span class="text">{{ __('Upload File') }}</span>
                            </button>
                            @if ($currentPath == null)
                                <button id="createFolderButton" class="btn rounded btn-sm btn-primary ml-2"
                                    data-toggle="modal" data-target="#createFolderModal"
                                    data-departments="{{ json_encode($departments) }}">
                                    <i class="fa fa-folder-plus"></i>
                                    <span class="text">{{ __('Create Folder') }}</span>
                                </button>
                            @else
                                <button id="createFolderButton" class="btn rounded btn-sm btn-primary ml-2"
                                    data-toggle="modal" data-target="#createFolderModal">
                                    <i class="fa fa-folder-plus"></i>
                                    <span class="text">{{ __('Create Folder') }}</span>
                                </button>
                            @endif
                        @else
                            @isset($openedFolder)
                                @if (
                                    $openedFolder->dept_id != null &&
                                        $openedFolder->dept_id == auth()->user()->department->id &&
                                        auth()->user()->permissions->contains('name', 'Upload File'))
                                    <button id="uploadFileButton" class="btn rounded btn-sm btn-primary" data-toggle="modal"
                                        data-target="#uploadFileModal">
                                        <i class="fa fa-upload"></i>
                                        <span class="text">{{ __('Upload File') }}</span>
                                    </button>
                                @endif

                                @if (
                                    $openedFolder->dept_id != null &&
                                        $openedFolder->dept_id == auth()->user()->department->id &&
                                        auth()->user()->permissions->contains('name', 'Create Folder'))
                                    <button id="createFolderButton" class="btn rounded btn-sm btn-primary ml-2"
                                        data-toggle="modal" data-target="#createFolderModal">
                                        <i class="fa fa-folder-plus"></i>
                                        <span class="text">{{ __('Create Folder') }}</span>
                                    </button>
                                @endif
                            @endisset
                        @endif

                    </div>
                </div>

                <!-- Card Body -->
                <div class="card-body">

                    {{-- Breadcrumb --}}
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            @isset($dataSlug)
                                @foreach ($dataSlug as $index => $slug)
                                    @if ($index === count($dataSlug) - 1)
                                        <li class="breadcrumb-item active" aria-current="page">{{ $folderNames[$index] }}
                                        </li>
                                    @else
                                        <li class="breadcrumb-item"><a
                                                href="{{ route('home.folder.nested', implode('/', array_slice($dataSlug, 0, $index + 1))) }}">{{ $folderNames[$index] }}</a>
                                        </li>
                                    @endif
                                @endforeach
                            @endisset
                        </ol>
                    </nav>

                    {{-- Alert --}}
                    @include('partials.alert')

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </div>
                    @endif


                    {{-- Table --}}
                    <div class="table-responsive">
                        <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">

                            {{-- Table Head --}}
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Type/ext</th>
                                    <th>Created by</th>
                                    <th>Date Created</th>
                                    <th>Date Modified</th>
                                    @if (auth()->user()->role->name != 'User')
                                        <th>Action</th>
                                    @endif
                                </tr>
                            </thead>

                            {{-- Table Body --}}
                            <tbody>
                                @if (auth()->user()->permissions->contains('name', 'Open Folder'))
                                    @foreach ($combinedDataTable as $index => $data)
                                        <tr
                                            {{ $data->dept_id == auth()->user()->department->id || $data->dept_id == null || auth()->user()->role->name == 'Administrator' || auth()->user()->role->name == 'Superuser' ? '' : 'class=table-secondary' }}>
                                            @if ($data->source == 'folder')
                                                @include('home.user.folder.index')
                                                @include('home.user.folder.modal', [
                                                    'data' => $data,
                                                ])
                                            @elseif ($data->source == 'file')
                                                @include('home.user.file.index')
                                                @include('home.user.file.modal', [
                                                    'data' => $data,
                                                ])
                                            @endif
                                        </tr>
                                    @endforeach
                                @endif
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
        </div>
    </div>

    @include('partials.home-modal')
@endsection
