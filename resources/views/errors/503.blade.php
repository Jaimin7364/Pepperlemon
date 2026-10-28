<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Under Maintenance' }} - Pepperlemon</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            color: #1e293b;
        }
        .maintenance-card {
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.08), 0 0 1px 1px rgba(0, 0, 0, 0.04);
            max-width: 580px;
            width: 100%;
            padding: 48px 40px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .maintenance-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(90deg, #10b981 0%, #059669 50%, #047857 100%);
        }
        .logo-wrap {
            margin-bottom: 24px;
        }
        .logo-wrap img {
            max-height: 64px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.06);
        }
        .icon-container {
            width: 88px;
            height: 88px;
            background: #ecfdf5;
            color: #059669;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
            font-size: 38px;
            position: relative;
            animation: pulse-ring 2.5s infinite;
        }
        @keyframes pulse-ring {
            0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.25); }
            70% { box-shadow: 0 0 0 20px rgba(16, 185, 129, 0); }
            100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
        }
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #fef3c7;
            color: #92400e;
            font-size: 13px;
            font-weight: 600;
            padding: 6px 14px;
            border-radius: 9999px;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .status-dot {
            width: 8px;
            height: 8px;
            background: #f59e0b;
            border-radius: 50%;
            display: inline-block;
            animation: blink 1.2s infinite ease-in-out;
        }
        @keyframes blink {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.4; transform: scale(0.85); }
        }
        h1 {
            font-family: 'Outfit', sans-serif;
            font-size: 30px;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 14px;
            line-height: 1.25;
        }
        p.desc {
            font-size: 15px;
            color: #64748b;
            line-height: 1.6;
            margin-bottom: 28px;
        }
        .info-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            padding: 16px 20px;
            display: flex;
            align-items: center;
            justify-content: space-around;
            margin-bottom: 30px;
            font-size: 14px;
        }
        .info-item {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }
        .info-label {
            font-size: 12px;
            color: #94a3b8;
            text-transform: uppercase;
            font-weight: 600;
        }
        .info-value {
            font-weight: 700;
            color: #0f172a;
        }
        .btn-refresh {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            background: #059669;
            color: #ffffff;
            font-weight: 600;
            font-size: 15px;
            padding: 12px 28px;
            border-radius: 12px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 4px 12px rgba(5, 150, 105, 0.25);
        }
        .btn-refresh:hover {
            background: #047857;
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(5, 150, 105, 0.35);
        }
        .footer-note {
            margin-top: 28px;
            font-size: 13px;
            color: #94a3b8;
        }
    </style>
</head>
<body>
    <div class="maintenance-card">
        <div class="logo-wrap">
            <img src="{{ asset('images/logo.jpeg') }}" alt="Pepperlemon Logo" onerror="this.style.display='none'">
        </div>

        <div class="status-badge">
            <span class="status-dot"></span>
            Scheduled Maintenance
        </div>

        <div class="icon-container">
            <i class="fa-solid fa-screwdriver-wrench"></i>
        </div>

        <h1>{{ $title ?? 'Under Maintenance' }}</h1>
        <p class="desc">
            {{ $message ?? 'Pepperlemon is currently undergoing scheduled updates and maintenance. We are working hard to provide you with the best shopping experience and will be back shortly!' }}
        </p>

        <div class="info-box">
            <div class="info-item">
                <span class="info-label">Current Status</span>
                <span class="info-value" style="color: #059669;">Upgrading</span>
            </div>
            <div class="info-item">
                <span class="info-label">Expected Duration</span>
                <span class="info-value">{{ $estimated_time ?? 'A few minutes' }}</span>
            </div>
        </div>

        <div>
            <button onclick="window.location.reload();" class="btn-refresh">
                <i class="fa-solid fa-arrows-rotate"></i>
                Check Again
            </button>
        </div>

        <div class="footer-note">
            Thank you for your patience! &bull; &copy; {{ date('Y') }} Pepperlemon
        </div>
    </div>
</body>
</html>
