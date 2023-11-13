<!-- resources/views/partials/folder.blade.php -->

<!-- resources/views/partials/folder.blade.php -->

<tr>
    <td>
        <div class="d-flex align-items-center">
            <div>
                <i class="mdi mdi-folder me-2 font-24 text-warning"></i>
            </div>
            <div class="font-weight-bold folder-name">{{ $folder->nama_folder }}</div>
        </div>
    </td>
    <td>{{ $folder->created_at }}</td>
    <td></td>
    <td>{{ $folder->updated_at }}</td>
    <td></td>
    <td>
        <div class="btn-group">
            <button type="button" class="btn btn-sm btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Actions
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#addSubfolderModal">Add Subfolder</a>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#renameFolderModal{{ $folder->id }}">Rename Folder</a>
                <form action="{{ route('folder.delete', ['id' => $folder->id]) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="dropdown-item" onclick="return confirm('Yakin menghapus folder ini?')">Delete Folder</button>
                </form>
            </div>
        </div>
    </td>
</tr>

@if (!empty($folder->subfolders) && count($folder->subfolders) > 0)
    @foreach ($folder->subfolders as $subfolder)
        @include('partials.folder', ['folder' => $subfolder])
    @endforeach
@endif


 <!-- Rename Folder -->
 <div class="modal fade" id="renameFolderModal{{$folder->id}}" tabindex="-1" role="dialog" aria-labelledby="renameFolderModalLabel{{$folder->id}}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="renameFolderModalLabel{{$folder->id}}">Rename Folder</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form for renaming a folder -->
                <form action="{{ route('folder.rename', ['id' => $folder->id]) }}" method="POST">
                    @csrf <!-- Untuk melindungi dari serangan CSRF -->
                    <div class="form-group">
                        <label for="newFolderName{{$folder->id}}">New Folder Name</label>
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
<!-- Modal for Adding Subfolder -->
<div class="modal fade" id="addSubfolderModal" tabindex="-1" role="dialog" aria-labelledby="addSubfolderModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addSubfolderModalLabel">Add Subfolder</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Form for adding a subfolder -->
        <form action="{{ route('folder.createSubfolder', ['id' => $folder->id]) }}" method="POST">
            @csrf <!-- Untuk melindungi dari serangan CSRF -->
            <div class="form-group">
                <label for="subfolderName">Nama Subfolder</label>
                <input type="text" class="form-control" id="subfolderName" name="nama_subfolder">
            </div>
      </div>
      <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Add Subfolder</button>
        </form>
      </div>
    </div>
  </div>
</div>