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
                      <h4 class="card-title">User</h4>

                      <a href="{{route('admin.user.create')}}" class="btn btn-warning btn-sm">Add Data</a>
                  </div>
                  <div class="card-body">
                    
                    <div class="table-responsive">
                      <table class="table table-striped" id="example">
                        <thead>
                          <tr>
                            <th>Id User</th>
                            <th>Nama</th>
                            <th>No. Pegawai</th>
                            <th>Email</th>
                            <th>Cabang</th>
                            <th>Role</th>
                            <th>Created at</th>

                            <th>Created by</th>
                            <th>Updated at</th>
                            <th>Updated by</th>
                            
                            <th>Action</th>

                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>1</td>
                            <td>Tono</td>
                            <td>HO-123</td>
                            <td>tono@gmail.com</td>
                            <td>Head Office</td>
                            <td>User</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>

                              <button class="btn-edit"> <a href=""data-toggle="tooltip" title='Edit'><i class="mdi mdi-pencil" style="color:white" ></i></a></button>                  
                              <button class="btn-delete">  <a href=""data-toggle="tooltip" title='Hapus'><i class="mdi mdi-delete" style="color:white" ></i></a></button>            

                            </td>
                          </tr>

                          
                        
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>

            </div>

        </div>
        
  
    
  </div>

  @endsection