                                    <!-- Modal Edit Data -->
                                    <div class="modal fade" id="editFileModal-{{ $data->id }}" tabindex="-1"
                                        role="dialog" aria-labelledby="editFileModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editFileModalLabel">Rename
                                                        File</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form id="editFileForm-{{ $data->id }}" action="{{ route('home.file.update', $currentPath != null ? $currentPath . '/' . $data->slug : $data->slug) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <!-- Method HTTP untuk mengirim perubahan -->
                                                    <div class="modal-body">
                                                        <!-- Form untuk mengedit nama file -->
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
                                    <div class="modal fade" id="delete-modal-file-{{ $data->id }}" tabindex="-1"
                                        role="dialog" aria-labelledby="delete-modal-file-label-{{ $data->id }}"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="delete-modal-file-label-{{ $data->id }}">
                                                        Delete File</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure you want to delete the file {{ $data->name }}?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close</button>
                                                    <form
                                                        action="{{ route('home.destroy', ['slug' => $data->slug, 'source' => $data->source]) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
