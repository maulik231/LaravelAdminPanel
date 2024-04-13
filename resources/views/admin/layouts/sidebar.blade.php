  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="{{ route('adminDashboard') }}" class="brand-link">
          <img src="{{ asset('theme-assets/dist/img/AdminLTELogo.png') }}" alt="Dimore Logo"
              class="brand-image img-circle elevation-3" style="opacity: .8">
          <span class="brand-text font-weight-light">Admin</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
          <!-- Sidebar user panel (optional) -->
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
              <div class="image">
              </div>
              <div class="info">
                  <a href="{{ route('adminDashboard') }}" class="d-block">{{ auth()->guard('admin')->user()->name }}</a>
              </div>
          </div>
          <!-- Sidebar Menu -->
          <nav class="mt-2">
              <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                  data-accordion="false">
                  <li class="nav-item {{ Request::is('adminDashboard') ? 'menu-open' : '' }}">
                      <a href="{{ route('adminDashboard') }}"
                          class="nav-link {{ Request::is('admin') ? 'active' : '' }}">
                          <i class="nav-icon fas fa-tachometer-alt"></i>
                          <p>
                              Dashboard
                          </p>
                      </a>

                  </li>
                  <li class="nav-item {{ Request::is('shop') || Request::is('shop/*') ? 'menu-open' : '' }}">
                    <a href="{{ route('shop.index') }}"
                        class="nav-link {{ Request::is('admin/shop') || Request::is('shop/*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-shopping-cart"></i>
                        <p>Shop</p>
                    </a>
                </li>
                <li class="nav-item {{ Request::is('product') || Request::is('product/*') ? 'menu-open' : '' }}">
                    <a href="{{ route('product.index') }}"
                        class="nav-link {{ Request::is('admin/product') || Request::is('product/*') ? 'active' : '' }}">
                        <i class="nav-icon fab fa-product-hunt"></i>
                        <p>Product</p>
                    </a>
                </li>
                <li class="nav-item">
                      <form action="{{ route('logout') }}" method="post">
                          @csrf
                          <button type="submit" style="background: none; border:none;" class="nav-link text-left">
                              <p class="text-danger">
                                  Logout
                              </p>
                          </button>
                      </form>
                  </li>
              </ul>
          </nav>
          <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
  </aside>
