@extends('layouts.user.app')
@section('content')
    <div>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <div class="container-fluid">
                    <h5>
                    <a href="{{ route('user.home')}}"> ... </a>
         /
    @foreach ($folder->getFullFolderPath() as $path)
        <a href="{{ route('show-folder', ['folderId' => $path['id']]) }}">
            {{ $path['nama_folder'] }}
        </a>
        /
    @endforeach
</h5>
<div id="myDataTable_filter" class="dataTables_filter mb-3" >
    <label for="search">Search
        <input id="search" placeholder oninput="applySearchFilter()">
    </label>
</div>
                    <!-- {{-- Display subfolders and files in a single table --}} -->
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Date Modified</th>
                                    <th scope="col">Type</th>

                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Display subfolders --}}
                                @foreach($folder->subfolders as $subfolder)
                                    <tr>
                                        <td>
                                            <a href="{{ route('show-folder', ['folderId' => $subfolder->id]) }}">
                                                <i class="fas fa-folder" style="color:#FFC107"></i>
                                                {{ $subfolder->nama_folder }}
                                            </a>
                                        </td>
                                        <td>{{$subfolder->updated_at}}</td>
                                        <td>Folder</td>
                                        <td>
                                    @if(auth()->user()->isFolderPinned($subfolder->id))
                                        <button class="btn btn-sm btn-danger" onclick="unpinFolder({{ $subfolder->id }}, 'folder')">Unpin Folder</button>
                                    @else
                                        <button class="btn btn-sm btn-info" onclick="pinFolder({{ $subfolder->id }}, 'folder')">Pin Folder</button>
                                    @endif
                                        </td>
                                    </tr>
                                @endforeach

                                {{-- Display files --}}
                                @foreach($folder->files->where('status_persetujuan', 'Disetujui')  as $file)
                                    <tr>
                                        <td>
                                            <a href="{{ route('user.kontenread', $file->id) }}" style=""  class="see-file">
                                                <i class="fas fa-file"></i>
                                                {{ $file->nama_file }}
                                            </a>
                                        </td>
                                        <td>
            @if ($file->status === 'berlaku')
                <span class="badge badge-success">Berlaku</span>
            @elseif ($file->status === 'tidak_berlaku')
                <span class="badge badge-danger">Tidak Berlaku</span>
            @else
                {{ $file->status }}
            @endif
    </td>
                                        <td>{{$file->updated_at}}</td>
                                        <td>File</td>
                                        <td>
    @if(auth()->user()->isFilePinned($file->id))
        <button class="btn btn-sm btn-danger" onclick="unpinFile({{ $file->id }}, 'file')">Unpin File</button>
    @else
        <button class="btn btn-sm btn-info" onclick="pinFile({{ $file->id }}, 'file')">Pin File</button>
    @endif
</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- File Modals --}}
                    @foreach($folder->files as $file)
                        <!-- <div class="modal fade" id="fileModal{{ $file->id }}" tabindex="-1" role="dialog" aria-labelledby="fileModalLabel{{ $file->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-xl" style="margin-top:5px;" role="document">
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
                                        {{-- Footer content --}}
                                    </div>
                                </div>
                            </div>
                        </div> -->
                    @endforeach
                </div>
            </div>
        </div>
    </div>


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


<script>
function pinFile(fileId) {
        $.ajax({
            type: 'POST',
            url: '/pin-file/' + fileId,
            data: {
                "_token": "{{ csrf_token() }}",
            },
            success: function(data) {
                location.reload();
            }
        });
    }

    function unpinFile(fileId) {
        $.ajax({
            type: 'POST',
            url: '/unpin-file/' + fileId,
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
@endsection
