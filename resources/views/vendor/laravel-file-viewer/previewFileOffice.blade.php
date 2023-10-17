@extends('laravel-file-viewer::layouts.blank_app_no_logo', [
    'title' => $file->name . '.' . $file->ext,
])

@push('css')
    <!--PDF-->
    <link rel="stylesheet" href="{{ asset('vendor/laravel-file-viewer/officetohtml/pdf/pdf.viewer.css') }}">

    <!--Docs-->

    <!--PPTX-->
    <link rel="stylesheet" href="{{ asset('vendor/laravel-file-viewer/officetohtml/PPTXjs/css/pptxjs.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/laravel-file-viewer/officetohtml/PPTXjs/css/nv.d3.min.css') }}">

    <!--All Spreadsheet -->
    <link rel="stylesheet" href="{{ asset('vendor/laravel-file-viewer/officetohtml/SheetJS/handsontable.full.min.css') }}">

    <!--Image viewer-->
    <link rel="stylesheet"
        href="{{ asset('vendor/laravel-file-viewer/officetohtml/verySimpleImageViewer/css/jquery.verySimpleImageViewer.css') }}">

    <!--officeToHtml-->
    <link rel="stylesheet" href="{{ asset('vendor/laravel-file-viewer/officetohtml/officeToHtml/officeToHtml.css') }}">

    <style>
        .file-detail-card {
            width: 100%;
            bottom: 0px;
            left: 0px;
            z-index: 999;
            background: #ffffffed;
        }

        .preview_container {
            @if ($file->ext == 'doc' || $file->ext == 'docx')
                overflow: scroll;
            @endif
            background: white;
            padding: 1em;
            height: 90vh
        }

        .jqvsiv_main_image_content img {
            width: 100%;
            height: auto;
        }
    </style>
@endpush

@push('js')
    {{-- PDF --}}
    <script src="{{ asset('vendor/laravel-file-viewer/officetohtml/pdf/pdf.js') }}"></script>

    {{-- DOC --}}
    <script src="{{ asset('vendor/laravel-file-viewer/officetohtml/docx/jszip-utils.js') }}"></script>
    <script src="{{ asset('vendor/laravel-file-viewer/officetohtml/docx/mammoth.browser.min.js') }}"></script>

    {{-- PPTX --}}
    <script type="text/javascript" src="{{ asset('vendor/laravel-file-viewer/officetohtml/PPTXjs/js/filereader.js') }}">
    </script>
    <script type="text/javascript" src="{{ asset('vendor/laravel-file-viewer/officetohtml/PPTXjs/js/d3.min.js') }}">
    </script>
    <script type="text/javascript" src="{{ asset('vendor/laravel-file-viewer/officetohtml/PPTXjs/js/nv.d3.min.js') }}">
    </script>
    <script type="text/javascript" src="{{ asset('vendor/laravel-file-viewer/officetohtml/PPTXjs/js/pptxjs.js') }}">
    </script>
    <script type="text/javascript" src="{{ asset('vendor/laravel-file-viewer/officetohtml/PPTXjs/js/divs2slides.js') }}">
    </script>

    {{-- XLS/Spreadsheet --}}
    <script type="text/javascript"
        src="{{ asset('vendor/laravel-file-viewer/officetohtml/SheetJS/handsontable.full.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/laravel-file-viewer/officetohtml/SheetJS/xlsx.full.min.js') }}">
    </script>

    {{-- Image --}}
    <script type="text/javascript"
        src="{{ asset('vendor/laravel-file-viewer/officetohtml/verySimpleImageViewer/js/jquery.verySimpleImageViewer.js') }}">
    </script>

    {{-- Office to HTML --}}
    <script src="{{ asset('vendor/laravel-file-viewer/officetohtml/officeToHtml/officeToHtml.js') }}"></script>

    <script>
        $(function() {
            $("#resolte-contaniner").officeToHtml({
                url: '{!! $file_url !!}',
                docxSetting: {
                    includeEmbeddedStyleMap: true,
                    includeDefaultStyleMap: true,
                    convertImage: mammoth.images.imgElement(function(image) {
                        return image.read("base64").then(function(imageBuffer) {
                            return {
                                src: "data:" + image.contentType + ";base64," + imageBuffer
                            };
                        });
                    }),
                    ignoreEmptyParagraphs: false,
                },

                // pdfSetting: {
                //     // setting for pdf
                // },
                // docxSetting: {
                //     // setting for docx
                // },
                pptxSetting: {
                    slidesScale: "50%", //Change Slides scale by percent
                    slideMode: true,
                    /** true,false*/
                    slideType: "revealjs",
                    /*'divs2slidesjs' (default) , 'revealjs'(https://revealjs.com) */
                    revealjsPath: "{{ asset('vendor/laravel-file-viewer/revealjs/dist/reveal.js') }}",
                    /*path to js file of revealjs. default:  './revealjs/reveal.js'*/
                    keyBoardShortCut: true,
                    /** true,false ,condition: slideMode: true*/
                    mediaProcess: true,
                    /** true,false: if true then process video and audio files */
                    jsZipV2: false,
                    slideModeConfig: {
                        first: 1,
                        nav: true,
                        /** true,false : show or not nav buttons*/
                        navTxtColor: "black",
                        /** color */
                        keyBoardShortCut: false,
                        /** true,false ,condition: */
                        showSlideNum: true,
                        /** true,false */
                        showTotalSlideNum: true,
                        /** true,false */
                        autoSlide: 1,
                        /** false or seconds , F8 to active ,keyBoardShortCut: true */
                        randomAutoSlide: false,
                        /** true,false ,autoSlide:true */
                        loop: true,
                        /** true,false */
                        background: false,
                        /** false or color*/
                        transition: "default",
                        /** transition type: "slid","fade","default","random" , to show transition efects :transitionTime > 0.5 */
                        transitionTime: 1 /** transition time between slides in seconds */
                    },
                    revealjsConfig: {
                        transition: 'zoom',
                        // backgroundTransition: 'zoom', 
                        // autoSlide: 5000,
                        // loop: true
                        slideNumber: true

                    } /*revealjs options. see https://revealjs.com */
                }
                // sheetSetting: {
                //     // setting for excel
                // },
                // imageSetting: {
                //     // setting for  images
                // }
            });
        });
    </script>
@endpush

@section('content')
    @include('laravel-file-viewer::docstyledef')

    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mt-3">

                <!-- Card Header-->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    @include('laravel-file-viewer::previewFileDetails')
                </div>

                <!-- Card Body -->
                <div class="card-body">
                    <div id="resolte-contaniner" class="preview_container"></div>
                </div>

            </div>
        </div>
    </div>
@endsection
