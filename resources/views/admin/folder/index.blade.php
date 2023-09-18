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
                      <h4 class="card-title">Folder</h4>

                      <a href="{{route('admin.folder.create')}}" class="btn btn-warning btn-sm">Add Folder</a>
                  </div>
                  <div class="card-body">
                    
                    <div class="table-responsive">
                      <table class="table table-striped" id="example">
                        <thead>
                          <tr>
                          
                            <th>Nama Folder</th>
                            <th>Group</th>
                         
                            <th>Created at</th>

                            <th>Created by</th>
                            <th>Updated at</th>
                            <th>Updated by</th>
                            
                            <th>Action</th>

                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>
                              <a href="#" class="folderlink">
                              <div class="d-flex align-items-center">
                                  <div><i class="mdi mdi-folder me-2 font-24 text-warning "></i>
                                  </div>
                                  <div class="font-weight-bold ">Folder A</div>
                              </div>
                          </a>
                          </td>
                          
                            <td>Group BU</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>

                              <button class="btn-edit"> <a href=""data-toggle="tooltip" title='Edit'><i class="mdi mdi-pencil" style="color:white" ></i></a></button>                  
                              <button class="btn-delete">  <a href=""data-toggle="tooltip" title='Hapus'><i class="mdi mdi-delete" style="color:white" ></i></a></button>            

                            </td>
                          </tr>


                          <tr>
                              <td>
                                <a href="#" class="folderlink">
                                <div class="d-flex align-items-center">
                                    <div><i class="mdi mdi-folder me-2 font-24 text-warning "></i>
                                    </div>
                                    <div class="font-weight-bold ">Folder B</div>
                                </div>
                            </a>
                            </td>
                            
                              <td>Group HR</td>
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