<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

<!-- Sidebar Toggle (Topbar) -->


<!-- Topbar Search -->
<a href="{{route('user.home')}}"> <img src="{{asset('img/logodirectory.png')}}" style="width: 100px; height: 40px;" alt=""></a>

<!-- Topbar Navbar -->
<ul class="navbar-nav ml-auto">

@if (auth()->user()->is_approval == 1)

<li class="nav-item {{ Request::is('user/approvalpage') || Request::is('user/approvalpage') ? 'active' : '' }}">
    <a class="nav-link" style="color:gray;" href="{{ route('user.approvalpage') }}">Approval</a>
</li>

<style>
    /* CSS untuk efek hover */
    .nav-link:hover {
        color: blue; /* Ubah warna saat dihover */
        text-decoration: underline; /* Tambahkan garis bawah saat dihover */
        cursor: pointer; /* Ubah kursor saat dihover */
        font-weight : bold;
    }
</style>

@endif


    <div class="topbar-divider d-none d-sm-block"></div>

    <!-- Nav Item - Search Dropdown (Visible Only XS) -->
    <!-- Nav Item - User Information -->
    <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="mr-2 d-none d-lg-inline text-gray-600 small">Welcome, {{ auth()->user()->nama_user }}</span>
            <img class="img-profile rounded-circle"
                src="{{asset('img/undraw_profile.svg')}}">
        </a>
        <!-- Dropdown - User Information -->
        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
            aria-labelledby="userDropdown">
            <!-- <a class="dropdown-item" href="{{route('edit-profile')}}">
                <i class="fas fa-edit fa-sm fa-fw mr-2 text-gray-400"></i>
                Edit Profile
            </a> -->
            <a class="dropdown-item" href="{{route('user.password')}}">
                <i class="fas fa-key fa-sm fa-fw mr-2 text-gray-400"></i>
                Change Password
            </a>
            
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                Logout
            </a>
        </div>
    </li>

</ul>

</nav>