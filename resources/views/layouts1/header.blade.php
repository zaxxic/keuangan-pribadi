<div class="header header-one">

  <a href="javascript:void(0);" id="toggle_btn">
    <span class="toggle-bars">
      <span class="bar-icons"></span>
      <span class="bar-icons"></span>
      <span class="bar-icons"></span>
      <span class="bar-icons"></span>
    </span>
  </a>

  <a class="mobile_btn" id="mobile_btn">
    <i class="fas fa-bars"></i>
  </a>


  <ul class="nav nav-tabs user-menu">
    <li class="me-2">
      <span class="d-inline-block">
        Saldo: Rp {{ number_format(Auth::user()->total(), 0, '', '.') }}
      </span>
    </li>



    <li class="nav-item dropdown  flag-nav dropdown-heads">
      <a class="nav-link" data-bs-toggle="dropdown" href="#" role="button">
        <i class="fe fe-bell"></i> <span class="badge rounded-pill"></span>
      </a>
      <div class="dropdown-menu notifications">
        <div class="topnav-dropdown-header">
          <span class="notification-title">Notifications</span>
          <a href="javascript:void(0)" class="clear-noti"> Clear All</a>
        </div>
        <div class="noti-content">
          <ul class="notification-list">
            <li class="notification-message">
              <a href="javascript:void(0);" style="cursor: default;">
                <div class="media d-flex">
                  <div class="media-body">
                    <p class="noti-time">
                      <span class="notification-time">4 mins ago</span>
                    </p>
                    <p class="noti-details">
                      <span class="noti-title">Pemasukan</span>
                      Gajian bulanan dari kantor A
                    </p>
                    <span class="noti-title">
                      <button class="custom-btn edit-btn" onclick="editNotification()">Edit</button>
                      <button class="custom-btn detail-btn" onclick="viewDetails()">Detail</button>
                      <button class="custom-btn approve-btn" onclick="approveIncome()">Setuju</button>
                    </span>

                  </div>
                </div>
              </a>
            </li>

            <li class="notification-message">
              <a href="javascript:void(0);" style="cursor: default;">
                <div class="media d-flex">
                  <div class="media-body">
                    <p class="noti-time">
                      <span class="notification-time">40 mins ago</span>
                    </p>
                    <p class="noti-details">
                      <span class="noti-title">Pemasukan</span>
                      Gajian bulanan dari kantor HummaTech

                    </p>
                    <span class="noti-title">
                      <button class="custom-btn edit-btn" onclick="editNotification()">Edit</button>
                      <button class="custom-btn detail-btn" onclick="viewDetails()">Detail</button>
                      <button class="custom-btn approve-btn" onclick="approveIncome()">Setuju</button>
                    </span>

                  </div>
                </div>
              </a>
            </li>

            <li class="notification-message">
              <a href="javascript:void(0);" style="cursor: default;">
                <div class="media d-flex">
                  <div class="media-body">
                    <p class="noti-time">
                      <span class="notification-time">90 mins ago</span>
                    </p>
                    <p class="noti-details">
                      <span class="noti-title">Pemasukan</span>
                      Gajian bulanan dari kantor Laaa
                    </p>
                    <span class="noti-title">
                      <button class="custom-btn edit-btn" onclick="editNotification()">Edit</button>
                      <button class="custom-btn detail-btn" onclick="viewDetails()">Detail</button>
                      <button class="custom-btn approve-btn" onclick="approveIncome()">Setuju</button>
                    </span>

                  </div>
                </div>
              </a>
            </li>

          </ul>
        </div>
        <div class="topnav-dropdown-footer">
          <a href="notifications.html">View all Notifications</a>
        </div>
      </div>
    </li>
    
    <li class="nav-item  has-arrow dropdown-heads ">
      <a href="javascript:void(0);" class="win-maximize">
        <i class="fe fe-maximize"></i>
      </a>
    </li>

    <li class="nav-item dropdown">
      <a href="javascript:void(0)" class="user-link  nav-link" data-bs-toggle="dropdown">
        <span class="user-img">
          <img src="/storage/profile/{{ Auth::user()->image }}" alt="img" class="profilesidebar">
          <span class="animate-circle"></span>
        </span>
        <span class="user-content">
          <span class="user-details">{{ ucfirst(Auth::user()->role) }}</span>
          <span class="user-name">{{ Auth::user()->name }}</span>
        </span>
      </a>
      <div class="dropdown-menu menu-drop-user">
        <div class="profilemenu">
          <div class="subscription-menu">
            <ul>
              <li>
                <a class="dropdown-item" href="profile.html">Profile</a>
              </li>
              <li>
                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#planModal">Upgrade</a>
              </li>
              <li>
                <a class="dropdown-item" href="settings.html">Settings</a>
              </li>
            </ul>
          </div>
          <div class="subscription-logout">
            <ul>
              <li class="pb-0">
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">Log
                  Out</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                  @csrf
                </form>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </li>

  </ul>

</div>