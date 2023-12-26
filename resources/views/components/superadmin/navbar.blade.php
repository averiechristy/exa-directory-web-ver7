<nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex align-items-top flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
        <div class="me-3">         
        </div>
        <div>
          <a class="navbar-brand brand-logo" href="#">
            <img src="{{asset('img/logodirectory.png')}}" alt="logo" />
          </a>
          <a class="navbar-brand brand-logo-mini" href="#">
            <img src="{{asset('img/smalllogo.png')}}" alt="logo" />
          </a>
        </div>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-top"> 
        <ul class="navbar-nav">
          <li class="nav-item font-weight-semibold d-none d-lg-block ms-0">
            <h1 class="welcome-text">Website Super Admin<span class="text-black fw-bold"></span></h1>
            <h3 class="welcome-sub-text">Exa Directory </h3>
          </li>
        </ul>
        <ul class="navbar-nav ms-auto">
          <li class="nav-item font-weight-semibold d-none d-lg-block ms-0">
            <h3 class="welcome-sub-text">Welcome, {{ auth()->user()->nama_user }} </h3>
          </li>
          <li class="nav-item dropdown d-none d-lg-block user-dropdown">
            <a class="nav-link" id="UserDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
              <img class="img-xs rounded-circle" src="{{asset('img/profil.png')}}" alt="Profile image"> </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">   
              <a href="{{route('admin.changepassowrd')}}" class="dropdown-item"><i class="dropdown-item-icon mdi mdi-lock-outline text-gray me-2"></i>Change Password</a>
            
              <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                        <i class="dropdown-item-icon mdi mdi-power text-gray me-2"></i>
                            Logout
                        </a>
                    </div>
            </div>
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-bs-toggle="offcanvas">
          <span class="mdi mdi-menu"></span>
        </button>
      </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_settings-panel.html -->
    
      <!-- partial -->
      <!-- partial:partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item {{ Request::is('superadmin/dashboard') ? 'active' : '' }}  ">
            <a class="nav-link" href="{{route('superadmin.dashboard')}}">
              <i class="menu-icon mdi mdi-grid-large "></i>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
          <li class="nav-item {{ Request::is('superadmin/cabang/index') || Request::is('superadmin/cabang/create') ? 'active' : '' }}">
            <a class="nav-link" href="{{route('superadmin.cabang.index')}}">
              <i class="menu-icon mdi mdi-office-building"></i>
              <span class="menu-title">Cabang</span>
            </a>
          </li>
          <li class="nav-item {{ Request::is('superadmin/user/index')|| Request::is('superadmin/user/create') ? 'active' : '' }} ">
            <a class="nav-link" href="{{route('superadmin.user.index')}}">
              <i class="menu-icon mdi mdi-account"></i>
              <span class="menu-title">User</span>
            </a>
          </li>
          <li class="nav-item {{ Request::is('superadmin/usergroup/index') || Request::is('superadmin/usergroup/create')? 'active' : '' }} ">
            <a class="nav-link" href="{{route('superadmin.usergroup.index')}}">
              <i class="menu-icon mdi mdi-account-group"></i>
              <span class="menu-title">User Group</span>
            </a>
          </li>

          <li class="nav-item nav-category">Directory</li>
<li class="nav-item {{ Request::is('superadmin/file/index')|| Request::is('superadmin/file/create') || Request::is('superadmin/folder/create')|| Request::is('superadmin/folder/index')? 'active' : '' }} ">
    <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
        <i class="menu-icon mdi mdi-folder"></i>
        <span class="menu-title">Directory</span>
        <i class="menu-arrow"></i> 
    </a>
    <div class="collapse {{ Request::is('superadmin.folder.index', 'superadmin.file.index') || Request::is('superadmin/file/create')|| Request::is('superadmin/folder/create') || Request::is('superadmin.folder.index', 'superadmin.file.index/*') ? 'show' : '' }}" id="ui-basic">
        <ul class="nav flex-column sub-menu">
        <li class="nav-item">
    <a class="nav-link {{ Request::is('superadmin.folder.index') || Request::is('superadmin/folder/create') ? 'active' : '' }}" href="{{route('superadmin.folder.index')}}">
        Folder
    </a>
</li>
<li class="nav-item">
    <a class="nav-link {{ Request::is('superadmin.file.index') || Request::is('superadmin/file/create') ? 'active' : '' }}" href="{{route('superadmin.file.index')}}">
        File
    </a>
</li>
        </ul>
    </div>
</li>

        </ul>
      </nav>

      

      