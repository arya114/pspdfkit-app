<div class="header d-flex align-items-center justify-content-between p-3 bg-dark text-white">
    <!-- Logo -->
    <div class="d-flex align-items-center">
        <a href="{{ url('/') }}" class="logo text-white fs-3 fw-bold">MyApp</a>
    </div>

    <!-- User Menu -->
    <div class="user-menu d-flex align-items-center">
        <span class="text-white fw-semibold">Hi, {{ Auth::user()->name ?? 'Guest' }}</span>
    </div>
</div>
