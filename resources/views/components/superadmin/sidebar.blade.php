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