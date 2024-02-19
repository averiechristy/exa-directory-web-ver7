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
                      <h4 class="card-title">File</h4>

                      <a href="{{route('admin.file.create')}}" class="btn btn-warning btn-sm">Add File</a>
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
                    <table class="table table-striped" >
                    <thead>
                          <tr>
                            <th>Judul Konten</th>
                            <th>Path Folder</th>
                            <th>Size </th>
                            <th>Jenis File </th>
                            <th>Status</th>
                            <th>Lihat File</th>
                            <th>Created at</th>
                            <th>Created by</th>
                            <th>Updated at</th>
                            <th>Updated by</th>                 
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                        @foreach($filesByFolder as $folder_id => $files)
                        @foreach($files as $file)
                         <tr>
                        <td>
                              <a href="#" class="folderlink">
                              <div class="d-flex align-items-center">
                                  <div><i class="mdi mdi-file me-2 font-24 text-warning "></i>
                                  </div>
                                  <div class="font-weight-bold ">{{$file -> nama_file}}</div>
                              </div>
                        </a>
                        </td>
                          
                          <td>{{ $file->folder->getFolderPath() }}</td>
                          <td>{{$file -> size}}</td>
                            <td>{{$file -> type}}</td>
                            <td>
                            @if ($file->status === 'berlaku')
        <span class="badge badge-success">Berlaku</span>
            @elseif ($file->status === 'tidak_berlaku')
                <span class="badge badge-danger">Tidak Berlaku</span>
            @else
                {{ $file->status }}
            @endif
        </td>
<td>
    <a href="" data-toggle="modal" data-target="#fileModal{{ $file->id }}" class="see-file">Lihat File</a>
</td>
<div class="modal fade" id="fileModal{{ $file->id }}" tabindex="-1" role="dialog" aria-labelledby="fileModalLabel{{ $file->id }}" aria-hidden="true">

<div class="modal-dialog modal-dialog-centered modal-xl"  style="margin-top:5px;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="fileModalLabel{{ $file->id }}"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <iframe src="{{ asset('storage/files/' . $file->file) }}" width="100%" height="600px"></iframe>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
                        <td>{{$file->created_at}}</td>
                        <td>{{$file->created_by}}</td>
                        <td>{{$file->updated_at}}</td>
                        <td>{{$file->updated_by}}</td>
                        <td>
                        @if($file->cabang_id_user != 1)
                             <a  href="{{route('admintampilfile', $file->id)}}"data-toggle="tooltip" title='Edit'><button class="btn-edit"><i class="mdi mdi-pencil" style="color:white" ></i></button></a>        
                             <form method="POST" action="{{ route('admindeletefile', $file->id) }}">
                        @csrf
                            <input name="_method" type="hidden" value="DELETE">
                            <button type="submit" class="btn-delete show_confirm mt-1" data-toggle="tooltip" title='Hapus'><i class="mdi mdi-delete" style="color:white;"></i></button>
                        </form>  
                        @else    
                        <p>Action Disabled</p>
                        @endif
                        </td>
                        </tr>
@endforeach  
@endforeach    
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
    .badge-success{
      background-color : green;
    }

    .badge-danger{
      background-color : red;
    }

    .modal-dialog-tes {
      margin:20px;

    }
    .close {
      background-color :white;
      border:none;
    }
  </style>

  
<style>

.dataTables_paginate{
  float:right;
  text-align:
}


.paginate_button {box-sizing:border-box;
    display:inline-block;
    min-width:1.5em;
    text-align:center;
    text-decoration:none !important;
    cursor:pointer;color:inherit !important;
    border:1px solid transparent;
    border-radius:2px;
    background:transparent}

  
.dataTables_length{
  float:left;
}


