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
                    
            <form method="POST" action="" enctype="multipart/form-data">
        @csrf

        @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

<div class="mb-3">
<label for="name">Profil Foto</label>

<input type="file" class="form-control" name="avatar"  style="width: 80%;" id="avatar-input" accept=".png, .jpg, .jpeg" 
               title="Hanya file dengan ekstensi .png, .jpg, atau .jpeg yang diterima" 
               size="5000000">
                    <div class="mt-2">
                        <img id="avatar-preview" src="{{ asset('img/' . auth()->user()->avatar) }}" alt="Preview" style="max-width: 100px; max-height: 100px;">
                    </div>
                    @if($errors->has('avatar'))
                        <p class="text-danger">{{ $errors->first('avatar') }}</p>
                    @endif
          </div>

<div class="mb-3">
    <label for="name">Nama</label>
    <input id="nama" type="text" name="nama" value="{{ $user->nama_user }}" style="width: 80%;" class="form-control" oninput="removeExtraSpaces(this)">

<script>
function removeExtraSpaces(inputElement) {
    // Menghapus spasi berlebihan dengan menggunakan regex
    inputElement.value = inputElement.value.replace(/\s+/g, ' ');
}
</script>
    @if ($errors->has('nama'))
        <p class="text-danger">{{ $errors->first('nama') }}</p>
    @endif
</div>

          <div class="mb-3">
            <button type="submit" class="btn btn-primary me-md-2">Update Profile</button>
        </div>
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