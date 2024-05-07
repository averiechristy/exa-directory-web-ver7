@extends('layouts.admin.app')

@section('content')

<div class="content-wrapper">
          
  <div class="d-sm-flex align-items-center justify-content-between border-bottom"></div>
  
  <div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content" class="content">
      
      <div class="card mt-5">
        <div class="card-body py-3">
          <h4 class="card-title"><a href="{{ route('admin.folder.index') }}">Folder</a> / Detail Group Folder {{$data->nama_folder}}</h4>
        </div>
        <div class="card-body">
          <table class="table">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Group</th>
              </tr>
            </thead>
            <tbody>
              @foreach($namaGroups as $index => $namaGroup)
                <tr>
                  <td>{{ $index + 1 }}</td>
                  <td>{{ $namaGroup }}</td>
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
