<!-- folder_recursive.blade.php -->
@foreach ($subfolders as $subfolder)
    <tr >
    <td data-bs-toggle="collapse" data-bs-target="#subfolders{{$subfolder->id}}" aria-expanded="false" class="accordion-toggle" style="padding-left: {{ $loop->depth * 10 }}px;">
                <div class="d-flex align-items-center">
                <div>
                    <i class="mdi mdi-folder me-2 font-24 text-warning"></i>
                </div>
                <div class="font-weight-bold folder-name">{{$subfolder->nama_folder}}</div>
            </div>
        </td>
       
        <td>
                                                @if (!isset($folder) || !$subfolder->id_folder_induk)
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-sm btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            Actions
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#addSubfolderModaladmin{{$subfolder->id}}">Add Subfolder</a>
                                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#renameFolderModaladmin{{$subfolder->id}}">Rename Folder</a>      
                                                            <form action="{{ route('folder.deleteadmin', ['id' => $subfolder->id]) }}" method="POST" style="display: inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="dropdown-item" onclick="return confirm('Yakin menghapus folder ini?')">Delete Folder</button>
                                                            </form>
                                                            <a class="dropdown-item edit-group-btn"  href="#" data-toggle="modal" data-target="#editgroupadmin{{$subfolder->id}}" >Edit Group</a>
                                                            <!-- <a class="dropdown-item edit-group-btn" href="{{route('tampilfoldergroup', $folder->id)}}" >Edit Group</a> -->

                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-sm btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            Actions
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#addSubfolderModaladmin{{$subfolder->id}}">Add Subfolder</a>
                                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#renameFolderModaladmin{{$subfolder->id}}">Rename Folder</a>      
                                                            <form action="{{ route('folder.deleteadmin', ['id' => $subfolder->id]) }}" method="POST" style="display: inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="dropdown-item" onclick="return confirm('Yakin menghapus folder ini?')">Delete Folder</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                @endif
                                            </td>
     
    </tr>



    <td colspan="6">
                                                <div class="collapse" id="subfolders{{$subfolder->id}}">
                                                    <table class="table table-striped">
                                                    @if ($subfolder->subfolders->count() > 0)
                                                        <tbody>
                                                        {{-- Recursively include subfolders --}}
   
        @include('partials.admin_folder_recursive', ['subfolders' => $subfolder->subfolders])
                                                 
    </tbody>
    @else 
    <p>Folder ini kosong</p>
    @endif      
                                                    </table>
                                                </div>
                                            </td>


                                            
  <!-- Rename Folder -->
  <div class="modal fade" id="renameFolderModaladmin{{$subfolder->id}}" tabindex="-1" role="dialog" aria-labelledby="renameFolderModalLabeladmin{{$subfolder->id}}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="renameFolderModalLabeladmin{{$subfolder->id}}">Rename Folder</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form for renaming a folder -->
                <form action="{{ route('folder.renameadmin', ['id' => $subfolder->id]) }}" method="POST">
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
<div class="modal fade" id="addSubfolderModaladmin{{$subfolder->id}}" tabindex="-1" role="dialog" aria-labelledby="addSubfolderModalLabeladmin{{$folder->id}}" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addSubfolderModalLabeladmin{{$subfolder->id}}">Add Subfolder</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Form for adding a subfolder -->
        <form action="{{ route('folder.createSubfolderadmin', ['id' => $subfolder->id]) }}" method="POST">
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

                                            
@endforeach
