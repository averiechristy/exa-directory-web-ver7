@extends('layouts.approval.app')
@section('content')
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">  
                <div class="d-sm-flex align-items-center justify-content-between border-bottom">  
                </div>
                <div id="content-wrapper" class="d-flex flex-column">
                  <!-- Main Content -->
                  <div id="content" class="content">       
                  @include('components.alert')            
  <table class="table table-bordered">
  <thead>
    <tr>
      <th >Judul Konten</th>
      <!-- <th >File</th> -->
      <th>Isi Konten</th>
      <th>Path</th>
      <th>User Group</th>
      <th>Status Persetujuan</th>
      <th>Catatan</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($data as $data)
    <tr>
      <td>{{$data->nama_file}}</td>
<td> 
  <a href="{{ route('tampilkontenapproval', $data->id) }}">Lihat isi konten</a>
      <td>{{ $data->folder->getFolderPath() }}</td>
      <td></td>
      <td>
        @if ($data->status_persetujuan === 'Disetujui')
                <span class="badge badge-success">Disetujui</span>
        @elseif ($data->status_persetujuan === 'Ditolak')
                <span class="badge badge-danger">Ditolak</span>
        @elseif ($data->status_persetujuan === 'Menunggu Persetujuan')
                <span class="badge badge-warning">Menunggu Persetujuan</span>
        @endif
      </td>
      <td>{{$data->catatan}}</td>
    <td>
    <button class="btn-edit" data-toggle="modal" data-target="#exampleModal{{ $data->id }}" ><i class="mdi mdi-pencil" style="color:white" ></i></button>                          
</td>
</tr>
<div class="modal fade" id="exampleModal{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ubah Status Persetujuan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form action="/updatestatus/{{$data->id}}" method="post" enctype="multipart/form-data">
      @csrf
      <div class="mb-3">
      <label for="exampleFormControlInput1" class="form-label">Status Persetujuan</label>
      <select name="status_persetujuan" class="form-select" aria-label="Default select example">
            <option disabled>Pilih Status Persetujuan</option>
            <option value="Menunggu Persetujuan" {{ $data->status_persetujuan == "Menunggu Persetujuan" ? 'selected' : '' }}>Menunggu Persetujuan</option>
            <option value="Disetujui" {{ $data->status_persetujuan == "Disetujui" ? 'selected' : '' }}>Disetujui</option>
            <option value="Ditolak" {{ $data->status_persetujuan == "Ditolak" ? 'selected' : '' }}>Ditolak</option>
      </select>
      </div>
<div class="mb-3">
  <label for="exampleFormControlInput1" class="form-label">Catatan</label>
  <textarea name="catatan" type="catatan" class="form-control" required> {{$data->catatan}}</textarea>
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
  </div>

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
  <!-- plugins:js -->
@endsection