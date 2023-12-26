<!-- Modal for Adding Subfolder -->
<div class="modal fade" id="addSubfolderModaladmin{{$folder->id}}" tabindex="-1" role="dialog" aria-labelledby="addSubfolderModalLabeladmin{{$folder->id}}" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addSubfolderModalLabeladmin{{$folder->id}}">Add Subfolder</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Form for adding a subfolder -->
        <form action="{{ route('folder.createSubfolderadmin', ['id' => $folder->id]) }}" method="POST">
            @csrf 
            <!-- Untuk melindungi dari serangan CSRF -->
            <div class="form-group">
                <label for="subfolderName">Nama Subfolder</label>
                <input type="text" class="form-control" id="subfolderName" name="nama_subfolder">
            </div>
      </div>
      <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Add Folder</button>
        </form>
      </div>
    </div>
  </div>
</div>