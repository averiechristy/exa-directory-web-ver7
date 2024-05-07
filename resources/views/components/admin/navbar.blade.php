<nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex align-items-top flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
        <div class="me-3">         
        </div>
        <div>
          <a class="navbar-brand brand-logo" >
            <img src="{{asset('img/logodirectory.png')}}" alt="logo" />
          </a>
          <a class="navbar-brand brand-logo-mini" >
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

        <li class="nav-item dropdown">
            <a class="nav-link count-indicator" id="notificationDropdown" href="#" data-bs-toggle="dropdown">
             <h6>Welcome, {{ auth()->user()->nama_user }}</h6>
            </a>
          
          </li>

        <li class="nav-item dropdown"> 
    <a class="nav-link count-indicator" id="countDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
    <img class="img-xs rounded-circle" src="{{asset('img/profil.png')}}" alt="Profile image"> </a>
      <span class="count"></span>
    </a>
    <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list pb-0" aria-labelledby="countDropdown">
    <a href="{{route('admin.password')}}" class="dropdown-item"><i class="dropdown-item-icon mdi mdi-lock-outline text-gray me-2"></i>Change Password
            </a>
      <div class="dropdown-divider"></div>
      <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                        <i class="dropdown-item-icon mdi mdi-power text-gray me-2"></i>
                            Logout
                        </a>
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

  <div class=" {{ Request::is('admin.folder.index', 'admin.file.index') || Request::is('admin/file/create')|| Request::is('admin/folder/create') || Request::is('admin.folder.index', 'admin.file.index/*') ? 'show' : '' }}" id="ui-basic">
      <ul class="nav flex-column sub-menu" style="background-color:none;">
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

<li class="nav-item {{  Request::is('admin/logactivity') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.logactivity') }}">
            <i class=" menu-icon mdi mdi-history"></i>
            <span class="menu-title">Log Activity</span>
        </a>
</li>


@if (auth()->user()->is_approval == 1)
    <li class="nav-item {{ Request::is('admin/approvalpage') || Request::is('admin/approvalpage') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.approvalpage') }}">
            <i class="menu-icon mdi mdi-file-account"></i>
            <span class="menu-title">Approval</span>
        </a>
    </li>
@endif

        </ul>
      </nav>

      

      