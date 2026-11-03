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
                  <span class="count">3</span>
              </a>
          </li>
          @can('apply leave')
              <li>
                  <a href="{{ route('leave') }}" class="{{ request()->routeIs('leave') ? 'active' : '' }}">
                      <i class="fas fa-calendar-check"></i>
                      <span>Leaves</span>
                  </a>
              </li>
          @endcan
          @can('approve leave')
              <li>
                  <a href="{{ route('leaveRequest') }}" class="{{ request()->routeIs('leaveRequest') ? 'active' : '' }}">
                      <i class="fas fa-calendar-check"></i>
                      <span>Leave Requests</span>
                  </a>
              </li>
          @endcan

          <li>
              <a href="{{ route('chat') }}" class="{{ request()->routeIs('chat') ? 'active' : '' }}">
                  <i class="fas fa-comments"></i>
                  <span>Chat</span>
              </a>
          </li>

          <li>
              <a href="{{ route('logout') }}">
                  <i class="fas fa-sign-out-alt"></i>
                  <span>Logout</span>
              </a>
          </li>
      </ul>
  </aside>
