@extends('laravel-file-viewer::layouts.blank_app_no_logo', [
    'title' => $file->name. '.' .$file->ext,
])

@push('css')
    <link rel="stylesheet" href="{{ asset('vendor/laravel-file-viewer/officetohtml/plyr/cdn.plyr.io_3.7.2_plyr.css') }}">
    <style>
        .file-detail-card {
            width: 100%;
            bottom: 0px;
            left: 0px;
            z-index: 999;
            background: #ffffffed;
        }

        .preview_container {
            background: white;
            padding: 1em;
            height: 65vh;
        }
    </style>
@endpush

@push('js')
    <script src="{{ asset('vendor/laravel-file-viewer/officetohtml/plyr/cdn.plyr.io_3.7.2_plyr.js') }}"></script>
    <script>
        const player = new Plyr('#player');
    </script>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mt-3">

                <!-- Card Header-->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    @include('laravel-file-viewer::previewFileDetails')
                </div>

                <!-- Card Body -->
                <div class="card-body">
                    <div id="resolte-contaniner" class="preview_container">
                        <audio controls class="w-100" style="margin-top: 10%" src="{!! $file_url !!}">
                            Your browser does not support the
                            <code>audio</code> element.
                        </audio>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
