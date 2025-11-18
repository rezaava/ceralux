<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title> @yield('title-site')</title>
<!-- Bootstrap 5 RTL CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css">
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<style>

    @font-face {
        font-family: yekan;
        src: url({{ asset('fonts/YekanBakh-Medium.ttf') }});
    }
    :root {
        --main-bg: #181f2a;
        --sidebar-bg: #151a23;
        --card-bg: #232b39;
        --card-border: #232b39;
        --accent-green: #43e97b;
        --text-main: #e6eaf1;
        --text-secondary: #8fa2b7;
        --card-radius: 18px;
        --sidebar-width: 220px;
        --sidebar-width-collapsed: 80px;
        --sidebar-icon-size: 1.4rem;
        --transition: 0.3s cubic-bezier(.4, 2, .6, 1);
    }

    body {
        font-family: yekan, sans-serif;
        background: var(--main-bg);
        color: var(--text-main);
    }

    .sidebar {
        background: var(--sidebar-bg);
        height: 100vh;
        position: fixed;
        right: 0;
        top: 0;
        width: var(--sidebar-width);
        transition: width var(--transition);
        z-index: 1000;
        display: flex;
        flex-direction: column;
        align-items: stretch;
        padding-top: 0;
        box-shadow: 0 0 24px 0 #000a;
    }

    .sidebar.collapsed {
        width: var(--sidebar-width-collapsed);
    }

    .sidebar .sidebar-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 24px 20px 12px 12px;
    }

    .sidebar .sidebar-logo {
        color: var(--accent-green);
        font-size: 2rem;
        font-weight: bold;
        display: flex;
        align-items: center;
        gap: 10px;
        cursor: pointer;
        user-select: none;
    }

    .sidebar .sidebar-title {
        color: var(--text-main);
        font-size: 1.5rem;
        margin-right: 0;
        transition: opacity var(--transition);
    }

    .sidebar.collapsed .sidebar-title {
        opacity: 0;
        width: 0;
        overflow: hidden;
    }

    .sidebar .sidebar-toggle {
        background: none;
        border: none;
        color: var(--text-secondary);
        font-size: 1.5rem;
        cursor: pointer;
        transition: color 0.2s;
    }

    .sidebar .sidebar-toggle:hover {
        color: var(--accent-green);
    }

    .sidebar .nav {
        width: 100%;
        margin-top: 24px;
    }

    .sidebar .nav-link {
        color: var(--text-secondary);
        display: flex;
        align-items: center;
        height: 48px;
        font-size: var(--sidebar-icon-size);
        border-radius: 12px;
        margin: 8px 0;
        transition: background 0.2s, color 0.2s, padding var(--transition);
        padding-right: 18px;
        gap: 16px;
        white-space: nowrap;
    }

    .sidebar .nav-link.active,
    .sidebar .nav-link:hover {
        background: #232b39;
        color: var(--accent-green);
    }

    .sidebar .nav-link .menu-label {
        font-size: 1.1rem;
        color: var(--text-main);
        transition: opacity var(--transition);
    }

    .sidebar.collapsed .nav-link .menu-label {
        opacity: 0;
        width: 0;
        overflow: hidden;
    }

    .sidebar .nav-link .fa {
        margin-left: 0;
    }

    .main-content {
        margin-right: var(--sidebar-width);
        padding: 40px 32px 32px 32px;
        min-height: 100vh;
        background: var(--main-bg);
        transition: margin-right var(--transition);
    }

    .main-content.expanded {
        margin-right: var(--sidebar-width-collapsed);
    }

    .dashboard-header {
        margin-bottom: 32px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .dashboard-header .user-info {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .dashboard-header .user-avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid var(--accent-green);
    }

    .dashboard-header .user-name {
        color: var(--text-main);
        font-weight: 600;
        font-size: 1.1rem;
    }

    .dashboard-header .dashboard-desc {
        color: var(--text-secondary);
        font-size: 1rem;
    }

    .stat-card {
        background: var(--card-bg);
        border-radius: var(--card-radius);
        box-shadow: 0 2px 16px 0 #0003;
        padding: 28px 24px 20px 24px;
        margin-bottom: 24px;
        border: 1px solid var(--card-border);
        color: var(--text-main);
    }

    .stat-card .stat-title {
        color: var(--text-secondary);
        font-size: 1.1rem;
        margin-bottom: 8px;
    }

    .stat-card .stat-value {
        font-size: 2.2rem;
        font-weight: 700;
        margin-bottom: 6px;
    }

    .stat-card .stat-desc {
        color: var(--accent-green);
        font-size: 1rem;
    }

    .card {
        background: var(--card-bg);
        border-radius: var(--card-radius);
        box-shadow: 0 2px 16px 0 #0003;
        border: 1px solid var(--card-border);
        color: var(--text-main);
    }

    .card-header {
        background: transparent;
        border-bottom: none;
        color: var(--text-main);
        font-weight: 600;
        font-size: 1.1rem;
    }

    .notification-area {
        background: var(--card-bg);
        border-radius: var(--card-radius);
        box-shadow: 0 2px 16px 0 #0003;
        border: 1px solid var(--card-border);
        padding: 20px 24px;
        margin-bottom: 24px;
    }

    .notification-area .notif-title {
        color: var(--accent-green);
        font-weight: 700;
        margin-bottom: 12px;
    }

    .notification-area .notif-item {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 10px;
    }

    .notification-area .notif-icon {
        font-size: 1.3rem;
        color: var(--accent-green);
    }

    .notification-area .notif-text {
        color: var(--text-main);
        font-size: 1rem;
    }

    .chart-card {
        background: var(--card-bg);
        border-radius: var(--card-radius);
        box-shadow: 0 2px 16px 0 #0003;
        border: 1px solid var(--card-border);
        padding: 24px 24px 12px 24px;
        margin-bottom: 24px;
    }

    .chart-placeholder {
        width: 100%;
        height: 180px;
        background: linear-gradient(90deg, #232b39 60%, #181f2a 100%);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-secondary);
        font-size: 1.2rem;
        font-weight: 500;
    }

    @media (max-width: 991px) {
        .main-content {
            padding: 24px 8px 8px 8px;
        }
    }

    @media (max-width: 767px) {
        .main-content {
            margin-right: 0;
            padding: 16px 4px 16px 4px;
        }

        .sidebar {
            display: none;
        }

        .sidebar.offcanvas-mobile {
            display: none !important;
        }

        .sidebar.offcanvas-mobile.show {
            display: flex !important;
            flex-direction: column;
            position: fixed;
            top: 0;
            right: 0;
            left: 0;
            bottom: 0;
            width: 100vw;
            height: 100vh;
            background: var(--sidebar-bg);
            z-index: 2000;
            box-shadow: 0 0 32px 0 #000a;
            animation: slideInRight 0.3s cubic-bezier(.4, 2, .6, 1);
        }

        @keyframes slideInRight {
            from {
                right: -100vw;
            }

            to {
                right: 0;
            }
        }

        .sidebar-header {
            display: flex !important;
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
            padding: 24px 20px 12px 12px;
        }

        .sidebar .close-offcanvas {
            display: block;
            background: none;
            border: none;
            color: var(--text-secondary);
            font-size: 2rem;
            cursor: pointer;
        }

        .sidebar .nav {
            flex-direction: column;
            width: 100%;
            margin-top: 32px;
            align-items: flex-start;
        }

        .sidebar .nav-link {
            margin: 0 0 8px 0;
            padding: 0 24px;
            height: 48px;
            flex-direction: row;
            justify-content: flex-start;
            align-items: center;
            font-size: 1.3rem;
            gap: 16px;
        }

        .sidebar .nav-link .menu-label {
            display: block;
            font-size: 1.05rem;
            color: var(--text-main);
            opacity: 1;
            width: auto;
        }

        .dashboard-header {
            flex-direction: row;
            align-items: center;
            text-align: right;
            gap: 8px;
            justify-content: space-between;
        }

        .dashboard-header .user-info {
            flex-direction: row;
            gap: 8px;
        }

        .dashboard-header .user-avatar {
            width: 36px;
            height: 36px;
        }

        .mobile-menu-btn {
            display: inline-flex !important;
            align-items: center;
            justify-content: center;
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            color: var(--accent-green);
            font-size: 1.3rem;
            padding: 6px 10px;
            border-radius: 12px;
            position: fixed;
            top: 36px;
            right: 36px;
            z-index: 2100;
            box-shadow: 0 2px 8px 0 #0002;
            transition: all 0.2s;
        }

        .mobile-menu-btn:hover {
            background: var(--accent-green);
            color: var(--card-bg);
        }
    }

    @media (min-width: 768px) {
        .mobile-menu-btn {
            display: none !important;
        }
    }
</style>