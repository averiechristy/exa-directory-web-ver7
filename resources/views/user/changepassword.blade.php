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

             
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                   

                    <div class="container">
                      
                        <div class="row mt-5">
                           
                              
                            <img src="{{asset('img/bannerpassword.png')}}" style="width: 251px;
                            height: 230px;
                            flex-shrink: 0; align-items: center ; justify-content: center;">          
                                
    
                               
                           
                        </div>
                        <form class="mt-3">
                            <div class="mb-3">
                              <label for="exampleInputEmail1" class="form-label">Current Password</label>
                              <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required>
                            </div>
                            <div class="mb-3">
                              <label for="exampleInputPassword1" class="form-label"> New Password</label>
                              <input type="password" class="form-control" id="exampleInputPassword1" required>
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">Re- type Password</label>
                                <input type="password" class="form-control" id="exampleInputPassword1" required>
                              </div>
    
                            <button type="submit" class="btn btn-primary">Simpan</button>
                          </form>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

          

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

@endsection