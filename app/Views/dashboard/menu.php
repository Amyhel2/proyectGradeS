<aside class="main-sidebar  elevation-4">
  <!-- Brand Logo -->
  <a href="<?= base_url('start'); ?>" class="brand-link">
    <img src="<?php echo base_url('assets/dist/img/AdminLTELogo.png'); ?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">SistemPro</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="<?php echo base_url('assets/dist/img/user2-160x160.jpg'); ?>" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block"><?php echo esc(session('username')); ?></a>
      </div>
    </div>

    <!-- SidebarSearch Form -->
    <div class="form-inline">
      <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-sidebar">
            <i class="fas fa-search fa-fw"></i>
          </button>
        </div>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        
        <!-- Opción disponible para todos -->
        <li class="nav-item">
          <a href="<?= base_url('start'); ?>" class="nav-link">
            <i class="nav-icon fas fa-home"></i>
            <p>Inicio</p>
          </a>
        </li>

        <!-- Opción solo para admin -->
        <?php if(session('rol') == 'admin'): ?>
        <li class="nav-item">
          <a href="<?= base_url('users'); ?>" class="nav-link">
            <i class="nav-icon fas fa-users"></i>
            <p>Usuarios</p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?= base_url('users');?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Gestión de Usuarios</p>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-user-secret"></i>
            <p>Criminales</p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?= base_url('criminals');?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Gestion de Criminales</p>
              </a>
            </li>
          </ul>
        </li>
        <?php endif; ?>

        <!-- Opción para admin y user -->
        <?php if(session('rol') == 'admin' || session('rol') == 'user'): ?>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-chart-pie"></i>
            <p>Reportes</p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?= base_url('reportes'); ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Reportes</p>
              </a>
            </li>
          </ul>
        </li>
        <?php endif; ?>

        <!-- Otras opciones de menú, aplica lo mismo según los roles -->
        <li class="nav-item">
          <a href="https://adminlte.io/docs/3.1/" class="nav-link">
            <i class="nav-icon fas fa-file"></i>
            <p>Documentación</p>
          </a>
        </li>

      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
