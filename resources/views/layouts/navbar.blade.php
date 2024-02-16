    <!-- Main Menu -->
    <div data-simplebar class="nicescroll-bar">
        <div class="menu-content-wrap">
            <div class="menu-group">
                <ul class="navbar-nav flex-column">
                    <li class="nav-item {{ request()->segment(1) == 'dashboard' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('dashboard.index') }}">
                            <span class="nav-link-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->segment(1) == 'barang' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('barang.index') }}">
                            <span class="nav-link-text">Data Barang</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="javascript:void(0);" data-bs-toggle="collapse"
                            data-bs-target="#masterdata">
                            <span class="nav-link-text">Master Data</span>
                        </a>
                        <ul id="masterdata" class="nav flex-column collapse nav-children">
                            <li class="nav-item">
                                <ul class="nav flex-column">
                                    <li class="nav-item {{ request()->segment(1) == 'user' ? 'active' : '' }}">
                                        <a class="nav-link" href="{{ route('user.index') }}"><span
                                                class="nav-link-text">User</span></a>
                                    </li>
                                    <li class="nav-item {{ request()->segment(1) == 'alat' ? 'active' : '' }}">
                                        <a class="nav-link" href="{{ route('alat.index') }}"><span
                                                class="nav-link-text">Alat</span></a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Main Menu -->
