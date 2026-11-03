<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Notifications | HVAC Employee Portal</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --sidebar-w: 260px;
            --primary: #2563eb;
            --primary-dark: #1e40af;
            --bg: #f1f5f9;
            --text: #1e293b;
            --muted: #64748b;
            --border: #e2e8f0;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: var(--bg);
            font-family: "Segoe UI", Arial, sans-serif;
            color: var(--text);
        }

        /* ===== FIXED SIDEBAR (does not move on scroll) ===== */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-w);
            height: 100vh;
            background: linear-gradient(180deg, #0f172a 0%, #1e3a8a 100%);
            color: #cbd5e1;
            display: flex;
            flex-direction: column;
            z-index: 1000;
            overflow-y: auto;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 24px 22px;
            border-bottom: 1px solid rgba(255, 255, 255, .08);
        }

        .brand-logo {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: linear-gradient(135deg, #38bdf8, #2563eb);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 20px;
            box-shadow: 0 6px 16px rgba(56, 189, 248, .35);
        }

        .brand-text strong {
            display: block;
            color: #fff;
            font-size: 17px;
        }

        .brand-text small {
            font-size: 12px;
            color: #94a3b8;
        }

        .menu-title {
            padding: 20px 22px 8px;
            font-size: 11px;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            color: #64748b;
        }

        .sidebar-menu {
            list-style: none;
            margin: 0;
            padding: 0 12px;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px 14px;
            margin-bottom: 4px;
            border-radius: 10px;
            color: #cbd5e1;
            text-decoration: none;
            font-size: 14.5px;
            transition: all .2s ease;
        }

        .sidebar-menu a i {
            width: 20px;
            text-align: center;
            font-size: 16px;
        }

        .sidebar-menu a:hover {
            background: rgba(255, 255, 255, .08);
            color: #fff;
            transform: translateX(3px);
        }

        .sidebar-menu a.active {
            background: linear-gradient(90deg, #3b82f6, #2563eb);
            color: #fff;
            box-shadow: 0 6px 16px rgba(37, 99, 235, .4);
        }

        .sidebar-menu .count {
            margin-left: auto;
            background: #ef4444;
            color: #fff;
            font-size: 11px;
            padding: 2px 8px;
            border-radius: 20px;
        }

        /* ===== MAIN CONTENT (only this area scrolls) ===== */
        .main {
            margin-left: var(--sidebar-w);
            min-height: 100vh;
        }

        .topbar {
            position: sticky;
            top: 0;
            z-index: 900;
            background: rgba(255, 255, 255, .9);
            backdrop-filter: blur(8px);
            border-bottom: 1px solid var(--border);
            padding: 16px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .topbar h4 {
            margin: 0;
            font-size: 20px;
            font-weight: 700;
        }

        .topbar p {
            margin: 2px 0 0;
            font-size: 13px;
            color: var(--muted);
        }

        /* Create notification button */
        .btn-create {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: 0;
            background: linear-gradient(90deg, #3b82f6, #2563eb);
            color: #fff;
            font-size: 14px;
            font-weight: 600;
            padding: 10px 20px;
            border-radius: 10px;
            white-space: nowrap;
            box-shadow: 0 6px 16px rgba(37, 99, 235, .35);
            transition: all .2s ease;
        }

        .btn-create:hover {
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 10px 22px rgba(37, 99, 235, .45);
        }

        .content {
            padding: 28px 32px;
            max-width: 1000px;
        }

        /* Notification cards */
        .notification-card {
            position: relative;
            background: #fff;
            border: 1px solid var(--border);
            border-left: 4px solid transparent;
            border-radius: 14px;
            padding: 20px;
            margin-bottom: 14px;
            display: flex;
            gap: 16px;
            align-items: flex-start;
            transition: all .25s ease;
        }

        .notification-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 28px rgba(15, 23, 42, .10);
        }

        .notification-card.announcement {
            border-left-color: #3b82f6;
        }

        .notification-card.important {
            border-left-color: #f59e0b;
        }

        .notification-card.system {
            border-left-color: #10b981;
        }

        .notification-card.unread {
            background: #f8fbff;
        }

        .notification-card.unread::after {
            content: "";
            position: absolute;
            top: 18px;
            right: 18px;
            width: 9px;
            height: 9px;
            border-radius: 50%;
            background: #ef4444;
            box-shadow: 0 0 0 4px rgba(239, 68, 68, .15);
        }

        .notification-icon {
            width: 50px;
            height: 50px;
            min-width: 50px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: #fff;
        }

        .icon-announcement {
            background: linear-gradient(135deg, #60a5fa, #2563eb);
        }

        .icon-important {
            background: linear-gradient(135deg, #fbbf24, #ea580c);
        }

        .icon-system {
            background: linear-gradient(135deg, #34d399, #059669);
        }

        .notification-content {
            flex: 1;
            padding-right: 14px;
        }

        .notification-content h6 {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .notification-content p {
            font-size: 14px;
            color: var(--muted);
            line-height: 1.65;
            margin-bottom: 12px;
        }

        .notification-meta {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 16px;
            font-size: 12.5px;
            color: #94a3b8;
        }

        .notification-meta span {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        /* ===== TABS (All / Sent) ===== */
        .tabs-bar {
            display: inline-flex;
            gap: 6px;
            padding: 5px;
            margin-bottom: 22px;
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 14px;
            box-shadow: 0 4px 14px rgba(15, 23, 42, .05);
        }

        .tab-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: 0;
            background: transparent;
            color: var(--muted);
            font-size: 14px;
            font-weight: 600;
            padding: 9px 22px;
            border-radius: 10px;
            transition: all .2s ease;
        }

        .tab-btn:hover {
            color: var(--primary);
            background: #f1f5f9;
        }

        .tab-btn.active {
            background: linear-gradient(90deg, #3b82f6, #2563eb);
            color: #fff;
            box-shadow: 0 6px 14px rgba(37, 99, 235, .35);
        }

        .tab-count {
            min-width: 22px;
            padding: 1px 7px;
            border-radius: 20px;
            font-size: 11.5px;
            text-align: center;
            background: #e2e8f0;
            color: #475569;
        }

        .tab-btn.active .tab-count {
            background: rgba(255, 255, 255, .25);
            color: #fff;
        }

        .empty-state {
            text-align: center;
            padding: 50px 20px;
            background: #fff;
            border: 1px dashed var(--border);
            border-radius: 14px;
            color: var(--muted);
        }

        .empty-state i {
            font-size: 34px;
            color: #cbd5e1;
            margin-bottom: 10px;
        }

        /* ===== CREATE NOTIFICATION MODAL ===== */
        .modal-content {
            border: 0;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 25px 60px rgba(15, 23, 42, .25);
        }

        .modal-header-custom {
            background: linear-gradient(135deg, #1e3a8a, #2563eb);
            color: #fff;
            padding: 20px 26px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .modal-header-custom .title-wrap {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .modal-header-custom .title-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: rgba(255, 255, 255, .18);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .modal-header-custom h5 {
            margin: 0;
            font-size: 18px;
            font-weight: 700;
        }

        .modal-header-custom small {
            color: #bfdbfe;
            font-size: 12.5px;
        }

        /* Keep header + footer (Cancel / Send) always visible, only the body scrolls */
        .modal-dialog-scrollable .modal-content {
            max-height: 100%;
            display: flex;
            flex-direction: column;
        }

        .modal-content form {
            display: flex;
            flex-direction: column;
            flex: 1 1 auto;
            min-height: 0;
            overflow: hidden;
        }

        .modal-header-custom {
            flex-shrink: 0;
        }

        .modal-body {
            padding: 26px;
            background: #fff;
            flex: 1 1 auto;
            min-height: 0;
            overflow-y: auto;
        }

        .form-label {
            font-size: 13px;
            font-weight: 600;
            color: var(--text);
            margin-bottom: 6px;
        }

        .form-control {
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 11px 14px;
            font-size: 14px;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(37, 99, 235, .12);
        }

        .char-count {
            font-size: 12px;
            color: #94a3b8;
            text-align: right;
            margin-top: 4px;
        }

        /* Users box */
        .users-box {
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
        }

        .users-toolbar {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            background: #f8fafc;
            border-bottom: 1px solid var(--border);
        }

        .users-toolbar .search {
            position: relative;
            flex: 1;
        }

        .users-toolbar .search i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 13px;
        }

        .users-toolbar .search input {
            padding-left: 34px;
            padding-top: 8px;
            padding-bottom: 8px;
        }

        .select-all {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            font-weight: 600;
            white-space: nowrap;
            cursor: pointer;
            margin: 0;
        }

        .users-list {
            max-height: 240px;
            overflow-y: auto;
        }

        .user-row {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px 16px;
            border-bottom: 1px solid #f1f5f9;
            cursor: pointer;
            transition: background .15s ease;
            margin: 0;
        }

        .user-row:last-child {
            border-bottom: 0;
        }

        .user-row:hover {
            background: #f8fbff;
        }

        .user-row.selected {
            background: #eff6ff;
        }

        .user-avatar {
            width: 42px;
            height: 42px;
            min-width: 42px;
            border-radius: 50%;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 14px;
        }

        .user-info {
            flex: 1;
            min-width: 0;
        }

        .user-info strong {
            display: block;
            font-size: 14px;
        }

        .user-info small {
            display: block;
            font-size: 12.5px;
            color: var(--muted);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-role {
            font-size: 11.5px;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 20px;
            background: #e0e7ff;
            color: #3730a3;
            white-space: nowrap;
        }

        .selected-info {
            font-size: 13px;
            color: var(--muted);
        }

        .selected-info b {
            color: var(--primary);
        }

        .modal-footer-custom {
            flex-shrink: 0;
            padding: 16px 26px;
            background: #f8fafc;
            border-top: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .btn-cancel {
            border: 1px solid var(--border);
            background: #fff;
            color: var(--muted);
            font-weight: 600;
            font-size: 14px;
            padding: 10px 20px;
            border-radius: 10px;
        }

        .btn-cancel:hover {
            background: #f1f5f9;
        }

        .btn-send {
            border: 0;
            background: linear-gradient(90deg, #3b82f6, #2563eb);
            color: #fff;
            font-weight: 600;
            font-size: 14px;
            padding: 10px 26px;
            border-radius: 10px;
            box-shadow: 0 6px 16px rgba(91, 98, 114, 0.35);
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-send:hover {
            color: #fff;
            box-shadow: 0 10px 22px rgba(37, 99, 235, .45);
        }

        /* Toast */
        .toast-wrap {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 2000;
        }

        .toast-success {
            background: #059669;
            color: #fff;
            border: 0;
            border-radius: 12px;
            box-shadow: 0 10px 28px rgba(5, 150, 105, .35);
        }

        /* Mobile */
        @media (max-width: 992px) {
            :root {
                --sidebar-w: 78px;
            }

            .brand-text,
            .menu-title,
            .sidebar-menu a span,
            .sidebar-menu .count {
                display: none;
            }

            .sidebar-brand {
                justify-content: center;
                padding-left: 0;
                padding-right: 0;
            }

            .sidebar-menu a {
                justify-content: center;
            }
        }

        @media (max-width: 576px) {

            .topbar,
            .content {
                padding-left: 16px;
                padding-right: 16px;
            }

            .topbar p {
                display: none;
            }

            .btn-create span {
                display: none;
            }

            .notification-card {
                padding: 14px;
                gap: 12px;
            }

            .notification-icon {
                width: 40px;
                height: 40px;
                min-width: 40px;
                font-size: 16px;
            }

            .user-role {
                display: none;
            }

            .modal-body,
            .modal-footer-custom,
            .modal-header-custom {
                padding-left: 16px;
                padding-right: 16px;
            }
        }
    </style>

</head>

<body>

    <!-- ===== FIXED SIDEBAR ===== -->

    @include('layouts.header')

    <!-- ===== MAIN ===== -->

    <main class="main">

        <div class="topbar">

            <div>

                <h4>Notifications</h4>

                <p>Stay updated with all your latest messages and announcements.</p>

            </div>

            <!-- Create Notification Button -->

            @can('create notification')
                <button type="button" class="btn-create" data-bs-toggle="modal" data-bs-target="#createNotificationModal">

                    <i class="fas fa-plus-circle"></i> <span>Create Notification</span>

                </button>
            @endcan

        </div>

        <div class="content">

            <!-- Tabs -->

            @can('create notification')
                <div class="tabs-bar" id="notifTabs">

                    <button type="button" class="tab-btn active" data-tab="all">

                        <i class="fas fa-bell"></i> All <span class="tab-count"
                            id="countAll">{{ $notifications->count() }}</span>

                    </button>

                    <button type="button" class="tab-btn" data-tab="sent">

                        <i class="fas fa-paper-plane"></i> Sent <span class="tab-count"
                            id="countSent">{{ $sent->count() }}</span>

                    </button>

                </div>
            @endcan

            <!-- Notification list -->

            <div id="notificationList">

                @forelse ($notifications as $notification)
                    <div class="notification-card announcement">

                        <div class="notification-icon icon-announcement"><i class="fas fa-bullhorn"></i></div>

                        <div class="notification-content">

                            <h6>{{ $notification->title }}</h6>

                            <p>{{ $notification->description }}</p>

                            <div class="notification-meta">

                                <span><i class="far fa-clock"></i>

                                    {{ $notification->created_at->diffForHumans() }}</span>

                            </div>

                        </div>

                    </div>

                @empty

                    <div class="empty-state" id="emptyState">

                        <i class="far fa-bell-slash"></i>

                        <div>No notifications found.</div>

                    </div>
                @endforelse

            </div>

            @can('create notification')

                <div class="d-none" id="sentNotifications">

                    @forelse ($sent as $notification)
                        <div class="notification-card announcement">

                            <div class="notification-icon icon-announcement"><i class="fas fa-bullhorn"></i></div>

                            <div class="notification-content">

                                <h6>{{ $notification->title }}</h6>

                                <p>{{ $notification->description }}</p>

                                <div class="notification-meta">

                                    <span><i class="far fa-clock"></i>

                                        {{ $notification->created_at->diffForHumans() }}</span>

                                    <span><i class="fas fa-paper-plane"></i> Sent to

                                        {{ count($notification->user_ids) }}

                                        users</span>

                                </div>

                            </div>

                        </div>

                    @empty

                        <div class="empty-state" id="sentEmptyState" style="display: none;">

                            <i class="far fa-bell-slash"></i>

                            <div>No notifications found.</div>

                        </div>
                    @endforelse

                </div>

            @endcan

        </div>

    </main>

    <!-- ===== CREATE NOTIFICATION MODAL ===== -->

    <div class="modal fade" id="createNotificationModal" tabindex="-1" aria-labelledby="createNotificationLabel"
        aria-hidden="true">

        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">

            <div class="modal-content">

                <div class="modal-header-custom">

                    <div class="title-wrap">

                        <div class="title-icon"><i class="fas fa-paper-plane"></i></div>

                        <div>

                            <h5 id="createNotificationLabel">Create Notification</h5>

                            <small>Write a message and choose who should receive it.</small>

                        </div>

                    </div>

                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>

                </div>

                <form id="notificationForm" method="POST" action="{{ route('sendNotification') }}">

                    @csrf

                    <div class="modal-body">

                        <!-- Title -->

                        <div class="mb-3">

                            <label for="notifTitle" class="form-label">Title <span class="text-danger">*</span></label>

                            <input type="text" class="form-control" id="notifTitle" maxlength="80"
                                placeholder="Enter notification title" name="title">

                            <div class="invalid-feedback">Please enter a title.</div>

                        </div>

                        <!-- Description -->

                        <div class="mb-4">

                            <label for="notifDescription" class="form-label">Description
                                <span                                     class="text-danger">*</span></label>

                            <textarea class="form-control" id="notifDescription" rows="4" name="description" maxlength="300"                  
                                              placeholder="Write your message here..."></textarea>

                            <div class="char-count"><span id="descCount">0</span>/300</div>

                            <div class="invalid-feedback">Please enter a description.</div>

                        </div>

                        <!-- Users -->

                        <label class="form-label">Send To <span class="text-danger">*</span></label>

                        <div class="users-box" id="usersBox">

                            <div class="users-toolbar">

                                <div class="search">

                                    <i class="fas fa-search"></i>

                                    <input type="text" class="form-control" id="userSearch"
                                        placeholder="Search by name, email or role">

                                </div>

                                <label class="select-all">

                                    <input type="checkbox" class="form-check-input mt-0" id="selectAll">

                                    Select All

                                </label>

                            </div>

                            <div class="users-list" id="usersList">

                                @forelse ($employee as $e)
                                    <label class="user-row">

                                        <input type="checkbox" name="user_ids[]" value="{{ $e->user_id }}"
                                            class="form-check-input user-check mt-0">

                                        <div class="user-avatar"
                                            style="background:linear-gradient(135deg,#60a5fa,#2563eb)">

                                            {{ substr($e->full_name, 0, 1) }}</div>

                                        <div class="user-info">

                                            <strong>{{ $e->full_name }}</strong>

                                            <small>{{ $e->email }}
                                                &bull; {{ $e->phone }}</small>

                                        </div>

                                        <span class="user-role">{{ $e->designation }}</span>

                                    </label>

                                @empty

                                    <div class="text-center text-muted py-4 d-none" id="noUsers">

                                        <i class="fas fa-user-slash mb-2"></i><br>No users found

                                    </div>
                                @endforelse

                            </div>

                        </div>

                        <div class="text-danger mt-2 d-none" id="userError" style="font-size:13px;">

                            <i class="fas fa-exclamation-circle"></i> Please select at
                            least one user.

                        </div>

                    </div>

                    <div class="modal-footer-custom">

                        <div class="selected-info"><b id="selectedCount">0</b> user(s)
                            selected</div>

                        <div class="d-flex gap-2">

                            <button type="button" class="btn-cancel" data-bs-dismiss="modal">Cancel</button>

                            <button type="submit" class="btn-send"><i class="fas fa-paper-plane"></i> Send</button>

                        </div>

                    </div>

                </form>

            </div>

        </div>

    </div>

    <!-- Success toast -->

    <div class="toast-wrap">

        <div id="successToast" class="toast toast-success align-items-center" role="alert" aria-live="assertive"
            aria-atomic="true" data-bs-delay="3000">

            <div class="d-flex">

                <div class="toast-body" id="toastMessage"><i class="fas fa-check-circle me-2"></i>
                    Notification sent

                    successfully.</div>

                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>

            </div>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/dayjs@1/dayjs.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/dayjs@1/plugin/relativeTime.js"></script>
    <script>
        dayjs.extend(dayjs_plugin_relativeTime);
    </script>
    <script>
        window.authUserId = @json(auth()->id());

        console.log('Logged-in User ID:', window.authUserId);
    </script>

    @vite(['resources/js/app.js'])

    <script>
        window.addEventListener('echo-ready', function() {

            const userId = window.authUserId;

            window.Echo.private(`users.${userId}`)
                .listen('.notification.created', function(event) {

                    console.log('Complete Event Data:', event);

                    let notification = event.notification ?? event.data ?? event;

                    console.log('Notification Data:', notification);

                    document.getElementById('emptyState')?.remove();

                    let title = notification.title ?? 'New Notification';
                    let description = notification.description ?? notification.message ?? '';
                    let createdAt = 'Just now';

                    if (notification.createdAt) {
                        let seconds = dayjs().diff(dayjs(notification.createdAt), 'second');

                        if (seconds < 60) {
                            createdAt = seconds + ' seconds ago';
                        } else {
                            createdAt = dayjs(notification.createdAt).fromNow();
                        }
                    }

                    function escapeHtml(value) {
                        const div = document.createElement('div');
                        div.textContent = value ?? '';
                        return div.innerHTML;
                    }

                    let html = `
                <div class="notification-card announcement">

                    <div class="notification-icon icon-announcement">
                        <i class="fas fa-bullhorn"></i>
                    </div>

                    <div class="notification-content">

                        <h6>${escapeHtml(title)}</h6>

                        <p>${escapeHtml(description)}</p>

                        <div class="notification-meta">
                            <span>
                                <i class="far fa-clock"></i>
                                ${escapeHtml(createdAt)}
                            </span>
                        </div>

                    </div>

                </div>
            `;

                    document.getElementById('notificationList')
                        .insertAdjacentHTML('afterbegin', html);

                });

        });






        /* =========================================

           2. NOTIFICATION FORM ELEMENTS

        ========================================= */



        (function() {



            const modalEl = document.getElementById('createNotificationModal');

            const form = document.getElementById('notificationForm');

            const titleInput = document.getElementById('notifTitle');

            const descInput = document.getElementById('notifDescription');

            const descCount = document.getElementById('descCount');

            const selectAll = document.getElementById('selectAll');

            const searchInput = document.getElementById('userSearch');

            const userError = document.getElementById('userError');

            const selectedCount = document.getElementById('selectedCount');

            const noUsers = document.getElementById('noUsers');



            // Check required elements

            if (!modalEl || !form) {

                console.error('Notification modal or form not found');

                return;

            }



            function userRows() {

                return document.querySelectorAll('#usersList .user-row');

            }



            function checks() {

                return document.querySelectorAll('#usersList .user-check');

            }



            function escapeHtml(str) {

                const div = document.createElement('div');

                div.textContent = str ?? '';

                return div.innerHTML;

            }





            /* =========================================

               3. DESCRIPTION CHARACTER COUNTER

            ========================================= */



            if (descInput && descCount) {



                descInput.addEventListener('input', function() {

                    descCount.textContent = descInput.value.length;

                });



            }





            /* =========================================

               4. UPDATE SELECTED USERS

            ========================================= */



            function updateSelected() {



                let n = 0;



                checks().forEach(function(c) {



                    const row = c.closest('.user-row');



                    if (row) {

                        row.classList.toggle('selected', c.checked);

                    }



                    if (c.checked) {

                        n++;

                    }



                });



                if (selectedCount) {

                    selectedCount.textContent = n;

                }



                const visible = Array.from(checks()).filter(function(c) {



                    const row = c.closest('.user-row');



                    return row && row.style.display !== 'none';



                });



                if (selectAll) {



                    selectAll.checked =

                        visible.length > 0 &&

                        visible.every(function(c) {

                            return c.checked;

                        });



                }



                if (n > 0 && userError) {

                    userError.classList.add('d-none');

                }



            }





            /* =========================================

               5. USER CHECKBOX CHANGE

            ========================================= */



            checks().forEach(function(c) {



                c.addEventListener('change', updateSelected);



            });





            /* =========================================

               6. SELECT ALL USERS

            ========================================= */



            if (selectAll) {



                selectAll.addEventListener('change', function() {



                    checks().forEach(function(c) {



                        const row = c.closest('.user-row');



                        if (row && row.style.display !== 'none') {

                            c.checked = selectAll.checked;

                        }



                    });



                    updateSelected();



                });



            }





            /* =========================================

               7. SEARCH USERS

            ========================================= */



            if (searchInput) {



                searchInput.addEventListener('input', function() {



                    const q = searchInput.value.trim().toLowerCase();



                    let shown = 0;



                    userRows().forEach(function(row) {



                        const match = row.textContent.toLowerCase().includes(q);



                        row.style.display = match ? '' : 'none';



                        if (match) {

                            shown++;

                        }



                    });



                    if (noUsers) {

                        noUsers.classList.toggle('d-none', shown !== 0);

                    }



                    updateSelected();



                });



            }





            /* =========================================

               8. DEFAULT TAB ON PAGE LOAD

            ========================================= */



            const notificationList = document.getElementById('notificationList');

            const sentNotifications = document.getElementById('sentNotifications');



            if (notificationList && sentNotifications) {



                notificationList.classList.remove('d-none');



                sentNotifications.classList.add('d-none');



            }



            document.querySelectorAll('.tab-btn').forEach(function(btn) {



                btn.classList.toggle('active', btn.dataset.tab === 'all');



            });





            /* =========================================

               9. ALL / SENT TABS

            ========================================= */



            document.querySelectorAll('.tab-btn').forEach(function(btn) {



                btn.addEventListener('click', function() {



                    const tab = this.dataset.tab;



                    document.querySelectorAll('.tab-btn').forEach(function(b) {



                        b.classList.remove('active');



                    });



                    this.classList.add('active');



                    if (notificationList) {



                        notificationList.querySelectorAll('.notification-card')

                            .forEach(function(card) {



                                card.classList.toggle('d-none', tab === 'sent');



                            });



                    }



                    if (sentNotifications) {



                        sentNotifications.classList.toggle('d-none', tab !== 'sent');



                    }



                });



            });





            /* =========================================

               10. RESET FORM WHEN MODAL CLOSES

            ========================================= */



            modalEl.addEventListener('hidden.bs.modal', function() {



                form.reset();



                if (descCount) {

                    descCount.textContent = '0';

                }



                if (titleInput) {

                    titleInput.classList.remove('is-invalid');

                }



                if (descInput) {

                    descInput.classList.remove('is-invalid');

                }



                if (userError) {

                    userError.classList.add('d-none');

                }



                userRows().forEach(function(row) {



                    row.style.display = '';



                });



                if (noUsers) {

                    noUsers.classList.add('d-none');

                }



                updateSelected();



            });



            // Initial selected count

            updateSelected();



        })();
    </script>

</body>

</html>
