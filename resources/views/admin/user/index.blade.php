@extends('layouts.admin.app')

@section('content')
<div class="main-panel">
<div class="content-wrapper">
          
           
             
          <div class="d-sm-flex align-items-center justify-content-between border-bottom">
           
           
            
          </div>
          <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content" class="content">
              
              <div class="card mt-5">
                  <div class="card-body py-3">
                      <h4 class="card-title">User</h4>

                      <a href="{{route('admin.user.create')}}" class="btn btn-warning btn-sm">Add Data</a>
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
                           
                            <th>Nama<i class="fa fa-sort"></i></th>
                            <th>No. Pegawai<i class="fa fa-sort"></i></th>
                            <th>Email<i class="fa fa-sort"></i></th>
                            <th>Cabang<i class="fa fa-sort"></i></th>
                            <th>Role<i class="fa fa-sort"></i></th>
                            <th>Approval / Non Approval<i class="fa fa-sort"></i></th>
                            <th>Aktif / Tidak Aktif<i class="fa fa-sort"></i></th>
                            <th>Created at<i class="fa fa-sort"></i></th>

                            <th>Created by<i class="fa fa-sort"></i></th>
                            <th>Updated at<i class="fa fa-sort"></i></th>
                            <th>Updated by<i class="fa fa-sort"></i></th>
                            
                            <th>Action<i class="fa fa-sort"></i></th>

                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($users as $user)
                          <tr>
                           
                            <td>{{$user->nama_user}}</td>
                            <td>{{$user->no_pegawai}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->Cabang->nama_cabang}}</td>
                            <td>{{$user->Role->nama_role}}</td>
                            <td>
    @if($user->is_approval == 1)
        Approval
    @elseif ($user->is_approval == 0)
        Non Approval
    @endif
</td>
<td>
            @if ($user->is_active == 1)
                <span class="badge badge-success">Aktif</span>
            @elseif ($user->is_active == 0)
                <span class="badge badge-danger">Tidak Aktif</span>
          
            @endif
    </td>
                            <td>{{$user->created_at}}</td>
                            <td>{{$user->created_by}}</td>
                            <td>{{$user->updated_at}}</td>
                            <td>{{$user->updated_by}}</td>
                            <td>
                            @if ($user->is_active == 1)
                            <form action="{{ route('admin.reset-password', ['user' => $user->id]) }}" method="POST">
                @csrf
                <button type="submit" class="btn-reset show_confirm2" data-toggle="tooltip" title='Reset Password'><i class="mdi mdi-refresh"  style="color:white" ></i></button>
            </form>
                            <a  href="{{route('admintampiluser', $user->id)}}"data-toggle="tooltip" title='Edit'><button class="btn-edit mt-1"><i class="mdi mdi-pencil" style="color:white" ></i></button></a>        
                            <form method="POST" action="{{ route('admindeleteuser', $user->id) }}">
                            @csrf
                            <input name="_method" type="hidden" value="DELETE">
                            <button type="submit" class="btn-delete mt-1 show_confirm" data-toggle="tooltip" title='Hapus'><i class="mdi mdi-delete" style="color:white;" ></i></button>
                        </form> 
                        
                        @else
                        <form method="POST" action="{{ route('adminaktifkanuser', $user->id) }}">
    @csrf
    <button type="submit" class="btn btn-sm btn-primary mt-1 show_confirm3" data-toggle="tooltip"> Aktifkan User</button>
</form>
                        @endif
                            </td>
                          </tr>
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
  </div>
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

<style>
    .badge-success{
      background-color : green;
    }

    .badge-warning {
        background-color : orange;
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
  <script>
// Tambahkan event listener untuk setiap ikon sort
document.querySelectorAll('thead th i.fa-sort').forEach(function(icon) {
    icon.addEventListener('click', function() {
        // Ambil status sort dari atribut data
        var sortStatus = this.dataset.sort || 'asc';

        // Hapus kelas active dari semua ikon
        document.querySelectorAll('thead th i').forEach(function(icon) {
            icon.classList.remove('fa-sort-up');
            icon.classList.remove('fa-sort-down');
        });

        // Periksa status sort dan atur ikon yang sesuai
        if (sortStatus === 'asc') {
            this.classList.add('fa-sort-up');
            this.dataset.sort = 'desc'; // Toggle status sort menjadi 'desc'
        } else {
            this.classList.add('fa-sort-down');
            this.dataset.sort = 'asc'; // Toggle status sort menjadi 'asc'
        }

        // Ambil indeks kolom yang diurutkan
        var columnIndex = Array.from(this.parentNode.parentNode.children).indexOf(this.parentNode);

        // Ambil semua baris data
        var rows = Array.from(document.querySelectorAll('tbody tr'));

        // Lakukan pengurutan data
        rows.sort(function(rowA, rowB) {
            var valueA = rowA.children[columnIndex].textContent;
            var valueB = rowB.children[columnIndex].textContent;

            // Lakukan pengurutan berdasarkan nilai teks
            if (sortStatus === 'asc') {
                return valueA.localeCompare(valueB);
            } else {
                return valueB.localeCompare(valueA);
            }
        });

        // Perbarui tbody dengan baris yang telah diurutkan
        var tbody = document.querySelector('tbody');
        rows.forEach(function(row) {
            tbody.appendChild(row);
        });
    });
});

</script>
  @endsection