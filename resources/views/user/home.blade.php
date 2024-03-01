@extends('layouts.user.app')
@section('content')
    <div>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <div class="container-fluid">
                <h4 style="color:#000;">Your Pins</h4>
                    <hr style="border-color:gray;">
                    <div class="row">
                    @foreach($userPins as $pin)
    <div class="col-md-4 mb-4">
        <div class="card bg-white shadow">
            <div class="card-body">
                @if($pin->folder_id)
                    <h5 class="card-title">
                        <a href="{{ route('show-folder', ['folderId' => $pin->folder_id]) }}">
                            <i class="fas fa-folder" style="color:#FFC107"></i>
                            {{ $pin->folder->nama_folder }}
                        </a>
                    </h5>
                @elseif($pin->file_id)
                    <h5 class="card-title">
                        <a href="" style="" data-toggle="modal" data-target="#fileModal{{ $pin->file_id }}" class="see-file">
                            <i class="fas fa-file"></i>
                            {{ $pin->file->nama_file }}
                        </a>
                    </h5>
                    <div class="modal fade" id="fileModal{{ $pin->file_id }}" tabindex="-1" role="dialog" aria-labelledby="fileModalLabel{{ $pin->file_id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-xl" style="margin-top:5px;" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="fileModalLabel{{ $pin->file_id }}"></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <iframe src="{{ asset('storage/files/' . $pin->file->file) }}" width="100%" height="600px"></iframe>
                                </div>
                                <div class="modal-footer">
                                    {{-- Footer content --}}
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endforeach
</div>
                    <h4 style="color:#000;">List Folders and Files</h4>
         
                    <div id="myDataTable_filter" class="dataTables_filter mb-3" >
    <label for="search">Search
        <input id="search" placeholder oninput="applySearchFilter()">
    </label>
</div>
                    <div class="table-responsive">
                    <table class="table">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Date Modified</th>
                                    <th>Type</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
@foreach($folders as $folder)
    <tr>
        <td>
            <a href="{{ route('show-folder', ['folderId' => $folder->id]) }}">            
                    <i class="fas fa-folder" style="color:#FFC107"></i>
                    {{ $folder->nama_folder }}
            </a>
        </td>       
        <td>{{$folder->updated_at}}</td>
        <td>Folder</td>
        <td>
            @if(auth()->user()->isFolderPinned($folder->id))
                <button class="btn btn-sm btn-danger" onclick="unpinFolder({{ $folder->id }})">Unpin Folder</button>
            @else
                <button class="btn btn-sm btn-info" onclick="pinFolder({{ $folder->id }})">Pin Folder</button>
            @endif
        </td>
    </tr>
@endforeach
        </tbody>
        </table>
     
        </div>
        </div>
        </div>
        </div>
        </div>
@endsection

<script>
    function pinFolder(folderId) {
        $.ajax({
            type: 'POST',
            url: '/pin-folder/' + folderId,
            data: {
                "_token": "{{ csrf_token() }}",
            },
            success: function(data) {
                location.reload();
            }
        });
    }

    function unpinFolder(folderId) {
        $.ajax({
            type: 'POST',
            url: '/unpin-folder/' + folderId,
            data: {
                "_token": "{{ csrf_token() }}",
            },
            success: function(data) {
                location.reload();
            }
        });
    }
</script>


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
    function applySearchFilter() {
    var searchInput = document.getElementById('search');
    var filter = searchInput.value.toLowerCase();
    
    // Mencari data yang sesuai dengan filter
    var filteredRows = Array.from(document.querySelectorAll("table tbody tr"));

    filteredRows.forEach(function(row) {
        var rowText = row.textContent.toLowerCase();
        if (rowText.includes(filter)) {
            row.style.display = ""; // Menampilkan baris yang sesuai dengan filter
        } else {
            row.style.display = "none"; // Menyembunyikan baris yang tidak sesuai dengan filter
        }
    });

    // Menangani kasus khusus jika tidak ada hasil pencarian
    var noResultsMessage = document.getElementById('no-results-message');
    if (filteredRows.length === 0) {
        noResultsMessage.style.display = ""; // Menampilkan pesan jika tidak ada hasil pencarian
    } else {
        noResultsMessage.style.display = "none"; // Menyembunyikan pesan jika ada hasil pencarian
    }
}

</script>
