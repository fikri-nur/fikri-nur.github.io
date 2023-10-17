                                    <!-- Modal Edit Data -->
                                    <div class="modal fade" id="editFolderModal-{{ $data->id }}" tabindex="-1"
                                        role="dialog" aria-labelledby="editFolderModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editFolderModalLabel">Rename
                                                        Folder</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form id="editFolderForm-{{ $data->id }}"
                                                    action="{{ route('home.folder.update', $data->slug) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <!-- Method HTTP untuk mengirim perubahan -->
                                                    <div class="modal-body">
                                                        <!-- Form untuk mengedit nama folder -->
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="name">Name</label>
                                                                <input class="form-control" type="text"
                                                                    id="name" name="name"
                                                                    value="{{ $data->name }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-success">Rename</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal konfirmasi hapus data -->
                                    <div class="modal fade" id="delete-modal-folder-{{ $data->id }}" tabindex="-1"
                                        role="dialog" aria-labelledby="delete-modal-folder-{{ $data->id }}"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="delete-modal-folder-label-{{ $data->id }}">
                                                        Delete Folder</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure you want to delete the folder {{ $data->name }}?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close</button>
                                                    <form action="{{ route('home.destroy', ['slug' => $data->slug, 'source' => $data->source]) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
