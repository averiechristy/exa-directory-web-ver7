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
                           
                                <img src="{{asset('img/undraw_profile.svg')}}" style="height: 80px; width: 100px;">
                                <h3 class="ml-2 mt-4">Amanda</h3>
                                
    
                               
                           
                        </div>
                        <form class="mt-3">

                           
                        <div class="mb-3">
  <label for="formFileSm" class="form-label">Foto Profil</label><br>
  <input class="form-control-sm" id="formFileSm" type="file">
</div>

                            <div class="mb-3">
                              <label for="exampleInputEmail1" class="form-label">Nama</label>
                              <input type="text" class="form-control" id="exampleInputEmail1" value="Anita" aria-describedby="emailHelp" required>
                            </div>

                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Email</label>
                                <input type="email" value ="anita@gmail.com" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required>
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

    <!-- Scroll to Top Button-->
   @endsection