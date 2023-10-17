<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <title>{{ $title ?? '' }}</title>

    {{-- Style --}}
    {{--  Font --}}
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free-6.4.2-web/css/all.min.css') }}">

    {{-- Template --}}
    <link href="{{ asset('css/sb-admin-2.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/logo-navbar.css') }}">

    {{-- Datatables --}}
    <link rel="stylesheet" href="{{ asset('vendor/datatables/css/dataTables.bootstrap4.css') }}">

    {{-- Folder tree style --}}
    <link rel="stylesheet" href="{{ asset('css/folder-tree.css') }}">

    {{-- @stack('css') --}}
    @stack('css')

    {{-- End of Style --}}
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                @include('home.layout.navbar')
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    @yield('content')
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Designed by <span style="color: #215EAD;">Start Bootstrap.</span> Coded by <span
                                style="color: #215EAD">Amiruddin Fikri</span> & <span style="color: #215EAD">Dike
                                Ayu</span> for PT Otsuka Indonesia, 2023.</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Yakin Logout ?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-primary">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    {{-- Script --}}
    {{-- Template --}}
    <script src="{{ asset('js/sb-admin-2.js') }}"></script>

    {{-- Jquery --}}
    <script src="{{ asset('vendor/jquery/jquery.js') }}"></script>

    {{-- Bootstrap --}}
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    {{-- Datatables --}}
    <script src="{{ asset('vendor/datatables/js/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('vendor/datatables/js/dataTables.bootstrap4.js') }}"></script>

    {{-- Custom --}}
    <script>
        // Tooggletip
        $(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });

        // Inisialisasi DataTable
        $(document).ready(function() {
            $('#dataTable').DataTable({
                "pageLength": 100,
            });
        });

        // Clickable row
        $(document).ready(function() {
            $('table tbody tr td[data-clickable="true"]').click(function() {
                var source = $(this).data('source'); // Dapatkan nilai data-source

                if (source) {
                    if (source === 'folder') {
                        // Jika source adalah 'folder', buka di tab ini
                        window.location = $(this).data('href');
                    } else if (source === 'file') {
                        // Jika source adalah 'file', buka di tab baru
                        var url = $(this).data('href');
                        if (url) {
                            window.open(url, '_blank');
                        }
                    }
                }
                return false;
            });
        });

        // Create Folder Modal
        $(document).ready(function() {
            // Ketika tombol "Create Folder" diklik
            $('#createFolderButton').click(function() {
                $('#createFolderModal').modal('show');
            });
        });

        // Edit Folder Modal
        $(document).ready(function() {
            // Menangani klik tombol "Edit" dan mengisi nilai input modal
            $('.edit-folder-button').click(function() {
                var modalTarget = $(this).data('target');
                var folderName = $(this).data('folder-name');

                // Mengisi nilai input modal dengan nama folder yang sedang diedit
                $(modalTarget + ' input[name="name"]').val(folderName);
            });

            // Reset form saat modal ditutup
            $('#editFolderModal, .modal.fade').on('hidden.bs.modal', function() {
                $('form').trigger('reset');
            });
        });

        // Upload File Modal
        $(document).ready(function() {
            // Tampilkan modal saat tombol di klik
            $('#uploadFileButton').click(function() {
                $('#uploadFileModal').modal('show');
            });
        });
    </script>

    {{-- @stack('js') --}}
    @stack('js')

    {{-- End of Script --}}
</body>

</html>
