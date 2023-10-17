@extends('laravel-file-viewer::layouts.blank_app_no_logo', [
    'title' => $file->name. '.' .$file->ext,
])

@push('css')
    <link rel="stylesheet"
        href="{{ asset('vendor/laravel-file-viewer/officetohtml/vjs/vjs.zencdn.net_7.18.1_video-js.css') }}">

    <!-- If you'd like to support IE8 (for Video.js versions prior to v7) -->
    <!-- <script src="https://vjs.zencdn.net/ie8/1.1.2/videojs-ie8.min.js"></script> -->
    <!-- City -->
    <link href="https://unpkg.com/@videojs/themes@1/dist/city/index.css" rel="stylesheet" />

    <!-- Fantasy -->
    <link href="https://unpkg.com/@videojs/themes@1/dist/fantasy/index.css" rel="stylesheet">

    <!-- Forest -->
    <link href="https://unpkg.com/@videojs/themes@1/dist/forest/index.css" rel="stylesheet">

    <!-- Sea -->
    <link href="https://unpkg.com/@videojs/themes@1/dist/sea/index.css" rel="stylesheet">
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
            height: 90vh
        }
    </style>
@endpush

@push('js')
    <script src="{{ asset('vendor/laravel-file-viewer/officetohtml/vjs/vjs.zencdn.net_7.18.1_video.min.js') }}"></script>

    <script>
        function update_viewer() {
            var link = $('#input').val()
            if (link.length <= 1) {
                link = '{!! $file_url !!}';
            }
            $('#google').attr('src', 'https://docs.google.com/a/{{ $_SERVER['SERVER_NAME'] }}/viewer?url=' + link +
                '&embedded=true');
        }
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
                        <div class="embed-responsive embed-responsive-16by9 text-center p-2 mx-auto border border-primary"
                            style="max-width: auto;max-height: 100%;">
                            {{-- fantasy forest sea city --}}
                            <video id="my-video" class="video-js vjs-theme-forest embed-responsive-item" controls
                                preload="auto" data-setup="{}">
                                <source src="{!! $file_url !!}" />
                                <p class="vjs-no-js">
                                    To view this video please enable JavaScript, and consider upgrading to a
                                    web browser that
                                    <a href="https://videojs.com/html5-video-support/" target="_blank">supports HTML5
                                        video</a>
                                </p>
                            </video>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
