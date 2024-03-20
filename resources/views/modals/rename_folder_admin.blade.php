
  <!-- Rename Folder -->
  <div class="modal fade" id="renameFolderModaladmin{{$folder->id}}" tabindex="-1" role="dialog" aria-labelledby="renameFolderModalLabeladmin{{$folder->id}}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="renameFolderModalLabeladmin{{$folder->id}}">Rename Folder</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form for renaming a folder -->
                <form name="saveform"  action="{{ route('folder.renameadmin', ['id' => $folder->id]) }}" method="POST"  onsubmit="return validateForm()">
                    @csrf <!-- Untuk melindungi dari serangan CSRF -->
                    <div class="form-group">
                        <label for="newFolderName{{$folder->id}}">Nama Folder</label>
                        <input type="text" class="form-control" id="newFolderName{{$folder->id}}" name="new_folder_name" value="{{$folder->nama_folder}}">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Rename</button>
            </form>
            </div>
        </div>
    </div>
</div>

