<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>500 — Kesalahan Server | SMA Negeri 24 Bandung</title>
    <meta name="description" content="Terjadi kesalahan pada server.">
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
            background-color: #dc2626;
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
            background-color: #fee2e2;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
        }
        .icon-wrap svg {
            width: 40px;
            height: 40px;
            color: #dc2626;
            stroke: #dc2626;
        }
        .error-code {
            font-size: 6rem;
            font-weight: 800;
            color: #dc2626;
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
            margin-bottom: 0.5rem;
        }
        .desc-small {
            font-size: 0.875rem;
            color: #9ca3af;
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
        <!-- Fallback logo: static circle, no DB query -->
        <div style="margin-bottom: 2rem;">
            <div class="logo-circle">
                <span>24</span>
            </div>
        </div>

        <!-- Error Icon -->
        <div style="margin-bottom: 1rem; display: flex; justify-content: center;">
            <div class="icon-wrap">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>

        <!-- Error Code -->
        <div class="error-code">500</div>

        <!-- Message — no technical details exposed -->
        <h1>Terjadi Kesalahan Server</h1>
        <p class="desc">
            Mohon maaf, terjadi kesalahan pada server kami.
            Tim teknis sedang menangani masalah ini.
        </p>
        <p class="desc-small">
            Silakan coba lagi beberapa saat kemudian atau kembali ke beranda.
        </p>

        <!-- Actions -->
        <div class="btn-group">
            <a href="/" class="btn-primary">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Kembali ke Beranda
            </a>
            <button onclick="location.reload()" class="btn-secondary">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                Coba Lagi
            </button>
        </div>

        <p class="footer-text">SMA Negeri 24 Bandung &bull; Jl. A.H. Nasution No. 27, Kota Bandung</p>
    </div>
    {{-- Security: No DB queries, no stack traces, no technical details exposed to user --}}
    {{-- Error details are logged server-side in storage/logs/laravel.log --}}
</body>
</html>