.dataTables_wrapper 
.dataTables_length select{border:1px solid #aaa;border-radius:3px;padding:5px;background-color:transparent;color:inherit;padding:4px}
.dataTables_info{clear:both;float:left;padding-top:.755em}    
.dataTables_filter{text-align:right;}
.dataTables_filter input{border:1px solid #aaa;border-radius:3px;padding:5px;background-color:transparent;color:inherit;margin-left:3px}


</style>

  <script>
    var itemsPerPage = 10; // Ubah nilai ini sesuai dengan jumlah item per halaman
    var currentPage = 1;
    var filteredData = [];
    
    function initializeData() {
    var tableRows = document.querySelectorAll("table tbody tr");
    filteredData = Array.from(tableRows); // Konversi NodeList ke array
    updatePagination();
}

// Panggil fungsi initializeData() untuk menginisialisasi data saat halaman dimuat
initializeData();
    
function doublePreviousPage() {
        if (currentPage > 1) {
            currentPage = 1;
            updatePagination();
        }
    }
    
function nextPage() {
    var totalPages = Math.ceil(document.querySelectorAll("table tbody tr").length / itemsPerPage);
    if (currentPage < totalPages) {
        currentPage++;
        updatePagination();
    }
}
  
function doubleNextPage() {
    var totalPages = Math.ceil(document.querySelectorAll("table tbody tr").length / itemsPerPage);
    if (currentPage < totalPages) {
        currentPage = totalPages;
        updatePagination();
    }
}

    function previousPage() {
        if (currentPage > 1) {
            currentPage--;
            updatePagination();
        }
    }
 
    function updatePagination() {
    var startIndex = (currentPage - 1) * itemsPerPage;
    var endIndex = startIndex + itemsPerPage;

    // Sembunyikan semua baris
    var tableRows = document.querySelectorAll("table tbody tr");
    tableRows.forEach(function (row) {
        row.style.display = 'none';
    });

    // Tampilkan baris untuk halaman saat ini
    for (var i = startIndex; i < endIndex && i < filteredData.length; i++) {
        filteredData[i].style.display = 'table-row';
    }

    // Update nomor halaman
    var totalPages = Math.ceil(filteredData.length / itemsPerPage);
    var pageNumbers = document.getElementById('pageNumbers');
    pageNumbers.innerHTML = '';

    var totalEntries = filteredData.length;

    document.getElementById('showingStart').textContent = startIndex + 1;
    document.getElementById('showingEnd').textContent = Math.min(endIndex, totalEntries);
    document.getElementById('totalEntries').textContent = totalEntries;

    var pageRange = 3; // Jumlah nomor halaman yang ditampilkan
    var startPage = Math.max(1, currentPage - Math.floor(pageRange / 2));
    var endPage = Math.min(totalPages, startPage + pageRange - 1);

    for (var i = startPage; i <= endPage; i++) {
        var pageButton = document.createElement('button');
        pageButton.className = 'btn btn-primary btn-sm mr-1 ml-1';
        pageButton.textContent = i;
        if (i === currentPage) {
            pageButton.classList.add('btn-active');
        }
        pageButton.onclick = function () {
            currentPage = parseInt(this.textContent);
            updatePagination();
        };
        pageNumbers.appendChild(pageButton);
    }
}
    function changeEntries() {
        var entriesSelect = document.getElementById('entries');
        var selectedEntries = parseInt(entriesSelect.value);

        // Update the 'itemsPerPage' variable with the selected number of entries
        itemsPerPage = selectedEntries;

        // Reset the current page to 1 when changing the number of entries
        currentPage = 1;

        // Update pagination based on the new number of entries
        updatePagination();
    }

    function applySearchFilter() {
    var searchInput = document.getElementById('search');
    var filter = searchInput.value.toLowerCase();
    
    // Mencari data yang sesuai dengan filter
    filteredData = Array.from(document.querySelectorAll("table tbody tr")).filter(function (row) {
        var rowText = row.textContent.toLowerCase();
        return rowText.includes(filter);
    });

    // Set currentPage kembali ke 1
    currentPage = 1;

    updatePagination();
}

updatePagination();



    // Menangani perubahan pada input pencarian
    document.getElementById('search').addEventListener('input', applySearchFilter);
    // Panggil updatePagination untuk inisialisasi
  
             
</script>
@endsection