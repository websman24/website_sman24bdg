<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>403 — Akses Ditolak | SMA Negeri 24 Bandung</title>
    <meta name="description" content="Anda tidak memiliki izin untuk mengakses halaman ini.">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background-color: #f9fafb;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            color: #111827;
        }
        .container {
            text-align: center;
            max-width: 480px;
            width: 100%;
        }
        .logo-circle {
            width: 80px;
            height: 80px;
            background-color: #d97706;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 2rem;
        }
        .logo-circle span {
            color: #fff;
            font-size: 1.5rem;
            font-weight: 700;
        }
        .icon-wrap {
            width: 80px;
            height: 80px;
            background-color: #fef3c7;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
        }
        .error-code {
            font-size: 6rem;
            font-weight: 800;
            color: #d97706;
            line-height: 1;
            margin-bottom: 1rem;
            user-select: none;
        }
        h1 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
            color: #111827;
        }
        .desc {
            color: #6b7280;
            line-height: 1.6;
            margin-bottom: 2rem;
        }
        .btn-group {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            justify-content: center;
        }
        @media (min-width: 480px) {
            .btn-group { flex-direction: row; }
        }
        .btn-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            background-color: #065f46;
            color: #fff;
            font-weight: 600;
            border-radius: 0.5rem;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.2s;
        }
        .btn-primary:hover { background-color: #064e3b; }
        .btn-secondary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            border: 2px solid #065f46;
            color: #065f46;
            font-weight: 600;
            border-radius: 0.5rem;
            background: none;
            text-decoration: none;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.2s;
        }
        .btn-secondary:hover { background-color: #ecfdf5; }
        .footer-text {
            margin-top: 3rem;
            font-size: 0.875rem;
            color: #d1d5db;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Static logo circle — no DB query -->
        <div style="margin-bottom: 2rem; display: flex; justify-content: center;">
            <div class="logo-circle">
                <span>24</span>
            </div>
        </div>

        <!-- Warning Icon -->
        <div style="margin-bottom: 1rem; display: flex; justify-content: center;">
            <div class="icon-wrap">
                <svg width="40" height="40" fill="none" stroke="#d97706" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
        </div>

        <!-- Error Code -->
        <div class="error-code">403</div>

        <!-- Message -->
        <h1>Akses Ditolak</h1>
        <p class="desc">
            Anda tidak memiliki izin untuk mengakses halaman ini.<br>
            Jika Anda merasa ini adalah kesalahan, silakan hubungi administrator.
        </p>

        <!-- Actions — hardcoded href, no route() helper that could fail -->
        <div class="btn-group">
            <a href="/" class="btn-primary">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Kembali ke Beranda
            </a>
            <a href="/admin/login" class="btn-secondary">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                </svg>
                Login Admin
            </a>
        </div>

        <p class="footer-text">SMA Negeri 24 Bandung &bull; Jl. A.H. Nasution No. 27, Kota Bandung</p>
    </div>
</body>
</html>
