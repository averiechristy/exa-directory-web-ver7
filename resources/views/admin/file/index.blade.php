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
                      <h4 class="card-title">File</h4>

                      <a href="{{route('admin.file.create')}}" class="btn btn-warning btn-sm">Add File</a>
                  </div>
                  <div class="card-body">
                    
                    <div class="table-responsive">
                      <table class="table table-striped" id="example">
                        <thead>
                          <tr>
                          
                            <th>Nama File</th>
                            <th>Path Folder</th>
                            <th>Size </th>
                            <th>Jenis File </th>
                            <th>Share Email</th>

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
                                  <div><i class="mdi mdi-file me-2 font-24 text-warning "></i>
                                  </div>
                                  <div class="font-weight-bold ">Peraturan perusahaan.pdf</div>
                              </div>
                          </a>
                          </td>
                          
                            <td>Folder 1 / Folder 3</td>
                            <td>2 mb</td>
                            <td>pdf</td>
                            <td> <a href=""> <button class="btnlink">Share</button></a></td>

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