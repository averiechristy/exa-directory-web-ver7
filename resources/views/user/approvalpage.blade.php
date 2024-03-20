@extends('layouts.user.app')
@section('content')
    <div>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <div class="container-fluid">
             

                   
                    <h4 style="color:#000;">List File Approval</h4>
         
                    <div id="myDataTable_filter" class="dataTables_filter mb-3" >

                    @include('components.alert')   
    <label for="search">Search
        <input id="search" placeholder oninput="applySearchFilter()">
    </label>
</div>

<div class="table-responsive" >         
  <table class="table table-bordered">
  <thead>
    <tr>
      <th >Judul Konten</th>
      <!-- <th >File</th> -->
      <th>Isi Konten</th>
      <th>Path</th>
      <th>User Group</th>
      <th>Created By</th>
      <th>Created At</th>
      <th>Updated By</th>
      <th>Updated At</th>
      
      <th>Status Persetujuan</th>
      <th>Catatan</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($groupedResults as $data)
    <tr>
    <td>{{$data['nama_file']}}</td>

<td> 
  <a href="{{ route('tampilkontenapprovaluser', $data['id']) }}">Lihat isi konten</a>
  <td>{{ $data['folder'] }}</td>
     
      <td>
    @foreach ($data['usergroup_ids'] as $usergroup_id)
        <ul>  
            <li> <a href="{{ route('detailmemberapprovaluser',$usergroup_id ) }}" class="detail-member">{{ \App\Models\UserGroup::find($usergroup_id)->nama_group }}</a></li> 
        </ul>
    @endforeach
</td>
<td>{{ $data['created_by'] }}</td>
<td>{{ $data['created_at'] }}</td>
<td>{{ $data['updated_by'] }}</td>
<td>{{ $data['updated_at'] }}</td>
      <td>
        @if ($data['status_persetujuan'] === 'Disetujui')
                <span class="badge badge-success">Disetujui</span>
        @elseif ($data['status_persetujuan'] === 'Ditolak')
                <span class="badge badge-danger">Ditolak</span>
        @elseif ($data['status_persetujuan'] === 'Menunggu Persetujuan')
                <span class="badge badge-warning">Menunggu Persetujuan</span>
        @endif
      </td>

      <td>{{$data['catatan']}}</td>
    <td>
    <button class="btn-edit" data-toggle="modal" data-target="#exampleModal{{ $data['id'] }}" ><i class="mdi mdi-pencil" style="color:white" ></i></button>                          
</td>
</tr>
<div class="modal fade" id="exampleModal{{ $data['id'] }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ubah Status Persetujuan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form action="/updatestatususer/{{$data['id']}}" method="post" enctype="multipart/form-data">
      @csrf
      <div class="mb-3">
      <label for="exampleFormControlInput1" class="form-label">Status Persetujuan</label>
      <select name="status_persetujuan" class="form-select" aria-label="Default select example">
            <option disabled>Pilih Status Persetujuan</option>
            <option value="Menunggu Persetujuan" {{$data['status_persetujuan'] == "Menunggu Persetujuan" ? 'selected' : '' }}>Menunggu Persetujuan</option>
            <option value="Disetujui" {{$data['status_persetujuan'] == "Disetujui" ? 'selected' : '' }}>Disetujui</option>
            <option value="Ditolak" {{$data['status_persetujuan'] == "Ditolak" ? 'selected' : '' }}>Ditolak</option>
      </select>
      </div>
<div class="mb-3">
  <label for="exampleFormControlInput1" class="form-label">Catatan</label>
  <textarea name="catatan" type="catatan" class="form-control" required> {{$data['catatan']}}</textarea>
</div>
      </div>
      <div class="modal-footer">       
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
</form>
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
.btn-edit {
  border: none;
  border-radius: 8px;
  background: #0267FF;
  width: 30px;
  height: 30px;
  flex-shrink: 0;
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
