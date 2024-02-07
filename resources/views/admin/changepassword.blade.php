@extends('layouts.admin.app')

@section('content')

<div class="main-panel">
        <div class="content-wrapper">

                <div class="d-sm-flex align-items-center justify-content-between border-bottom">
              
                </div>
                <div id="content-wrapper" class="d-flex flex-column">

                  <!-- Main Content -->
                  <div id="content" class="content mt-3">
                    
                 

<div class="container">

@if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

                   
    <div class="user-info">
    <img src="{{asset('img/profil.png')}}" style="height: 100px; width: 100px;">
    <h3>{{ Auth::user()->nama_user }}</h3>
</div>

                            
                 
<form method="POST" action="{{ route('admin-change-password') }}">
        @csrf

            <hr>
            <div class="form-group mb-4">
    <div class="password-container position-relative">
        <input id="current_password" type="password" name="current_password" class="form-control" placeholder="Current Password">
       
        <i class="toggle-password mdi mdi-eye eye-toggle"></i>
    </div>
    @if($errors->has('current_password'))
        <p class="text-danger">{{ $errors->first('current_password') }}</p>
    @endif
</div>

<div class="form-group mb-4">
    <div class="password-container position-relative">
        <input id="new_password" type="password" name="new_password" class="form-control" placeholder="New Password">
      
        <i class="toggle-password1 mdi mdi-eye eye-toggle"></i>
        
    </div>
    @if($errors->has('new_password'))
        <p class="text-danger">{{ $errors->first('new_password') }}</p>
    @endif
</div>

<div class="form-group mb-4">
    <div class="password-container position-relative">
        <input id="new_password_confirmation" type="password" name="new_password_confirmation" class="form-control" placeholder="Confirm New Password">
        <i class="toggle-password2 mdi mdi-eye eye-toggle"></i>
    </div>
    @if($errors->has('new_password_confirmation'))
        <p class="text-danger">{{ $errors->first('new_password_confirmation') }}</p>
    @elseif($errors->has('new_password'))
        <p class="text-danger">{{ $errors->first('new_password') }}</p>
    @endif
</div>


       

      
        <div class="mb-3">
            <button class="btn btn-primary" type="submit">Ubah Password</button>
        </div>
    </form>


    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <script>
document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('current_password');
    const togglePasswordIcon = document.querySelector('.toggle-password');

    togglePasswordIcon.addEventListener('click', function() {
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            togglePasswordIcon.classList.remove('mdi-eye');
            togglePasswordIcon.classList.add('mdi-eye-off');
        } else {
            passwordInput.type = 'password';
            togglePasswordIcon.classList.remove('mdi-eye-off');
            togglePasswordIcon.classList.add('mdi-eye');
        }
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('new_password');
    const togglePasswordIcon = document.querySelector('.toggle-password1');

    togglePasswordIcon.addEventListener('click', function() {
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            togglePasswordIcon.classList.remove('mdi-eye');
            togglePasswordIcon.classList.add('mdi-eye-off');
        } else {
            passwordInput.type = 'password';
            togglePasswordIcon.classList.remove('mdi-eye-off');
            togglePasswordIcon.classList.add('mdi-eye');
        }
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('new_password_confirmation');
    const togglePasswordIcon = document.querySelector('.toggle-password2');

    togglePasswordIcon.addEventListener('click', function() {
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            togglePasswordIcon.classList.remove('mdi-eye');
            togglePasswordIcon.classList.add('mdi-eye-off');
        } else {
            passwordInput.type = 'password';
            togglePasswordIcon.classList.remove('mdi-eye-off');
            togglePasswordIcon.classList.add('mdi-eye');
        }
    });
});
</script>

<style>

.eye-toggle {
  position: absolute;
  top: 50%;
  right: 20px;
  transform: translateY(-50%);
  cursor: pointer;
}

.user-info {
    display: flex;
    align-items: center; /* Pusatkan secara vertikal */
}

.user-info img {
    margin-right: 12px; /* Beri jarak antara gambar dan teks */
}

</style>
@endsection