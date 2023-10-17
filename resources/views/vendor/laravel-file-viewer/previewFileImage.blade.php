@extends('laravel-file-viewer::layouts.blank_app_no_logo', [
    'title' => $file->name. '.' .$file->ext,
])

@push('css')
    <link rel="stylesheet"
        href="{{ asset('vendor/laravel-file-viewer/officetohtml/ajax_libs_viewer/cdnjs.cloudflare.com_ajax_libs_viewerjs_1.11.1_viewer.min.css') }}">
    <style>
        .file-detail-card {
            width: 100%;
            bottom: 0px;
            left: 0px;
            z-index: 999;
            background: #ffffffed;
            /* position: fixed; */
        }

        .preview_container {
            /* border: solid 1px lightgray; */
            /* overflow: scroll; */
            background: rgb(236, 236, 236);
            /* padding: 1em; */
            height: 85vh
        }
    </style>
@endpush

@push('js')
    <script
        src="{{ asset('vendor/laravel-file-viewer/officetohtml/ajax_libs_viewer/cdnjs.cloudflare.com_ajax_libs_viewerjs_1.11.1_viewer.min.js') }}">
    </script>
    <script>
        // View an image.
        const viewer = new Viewer(document.getElementById('image'), {
            inline: true,
            backdrop: false,
            navbar: false
        });
        // Then, show the image by clicking it, or call `viewer.show()`.

        // View a list of images.
        // Note: All images within the container will be found by calling `element.querySelectorAll('img')`.
        // const gallery = new Viewer(document.getElementById('images'));
        // Then, show one image by click it, or call `gallery.show()`.
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
                    <div id="resolte-contaniner" class="preview_container"><img id="image" src="{!! $file_url !!}"
                            alt="{{ $file->slug }}" height="100%" style="display: none;"></div>
                </div>


            </div>
        </div>
    </div>
@endsection
