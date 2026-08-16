<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>404 — Halaman Tidak Ditemukan | SMA Negeri 24 Bandung</title>
    <meta name="description" content="Halaman yang Anda cari tidak ditemukan.">
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
            background-color: #065f46;
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
        .error-code {
            font-size: 6rem;
            font-weight: 800;
            color: #065f46;
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
        <!-- Static logo circle — no DB query, safe even when app is broken -->
        <div style="margin-bottom: 2rem; display: flex; justify-content: center;">
            <div class="logo-circle">
                <span>24</span>
            </div>
        </div>

        <!-- Error Code -->
        <div class="error-code">404</div>

        <!-- Message -->
        <h1>Halaman Tidak Ditemukan</h1>
        <p class="desc">
            Halaman yang Anda cari tidak ada atau mungkin telah dipindahkan.<br>
            Periksa kembali alamat URL atau kembali ke beranda.
        </p>

        <!-- Actions — hardcoded href, no route() helper -->
        <div class="btn-group">
            <a href="/" class="btn-primary">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Kembali ke Beranda
            </a>
            <button onclick="history.back()" class="btn-secondary">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Halaman Sebelumnya
            </button>
        </div>

        <p class="footer-text">SMA Negeri 24 Bandung &bull; Jl. A.H. Nasution No. 27, Kota Bandung</p>
    </div>
</body>
</html>
