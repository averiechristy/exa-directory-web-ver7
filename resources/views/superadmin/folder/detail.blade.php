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
                      <h4 class="card-title"><a href="{{ route('superadmin.folder.index') }}">Folder</a> / Detail Group Folder {{$data->nama_folder}}</h4>

                    
                  </div>
                  <div class="card-body">
                    
                    <div class="table-responsive">
                      <table class="table table-bordered" id="example">
                        <thead>
                          <tr>
                           
                            <th>Daftar Group</th>
                         

                          </tr>
                        </thead>
                        <tbody>
                         
                        @foreach ($group as $group)
                          <tr>
                          
                            <td>{{$group -> UserGroup -> nama_group}}</td>
                           
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