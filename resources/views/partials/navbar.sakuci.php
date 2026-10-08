{{-- Zona tak terlihat untuk gesture swipe dari tepi atas layar --}}


{{-- Tab kecil di tengah atas untuk membuka/menutup navbar --}}
<button id="navbarPullTab" type="button" class="navbar-pull-tab"
        aria-label="Buka menu navigasi" aria-expanded="false" aria-controls="menuNavbar">
    <svg width="20" height="10" viewBox="0 0 20 10" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
        <path d="M2 2L10 8L18 2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
</button>

<nav id="menuNavbar" class="navbar navbar-expand-lg navbar-custom">
    <div class="container">
        <div class="d-flex align-items-center gap-2">
            @php
                $dbConnected = false;
                try {
                    \Sakuci\Database\Connection::pdo();
                    $dbConnected = true;
                } catch (\Throwable $e) {
                    $dbConnected = false;
                }
            @endphp
            <button id="themeToggle" type="button" class="logo-toggle"
                    aria-label="Ganti tema terang/gelap (status database: {{ $dbConnected ? 'terhubung' : 'tidak terhubung' }})"
                    title="Ganti tema terang/gelap">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <circle cx="12" cy="12" r="9"/>
                <path d="M12 3a9 9 0 0 1 0 18z" fill="currentColor"/>
                </svg>
            </button>
            <a class="navbar-brand fw-semibold m-0 d-flex align-items-center gap-2" href="{{ route('home') }}">
                {{ config('app.name') }}
            </a>
        </div>

        <button class="navbar-toggler border-0" type="button"
                data-bs-toggle="collapse" data-bs-target="#menuUtama"
                aria-controls="menuUtama" aria-expanded="false" aria-label="Buka menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menuUtama">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
                <li class="nav-item">
                    <a class="nav-link {{ is_route('home') ? 'active' : '' }}" href="{{ route('home') }}">Beranda</a>
                </li>
                
                @php
                    $currentUser = \App\Models\User::current();
                @endphp
                @if ($currentUser)
                    <li class="nav-item">
                        <a class="nav-link {{ is_route('admin.dashboard', 'dashboard') ? 'active' : '' }}"
                           href="{{ $currentUser->role === 'admin' ? route('admin.dashboard') : route('dashboard') }}">Dashboard</a>
                    </li>

                @if ($currentUser->role === 'admin')
                    <li class="nav-item">
                        <a class="nav-link {{ is_route('kategori.index', 'kategori.create', 'kategori.edit') ? 'active' : '' }}"
                           href="{{ route('kategori.index') }}">Kategori</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link {{ is_route('alat.index', 'alat.create', 'alat.edit') ? 'active' : '' }}"
                           href="{{ route('alat.index') }}">Alat</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link {{ is_route('aspirasi.index', 'aspirasi.edit') ? 'active' : '' }}"
                           href="{{ route('aspirasi.index') }}">Aspirasi</a>
                    </li>
                @endif 

                @if ($currentUser->role === 'siswa')
                    <li class="nav-item">
                    <a class="nav-link {{ is_route('siswa.aspirasi.index', 'siswa.aspirasi.create', 'siswa.aspirasi.edit') ? 'active' : '' }}"
                           href="{{ route('siswa.aspirasi.index') }}">Aspirasi Saya</a>
                    </li>

                    <li class="nav-item">
                    <a class="nav-link {{ is_route('siswa.aspirasi.index', 'siswa.aspirasi.create', 'siswa.aspirasi.edit') ? 'active' : '' }}"
                           href="{{ route('siswa.aspirasi.create') }}">berikan aspirasi</a>
                    </li>
                @endif

                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" class="d-lg-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-secondary w-100 mt-2 mt-lg-0">Logout ({{ $currentUser->username }})</button>
                        </form>
                    </li>
                @else
                    @php
                        $canRegister = false;
                        if ($dbConnected) {
                            try {
                                $canRegister = \App\Models\Role::where('can_register', 1)->exists();
                            } catch (\Throwable $e) {
                                $canRegister = false;
                            }
                        }
                    @endphp
                    @if ($canRegister)
                        <li class="nav-item">
                            <a class="nav-link {{ is_route('register') ? 'active' : '' }}" href="{{ route('register') }}">Daftar</a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="btn btn-sm btn-brand rounded-pill px-3 d-inline-flex align-items-center gap-2 mt-2 mt-lg-0" href="{{ route('login') }}">
                            <svg width="14" height="14" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <circle cx="8" cy="5" r="3" fill="currentColor" stroke="none"/>
                                <path d="M2.5 14c0-3.6 2.9-5.8 5.5-5.8s5.5 2.2 5.5 5.8"/>
                            </svg>
                            Masuk
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>

<script>
(function () {
    const navbar = document.getElementById('menuNavbar');
    const tab = document.getElementById('navbarPullTab');

    function openNavbar() {
    navbar.classList.add('navbar-visible');
    tab.classList.add('tab-open');
    tab.setAttribute('aria-expanded', 'true');
    document.body.style.paddingTop = navbar.offsetHeight + 'px';
}

function closeNavbar() {
    navbar.classList.remove('navbar-visible');
    tab.classList.remove('tab-open');
    tab.setAttribute('aria-expanded', 'false');
    document.body.style.paddingTop = '0px';
}

    tab.addEventListener('click', function () {
        navbar.classList.contains('navbar-visible') ? closeNavbar() : openNavbar();
    });

    document.addEventListener('click', function (e) {
        if (navbar.classList.contains('navbar-visible') &&
            !navbar.contains(e.target) &&
            !tab.contains(e.target)) {
            closeNavbar();
        }
    });

    let touchStartY = 0;
    let isSwiping = false;

    document.addEventListener('touchstart', function (e) {
        if (e.touches[0].clientY < 60) {
            touchStartY = e.touches[0].clientY;
            isSwiping = true;
        }
    }, { passive: true });

    document.addEventListener('touchmove', function (e) {
        if (!isSwiping) return;
        const diff = e.touches[0].clientY - touchStartY;

        if (diff > 40) {
            openNavbar();
            isSwiping = false;
        }
    }, { passive: true });

    document.addEventListener('touchend', function () {
        isSwiping = false;
    });

    navbar.addEventListener('touchstart', function (e) {
        touchStartY = e.touches[0].clientY;
        isSwiping = true;
    }, { passive: true });

    navbar.addEventListener('touchmove', function (e) {
        if (!isSwiping) return;
        const diff = e.touches[0].clientY - touchStartY;

        if (diff < -40) {
            closeNavbar();
            isSwiping = false;
        }
    }, { passive: true });
})();
</script>