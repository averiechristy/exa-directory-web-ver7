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

            <h5 class="h5 mb-2 text-gray-800 mt-3"> Detail Member "{{$data->nama_group}}"</h5>

        <br>
          
            <div class="card-body">
                    
                    <div class="table-responsive">
                      <table class="table table-bordered" id="example">
                        <thead>
                          <tr>
                            <th>Nama User</th>
                          </tr>
                        </thead>
                        <tbody>
                         
                        @foreach ($member as $member)
                          <tr>
                          
                            <td>{{$member -> User -> nama_user}}</td>
                           

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