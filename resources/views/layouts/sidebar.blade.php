<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header">
            <div class="d-flex justify-content-between">
                <div class="logo">
                    <a href="index.html"><img src="assets/images/logo/logo.png" alt="Logo" srcset=""></a>
                </div>
                <div class="toggler">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Menu</li>

                @auth
                <!-- Dashboard -->
                @if (Auth::user()->role->name === 'admin')

                <li class="sidebar-item {{ request()->is('admin*') ? 'active' : '' }}">
                    <a href="/admin" class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="sidebar-item has-sub {{ request()->is('kelas*', 'jurusan*') ? 'active' : '' }}">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-box"></i>
                        <span>Master Data</span>
                    </a>
                    <ul class="submenu ">
                        <li class="submenu-item">
                            <a href="/jurusan">Data Jurusan</a>
                        </li>
                        <li class="submenu-item">
                            <a href="/kelas">Data Kelas</a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-item {{ request()->is('manageGuru*') ? 'active' : '' }}">
                    <a href="/manageGuru" class='sidebar-link'>
                        <i class="bi bi-person-circle"></i>
                        <span>Manajemen Guru</span>
                    </a>
                </li>
                @elseif (Auth::user()->role->name === 'guru')

                <li class="sidebar-item {{ request()->is('admin*') ? 'active' : '' }}">
                    <a href="index.html" class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="sidebar-item has-sub">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-stack"></i>
                        <span>Laporan</span>
                    </a>
                    <ul class="submenu ">
                        <li class="submenu-item {{ request()->is('laporan*') ? 'active' : '' }}">
                            <a href="/laporan">Data Laporan</a>
                        </li>
                    </ul>
                </li>
                @endif
                <li class="sidebar-item  ">
                    <a href="#" class="sidebar-link" onclick="event.preventDefault(); Swal.fire({
                                title: 'Apakah anda yakin?',
                                text: 'Anda akan keluar dari web!',
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Ya, Keluar!'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        document.getElementById('logout-form').submit();
                                    }
                                });">
                        <i class="bi bi-box-arrow-in-left"></i></i> <span>Logout</span>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                </li>
                @else
                <li><a href="{{ route('login') }}">Login</a></li>
                <li><a href="{{ route('register') }}">Register</a></li>
                @endauth
            </ul>
        </div>
        <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
    </div>
</div>
