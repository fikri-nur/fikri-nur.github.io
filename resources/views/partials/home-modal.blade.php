                                    {{-- Create Folder Modal --}}
                                    <div class="modal fade" id="createFolderModal" tabindex="-1" role="dialog"
                                        aria-labelledby="createFolderModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="createFolderModalLabel">Create New
                                                        Folder</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form id="createFolderForm"
                                                    action="{{ $currentPath != null ? route('home.nested.store', $currentPath) : route('home.store') }}"
                                                    method="POST">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <!-- Form untuk membuat folder -->
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="name">Name</label>
                                                                <input class="form-control" type="text"
                                                                    id="name" name="name">
                                                            </div>
                                                        </div>
                                                        @if ($currentPath == null)
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label for="department">Department</label>
                                                                    <select name="dept_id" id="department"
                                                                        class="form-control">
                                                                        <option selected disabled>Pilih Departemen
                                                                        </option>
                                                                        <option value="">Semua Departemen</option>
                                                                        @foreach ($departments as $department)
                                                                            <option value="{{ $department->id }}">
                                                                                {{ $department->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Create
                                                            Folder</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal untuk Upload File -->
                                    <div class="modal fade" id="uploadFileModal" tabindex="-1" role="dialog"
                                        aria-labelledby="uploadFileModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="uploadFileModalLabel">
                                                        {{ __('Upload File') }}</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <!-- Form untuk membuat folder -->
                                                    <div class="col-12">
                                                        <form
                                                            action="{{ $currentPath != null ? route('home.nested.files.store', $currentPath) : route('home.files.store') }}"
                                                            method="POST" enctype="multipart/form-data"
                                                            class="dropzone" id="my-dropzone">
                                                            @csrf
                                                        </form>
                                                        <br>
                                                        <div id="upload-progress" class="progress">
                                                            <div id="upload-progress-bar" class="progress-bar"
                                                                role="progressbar" style="width: 0%" aria-valuenow="0"
                                                                aria-valuemin="0" aria-valuemax="100">0%</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-primary"
                                                        id="upload-button">Upload</button>
                                                    <a class="btn btn-success" href="{{ $currentPath != null ? route('home.folder.nested', ['slug' => $currentPath]) : route('home') }}">Refresh
                                                        Directory</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
