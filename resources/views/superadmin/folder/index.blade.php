@extends('layouts.superadmin.app')
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
                        <a href="{{route('superadmin.folder.create')}}" class="btn btn-warning btn-sm">Add Folder</a>
                    </div>
                    
                    <div class="card-body">    
                        @include('components.alert')
                        <div class="folder-list">
                        @foreach ($folders as $folder)
    <div class="folder-item">
        <div class="d-flex align-items-center justify-content-between" id="folderRow{{$folder->id}}" data-bs-toggle="collapse" data-bs-target="#subfolders{{$folder->id}}" aria-expanded="false" class="accordion-toggle">
            <div class="d-flex align-items-center">
                <div>
                    <i class="mdi mdi-folder me-2 font-24 text-warning"></i>
                </div>
                <div class="font-weight-bold folder-name">{{$folder->nama_folder}} </div>
              
            </div>
           
        </div>
        <p style="width:20%; float:right;">
        <a href="{{ route('tampilgrup', $folder->id) }}" style="width:20%;">Lihat Group Terdaftar</a></p>
        <div class="folder-actions">
    <div class="btn-group">
        <button type="button" class="btn btn-sm btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Actions
        </button>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#addSubfolderModal{{$folder->id}}">Add Subfolder</a>
           
            @if (!isset($folder) || !$folder->id_folder_induk)
            
                <a class="dropdown-item edit-group-btn" href="{{route('tampilfoldergroup', $folder->id)}}" >Edit Folder</a>
           
            @endif
            <form action="{{ route('folder.delete', ['id' => $folder->id]) }}" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="dropdown-item" onclick="return confirm('Yakin menghapus folder ini?')">Delete Folder</button>
            </form>
        </div>
    </div>
</div>

        <div class="subfolders collapse" id="subfolders{{$folder->id}}">
            @if(count($folder->subfolders) > 0)
                <div class="subfolder-list">
                    @include('partials.folder_recursive', ['subfolders' => $folder->subfolders])
                </div>
            @else
                <p>Folder ini kosong.</p>
            @endif
        </div>
    </div>
    @include('modals.rename_folder')
    @include('modals.adding_subfolder')
    @include('modals.edit_group')
@endforeach

                            @include('modals.add_folder')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>      
    <style>

.dataTables_paginate{
  float:right;
  text-align:
}

        .folder-item {
            cursor: pointer;
        }

.paginate_button {
    box-sizing:border-box;
    display:inline-block;
    min-width:1.5em;
    text-align:center;
    text-decoration:none !important;
    cursor:pointer;color:inherit !important;
    border:1px solid transparent;
    border-radius:2px;
    background:transparent
}

.dataTables_length{
  float:left;
}
.dataTables_wrapper 
.dataTables_length select{border:1px solid #aaa;border-radius:3px;padding:5px;background-color:transparent;color:inherit;padding:4px}
.dataTables_info{clear:both;float:left;padding-top:.755em}    
.dataTables_filter{text-align:right;}
.dataTables_filter input{border:1px solid #aaa;border-radius:3px;padding:5px;background-color:transparent;color:inherit;margin-left:3px}

.folder-item {
    border: 1px solid #ddd;
    padding: 10px;
    margin-bottom: 10px;
    border-radius: 5px;
}

.folder-name {
    margin-left: 10px;
}

.folder-actions {
    margin-top: 5px;
}

.subfolders {
    margin-left: 20px;
}

.subfolder-list {
    margin-top: 10px;
}
.folder-item {
    border: 1px solid #ddd;
    padding: 10px;
    margin-bottom: 10px;
    border-radius: 5px;
}

.folder-name {
    margin-left: 10px;
}

.folder-actions {
    margin-top: 5px;
}
/* CSS untuk merapikan tampilan button action */
.folder-actions {
    margin-top: 5px;
    display: inline-block;
}

.btn-group {
    display: inline-block;
    margin-right: 10px; /* Sesuaikan jarak antar button */
}

.dropdown-menu {
    min-width: 120px; /* Sesuaikan lebar dropdown jika diperlukan */
}


</style>

@endsection
