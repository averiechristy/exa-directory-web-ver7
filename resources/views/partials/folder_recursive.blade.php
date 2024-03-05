@foreach ($subfolders as $subfolder)
    <div class="folder-item">
        <div class="d-flex align-items-center justify-content-between" data-bs-toggle="collapse" data-bs-target="#subfolders{{$subfolder->id}}" aria-expanded="false" class="accordion-toggle" style="padding-left: {{ $loop->depth * 10 }}px;">
            <div class="d-flex align-items-center">
                <div>
                    <i class="mdi mdi-folder me-2 font-24 text-warning"></i>
                </div>
                <div class="font-weight-bold folder-name">{{$subfolder->nama_folder}}</div>
            </div>
            <div class="folder-actions">
                @if (!isset($subfolder) || !$subfolder->id_folder_induk)
                    <div class="btn-group-vertical">
                        <button type="button" class="btn btn-sm btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Actions
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#addSubfolderModal{{$subfolder->id}}">Add Subfolder</a>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#renameFolderModal{{$subfolder->id}}">Rename Folder</a>      
                            <form action="{{ route('folder.delete', ['id' => $subfolder->id]) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="dropdown-item" onclick="return confirm('Yakin menghapus folder ini?')">Delete Folder</button>
                            </form>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#editgroup{{$subfolder->id}}">Edit Group</a>
                        </div>
                    </div>
                @else 
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Actions
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#addSubfolderModal{{$subfolder->id}}">Add Subfolder </a>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#renameFolderModal{{$subfolder->id}}">Rename Folder</a>      
                            <form action="{{ route('folder.delete', ['id' => $subfolder->id]) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="dropdown-item" onclick="return confirm('Yakin menghapus folder ini?')">Delete Folder</button>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <!-- Rename Folder -->
        <div class="modal fade" id="renameFolderModal{{$subfolder->id}}" tabindex="-1" role="dialog" aria-labelledby="renameFolderModalLabel{{$subfolder->id}}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="renameFolderModalLabel{{$subfolder->id}}">Rename Folder</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Form for renaming a folder -->
                        <form name="simpanform"  action="{{ route('folder.rename', ['id' => $subfolder->id]) }}" method="POST"  onsubmit="return validasiform()">
                            @csrf <!-- Untuk melindungi dari serangan CSRF -->
                            <div class="form-group">
                                <label for="newFolderName{{$subfolder->id}}">Nama Folder</label>
                                <input type="text" class="form-control" id="newFolderName{{$subfolder->id}}" name="new_folder_name" value="{{$subfolder->nama_folder}}">
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
        <div class="modal fade" id="addSubfolderModal{{$subfolder->id}}" tabindex="-1" role="dialog" aria-labelledby="addSubfolderModalLabel{{$subfolder->id}}" aria-hidden="true">  
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
                        <form name="saveform"  action="{{ route('folder.createSubfolder', ['id' => $subfolder->id]) }}" method="POST"  onsubmit="return validateForm()">
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

        <div class="subfolders collapse" id="subfolders{{$subfolder->id}}">
            @if ($subfolder->subfolders->count() > 0)
                <div class="subfolder-list">
                    {{-- Recursively include subfolders --}}
                    @include('partials.folder_recursive', ['subfolders' => $subfolder->subfolders])
                </div>
            @else 
                <p>Folder ini kosong</p>
            @endif      
        </div>
    </div>

    <script>
  function validateForm() {
    var subfolderName = document.getElementById('subfolderName').value;
    if (subfolderName.trim() === '') {
      alert('Nama subfolder tidak boleh kosong.');
      return false;
    }
    return true;
  }
</script>


@endforeach
