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
                    <div class="dataTables_length " id="myDataTable_length">
<label for="entries"> Show
<select id="entries" name="myDataTable_length" aria-controls="myDataTable"  onchange="changeEntries()" class>
<option value="10">10</option>
<option value="25">25</option>
<option value="50">50</option>
<option value="100">100</option>
</select>
entries
</label>
</div>

<div id="myDataTable_filter" class="dataTables_filter mb-3" >
    <label for="search">Search
        <input id="search" placeholder>
    </label>
</div>                    
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
                                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#addSubfolderModal{{$folder->id}}">Add Subfolder</a>
                                                            <!-- <a class="dropdown-item" href="#" data-toggle="modal" data-target="#renameFolderModal{{$folder->id}}">Rename Folder</a>       -->
                                                            <form action="{{ route('folder.delete', ['id' => $folder->id]) }}" method="POST" style="display: inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="dropdown-item" onclick="return confirm('Yakin menghapus folder ini?')">Delete Folder</button>
                                                            </form>
                                                            <!-- <a class="dropdown-item edit-group-btn"  href="#" data-toggle="modal" data-target="#editgroup{{$folder->id}}" >Edit Group</a> -->
                                                            <a class="dropdown-item edit-group-btn" href="{{route('tampilfoldergroup', $folder->id)}}" >Edit Folder</a>

                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-sm btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            Actions
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#addSubfolderModal{{$folder->id}}">Add Subfolder</a>
                                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#renameFolderModal{{$folder->id}}">Rename Folder</a>      
                                                            <form action="{{ route('folder.delete', ['id' => $folder->id]) }}" method="POST" style="display: inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="dropdown-item" onclick="return confirm('Yakin menghapus folder ini?')">Delete Folder</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                        </tr>

                                        <tr>
                                            <td colspan="6">
                                                <div class="collapse" id="subfolders{{$folder->id}}">
                                                    @if(count($folder->subfolders) > 0)
                                                        <table class="table table-striped">
                                                            <tbody>
                                                                @include('partials.folder_recursive', ['subfolders' => $folder->subfolders])
                                                            </tbody>
                                                        </table>
                                                    @else
                                                        <p>Folder ini kosong.</p>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        @include('modals.rename_folder')
                                        @include('modals.adding_subfolder')
                                        @include('modals.edit_group')
                                    @endforeach

                                    @include('modals.add_folder')
                                </tbody>
                            </table>
                            <div class="dataTables_info" id="dataTableInfo" role="status" aria-live="polite">
    Showing <span id="showingStart">1</span> to <span id="showingEnd">10</span> of <span id="totalEntries">0</span> entries
</div>
        
<div class="dataTables_paginate paging_simple_numbers" id="myDataTable_paginate">
    
    <a href="#" class="paginate_button" id="doublePrevButton" onclick="doublePreviousPage()"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a>
    <a href="#" class="paginate_button" id="prevButton" onclick="previousPage()"><i class="fa fa-angle-left" aria-hidden="true"></i></a>
    <span>
        <a id="pageNumbers" aria-controls="myDataTable" role="link" aria-current="page" data-dt-idx="0" tabindex="0"></a>
    </span>
    <a href="#" class="paginate_button" id="nextButton" onclick="nextPage()"><i class="fa fa-angle-right" aria-hidden="true"></i></a>
    <a href="#" class="paginate_button" id="doubleNextButton" onclick="doubleNextPage()"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
</div>
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

</style>

@endsection
