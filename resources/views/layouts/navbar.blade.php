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
                    @if(Auth::user()->role === 'pengawas-lapangan')
                        <li class="nav-item {{ request()->segment(1) == 'suratjalan' ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('suratjalan.index') }}"><span
                                    class="nav-link-text">Surat Jalan</span></a>
                        </li>
                    @endif
                    @if(Auth::user()->role === 'admin')
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
                    @endif
                    @if(Auth::user()->role === 'admin')
                    <li class="nav-item">
                        <a class="nav-link" href="javascript:void(0);" data-bs-toggle="collapse"
                            data-bs-target="#operational">
                            <span class="nav-link-text">Operasional</span>
                        </a>
                        <ul id="operational" class="nav flex-column collapse nav-children">
                            <li class="nav-item">
                                <ul class="nav flex-column">
                                    <li class="nav-item {{ request()->segment(1) == 'proyek' ? 'active' : '' }}">
                                        <a class="nav-link" href="{{ route('proyek.index') }}"><span
                                                class="nav-link-text">Proyek</span></a>
                                    </li>
                                    <li class="nav-item {{ request()->segment(1) == 'suratjalan' ? 'active' : '' }}">
                                        <a class="nav-link" href="{{ route('suratjalan.index') }}"><span
                                                class="nav-link-text">Surat Jalan</span></a>
                                    </li>
                                    <li class="nav-item {{ request()->segment(1) == 'pengembalian' ? 'active' : '' }}">
                                        <a class="nav-link" href="{{ route('pengembalian.index') }}"><span
                                                class="nav-link-text">Pengembalian</span></a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    @endif
                    @if(Auth::user()->role === 'admin' || Auth::user()->role === 'pimpinan')
                    <li class="nav-item">
                        <a class="nav-link" href="javascript:void(0);" data-bs-toggle="collapse"
                            data-bs-target="#operational">
                            <span class="nav-link-text">Laporan</span>
                        </a>
                        <ul id="operational" class="nav flex-column collapse nav-children">
                            <li class="nav-item">
                                <ul class="nav flex-column">
                                    {{-- <li class="nav-item {{ request()->segment(1) == 'laporanSuratjalan' ? 'active' : '' }}">
                                        <a class="nav-link" href="{{ route('laporan.suratjalan') }}"><span
                                                class="nav-link-text">Laporan Surat Jalan</span></a>
                                    </li> --}}
                                    <li class="nav-item {{ request()->segment(1) == 'laporanProyek' ? 'active' : '' }}">
                                        <a class="nav-link" href="{{ route('laporan.proyek') }}"><span
                                                class="nav-link-text">Laporan Proyek</span></a>
                                    </li>
                                    <li class="nav-item {{ request()->segment(1) == 'laporanPengembalian' ? 'active' : '' }}">
                                        <a class="nav-link" href="{{ route('laporan.pengembalian') }}"><span
                                                class="nav-link-text">Laporan Pengembalian</span></a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
    <!-- /Main Menu -->
