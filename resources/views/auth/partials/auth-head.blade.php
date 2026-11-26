<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} — Direktori UMKM Putat Jaya</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass { background: rgba(255,255,255,0.08); backdrop-filter: blur(24px); border: 1px solid rgba(255,255,255,0.14); }
        .input-field { width: 100%; padding: .8125rem 1rem; border-radius: .75rem; border: 1.5px solid #e2e8f0; background: #fff; color: #0f172a; font-size: .9375rem; outline: none; transition: border-color .2s, box-shadow .2s; }
        .input-field:focus { border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59,130,246,.12); }
        .input-field.error { border-color: #ef4444; background: #fef2f2; }
        .btn-primary { width: 100%; padding: .875rem; border-radius: .75rem; font-weight: 700; font-size: .9375rem; color: white; cursor: pointer; transition: all .2s; border: none; background: linear-gradient(135deg,#2563eb 0%,#4f46e5 100%); box-shadow: 0 2px 12px rgba(37,99,235,.3); }
        .btn-primary:hover { box-shadow: 0 6px 20px rgba(37,99,235,.4); transform: translateY(-1px); }
        .btn-primary:active { transform: translateY(0); }
        .orb { position: absolute; border-radius: 50%; filter: blur(80px); pointer-events: none; }
    </style>
</head>
