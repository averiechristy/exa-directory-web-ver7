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
            <h1 class="welcome-text">Website Admin<span class="text-black fw-bold"></span></h1>
            <h3 class="welcome-sub-text">Exa Directory </h3>
          </li>
        </ul>
        <ul class="navbar-nav ms-auto">         
          <li class="nav-item font-weight-semibold d-none d-lg-block ms-0">
            <h3 class="welcome-sub-text">Welcome, {{ auth()->user()->nama_user }}</h3>
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
      <div class="theme-setting-wrapper">  
      </div>
    
      <!-- partial -->
      <!-- partial:partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item {{ Request::is('admin/dashboard') ? 'active' : '' }}  ">
            <a class="nav-link" href="{{route('admin.dashboard')}}">
              <i class="menu-icon mdi mdi-grid-large "></i>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
         
          <li class="nav-item {{ Request::is('admin/user/index')|| Request::is('admin/user/create') ? 'active' : '' }} ">
            <a class="nav-link" href="{{route('admin.user.index')}}">
              <i class="menu-icon mdi mdi-account"></i>
              <span class="menu-title">User</span>
            </a>
          </li>
          
          <li class="nav-item {{ Request::is('admin/usergroup/index') || Request::is('admin/usergroup/create')? 'active' : '' }} ">
            <a class="nav-link" href="{{route('admin.usergroup.index')}}">
              <i class="menu-icon mdi mdi-account-group"></i>
              <span class="menu-title">User Group</span>
            </a>
          </li>

          <li class="nav-item nav-category">Directory</li>
<li class="nav-item {{ Request::is('admin/file/index')|| Request::is('admin/file/create') || Request::is('admin/folder/create')|| Request::is('admin/folder/index')? 'active' : '' }} ">
    <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
        <i class="menu-icon mdi mdi-folder"></i>
        <span class="menu-title">Directory</span>
        <i class="menu-arrow"></i> 
    </a>
    <div class="collapse {{ Request::is('admin.folder.index', 'admin.file.index') || Request::is('admin/file/create')|| Request::is('admin/folder/create') || Request::is('admin.folder.index', 'admin.file.index/*') ? 'show' : '' }}" id="ui-basic">
        <ul class="nav flex-column sub-menu">
        <li class="nav-item">
    <a class="nav-link {{ Request::is('admin.folder.index') || Request::is('admin/folder/create') ? 'active' : '' }}" href="{{route('admin.folder.index')}}">
        Folder
    </a>
</li>
<li class="nav-item">
<a class="nav-link {{ Request::is('admin.file.index') || Request::is('admin/file/create') ? 'active' : '' }}" href="{{route('admin.file.index')}}">
        File
    </a>
</li>
        </ul>
    </div>
</li>

        </ul>
      </nav>

      

      