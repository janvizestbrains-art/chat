  <aside class="sidebar">
      <div class="sidebar-brand">
          <div class="brand-logo"><i class="fas fa-fan"></i></div>
          <div class="brand-text">
              <strong>HVAC Portal</strong>
              <small>Employee Dashboard</small>
          </div>
      </div>

      <div class="menu-title">Menu</div>
      <ul class="sidebar-menu">
          <li>
              <a href="{{ route('index') }}" class="{{ request()->routeIs('index') ? 'active' : '' }}">
                  <i class="fas fa-bell"></i>
                  <span>Notifications</span>

              </a>
          </li>

          @can('chat')
              <li>
                  <a href="{{ route('chat') }}" class="{{ request()->routeIs('chat') ? 'active' : '' }}">
                      <i class="fas fa-comments"></i>
                      <span>Chat</span>
                  </a>
              </li>
          @endcan

          <li>
              <a href="{{ route('logout') }}">
                  <i class="fas fa-sign-out-alt"></i>
                  <span>Logout</span>
              </a>
          </li>
      </ul>
  </aside>
