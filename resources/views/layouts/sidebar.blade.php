<div id="sidebar" class="active">
    <div class="sidebar-wrapper active bg-white border-end h-100">
        <div class="sidebar-header">
            <div class="d-flex justify-content-between">
                <div class="logo">
                    <img class="d-inline-flex" src="{{ url('/assets/logo/Man5.png') }}" style="width: 60px; height: 45px;"
                        alt="Logo" srcset="">
                    <h2 class="fw-bold d-inline-flex">MAN 5</h2>
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

                        <li
                            class="sidebar-item has-sub {{ request()->is('kelas*', 'jurusan*', 'mapel*') ? 'active' : '' }}">
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
                                <li class="submenu-item">
                                    <a href="/mapel">Mata Pelajaran</a>
                                </li>
                            </ul>
                        </li>
                        <li class="sidebar-item {{ request()->is('jadwal*') ? 'active' : '' }}">
                            <a href="/jadwal" class='sidebar-link'>
                                <i class="bi bi-stopwatch-fill"></i>
                                <span>Jadwal Pelajaran</span>
                            </a>
                        </li>

                        <li class="sidebar-item {{ request()->is('manageGuru*') ? 'active' : '' }}">
                            <a href="/manageGuru" class='sidebar-link'>
                                <i class="bi bi-person-circle"></i>
                                <span>Manajemen Guru</span>
                            </a>
                        </li>

                        <li class="sidebar-item {{ request()->is('manageSiswa*') ? 'active' : '' }}">
                            <a href="/manageSiswa" class='sidebar-link'>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-mortarboard-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M8.211 2.047a.5.5 0 0 0-.422 0l-7.5 3.5a.5.5 0 0 0 .025.917l7.5 3a.5.5 0 0 0 .372 0L14 7.14V13a1 1 0 0 0-1 1v2h3v-2a1 1 0 0 0-1-1V6.739l.686-.275a.5.5 0 0 0 .025-.917l-7.5-3.5Z" />
                                    <path
                                        d="M4.176 9.032a.5.5 0 0 0-.656.327l-.5 1.7a.5.5 0 0 0 .294.605l4.5 1.8a.5.5 0 0 0 .372 0l4.5-1.8a.5.5 0 0 0 .294-.605l-.5-1.7a.5.5 0 0 0-.656-.327L8 10.466 4.176 9.032Z" />
                                </svg>
                                <span>Manajemen Siswa</span>
                            </a>
                        </li>
                        <li class="sidebar-item {{ request()->is('profile*') ? 'active' : '' }}">
                            <a href="/profile" class='sidebar-link'>
                                <i class="bi bi-person"></i>
                                <span>Profile</span>
                            </a>
                        </li>
                    @elseif (Auth::user()->role->name === 'guru')
                        <li class="sidebar-item {{ request()->is('guru*') ? 'active' : '' }}">
                            <a href="/guru" class='sidebar-link'>
                                <i class="bi bi-grid-fill"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="sidebar-item {{ request()->is('listajar*') ? 'active' : '' }}">
                            <a href="/listajar" class='sidebar-link'>
                                <i class="bi bi-stack"></i>
                                <span>List Mata Pelajaran</span>
                            </a>
                        </li>

                        <li class="sidebar-item has-sub {{ request()->is('laporan*') ? 'active' : '' }}">
                            <a href="#" class='sidebar-link'>
                                <i class="bi bi-clipboard"></i>
                                <span>Laporan</span>
                            </a>
                            <ul class="submenu ">
                                <li class="submenu-item {{ request()->is('laporan*') ? 'active' : '' }}">
                                    <a href="/laporan">Data Laporan</a>
                                </li>
                            </ul>
                        </li>

                        <li class="sidebar-item {{ request()->is('profile*') ? 'active' : '' }}">
                            <a href="/profile/guru" class='sidebar-link'>
                                <i class="bi bi-person"></i>
                                <span>Profile</span>
                            </a>
                        </li>
                    @endif
                    <li class="sidebar-item  ">
                        <a href="#" class="sidebar-link"
                            onclick="event.preventDefault(); Swal.fire({
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
