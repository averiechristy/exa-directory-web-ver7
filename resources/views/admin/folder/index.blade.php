@extends('layouts.admin.app')
@section('content')
<div class="content-wrapper">            
          <div class="d-sm-flex align-items-center justify-content-between border-bottom">
          </div>
          <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content" class="content">
              <div class="card mt-5">
                  <div class="card-body py-3">
                      <h4 class="card-title">Folder</h4>
                      <a href="#" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#addFolderModal">Add Folder</a>
                  </div>
                  <div class="card-body">
                  @include('components.alert')
                    <div class="table-responsive">
                      <table class="table table-striped">
                        <thead>
                          <tr>
                            <th>Nama Folder</th>
                            <th>Created at</th>
                            <th>Created by</th>
                            <th>Updated at</th>
                            <th>Updated by</th>
                          </tr>
                        </thead>
                        <tbody>
                        @foreach ($folders as $folder)
    <tr>
      <td>
      <div class="d-flex align-items-center">
        <div>
          <i class="mdi mdi-folder me-2 font-24 text-warning"></i>
        </div>
        <div class="font-weight-bold folder-name">{{$folder->nama_folder}}</div>
      </div>
    </td>
    <td>{{$folder->created_at}}</td>
    <td></td>
    <td>{{$folder->updated_at}}</td>
    <td></td>
    <td>
      <div class="btn-group">
        <button type="button" class="btn btn-sm btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Actions
        </button>
        <div class="dropdown-menu">
        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#addSubfolderModal">Add Subfolder</a>
          <a class="dropdown-item" href="#" data-toggle="modal" data-target="#renameFolderModal{{$folder->id}}">Rename Folder</a>      
          <form action="{{ route('folder.delete', ['id' => $folder->id]) }}" method="POST" style="display: inline;">
    @csrf
    @method('DELETE')
    <button type="submit" class="dropdown-item" onclick="return confirm('Yakin menghapus folder ini?')">Delete Folder</button>
</form>
        </div>
      </div>
    </td>
  </tr>
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
        </tbody>
          </table>
         </div>
      </div>
    </div>
  </div>
</div>
</div>

  <!-- Modal for Adding Folder -->
<div class="modal fade" id="addFolderModal" tabindex="-1" role="dialog" aria-labelledby="addFolderModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addFolderModalLabel">Add Folder</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Form for adding a folder -->
        <form action="{{ route('folder.add') }}" method="POST" id="addFolderForm">
    @csrf <!-- Untuk melindungi dari serangan CSRF -->
    <div class="form-group">
        <label for="folderName">Nama Folder</label>
        <input type="text" class="form-control" id="folderName" name="nama_folder">
    </div>
      </div>
      <div class="modal-footer">
      <button type="submit" class="btn btn-primary" id="addFolderButton">Add</button>
</form>
      </div>
    </div>
  </div>
</div>
@endsection
