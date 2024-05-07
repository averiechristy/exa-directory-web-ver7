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
                      <h4 class="card-title"><a href="{{ route('superadmin.usergroup.index') }}">User Group</a> / Detail Member {{$data->nama_group}}</h4>

                    
                  </div>
                  <div class="card-body">
                    
                    <div class="table-responsive">
                      <table class="table table-bordered" id="example">
                        <thead>
                          <tr>
                           
                            <th>Nama User</th>
                            <th>Nomor Pegawai</th>
                        <th>Cabang</th>
                          </tr>
                        </thead>
                        <tbody>
                         
                        @foreach ($member as $members)
                          <tr>
                          
                            <td>{{$members -> User -> nama_user}}</td>
                            <td>{{$members -> User -> no_pegawai}}</td>
<td>{{$members -> Cabang -> nama_cabang}}</td>
</tr>
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