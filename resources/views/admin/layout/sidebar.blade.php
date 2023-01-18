<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="admin" class="brand-link">
      <img src="{{ asset('admin_lte') }}/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Kasir Cafe</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('admin_lte') }}/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <p class="d-block">{{ Auth::user()->name }}</p>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="/admin" class="nav-link {{ $sidebar == 'dashboard' ? 'active' : '' }}">
              <i class="fas fa-home nav-icon"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/admin/user" class="nav-link {{ $sidebar == 'user' ? 'active' : '' }}">
              <i class="fas fa-users nav-icon"></i>
              <p>User</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/admin/masakan" class="nav-link {{ $sidebar == 'masakan' ? 'active' : '' }}">
              <i class="fas fa-utensils nav-icon"></i>
              <p>Masakan</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/admin/meja" class="nav-link {{ $sidebar == 'meja' ? 'active' : '' }}">
              <i class="fas fa-table nav-icon"></i>
              <p>Meja</p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
