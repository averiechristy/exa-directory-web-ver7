@extends('layouts.user.app')

@section('content')

    <!-- Page Wrapper -->
    <div>

        <!-- Sidebar -->
      
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <!-- End of Topbar -->
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800"></h1>
                        <div href="#" class="d-none d-sm-inline-block ">
                           </div>
                    </div>

                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h4 class="h4 mb-0 text-black-800">Your Pins</h4>
                        <div href="#" class="d-none d-sm-inline-block ">
                           </div>
                    </div>
                    <!-- Content Row -->
                    <div class="row">
                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card  shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-auto">
                                            <i class="fas fa-folder fa-2x" style="color: orange;"></i>
                                        </div>
                                        <div class="col ml-3">
                                            <div class="font-weight-bold text-primary text-uppercase mb-1">
                                                Folder A</div>
                                            <div class="p mb-0 font-weight-bold text-gray-800">3Mb</div>
                                        </div>
                                 </div>
                            </div>
                         </div>
                    </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            
                            <div class="card  shadow h-100 py-2">
                                
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-auto">
                                            <i class="fas fa-folder fa-2x" style="color: orange;"></i>
                                        </div>
                                        <div class="col ml-3">
                                            <div class="font-weight-bold text-primary text-uppercase mb-1">
                                                Folder B</div>
                                            <div class="p mb-0 font-weight-bold text-gray-800">3Mb</div>
                                        </div>
                                        
                                    </div>
                                </div>
                            
                            </div>
                        </div>
                        
                        <div class="col-xl-3 col-md-6 mb-4">
                            <a href=""></a>
                            <div class="card  shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-auto">
                                            <i class="fas fa-file fa-2x" style="color: orange;"></i>
                                        </div>
                                        <div class="col ml-3">
                                            <div class="font-weight-bold text-primary text-uppercase mb-1">
                                                File A</div>
                                            <div class="p mb-0 font-weight-bold text-gray-800">3Mb</div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                      
                    </div>

                    <hr>
                  

                    <!-- Content Row -->

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Directory</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="example" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Date Modified</th>
                                            <th>Type</th>
                                            <th>Size</th>
                                            <th>Action</th>                                           
                                        </tr>
                                      </thead>
                                      <tbody>
                                        <tr>
                                          <td> <a href="#" class="folderlink">
                                            <div class="d-flex align-items-center">
                                                <div><i class="mdi mdi-folder me-2 font-24 text-warning "></i>
                                                </div>
                                                <div class="font-weight-bold ">Folder A</div>
                                            </div>
                                        </a></td>
                                          <td>23/10/23 09:00</td>
                                          <td>File Folder</td>
                                          <td> - </td>
                                          <td>
                                             <a href=""data-toggle="tooltip"><i class="mdi mdi-pin"  style="color: black;"></i></a>             
                                          </td>
                                         
                                        </tr>

                                        
                                      
                                      </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

          

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
   @endsection