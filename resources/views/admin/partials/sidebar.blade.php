<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
    <a class="sidebar-brand brand-logo" href="/admin/dashboard">
      <img src="{{ asset('logo_ramt.png') }}" alt="logo" style="width: 150px; height: auto; max-height: 40px;" />
    </a>
    <a class="sidebar-brand brand-logo-mini" href="/admin/dashboard">
      <img src="{{ asset('logo_ramt.png') }}" alt="logo" style="width: 30px; height: auto;" />
    </a>
  </div>
  <ul class="nav">
    <li class="nav-item profile">
      <div class="profile-desc">
        <div class="profile-pic">
            <div class="count-indicator">
              <img class="img-xs rounded-circle" src="{{ asset('favicon.png') }}" alt="">
              <span class="count bg-success"></span>
            </div>
          <div class="profile-name">
            <h5 class="mb-0 font-weight-normal">Usuario</h5>
            <span>Administrador</span>
          </div>
        </div>
        <a href="#" id="profile-dropdown" data-toggle="dropdown">
          <i class="mdi mdi-dots-vertical"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right sidebar-dropdown preview-list" aria-labelledby="profile-dropdown">
          <a href="#" class="dropdown-item preview-item">
            <div class="preview-thumbnail">
              <div class="preview-icon bg-dark rounded-circle">
                <i class="mdi mdi-settings text-primary"></i>
              </div>
            </div>
            <div class="preview-item-content">
              <p class="preview-subject ellipsis mb-1 text-small">Configuración</p>
            </div>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item preview-item">
            <div class="preview-thumbnail">
              <div class="preview-icon bg-dark rounded-circle">
                <i class="mdi mdi-logout text-info"></i>
              </div>
            </div>
            <div class="preview-item-content">
              <p class="preview-subject ellipsis mb-1 text-small">Cerrar sesión</p>
            </div>
          </a>
        </div>
      </div>
    </li>
    <li class="nav-item nav-category">
      <span class="nav-link">Menú Principal</span>
    </li>
    <li class="nav-item menu-items">
      <a class="nav-link" href="/admin/dashboard">
        <span class="menu-icon">
          <i class="mdi mdi-speedometer"></i>
        </span>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>
    <li class="nav-item menu-items">
      <a class="nav-link" href="{{ route('admin.clientes.index') }}">
        <span class="menu-icon">
          <i class="mdi mdi-account-group"></i>
        </span>
        <span class="menu-title">Clientes</span>
      </a>
    </li>
    <li class="nav-item menu-items">
      <a class="nav-link" href="{{ route('admin.direcciones.index') }}">
        <span class="menu-icon">
          <i class="mdi mdi-map-marker"></i>
        </span>
        <span class="menu-title">Direcciones</span>
      </a>
    </li>
    <li class="nav-item menu-items">
      <a class="nav-link" href="{{ route('admin.equipos.index') }}">
        <span class="menu-icon">
          <i class="mdi mdi-air-conditioner"></i>
        </span>
        <span class="menu-title">Equipos</span>
      </a>
    </li>
    <li class="nav-item menu-items">
      <a class="nav-link" href="{{ route('admin.tecnicos.index') }}">
        <span class="menu-icon">
          <i class="mdi mdi-wrench"></i>
        </span>
        <span class="menu-title">Técnicos</span>
      </a>
    </li>
    <li class="nav-item menu-items">
      <a class="nav-link" href="{{ route('admin.ordenes_trabajo.index') }}">
        <span class="menu-icon">
          <i class="mdi mdi-clipboard-text"></i>
        </span>
        <span class="menu-title">Órdenes de Trabajo</span>
      </a>
    </li>
    <li class="nav-item menu-items">
      <a class="nav-link" href="{{ route('admin.ayudantes.index') }}">
        <span class="menu-icon">
          <i class="mdi mdi-account-plus"></i>
        </span>
        <span class="menu-title">Ayudantes</span>
      </a>
    </li>
    <li class="nav-item menu-items">
      <a class="nav-link" href="{{ route('admin.materiales.index') }}">
        <span class="menu-icon">
          <i class="mdi mdi-package-variant"></i>
        </span>
        <span class="menu-title">Materiales</span>
      </a>
    </li>
    <li class="nav-item menu-items">
      <a class="nav-link" href="{{ route('admin.errores.index') }}">
        <span class="menu-icon">
          <i class="mdi mdi-alert-circle"></i>
        </span>
        <span class="menu-title">Errores</span>
      </a>
    </li>
    <li class="nav-item menu-items">
      <a class="nav-link" href="{{ route('admin.mantenciones.index') }}">
        <span class="menu-icon">
          <i class="mdi mdi-calendar-clock"></i>
        </span>
        <span class="menu-title">Próximas Mantenciones</span>
      </a>
    </li>
  </ul>
</nav>