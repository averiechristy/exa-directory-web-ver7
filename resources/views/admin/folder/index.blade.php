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
                        <a href="{{route('admin.folder.create')}}" class="btn btn-warning btn-sm">Add Folder</a>
                    </div>
                    <div class="card-body">                        
                        @include('components.alert')
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th> Folder</th>
                                     <th>Action</th>
                                     
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($folders as $folder)
                                        <tr >
                                            <td id="folderRow{{$folder->id}}" data-bs-toggle="collapse" data-bs-target="#subfolders{{$folder->id}}" aria-expanded="false" class="accordion-toggle">
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <i class="mdi mdi-folder me-2 font-24 text-warning"></i>
                                                    </div>
                                                    <div class="font-weight-bold folder-name">{{$folder->nama_folder}} </div>
                                                </div>
                                            </td>
                                           

                                            <td>
                                                @if (!isset($folder) || !$folder->id_folder_induk)
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-sm btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            Actions
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#addSubfolderModaladmin{{$folder->id}}">Add Subfolder</a>
                                                            <!-- <a class="dropdown-item" href="#" data-toggle="modal" data-target="#renameFolderModaladmin{{$folder->id}}">Rename Folder</a>       -->
                                                            <form action="{{ route('folder.deleteadmin', ['id' => $folder->id]) }}" method="POST" style="display: inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="dropdown-item" onclick="return confirm('Yakin menghapus folder ini?')">Delete Folder</button>
                                                            </form>
                                                            <!-- <a class="dropdown-item edit-group-btn"  href="#" data-toggle="modal" data-target="#editgroupadmin{{$folder->id}}" >Edit Group</a> -->
                                                            <a class="dropdown-item edit-group-btn" href="{{route('tampilfoldergroupadmin', $folder->id)}}" >Edit Folder</a>

                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-sm btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            Actions
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#addSubfolderModaladmin{{$folder->id}}">Add Subfolder</a>
                                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#renameFolderModaladmin{{$folder->id}}">Rename Folder</a>      
                                                            <form action="{{ route('folder.deleteadmin', ['id' => $folder->id]) }}" method="POST" style="display: inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="dropdown-item" onclick="return confirm('Yakin menghapus folder ini?')">Delete Folder</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                       

                                        <tr>
        <td colspan="6">
            <div class="collapse" id="subfolders{{$folder->id}}">
                @if(count($folder->subfolders) > 0)
                    <table class="table table-striped">
                        <tbody>
                            @include('partials.admin_folder_recursive', ['subfolders' => $folder->subfolders])
                        </tbody>
                    </table>
                @else
                    <p>Folder ini kosong.</p>
                @endif
            </div>
        </td>
    </tr>

    @include('modals.adding_subfolder_admin')
    
    @include('modals.rename_folder_admin')

    @include('modals.edit_group_admin')
                                      
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>      
    
    
@endsection
