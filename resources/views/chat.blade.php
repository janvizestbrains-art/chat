<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">

    <style>
        .online-dot {
            width: 9px;
            height: 9px;
            background-color: #22c55e;
            border-radius: 50%;
            display: inline-block;
            margin-left: 5px;
            box-shadow: 0 0 4px rgba(34, 197, 94, 0.4);
        }

        .online-dot[hidden] {
            display: none;
        }

        .user-status {
            font-size: 12px;
            color: #888;
        }

        .user-status.is-online {
            color: #22c55e;
        }

        .message-status.read-tick {
            color: #34b7f1;
        }

        .empty-chat {
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 10px;
            color: #999;
            text-align: center;
        }

        .empty-chat i {
            font-size: 45px;
            color: #bbb;
        }

        .empty-chat strong {
            font-size: 16px;
            color: #555;
        }

        .empty-chat span {
            font-size: 13px;
        }

        .single-tick {
            color: #999;
            margin-left: 4px;
        }

        .read-tick {
            color: #34b7f1;
            margin-left: 4px;
        }

        :root {
            --sidebar-w: 260px;
            --primary: #2563eb;
            --primary-dark: #1e40af;
            --bg: #f1f5f9;
            --text: #1e293b;
            --muted: #64748b;
            --border: #e2e8f0;
            --chat-bg: #efeae2;
            --bubble-out: #d9fdd3;
            --bubble-in: #ffffff;
            --wa-green: #25d366;
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

        /* ================= Sidebar ================= */
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

        /* ================= Main ================= */
        .main {
            margin-left: var(--sidebar-w);
            min-height: 100vh;
        }

        .content {
            padding: 20px 28px;
        }

        /* ================= Chat shell ================= */
        .chat-app {
            display: flex;
            height: calc(100vh - 40px);
            min-height: 480px;
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 14px 34px rgba(15, 23, 42, .10);
        }

        /* ---------- Left panel ---------- */
        .chat-list {
            width: 350px;
            min-width: 350px;
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            background: #fff;
            min-height: 0;
            position: relative;
        }

        .chat-list-head {
            flex-shrink: 0;
            padding: 18px 20px;
            background: linear-gradient(135deg, #1e3a8a, #2563eb);
            color: #fff;
            font-size: 18px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .chat-list-head .new-group-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            border: 0;
            background: rgba(255, 255, 255, .16);
            color: #fff;
            font-size: 13px;
            font-weight: 600;
            padding: 8px 14px;
            border-radius: 999px;
            cursor: pointer;
            transition: background .2s ease, transform .15s ease;
        }

        .chat-list-head .new-group-btn:hover {
            background: rgba(255, 255, 255, .28);
            transform: translateY(-1px);
        }

        .chat-list-head .new-group-btn i {
            font-size: 13px;
        }

        .chat-search {
            flex-shrink: 0;
            padding: 12px 14px 8px;
        }

        .chat-search .box {
            position: relative;
        }

        .chat-search i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 13px;
        }

        .chat-search input {
            width: 100%;
            border: 1px solid transparent;
            background: #f1f5f9;
            border-radius: 12px;
            padding: 10px 14px 10px 40px;
            font-size: 14px;
            outline: none;
            transition: all .2s ease;
        }

        .chat-search input:focus {
            background: #fff;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(37, 99, 235, .12);
        }

        .chat-filters {
            flex-shrink: 0;
            display: flex;
            gap: 8px;
            padding: 6px 14px 12px;
            border-bottom: 1px solid var(--border);
        }

        .chat-filters button {
            border: 0;
            background: #f1f5f9;
            color: var(--muted);
            font-size: 12.5px;
            font-weight: 600;
            padding: 6px 16px;
            border-radius: 20px;
            transition: all .2s ease;
        }

        .chat-filters button:hover {
            background: #e2e8f0;
        }

        .chat-filters button.active {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .contacts {
            flex: 1 1 auto;
            min-height: 0;
            overflow-y: auto;
        }

        .contacts::-webkit-scrollbar,
        .chat-body::-webkit-scrollbar {
            width: 6px;
        }

        .contacts::-webkit-scrollbar-thumb,
        .chat-body::-webkit-scrollbar-thumb {
            background: rgba(100, 116, 139, .35);
            border-radius: 6px;
        }

        .contact {
            position: relative;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 13px 18px;
            cursor: pointer;
            border-bottom: 1px solid #f1f5f9;
            transition: background .15s ease;
        }

        .contact:hover {
            background: #f8fafc;
        }

        .contact.active {
            background: #eff6ff;
        }

        .contact.active::before {
            content: "";
            position: absolute;
            left: 0;
            top: 10px;
            bottom: 10px;
            width: 4px;
            border-radius: 0 4px 4px 0;
            background: var(--primary);
        }

        .avatar {
            width: 48px;
            height: 48px;
            min-width: 48px;
            border-radius: 50%;
            color: #fff;
            font-weight: 700;
            font-size: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            box-shadow: 0 3px 8px rgba(15, 23, 42, .18);
            object-fit: cover;
        }

        .avatar.online::after {
            content: "";
            position: absolute;
            right: 0;
            bottom: 1px;
            width: 12px;
            height: 12px;
            background: #22c55e;
            border: 2px solid #fff;
            border-radius: 50%;
        }

        .contact-info {
            flex: 1;
            min-width: 0;
        }

        .contact-top {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            gap: 8px;
        }

        .contact-top strong {
            font-size: 14.8px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .contact-top small {
            font-size: 11.5px;
            color: #94a3b8;
            white-space: nowrap;
        }

        .contact.has-unread .contact-top small {
            color: #16a34a;
            font-weight: 600;
        }

        .contact-bottom {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 8px;
            margin-top: 2px;
        }

        .contact-bottom .preview {
            font-size: 13px;
            color: var(--muted);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .contact-bottom .preview i {
            font-size: 12px;
            margin-right: 4px;
        }

        .contact-bottom .preview .fa-check-double {
            color: #53bdeb;
        }

        .unread {
            background: var(--wa-green);
            color: #fff;
            font-style: normal;
            font-size: 11px;
            font-weight: 700;
            min-width: 20px;
            height: 20px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 6px;
        }

        .no-result {
            display: none;
            padding: 30px 16px;
            text-align: center;
            color: #94a3b8;
            font-size: 14px;
        }

        /* ---------- Right panel ---------- */
        .chat-window {
            position: relative;
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
            min-height: 0;
        }

        .panes {
            position: relative;
            flex: 1 1 auto;
            min-height: 0;
            display: flex;
            flex-direction: column;
        }

        .chat-pane {
            display: none;
            flex: 1 1 auto;
            min-height: 0;
            flex-direction: column;
        }

        .chat-pane.active {
            display: flex;
        }

        .chat-head {
            flex-shrink: 0;
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 11px 20px;
            background: #fff;
            border-bottom: 1px solid var(--border);
            box-shadow: 0 2px 8px rgba(15, 23, 42, .05);
            position: relative;
            z-index: 3;
        }

        .chat-head .back {
            display: none;
            cursor: pointer;
            color: var(--muted);
            font-size: 18px;
        }

        .chat-head .who strong {
            display: block;
            font-size: 15.5px;
            line-height: 1.25;
        }

        .chat-head .who small {
            font-size: 12.5px;
            color: var(--muted);
        }

        .chat-head .who small.on {
            color: #16a34a;
        }

        .chat-body {
            flex: 1 1 auto;
            min-height: 0;
            overflow-y: auto;
            padding: 18px 6% 12px;
            background-color: var(--chat-bg);
            background-image: radial-gradient(rgba(0, 0, 0, .05) 1px, transparent 1px);
            background-size: 18px 18px;
        }

        .day-chip {
            text-align: center;
            margin: 14px 0 10px;
        }

        .day-chip span {
            background: #fff;
            color: var(--muted);
            font-size: 12px;
            font-weight: 600;
            padding: 5px 14px;
            border-radius: 8px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, .1);
        }

        .msg {
            display: flex;
            margin-bottom: 3px;
        }

        .msg.out {
            justify-content: flex-end;
        }

        .msg.first {
            margin-top: 10px;
        }

        .bubble {
            position: relative;
            max-width: 66%;
            padding: 6px 10px 5px;
            border-radius: 10px;
            font-size: 14.2px;
            line-height: 1.45;
            box-shadow: 0 1px 1px rgba(0, 0, 0, .13);
            word-wrap: break-word;
            overflow-wrap: anywhere;
        }

        .msg.in .bubble {
            background: var(--bubble-in);
        }

        .msg.out .bubble {
            background: var(--bubble-out);
        }

        .msg.first .bubble::before {
            content: "";
            position: absolute;
            top: 0;
            width: 10px;
            height: 12px;
        }

        .msg.in.first .bubble {
            border-top-left-radius: 0;
        }

        .msg.out.first .bubble {
            border-top-right-radius: 0;
        }

        .msg.in.first .bubble::before {
            left: -8px;
            background: var(--bubble-in);
            clip-path: polygon(100% 0, 0 0, 100% 100%);
        }

        .msg.out.first .bubble::before {
            right: -8px;
            background: var(--bubble-out);
            clip-path: polygon(0 0, 100% 0, 0 100%);
        }

        .sender {
            display: block;
            font-size: 12.5px;
            font-weight: 700;
            margin-bottom: 1px;
        }

        .meta {
            float: right;
            margin: 8px 0 -3px 12px;
            font-size: 11px;
            color: #667781;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .meta .tick,
        .meta-over .tick {
            color: #8696a0;
            margin-left: 3px;
            font-size: 11.5px;
            cursor: pointer;
            transition: color .25s ease;
        }

        .meta .tick.read,
        .meta-over .tick.read {
            color: #53bdeb;
        }

        .meta .tick.animate-in,
        .meta-over .tick.animate-in {
            animation: tickPop .25s ease;
        }

        @keyframes tickPop {
            from {
                transform: scale(.6);
                opacity: .4;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        /* image bubble */
        .bubble.has-img {
            padding: 3px;
        }

        .bubble.has-img .sender {
            padding: 3px 7px 0;
        }

        .img-wrap {
            position: relative;
            cursor: zoom-in;
            line-height: 0;
            background: #cbd5e1;
            border-radius: 8px;
            overflow: hidden;
        }

        .img-wrap img {
            display: block;
            width: 100%;
            max-width: 300px;
            min-width: 220px;
            min-height: 150px;
            max-height: 320px;
            object-fit: cover;
            transition: transform .3s ease;
        }

        .img-wrap:hover img {
            transform: scale(1.03);
        }

        .img-wrap.shade::after {
            content: "";
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            height: 42px;
            background: linear-gradient(transparent, rgba(0, 0, 0, .42));
            pointer-events: none;
        }

        .meta-over {
            position: absolute;
            right: 8px;
            bottom: 5px;
            z-index: 2;
            font-size: 11px;
            color: #fff;
            display: flex;
            align-items: center;
            gap: 4px;
            line-height: 1.2;
            text-shadow: 0 1px 3px rgba(0, 0, 0, .6);
        }

        .img-caption {
            padding: 5px 7px 2px;
            line-height: 1.45;
        }

        /* document bubble */
        .doc-card {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 230px;
            background: rgba(0, 0, 0, .05);
            border-radius: 8px;
            padding: 10px 12px;
            margin-bottom: 2px;
        }

        .doc-card .ico {
            font-size: 30px;
            color: #ef4444;
        }

        .doc-card .name {
            font-size: 13.5px;
            font-weight: 600;
            word-break: break-all;
        }

        .doc-card small {
            color: var(--muted);
            font-size: 11.5px;
        }

        /* scroll-down button */
        .scroll-down {
            position: absolute;
            right: 22px;
            bottom: 14px;
            width: 42px;
            height: 42px;
            border-radius: 50%;
            border: 0;
            background: #fff;
            color: var(--muted);
            box-shadow: 0 4px 14px rgba(0, 0, 0, .25);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 4;
        }

        .scroll-down.show {
            display: flex;
        }

        .scroll-down .badge-new {
            position: absolute;
            top: -7px;
            right: -2px;
            background: var(--wa-green);
            color: #fff;
            font-size: 10.5px;
            font-weight: 700;
            min-width: 18px;
            height: 18px;
            border-radius: 18px;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 0 5px;
        }

        /* emoji panel */
        .emoji-panel {
            flex-shrink: 0;
            display: none;
            background: #f8fafc;
            border-top: 1px solid var(--border);
            padding: 8px 14px;
            max-height: 130px;
            overflow-y: auto;
            flex-wrap: wrap;
            gap: 2px;
        }

        .emoji-panel.show {
            display: flex;
        }

        .emoji-panel span {
            font-size: 24px;
            cursor: pointer;
            padding: 3px 5px;
            border-radius: 8px;
        }

        .emoji-panel span:hover {
            background: #e2e8f0;
        }

        /* footer */
        .chat-footer {
            flex-shrink: 0;
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px 18px;
            background: #f8fafc;
            border-top: 1px solid var(--border);
        }

        .chat-footer .tool {
            color: var(--muted);
            font-size: 21px;
            cursor: pointer;
            background: none;
            border: 0;
            padding: 0;
            transition: color .15s ease;
        }

        .chat-footer .tool:hover {
            color: var(--primary);
        }

        .chat-footer input[type="text"] {
            flex: 1;
            min-width: 0;
            background: #fff;
            border-radius: 24px;
            padding: 12px 20px;
            font-size: 14.5px;
            outline: none;
            border: 1px solid var(--border);
            transition: all .2s ease;
        }

        .chat-footer input[type="text"]:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(37, 99, 235, .12);
        }

        .btn-send-chat {
            width: 46px;
            height: 46px;
            min-width: 46px;
            border: 0;
            border-radius: 50%;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: #fff;
            font-size: 16px;
            box-shadow: 0 6px 16px rgba(37, 99, 235, .35);
            transition: transform .15s ease;
        }

        .btn-send-chat:hover {
            transform: scale(1.07);
        }

        /* attach menu */
        .attach-menu {
            position: absolute;
            left: 52px;
            bottom: 72px;
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 12px 34px rgba(15, 23, 42, .28);
            padding: 8px;
            display: none;
            z-index: 6;
            min-width: 190px;
        }

        .attach-menu.show {
            display: block;
        }

        .attach-menu label {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 12px;
            border-radius: 10px;
            cursor: pointer;
            font-size: 14px;
            margin: 0;
        }

        .attach-menu label:hover {
            background: #f1f5f9;
        }

        .attach-menu .ic {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 15px;
        }

        /* image preview before sending */
        .preview-screen {
            position: absolute;
            inset: 0;
            background: #e9edef;
            z-index: 10;
            display: none;
            flex-direction: column;
        }

        .preview-screen.show {
            display: flex;
        }

        .preview-top {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 20px;
            font-weight: 600;
        }

        .preview-top i {
            cursor: pointer;
            font-size: 20px;
        }

        .preview-main {
            flex: 1;
            min-height: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 10px 20px;
        }

        .preview-main img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, .22);
        }

        .preview-thumbs {
            display: flex;
            gap: 8px;
            justify-content: center;
            padding: 6px 14px;
            overflow-x: auto;
        }

        .preview-thumbs img {
            width: 54px;
            height: 54px;
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid transparent;
            cursor: pointer;
            opacity: .65;
        }

        .preview-thumbs img.active {
            border-color: var(--wa-green);
            opacity: 1;
        }

        .preview-foot {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 20px 18px;
        }

        .preview-foot input {
            flex: 1;
            border: 0;
            border-radius: 24px;
            padding: 12px 20px;
            font-size: 14.5px;
            outline: none;
        }

        /* lightbox */
        .lightbox {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .92);
            z-index: 3000;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 50px 20px;
        }

        .lightbox.show {
            display: flex;
        }

        .lightbox img {
            max-width: 100%;
            max-height: 100%;
            border-radius: 8px;
        }

        .lightbox .close {
            position: absolute;
            top: 18px;
            right: 28px;
            color: #fff;
            font-size: 28px;
            cursor: pointer;
        }

        .lightbox .cap {
            position: absolute;
            bottom: 18px;
            left: 0;
            right: 0;
            text-align: center;
            color: #e2e8f0;
            font-size: 14px;
            padding: 0 20px;
        }

        /* ================= Message actions ================= */
        .msg {
            position: relative;
        }

        .msg-menu-btn {
            align-self: flex-start;
            margin: 2px 5px 0;
            width: 24px;
            height: 24px;
            min-width: 24px;
            border: 0;
            border-radius: 50%;
            background: rgba(15, 23, 42, .07);
            color: #64748b;
            font-size: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            opacity: 0;
            transition: opacity .15s ease, background .15s ease;
        }

        .msg:hover .msg-menu-btn,
        .msg.menu-open .msg-menu-btn {
            opacity: 1;
        }

        .msg-menu-btn:hover {
            background: rgba(15, 23, 42, .16);
            color: #0f172a;
        }

        .msg-menu {
            position: fixed;
            z-index: 2600;
            min-width: 215px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 12px 40px rgba(15, 23, 42, .28);
            padding: 6px;
            display: none;
            animation: menuPop .13s ease;
        }

        .msg-menu.show {
            display: block;
        }

        @keyframes menuPop {
            from {
                opacity: 0;
                transform: scale(.96);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .msg-menu .reaction-row {
            display: flex;
            gap: 2px;
            padding: 4px 4px 8px;
            border-bottom: 1px solid var(--border);
            margin-bottom: 4px;
        }

        .msg-menu .reaction-row span {
            width: 34px;
            height: 34px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            border-radius: 50%;
            cursor: pointer;
            transition: transform .15s ease, background .15s ease;
        }

        .msg-menu .reaction-row span:hover {
            background: #f1f5f9;
            transform: scale(1.18);
        }

        .msg-menu button.mi {
            display: flex;
            align-items: center;
            gap: 12px;
            width: 100%;
            border: 0;
            background: none;
            padding: 9px 12px;
            border-radius: 8px;
            font-size: 14px;
            color: var(--text);
            text-align: left;
            cursor: pointer;
        }

        .msg-menu button.mi:hover {
            background: #f1f5f9;
        }

        .msg-menu button.mi i {
            width: 18px;
            text-align: center;
            color: #475569;
            font-size: 14px;
        }

        .msg-menu button.mi.danger,
        .msg-menu button.mi.danger i {
            color: #dc2626;
        }

        .msg-menu button.mi.danger:hover {
            background: #fef2f2;
        }

        .msg-menu .divider {
            height: 1px;
            background: var(--border);
            margin: 5px 6px;
        }

        .msg .reactions {
            position: absolute;
            bottom: -13px;
            display: flex;
            gap: 3px;
            z-index: 2;
        }

        .msg.out .reactions {
            right: 2px;
        }

        .msg.in .reactions {
            left: 2px;
        }

        .msg .reactions:empty {
            display: none;
        }

        .msg .reactions .rx {
            background: #fff;
            border-radius: 12px;
            padding: 1px 7px;
            font-size: 13px;
            line-height: 1.5;
            box-shadow: 0 1px 3px rgba(0, 0, 0, .22);
            cursor: pointer;
        }

        .msg.has-reaction {
            margin-bottom: 17px;
        }

        .bubble .flag-badge {
            position: absolute;
            top: -8px;
            right: -6px;
            width: 19px;
            height: 19px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 9px;
            color: #fff;
            box-shadow: 0 1px 3px rgba(0, 0, 0, .28);
            z-index: 2;
        }

        .bubble .flag-badge.star {
            background: #f59e0b;
        }

        .bubble .flag-badge.pin {
            background: var(--primary);
        }

        .msg.flash .bubble {
            animation: flashBubble 1.2s ease;
        }

        @keyframes flashBubble {

            0%,
            100% {
                box-shadow: 0 1px 1px rgba(0, 0, 0, .13);
            }

            35% {
                box-shadow: 0 0 0 4px rgba(37, 99, 235, .45);
            }
        }

        .quote {
            display: flex;
            gap: 8px;
            padding: 5px 8px;
            margin-bottom: 5px;
            border-radius: 6px;
            background: rgba(15, 23, 42, .07);
            border-left: 3px solid var(--primary);
            font-size: 12.5px;
            cursor: pointer;
            overflow: hidden;
        }

        .quote .q-ico {
            color: var(--primary);
            margin-top: 2px;
        }

        .quote .q-txt {
            min-width: 0;
            flex: 1;
        }

        .quote .q-who {
            display: block;
            font-weight: 700;
            color: var(--primary);
            font-size: 12px;
        }

        .quote .q-body {
            display: block;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            color: var(--muted);
        }

        .reply-bar {
            flex-shrink: 0;
            display: none;
            align-items: center;
            gap: 10px;
            padding: 8px 18px;
            background: #fff;
            border-top: 1px solid var(--border);
        }

        .reply-bar.show {
            display: flex;
        }

        .reply-bar .bar-line {
            width: 3px;
            align-self: stretch;
            border-radius: 2px;
            background: var(--wa-green);
        }

        .reply-bar .txt {
            flex: 1;
            min-width: 0;
            font-size: 13px;
        }

        .reply-bar .txt strong {
            display: block;
            color: #16a34a;
            font-size: 12.5px;
        }

        .reply-bar .txt span {
            display: block;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            color: var(--muted);
        }

        .reply-bar button {
            border: 0;
            background: none;
            color: var(--muted);
            font-size: 18px;
            cursor: pointer;
        }

        .pinned-bar {
            flex-shrink: 0;
            display: none;
            align-items: center;
            gap: 10px;
            padding: 8px 18px;
            background: #fff;
            border-bottom: 1px solid var(--border);
            font-size: 13px;
        }

        .pinned-bar.show {
            display: flex;
        }

        .pinned-bar i {
            color: var(--primary);
        }

        .pinned-bar .txt {
            flex: 1;
            min-width: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            color: var(--text);
        }

        .pinned-bar .txt strong {
            color: var(--primary);
        }

        .pinned-bar button {
            border: 0;
            background: none;
            color: var(--muted);
            cursor: pointer;
            font-size: 14px;
        }

        .edit-box {
            display: flex;
            flex-direction: column;
            gap: 6px;
            min-width: 210px;
        }

        .edit-box textarea {
            width: 100%;
            min-height: 48px;
            resize: vertical;
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 6px 8px;
            font-size: 14px;
            font-family: inherit;
            outline: none;
            background: #fff;
            color: var(--text);
        }

        .edit-box textarea:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, .12);
        }

        .edit-actions {
            display: flex;
            gap: 6px;
            justify-content: flex-end;
        }

        .edit-actions button {
            border: 0;
            border-radius: 8px;
            padding: 5px 12px;
            font-size: 13px;
            cursor: pointer;
        }

        .edit-actions .save {
            background: var(--primary);
            color: #fff;
        }

        .edit-actions .cancel {
            background: rgba(15, 23, 42, .08);
            color: var(--text);
        }

        .msg.deleted .bubble {
            background: #f1f5f9 !important;
            color: #94a3b8;
            font-style: italic;
            box-shadow: none;
        }

        .msg.deleted .bubble::before,
        .msg.deleted .flag-badge,
        .msg.deleted .quote {
            display: none !important;
        }

        .msg.deleted .msg-menu-btn {
            display: none;
        }

        .empty-chat {
            text-align: center;
            color: #94a3b8;
            padding: 60px 20px;
        }

        .empty-chat i {
            font-size: 34px;
            margin-bottom: 10px;
            opacity: .6;
        }

        .empty-chat p {
            margin: 0;
            font-size: 14px;
        }

        .chat-head .who {
            flex: 1 1 auto;
            min-width: 0;
        }

        .chat-head .head-actions {
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: 2px;
        }

        .chat-head .head-actions button {
            width: 34px;
            height: 34px;
            border: 0;
            border-radius: 50%;
            background: none;
            color: var(--muted);
            font-size: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .chat-head .head-actions button:hover {
            background: #f1f5f9;
            color: var(--primary);
        }

        /* modals */
        .wa-modal {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, .55);
            z-index: 2700;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .wa-modal.show {
            display: flex;
        }

        .wa-modal .panel {
            background: #fff;
            border-radius: 16px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 24px 60px rgba(0, 0, 0, .35);
            overflow: hidden;
            animation: menuPop .15s ease;
        }

        .wa-modal .panel-head {
            padding: 18px 20px 10px;
            font-size: 17px;
            font-weight: 700;
        }

        .wa-modal .panel-body {
            padding: 0 20px 16px;
            color: var(--muted);
            font-size: 14px;
            line-height: 1.5;
            white-space: pre-line;
        }

        .wa-modal .panel-foot {
            display: flex;
            flex-direction: column;
            gap: 2px;
            padding: 0 10px 12px;
            max-height: 360px;
            overflow-y: auto;
        }

        .wa-modal .panel-foot button {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            border: 0;
            background: none;
            text-align: left;
            padding: 12px 14px;
            border-radius: 10px;
            font-size: 14.5px;
            color: var(--text);
            cursor: pointer;
        }

        .wa-modal .panel-foot button:hover {
            background: #f1f5f9;
        }

        .wa-modal .panel-foot button i {
            width: 18px;
            text-align: center;
        }

        .wa-modal .panel-foot button.danger,
        .wa-modal .panel-foot button.danger i {
            color: #dc2626;
        }

        .wa-modal .panel-foot button.danger:hover {
            background: #fef2f2;
        }

        /* ================= Groups ================= */
        .wa-modal .panel-content {
            padding: 0 18px 12px;
        }

        .wa-input {
            width: 100%;
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 14px;
            outline: none;
            color: var(--text);
            background: #fff;
        }

        .wa-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, .12);
        }

        .pick-hint {
            font-size: 11.5px;
            letter-spacing: .6px;
            text-transform: uppercase;
            color: #94a3b8;
            font-weight: 700;
            margin: 14px 0 6px;
        }

        .pick-list {
            max-height: 250px;
            overflow-y: auto;
            border: 1px solid var(--border);
            border-radius: 12px;
        }

        .emp-row {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 8px 12px;
            margin: 0;
            cursor: pointer;
            border-bottom: 1px solid #f1f5f9;
        }

        .emp-row:last-child {
            border-bottom: 0;
        }

        .emp-row:hover {
            background: #f8fafc;
        }

        .emp-row .avatar {
            width: 38px;
            height: 38px;
            min-width: 38px;
            font-size: 13px;
        }

        .emp-row .emp-name {
            flex: 1;
            min-width: 0;
            font-size: 14px;
            color: var(--text);
        }

        .emp-row input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: var(--primary);
            cursor: pointer;
        }

        .add-part-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            border: 1px dashed #cbd5e1;
            background: #f8fafc;
            color: var(--primary);
            font-size: 13.5px;
            font-weight: 600;
            padding: 10px;
            border-radius: 10px;
            margin-bottom: 8px;
            cursor: pointer;
        }

        .add-part-btn:hover {
            background: #eff6ff;
            border-color: var(--primary);
        }

        .member-row {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 7px 8px;
            border-radius: 10px;
        }

        .member-row:hover {
            background: #f8fafc;
        }

        .member-row .avatar {
            width: 38px;
            height: 38px;
            min-width: 38px;
            font-size: 12.5px;
        }

        .member-row .m-info {
            flex: 1;
            min-width: 0;
        }

        .member-row .m-info strong {
            display: block;
            font-size: 14px;
            line-height: 1.3;
        }

        .member-row .m-info small {
            font-size: 11.5px;
            color: var(--muted);
        }

        .group-actions {
            display: flex;
            flex-direction: column;
            gap: 6px;
            margin-bottom: 6px;
        }

        .group-actions .add-part-btn {
            margin-bottom: 0;
        }

        .add-part-btn.danger {
            color: #dc2626;
            border-color: #fecaca;
            background: #fef2f2;
        }

        .add-part-btn.danger:hover {
            background: #fee2e2;
            border-color: #dc2626;
        }

        .add-part-btn.active {
            background: #eff6ff;
            border-color: var(--primary);
            border-style: solid;
        }

        .add-part-btn.danger.active {
            background: #fee2e2;
            border-color: #dc2626;
        }

        .admin-tag {
            font-size: 10.5px;
            font-weight: 700;
            background: #dbeafe;
            color: #1d4ed8;
            padding: 2px 8px;
            border-radius: 10px;
        }

        .chat-head .who small {
            display: block;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sys-msg {
            text-align: center;
            margin: 12px 0;
        }

        .sys-msg span {
            display: inline-block;
            max-width: 85%;
            background: #fff;
            color: var(--muted);
            font-size: 12px;
            line-height: 1.45;
            padding: 6px 14px;
            border-radius: 8px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, .1);
        }

        .wa-toast {
            position: fixed;
            left: 50%;
            bottom: 28px;
            transform: translateX(-50%) translateY(20px);
            background: #0f172a;
            color: #fff;
            font-size: 13.5px;
            padding: 10px 18px;
            border-radius: 999px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .3);
            opacity: 0;
            pointer-events: none;
            transition: opacity .22s ease, transform .22s ease;
            z-index: 2900;
            max-width: 90vw;
            text-align: center;
        }

        .wa-toast.show {
            opacity: 1;
            transform: translateX(-50%) translateY(0);
        }

        @media (hover: none) {
            .msg-menu-btn {
                opacity: .55;
            }
        }

        /* ===== file / document / upload additions ===== */
        a.doc-card {
            text-decoration: none;
            color: inherit;
        }

        a.doc-card:hover {
            background: rgba(0, 0, 0, .08);
        }

        .doc-card>div {
            min-width: 0;
        }

        .doc-card .dl {
            margin-left: auto;
            color: var(--muted);
            font-size: 15px;
        }

        .upload-bar {
            flex-shrink: 0;
            display: none;
            align-items: center;
            gap: 12px;
            padding: 8px 18px;
            background: #fff;
            border-top: 1px solid var(--border);
            font-size: 13px;
            color: var(--muted);
        }

        .upload-bar.show {
            display: flex;
        }

        .upload-bar .track {
            flex: 1;
            height: 6px;
            background: #e2e8f0;
            border-radius: 6px;
            overflow: hidden;
        }

        .upload-bar .track i {
            display: block;
            height: 100%;
            width: 0;
            background: var(--primary);
            transition: width .15s ease;
        }

        .btn-send-chat:disabled {
            opacity: .5;
            pointer-events: none;
        }

        .chat-footer .tool.disabled {
            opacity: .5;
            pointer-events: none;
        }

        .preview-top .spacer {
            margin-left: auto;
            color: #dc2626;
        }

        /* ================= Responsive ================= */
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

            .chat-list {
                width: 310px;
                min-width: 310px;
            }
        }

        @media (max-width: 768px) {
            .chat-list {
                width: 100%;
                min-width: 100%;
                border-right: 0;
            }

            .chat-window {
                display: none;
            }

            .chat-app.open .chat-list {
                display: none;
            }

            .chat-app.open .chat-window {
                display: flex;
            }

            .chat-head .back {
                display: block;
            }

            .bubble {
                max-width: 85%;
            }
        }

        @media (max-width: 576px) {
            .content {
                padding: 10px;
            }

            .chat-app {
                height: calc(100vh - 20px);
                border-radius: 14px;
            }

            .chat-body {
                padding: 14px 10px 8px;
            }

            .chat-footer {
                gap: 10px;
                padding: 10px;
            }
        }
    </style>
</head>

<body>

    @include('layouts.header')

    <main class="main">
        <div class="content">

            <div class="chat-app" id="chatApp">

                <!-- LEFT : chat names -->
                <aside class="chat-list">

                    <div class="chat-list-head">
                        <span>Chats</span>
                        <button type="button" class="new-group-btn" id="newGroupBtn" title="Create a new group">
                            <i class="fas fa-users"></i>
                            <span>New group</span>
                        </button>
                    </div>

                    <div class="chat-search">
                        <div class="box">
                            <i class="fas fa-magnifying-glass"></i>
                            <input type="text" id="searchContact" placeholder="Search chats">
                        </div>
                    </div>

                    <div class="chat-filters" id="chatFilters">
                        <button type="button" class="active" data-filter="all">All</button>
                        <button type="button" data-filter="unread">Unread</button>
                        <button type="button" data-filter="groups">Groups</button>
                    </div>

                    <div class="contacts" id="contacts"></div>

                    <div class="no-result" id="noResult">No chats found</div>
                </aside>

                <!-- RIGHT : conversation -->
                <section class="chat-window" id="chatWindow">

                    <div class="panes">

                        <!-- Welcome screen -->
                        <div class="chat-pane active" id="welcomeScreen">
                            <div class="chat-body">
                                <div
                                    style="height:100%; display:flex; align-items:center; justify-content:center; text-align:center;">
                                    <div>
                                        <h2>Welcome to Employee Chat</h2>
                                        <p>Select a contact to start your conversation.</p>
                                        <small><i class="fas fa-lock"></i> Your conversations are private.</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="button" class="scroll-down" id="scrollDown" aria-label="Scroll to latest">
                            <i class="fas fa-chevron-down"></i>
                            <span class="badge-new" id="newBadge">0</span>
                        </button>

                    </div>

                    <div class="emoji-panel" id="emojiPanel"></div>

                    <div class="attach-menu" id="attachMenu">
                        <label for="imgInput">
                            <span class="ic" style="background:#a855f7"><i class="fas fa-image"></i></span>
                            Photo
                        </label>
                        <label for="docInput">
                            <span class="ic" style="background:#2563eb"><i class="fas fa-file-lines"></i></span>
                            Document
                        </label>
                    </div>

                    <input type="file" id="imgInput" accept="image/png,image/jpeg,image/gif,image/webp" hidden>
                    <input type="file" id="docInput" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt,.csv"
                        hidden>

                    <div class="reply-bar" id="replyBar">
                        <span class="bar-line"></span>
                        <div class="txt">
                            <strong id="replyBarWho">You</strong>
                            <span id="replyBarText"></span>
                        </div>
                        <button type="button" id="replyBarClose" aria-label="Cancel reply">
                            <i class="fas fa-xmark"></i>
                        </button>
                    </div>

                    <div class="upload-bar" id="uploadBar">
                        <span id="uploadText">Uploading…</span>
                        <div class="track"><i id="uploadFill"></i></div>
                    </div>

                    <form class="chat-footer" id="chatForm" autocomplete="off" style="display: none;">
                        <button type="button" class="tool" id="emojiBtn" aria-label="Emoji">
                            <i class="far fa-face-smile"></i>
                        </button>

                        <button type="button" class="tool" id="attachBtn" aria-label="Attach">
                            <i class="fas fa-paperclip"></i>
                        </button>

                        <input type="text" id="msgInput" placeholder="Type a message">

                        <button type="submit" class="btn-send-chat" aria-label="Send">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>

                    <!-- Image preview screen -->
                    <div class="preview-screen" id="previewScreen">
                        <div class="preview-top">
                            <i class="fas fa-xmark" id="previewClose" title="Close"></i>
                            <span>Send photo</span>
                        </div>
                        <div class="preview-main"><img id="previewImg" alt=""></div>
                        <div class="preview-foot">
                            <input type="text" id="previewCaption" placeholder="Add a caption" maxlength="500">
                            <button type="button" class="btn-send-chat" id="previewSend" aria-label="Send">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                    </div>

                </section>

            </div>

        </div>
    </main>

    <!-- Lightbox -->
    <div class="lightbox" id="lightbox">
        <i class="fas fa-xmark close" id="lightboxClose"></i>
        <img id="lightboxImg" alt="">
        <div class="cap" id="lightboxCap"></div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        window.authUserId = @json(auth()->id());
    </script>

    @vite(['resources/js/app.js'])

    <script>
        /* ===================== shared media helper ===================== */
        window.ChatMedia = (function() {
            var IMAGE_EXT = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            var IMAGE_MIME = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            var DOC_EXT = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt', 'csv'];

            var LIMITS = {
                imageBytes: 5 * 1024 * 1024, // 5 MB per image
                docBytes: 10 * 1024 * 1024, // 10 MB per document
                maxImages: 1 // one image per send
            };

            function ext(name) {
                var p = String(name || '').split('.');
                return p.length > 1 ? p.pop().toLowerCase() : '';
            }

            function esc(v) {
                return String(v == null ? '' : v)
                    .replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;')
                    .replace(/"/g, '&quot;').replace(/'/g, '&#39;');
            }

            function sizeText(bytes) {
                bytes = Number(bytes) || 0;
                if (bytes >= 1048576) return (bytes / 1048576).toFixed(1) + ' MB';
                return Math.max(1, Math.round(bytes / 1024)) + ' KB';
            }

            /* returns '' when valid, otherwise an error message */
            function validateImage(file) {
                if (!file) return 'no file selected';
                if (IMAGE_EXT.indexOf(ext(file.name)) === -1 ||
                    (file.type && IMAGE_MIME.indexOf(file.type) === -1)) {
                    return 'only JPG, PNG, GIF or WEBP images are allowed';
                }
                if (file.size === 0) return 'the file is empty';
                if (file.size > LIMITS.imageBytes) return 'image is larger than 5 MB (' + sizeText(file.size) + ')';
                return '';
            }

            function validateDoc(file) {
                if (!file) return 'no file selected';
                if (DOC_EXT.indexOf(ext(file.name)) === -1) {
                    return 'allowed types: PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, TXT, CSV';
                }
                if (file.size === 0) return 'the file is empty';
                if (file.size > LIMITS.docBytes) return 'document is larger than 10 MB (' + sizeText(file.size) +
                    ')';
                return '';
            }

            /* makes sure a renamed / corrupt file is really an image */
            function checkImageReadable(file) {
                return new Promise(function(resolve) {
                    var u = URL.createObjectURL(file);
                    var img = new Image();
                    img.onload = function() {
                        URL.revokeObjectURL(u);
                        resolve(true);
                    };
                    img.onerror = function() {
                        URL.revokeObjectURL(u);
                        resolve(false);
                    };
                    img.src = u;
                });
            }

            function fileUrl(m) {
                var u = m.file_url || m.file_path || '';
                if (!u) return '';
                if (/^(https?:)?\/\//.test(u) || u.charAt(0) === '/') return u;
                return '/storage/' + u; // change if your files are served from somewhere else
            }

            function docStyle(e) {
                if (e === 'pdf') return {
                    icon: 'fa-file-pdf',
                    color: '#ef4444'
                };
                if (e === 'doc' || e === 'docx') return {
                    icon: 'fa-file-word',
                    color: '#2563eb'
                };
                if (e === 'xls' || e === 'xlsx' || e === 'csv') return {
                    icon: 'fa-file-excel',
                    color: '#16a34a'
                };
                if (e === 'ppt' || e === 'pptx') return {
                    icon: 'fa-file-powerpoint',
                    color: '#ea580c'
                };
                return {
                    icon: 'fa-file-lines',
                    color: '#64748b'
                };
            }

            /* builds the inside of a bubble. metaInner = trusted html (time + ticks) */

            function render(m, metaInner) {

                var text = m.message == null ? '' : String(m.message);

                // Support database response and Reverb event formats
                var file = null;

                if (Array.isArray(m.attachments) && m.attachments.length > 0) {

                    file = m.attachments[0];

                } else if (m.file_path) {

                    file = {
                        file_type: m.file_type,
                        file_path: m.file_path,
                        file_name: m.file_name
                    };

                }

                // Image or document message
                if (file && file.file_path) {

                    var url = "{{ asset('storage') }}/" + file.file_path;

                    var name = file.file_name ||
                        file.file_path.split('/').pop();

                    var html = '';

                    // Image: display image only
                    if (file.file_type === 'image') {

                        html += `
                <div class="img-wrap" data-caption="">
                    <img src="${esc(url)}"
                         alt="image"
                         loading="lazy">
                </div>
            `;

                        html += `<span class="meta">${metaInner}</span>`;

                        return {
                            cls: 'bubble has-img',
                            html: html
                        };
                    }

                    // Document: display document only
                    if (file.file_type === 'document') {

                        var e = ext(name);
                        var st = docStyle(e);
                        var info = e ? e.toUpperCase() : 'FILE';

                        html += `
                <a class="doc-card"
                   href="${esc(url)}"
                   target="_blank"
                   rel="noopener"
                   download="${esc(name)}">

                    <i class="fas ${st.icon} ico"
                       style="color:${st.color}"></i>

                    <div>
                        <div class="name">${esc(name)}</div>
                        <small>${esc(info)}</small>
                    </div>

                    <i class="fas fa-download dl"></i>
                </a>
            `;

                        html += `<span class="meta">${metaInner}</span>`;

                        return {
                            cls: 'bubble',
                            html: html
                        };
                    }
                }

                // Text-only message
                if (text.trim() !== '') {

                    return {
                        cls: 'bubble',
                        html: esc(text) + `<span class="meta">${metaInner}</span>`
                    };
                }

                // No text and no attachment: do not create a bubble
                return null;
            }

            return {
                LIMITS: LIMITS,
                ext: ext,
                esc: esc,
                sizeText: sizeText,
                validateImage: validateImage,
                validateDoc: validateDoc,
                checkImageReadable: checkImageReadable,
                render: render
            };
        })();

        /* ===================== real-time listener ===================== */


        window.addEventListener('echo-ready', function() {

            if (!window.Echo || !window.authUserId) {
                console.error('Echo or authenticated user ID is missing.');
                return;
            }

            // Private channel for the logged-in user
            const channel = window.Echo.private(`users.${window.authUserId}`);

            // ------------------------------------
            // 1. Receive new messages
            // ------------------------------------

            channel.listen('.message.sent', function(event) {

                if (Number(event.sender_id) === Number(window.authUserId)) {
                    return;
                }

                let pane = $('.chat-pane').filter(function() {
                    return Number($(this).data('conversation-id')) ===
                        Number(event.conversation_id);
                });

                if (pane.length && pane.hasClass('active')) {

                    let time = new Date(event.created_at).toLocaleTimeString([], {
                        hour: '2-digit',
                        minute: '2-digit',
                        hour12: true
                    });

                    let body = pane.find('.chat-body');

                    body.find('.empty-chat').remove();

                    let hasAttachment =
                        (event.file_type === 'image' || event.file_type === 'document') &&
                        event.file_path;

                    let messageEvent = {
                        ...event,
                        message: hasAttachment ? '' : (event.message || '')
                    };

                    let rendered = ChatMedia.render(messageEvent, time);

                    if (rendered.html.trim()) {
                        body.append(`
                    <div class="msg in">
                        <div class="${rendered.cls}">
                            ${rendered.html}
                        </div>
                    </div>
                `);
                    }

                    // Mark incoming message as read
                    MessageRead(event.conversation_id, event.sender_id);

                    body.scrollTop(body[0].scrollHeight);

                } else {
                    console.log('Message received. Chat is not open.');
                }

            });


            // ------------------------------------
            // 2. Update unread message count
            // ------------------------------------

            channel.listen('.message.count', function(event) {

                console.log('Count event:', event);

                let pane = $('.chat-pane').filter(function() {
                    return Number($(this).data('conversation-id')) ===
                        Number(event.conversation_id);
                });

                let contact = $('.contact').filter(function() {
                    return Number($(this).data('conversation-id')) ===
                        Number(event.conversation_id);
                });

                let badge = contact.find('.unread');

                if (pane.length && pane.hasClass('active')) {
                    badge.hide();
                    return;
                }

                badge.text(event.count);

                if (Number(event.count) > 0) {
                    badge.show();
                } else {
                    badge.hide();
                }

            });


            // ------------------------------------
            // 3. Update latest message preview
            // ------------------------------------

            channel.listen('.message.latestmessage', function(event) {

                let contact = $('.contact').filter(function() {
                    return Number($(this).data('conversation-id')) ===
                        Number(event.conversation_id);
                });

                if (contact.length === 0) {
                    console.log('Contact not found for conversation:', event.conversation_id);
                    return;
                }

                let preview = contact.find('.preview');

                preview.text(event.latest_message ?? '');
                preview.show();

            });


            // ------------------------------------
            // 4. Update message read ticks
            // ------------------------------------

            channel.listen('.message.read', function(event) {

                console.log('Read event received:', event);

                let pane = $('.chat-pane').filter(function() {
                    return Number($(this).data('conversation-id')) ===
                        Number(event.conversation_id);
                });

                pane.find('.msg.out .message-status')
                    .removeClass('single-tick')
                    .addClass('read-tick')
                    .html('<i class="fas fa-check-double"></i>');

            });


            // ------------------------------------
            // 5. Online / Offline presence channel
            // ------------------------------------

            window.Echo.join('online')

                .here(function(users) {

                    console.log('Currently online users:', users);

                    onlineUsers = users.map(user => Number(user.id));

                    updateAllContactStatuses();

                })

                .joining(function(user) {

                    console.log('Joining:', user);

                    let id = Number(user.id);

                    if (!onlineUsers.includes(id)) {
                        onlineUsers.push(id);
                    }

                    setUserStatus(id, true);

                })

                .leaving(function(user) {

                    console.log('Leaving:', user);

                    let id = Number(user.id);

                    onlineUsers = onlineUsers.filter(userId => userId !== id);

                    setUserStatus(id, false);

                })

                .error(function(error) {
                    console.error('Presence error:', error);
                });

        });

        // ------------------------------------
        // Update user online/offline status
        // ------------------------------------

        function updateAllContactStatuses() {

            $('.contact[data-user-id]').each(function() {

                let userId = Number($(this).attr('data-user-id'));

                setUserStatus(userId, onlineUsers.includes(userId));

            });

        }


        function setUserStatus(userId, isOnline) {

            let contact = $('.contact').filter(function() {

                return Number($(this).attr('data-user-id')) === Number(userId);

            });

            if (!contact.length) {
                console.log('Contact not found:', userId);
                return;
            }

            contact.find('.online-dot').toggle(isOnline);

            contact.find('.user-status').contents().filter(function() {
                return this.nodeType === 3;
            }).last().replaceWith(isOnline ? ' Online' : ' Offline');

            contact.find('.user-status').toggleClass('is-online', isOnline);

        }

        function MessageRead(conversation_id, sender_id) {
            $.ajax({
                url: "{{ route('messageRead') }}",
                type: "GET",
                data: {
                    conversation_id: conversation_id,
                    sender_id: sender_id,
                },
                success: function(response) {
                    if (response.status) {
                        let pane = $('.chat-pane').filter(function() {
                            return $(this).data('conversation-id') == conversation_id;
                        });

                        pane.find('.msg.out .message-status')
                            .removeClass('single-tick')
                            .addClass('read-tick')
                            .html('<i class="fas fa-check-double"></i>');
                    }
                }
            });
        }
    </script>
    <script>
        (function() {

            var app = document.getElementById('chatApp');
            var contactsEl = document.getElementById('contacts');
            var searchEl = document.getElementById('searchContact');
            var filtersEl = document.getElementById('chatFilters');
            var noResult = document.getElementById('noResult');
            var receiverId = null;
            var conversationId = null;
            var form = document.getElementById('chatForm');
            var input = document.getElementById('msgInput');

            var scrollBtn = document.getElementById('scrollDown');
            var newBadge = document.getElementById('newBadge');

            var emojiPanel = document.getElementById('emojiPanel');
            var attachMenu = document.getElementById('attachMenu');
            var imgInput = document.getElementById('imgInput');
            var docInput = document.getElementById('docInput');

            var previewScreen = document.getElementById('previewScreen');
            var previewImg = document.getElementById('previewImg');
            var previewCaption = document.getElementById('previewCaption');

            var lightbox = document.getElementById('lightbox');
            var lightboxImg = document.getElementById('lightboxImg');
            var lightboxCap = document.getElementById('lightboxCap');

            var filter = 'all';
            var pending = [];
            var pendingIndex = 0;
            var newCount = 0;

            var EMOJIS = ['😀', '😁', '😂', '🤣', '😊', '😍', '😘', '😎', '🤔', '😢', '😭', '😡', '👍', '👎', '👏',
                '🙏', '💪', '🔥', '🎉', '✅', '❌', '⚠️', '❄️', '🔧', '🏠', '📷', '📄', '⏰'
            ];

            /* ---------- helpers ---------- */
            function el(tag, cls, text) {
                var n = document.createElement(tag);
                if (cls) n.className = cls;
                if (text !== undefined) n.textContent = text;
                return n;
            }

            function nowTime() {
                return new Date().toLocaleTimeString('en-US', {
                    hour: 'numeric',
                    minute: '2-digit'
                });
            }

            function cleanId(v) {
                return (v === undefined || v === null || v === 'undefined' || v === 'null' || v === '') ? '' : v;
            }

            function activePane() {
                return document.querySelector('.chat-pane.active');
            }

            function activeBody() {
                var p = document.querySelector('.chat-pane.active');
                return p ? p.querySelector('.chat-body') : null;
            }

            function activeContact() {
                return document.querySelector('.contact.active');
            }

            function isNearBottom(body) {
                return body.scrollHeight - body.scrollTop - body.clientHeight < 120;
            }

            function scrollBottom(body, smooth) {
                if (!body) return;
                body.style.scrollBehavior = smooth ? 'smooth' : 'auto';
                body.scrollTop = body.scrollHeight;
            }

            function resetNew() {
                newCount = 0;
                newBadge.style.display = 'none';
                scrollBtn.classList.remove('show');
            }

            function closePanels() {
                emojiPanel.classList.remove('show');
                attachMenu.classList.remove('show');
            }

            function escapeHtml(value) {
                return $('<div>').text(value ?? '').html();
            }

            /* ---------- contacts ---------- */
            function loadContacts() {

                $.ajax({
                    url: "{{ route('loadContact') }}",
                    type: "GET",

                    success: function(response) {

                        let html = '';

                        $.each(response.users, function(index, user) {

                            let name = user.employee?.full_name ?? '';
                            let profile = user.employee?.profile_url ?? '';

                            let latestMessage = null;

                            let convId = user.conversation_id;
                            let messageText = user.latest_message ?? '';
                            let unreadCount = user.unread_messages_count;

                            html += `
                                <div class="contact"
                                    data-user-id="${user.id}"
                                    data-conversation-id="${convId}"
                                    data-name="${escapeHtml(name)}">

                                    <img class="avatar online"
                                        src="${escapeHtml(profile)}"
                                        style="background:#2563eb">

                                    <div class="contact-info">
                                        <div class="contact-top">
                                            <strong>${escapeHtml(name)}</strong>

                                            <span class="user-status">Offline</span>

                                        </div>

                                        <div class="contact-bottom">
                                            <span class="preview">${escapeHtml(messageText)}</span>
                                           <em class="unread" style="${unreadCount > 0 ? '' : 'display:none;'}">
        ${unreadCount}
    </em>
                                        </div>
                                    </div>
                                </div>
                            `;
                        });

                        $('#contacts').html(html);

                        // keep the currently open chat highlighted after reload
                        if (receiverId) {
                            $('#contacts .contact[data-user-id="' + receiverId + '"]').addClass('active');
                        }
                        applyFilters();
                    },
                    error: function(xhr) {
                        console.log(xhr.responseJSON || xhr.responseText);
                    }
                });
            }

            $(document).ready(function() {
                loadContacts();
            });

            /* ---------- open / load chat ---------- */
            function openChat(contact) {

                $('.contact').removeClass('active');
                $(contact).addClass('active');

                receiverId = $(contact).data('user-id');
                conversationId = cleanId($(contact).attr('data-conversation-id'));

                closePanels();
                resetNew();

                app.classList.add('open');

                $('#welcomeScreen').removeClass('active');
                $('#chatForm').show();

                $(contact).removeClass('has-unread');
                $(contact).find('.unread').remove();

                loadChat(conversationId, receiverId);
            }

            function loadChat(conversationId, receiverId, target) {

                $.ajax({
                    url: "{{ route('loadChat') }}",
                    type: "GET",
                    data: {
                        conversationId: conversationId,
                        receiverId: receiverId
                    },

                    success: function(response) {

                        let chatContent = $('.panes');
                        chatContent.find('.chat-pane').remove();

                        let userName = response.user?.employee?.full_name || '';
                        let profileUrl = response.user?.employee?.profile_url || '';

                        let html = `
                            <div class="chat-pane active" data-user-id="${receiverId}"
                                data-conversation-id="${conversationId}">

                                <div class="chat-head">
                                    <i class="fas fa-arrow-left back"></i>

                                    <img class="avatar online"
                                        src="${escapeHtml(profileUrl)}"
                                        style="background:#2563eb">

                                    <div class="who">
                                        <strong>${escapeHtml(userName)}</strong>
                                    </div>
                                </div>

                                <div class="chat-body"></div>

                            </div>
                        `;

                        chatContent.prepend(html);

                        let body = chatContent.find('.chat-body');

                        if (response.status === false || !response.data?.length) {

                            body.html(`
                                <div class="empty-chat">
                                    <i class="far fa-comments"></i>
                                    <strong>No messages yet</strong>
                                    <span>Start a conversation!</span>
                                </div>
                            `);

                            return;
                        }

                        let messages = response.data[0].conversation.messages;
                        let previousDate = '';
                        let myId = {{ Auth::id() }};

                        console.log(response);


                        $.each(messages, function(index, message) {

                            let messageDate = new Date(message.created_at);
                            let dateKey = messageDate.toLocaleDateString('en-CA');

                            if (previousDate !== dateKey) {

                                let today = new Date();
                                let yesterday = new Date();
                                yesterday.setDate(today.getDate() - 1);

                                let displayDate;

                                if (dateKey === today.toLocaleDateString('en-CA')) {
                                    displayDate = 'Today';
                                } else if (dateKey === yesterday.toLocaleDateString('en-CA')) {
                                    displayDate = 'Yesterday';
                                } else {
                                    displayDate = messageDate.toLocaleDateString('en-IN', {
                                        weekday: 'long',
                                        day: 'numeric',
                                        month: 'long',
                                        year: 'numeric'
                                    });
                                }

                                body.append(`
            <div class="day-chip">
                <span>${displayDate}</span>
            </div>
        `);

                                previousDate = dateKey;
                            }

                            let messageType = Number(message.sender_id) === myId ? 'out' : 'in';

                            let time = messageDate.toLocaleTimeString([], {
                                hour: '2-digit',
                                minute: '2-digit'
                            });

                            let ticks = '';

                            if (messageType === 'out') {
                                ticks = message.is_read ?
                                    '<span class="message-status read-tick"><i class="fas fa-check-double"></i></span>' :
                                    '<span class="message-status single-tick"><i class="fas fa-check"></i></span>';
                            }



                            let rendered = ChatMedia.render(message, time + ' ' + ticks);

                            body.append(`
        <div class="msg ${messageType}">
            <div class="${rendered.cls}">
                ${rendered.html}
            </div>
        </div>
    `);
                        });


                        body.find('.img-wrap img').each(function() {
                            this.addEventListener('load', function() {
                                scrollBottom(body[0], false);
                            });
                        });

                        scrollBottom(body[0], false);
                    },

                    error: function(xhr) {
                        console.log(xhr.responseJSON || xhr.responseText);
                    }
                });
            }

            $('#contacts').on('click', '.contact', function() {
                openChat(this);
            });

            /* ---------- send text ---------- */
            function sendText(text) {

                if (!receiverId) return;

                $.ajax({
                    url: "{{ route('chatSend') }}",
                    type: "POST",
                    data: {
                        conversation_id: conversationId || null,
                        reciver_id: receiverId,
                        type: 'text',
                        message: text,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.status === true) {
                            conversationId = response.conversation.id;
                            loadChat(response.conversation.id, receiverId);
                            loadContacts();
                        }
                    },
                    error: function(xhr) {
                        toast(errorText(xhr));
                    }
                });
            }

            form.addEventListener('submit', function(e) {
                e.preventDefault();
                var text = input.value.trim();
                if (!text) return;
                sendText(text);
                input.value = '';
                emojiPanel.classList.remove('show');
            });

            /* ---------- scroll-down button ---------- */
            scrollBtn.addEventListener('click', function() {
                scrollBottom(activeBody(), true);
                resetNew();
            });


            document.addEventListener('scroll', function(e) {
                var b = e.target;
                if (!b || !b.classList || !b.classList.contains('chat-body')) return;
                if (b !== activeBody()) return;
                if (isNearBottom(b)) {
                    resetNew();
                } else {
                    scrollBtn.classList.add('show');
                }
                closeMsgMenu();
            }, true);

            /* ---------- emoji + attach ---------- */
            EMOJIS.forEach(function(e) {
                var s = el('span', '', e);
                s.addEventListener('click', function() {
                    input.value += e;
                    input.focus();
                });
                emojiPanel.appendChild(s);
            });

            document.getElementById('emojiBtn').addEventListener('click', function() {
                attachMenu.classList.remove('show');
                emojiPanel.classList.toggle('show');
            });

            document.getElementById('attachBtn').addEventListener('click', function(e) {
                e.stopPropagation();
                emojiPanel.classList.remove('show');
                attachMenu.classList.toggle('show');
            });

            document.addEventListener('click', function(e) {
                if (!attachMenu.contains(e.target)) attachMenu.classList.remove('show');
            });

            /* ============================================================
               IMAGE + DOCUMENT SENDING (with validation)
               ============================================================ */
            var uploadBar = document.getElementById('uploadBar');
            var uploadText = document.getElementById('uploadText');
            var uploadFill = document.getElementById('uploadFill');
            var isUploading = false;

            function setUploading(on, text, pct) {
                isUploading = on;
                uploadBar.classList.toggle('show', on);
                if (on) {
                    uploadText.textContent = text || 'Uploading…';
                    uploadFill.style.width = (pct || 0) + '%';
                }
                form.querySelector('.btn-send-chat').disabled = on;
                document.getElementById('attachBtn').classList.toggle('disabled', on);
            }

            function showErrors(title, errors) {
                if (errors.length === 1) {
                    toast(errors[0]);
                    return;
                }
                showModal({
                    title: title,
                    text: errors.slice(0, 8).join('\n') + (errors.length > 8 ? '\n…and ' + (errors.length - 8) +
                        ' more' : ''),
                    actions: [{
                        icon: 'fas fa-xmark',
                        label: 'OK',
                        onClick: closeModal
                    }]
                });
            }

            function errorText(xhr) {
                var j = xhr.responseJSON;
                if (j && j.errors) {
                    var k = Object.keys(j.errors)[0];
                    return j.errors[k][0];
                }
                if (j && j.message) return j.message;
                if (xhr.status === 413) return 'File is too large for the server';
                if (xhr.status === 419) return 'Session expired. Please refresh the page';
                if (xhr.status === 0) return 'Network error. Check your connection';
                return 'Request failed. Please try again';
            }

            function uploadOne(item, type, caption, conversationId, receiverId) {

                var fd = new FormData();

                fd.append('conversation_id', conversationId);
                fd.append('reciver_id', receiverId);
                fd.append('type', type);
                fd.append('message', caption || '');
                fd.append('file', item.file);
                fd.append('_token', "{{ csrf_token() }}");

                return $.ajax({
                    url: "{{ route('chatSend') }}",
                    type: 'POST',
                    data: fd,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.status === true) {
                            conversationId = response.conversation.id;
                            loadChat(response.conversation.id, receiverId);
                            loadContacts();
                        }
                    }
                });
            }

            /* sends one file (one message) */
            async function sendQueue(items, type, caption) {
                if (isUploading) {
                    toast('Please wait for the current upload to finish');
                    return;
                }
                if (!receiverId) {
                    toast('Select a chat first');
                    return;
                }

                var rId = receiverId;
                var convId = cleanId(conversationId);
                var sent = 0;

                setUploading(true, 'Preparing…', 0);

                try {
                    for (let i = 0; i < items.length; i++) {
                        var label = items.length > 1 ? 'Sending ' + (i + 1) + ' of ' + items.length : 'Sending';
                        setUploading(true, label, 0);

                        var res = await uploadOne(items[i], type, i === 0 ? caption : '', convId, rId, function(p) {
                            setUploading(true, label + ' · ' + p + '%', p);
                        });

                        if (res.conversation && res.conversation.id) convId = res.conversation.id;
                        sent++;
                    }
                } catch (err) {
                    toast((err && err.message) || 'Upload failed');
                } finally {
                    setUploading(false);
                    items.forEach(function(it) {
                        if (it.url) URL.revokeObjectURL(it.url);
                    });

                    if (sent) {
                        if (receiverId === rId) {
                            conversationId = convId;
                            loadChat(convId, rId);
                        }
                        loadContacts();
                    }
                }
            }

            /* ---------- image preview screen (one image) ---------- */
            function showPreview() {
                if (!pending.length) {
                    previewScreen.classList.remove('show');
                    return;
                }
                previewImg.src = pending[0].url;
                previewScreen.classList.add('show');
            }

            function closePreview() {
                pending.forEach(function(p) {
                    URL.revokeObjectURL(p.url);
                });
                pending = [];
                pendingIndex = 0;
                previewScreen.classList.remove('show');
            }

            /* ---------- pick one image ---------- */
            imgInput.addEventListener('change', async function() {
                var files = Array.prototype.slice.call(imgInput.files);
                imgInput.value = '';
                attachMenu.classList.remove('show');

                if (!files.length) return;
                if (!receiverId) {
                    toast('Select a chat first');
                    return;
                }
                if (isUploading) {
                    toast('Please wait for the current upload to finish');
                    return;
                }

                var f = files[0];
                var err = ChatMedia.validateImage(f);

                if (!err) {
                    var ok = await ChatMedia.checkImageReadable(f);
                    if (!ok) err = 'this file is not a valid image';
                }

                if (err) {
                    toast(f.name + ': ' + err);
                    return;
                }

                closePreview();
                pending = [{
                    file: f,
                    url: URL.createObjectURL(f),
                    name: f.name
                }];
                previewCaption.value = '';
                showPreview();
                previewCaption.focus();
            });

            document.getElementById('previewClose').addEventListener('click', closePreview);

            document.getElementById('previewSend').addEventListener('click', function() {
                if (!pending.length) return;

                var caption = previewCaption.value.trim();
                if (caption.length > 500) {
                    toast('Caption can be at most 500 characters');
                    return;
                }

                var list = pending.slice();
                pending = [];
                pendingIndex = 0;
                previewScreen.classList.remove('show');

                sendQueue(list, 'image', caption);
            });

            previewCaption.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    document.getElementById('previewSend').click();
                }
            });

            /* ---------- pick document ---------- */
            docInput.addEventListener('change', function() {
                var file = docInput.files[0];
                docInput.value = '';
                attachMenu.classList.remove('show');

                if (!file) return;
                if (!receiverId) {
                    toast('Select a chat first');
                    return;
                }

                var err = ChatMedia.validateDoc(file);
                if (err) {
                    toast(file.name + ': ' + err);
                    return;
                }

                sendQueue([{
                    file: file,
                    url: null,
                    name: file.name
                }], 'document', '');
            });

            /* ---------- lightbox ---------- */
            document.addEventListener('click', function(e) {
                var wrap = e.target.closest('.img-wrap');
                if (!wrap) return;
                var img = wrap.querySelector('img');
                lightboxImg.src = img.src;
                lightboxCap.textContent = wrap.dataset.caption || '';
                lightbox.classList.add('show');
            });

            lightbox.addEventListener('click', function(e) {
                if (e.target !== lightboxImg) lightbox.classList.remove('show');
            });

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    lightbox.classList.remove('show');
                    closePreview();
                    closePanels();
                }
            });

            /* ---------- search + filters ---------- */
            function applyFilters() {
                var q = searchEl.value.trim().toLowerCase();
                var shown = 0;

                contactsEl.querySelectorAll('.contact').forEach(function(c) {
                    var ok = (c.dataset.name || '').toLowerCase().indexOf(q) > -1;
                    if (filter === 'unread' && !c.querySelector('.unread')) ok = false;
                    if (filter === 'groups' && !c.dataset.group) ok = false;
                    c.style.display = ok ? '' : 'none';
                    if (ok) shown++;
                });

                noResult.style.display = (shown || !contactsEl.querySelector('.contact')) ? 'none' : 'block';
            }

            searchEl.addEventListener('input', applyFilters);

            filtersEl.addEventListener('click', function(e) {
                var btn = e.target.closest('button');
                if (!btn) return;
                filter = btn.dataset.filter;
                Array.prototype.forEach.call(filtersEl.children, function(b) {
                    b.classList.toggle('active', b === btn);
                });
                applyFilters();
            });

            /* ============================================================
               WhatsApp-style message & chat actions (front-end only)
               ============================================================ */

            var menuEl = document.createElement('div');
            menuEl.className = 'msg-menu';
            document.body.appendChild(menuEl);

            var modalEl = document.createElement('div');
            modalEl.className = 'wa-modal';
            document.body.appendChild(modalEl);

            var toastEl = document.createElement('div');
            toastEl.className = 'wa-toast';
            document.body.appendChild(toastEl);

            var toastTimer = null;
            var currentMenuRow = null;

            function toast(msg) {
                toastEl.textContent = msg;
                toastEl.classList.add('show');
                clearTimeout(toastTimer);
                toastTimer = setTimeout(function() {
                    toastEl.classList.remove('show');
                }, 2600);
            }

            function bubbleOf(row) {
                return row ? row.querySelector('.bubble') : null;
            }

            function cleanText(node) {
                var copy = node.cloneNode(true);
                copy.querySelectorAll('.meta, .meta-over, .flag-badge, .quote, .reactions, .sender, .edited-label')
                    .forEach(function(n) {
                        n.remove();
                    });
                return copy.textContent.replace(/\s+/g, ' ').trim();
            }

            function messageText(row) {
                var b = bubbleOf(row);
                if (!b) return '';
                if (row.dataset.deleted === '1') return 'This message was deleted';
                var cap = b.querySelector('.img-caption');
                if (cap) return cleanText(cap);
                var doc = b.querySelector('.doc-card .name');
                if (doc) return '📄 ' + doc.textContent.trim();
                if (b.querySelector('.img-wrap')) return '📷 Photo';

                var text = '';
                Array.prototype.forEach.call(b.childNodes, function(n) {
                    if (n.nodeType === 3) text += ' ' + n.textContent;
                });
                text = text.replace(/\s+/g, ' ').trim();
                return text || cleanText(b);
            }

            function senderOf(row) {
                var s = row.querySelector('.sender');
                if (s) return s.textContent.trim();
                if (row.classList.contains('out')) return 'You';
                var c = activeContact();
                return c ? c.dataset.name : 'Contact';
            }

            function divider() {
                var d = document.createElement('div');
                d.className = 'divider';
                return d;
            }

            /* ---------- dropdown menu ---------- */
            function closeMsgMenu() {
                menuEl.classList.remove('show');
                if (currentMenuRow) currentMenuRow.classList.remove('menu-open');
                currentMenuRow = null;
            }

            function addMenuItem(icon, label, fn, cls) {
                var b = document.createElement('button');
                b.type = 'button';
                b.className = 'mi' + (cls ? ' ' + cls : '');
                b.innerHTML = '<i class="' + icon + '"></i>';
                b.appendChild(document.createTextNode(label));
                b.addEventListener('click', function() {
                    closeMsgMenu();
                    fn();
                });
                menuEl.appendChild(b);
                return b;
            }

            function placeMenu(anchor, align) {
                var r = (anchor || document.body).getBoundingClientRect();
                var mw = menuEl.offsetWidth;
                var mh = menuEl.offsetHeight;
                var left = align === 'right' ? r.right - mw : r.left;
                var top = align === 'right' ? r.bottom + 6 : r.top;
                if (left < 8) left = 8;
                if (left + mw > window.innerWidth - 8) left = Math.max(8, window.innerWidth - mw - 8);
                if (top + mh > window.innerHeight - 8) top = Math.max(8, r.top - mh - 6);
                menuEl.style.left = left + 'px';
                menuEl.style.top = top + 'px';
            }

            function openMessageMenu(row, anchor) {
                if (currentMenuRow === row && menuEl.classList.contains('show')) {
                    closeMsgMenu();
                    return;
                }
                closeMsgMenu();
                currentMenuRow = row;
                row.classList.add('menu-open');

                var deleted = row.dataset.deleted === '1';
                var isOut = row.classList.contains('out');
                var isMedia = !!row.querySelector('.img-wrap, .doc-card');

                menuEl.innerHTML = '';

                if (!deleted) {
                    var rx = document.createElement('div');
                    rx.className = 'reaction-row';
                    ['👍', '❤️', '😂', '😮', '😢', '🙏'].forEach(function(emo) {
                        var s = document.createElement('span');
                        s.textContent = emo;
                        s.title = 'React ' + emo;
                        s.addEventListener('click', function() {
                            reactTo(row, emo);
                            closeMsgMenu();
                        });
                        rx.appendChild(s);
                    });
                    menuEl.appendChild(rx);

                    addMenuItem('fas fa-reply', 'Reply', function() {
                        startReply(row);
                    });
                    addMenuItem('fas fa-copy', 'Copy', function() {
                        copyMessage(row);
                    });
                    addMenuItem('fas fa-share', 'Forward', function() {
                        openForward(row);
                    });
                    addMenuItem(row.classList.contains('starred') ? 'fas fa-star' : 'far fa-star',
                        row.classList.contains('starred') ? 'Unstar' : 'Star',
                        function() {
                            toggleStar(row);
                        });
                    addMenuItem('fas fa-thumbtack', row.classList.contains('pinned') ? 'Unpin' : 'Pin',
                        function() {
                            togglePin(row);
                        });
                    if (isOut && !isMedia) {
                        addMenuItem('fas fa-pen', 'Edit', function() {
                            startEdit(row);
                        });
                    }

                    menuEl.appendChild(divider());
                    addMenuItem('fas fa-circle-info', 'Message info', function() {
                        messageInfo(row);
                    });
                    if (isOut) {
                        addMenuItem('fas fa-trash-can', 'Delete', function() {
                            askDelete(row);
                        }, 'danger');
                    }
                } else {
                    addMenuItem('fas fa-circle-info', 'Message info', function() {
                        messageInfo(row);
                    });
                }

                menuEl.classList.add('show');
                placeMenu(anchor || bubbleOf(row), isOut ? 'left' : 'right-left');
            }

            /* ---------- reactions ---------- */
            function updateReactionSpace(row) {
                var box = row.querySelector('.reactions');
                row.classList.toggle('has-reaction', !!(box && box.children.length));
            }

            function reactTo(row, emo) {
                var box = row.querySelector('.reactions');
                if (!box) {
                    box = document.createElement('div');
                    box.className = 'reactions';
                    row.appendChild(box);
                }
                var existing = null;
                Array.prototype.forEach.call(box.children, function(c) {
                    if (c.dataset.emoji === emo) existing = c;
                });
                if (existing) {
                    existing.remove();
                } else {
                    var chip = document.createElement('span');
                    chip.className = 'rx';
                    chip.dataset.emoji = emo;
                    chip.textContent = emo;
                    chip.title = 'Remove reaction';
                    chip.addEventListener('click', function() {
                        chip.remove();
                        updateReactionSpace(row);
                    });
                    box.appendChild(chip);
                }
                updateReactionSpace(row);
            }

            /* ---------- copy ---------- */
            function copyMessage(row) {
                var text = messageText(row);

                function fallback() {
                    var ta = document.createElement('textarea');
                    ta.value = text;
                    ta.style.position = 'fixed';
                    ta.style.opacity = '0';
                    document.body.appendChild(ta);
                    ta.select();
                    try {
                        document.execCommand('copy');
                    } catch (err) {}
                    ta.remove();
                    toast('Message copied');
                }

                if (navigator.clipboard && navigator.clipboard.writeText) {
                    navigator.clipboard.writeText(text).then(function() {
                        toast('Message copied');
                    }, fallback);
                } else {
                    fallback();
                }
            }

            /* ---------- forward (multi-select) ---------- */
            function openForward(row) {
                var targets = [];
                var checks = [];

                var wrap = document.createElement('div');
                wrap.className = 'panel-content';
                var list = document.createElement('div');
                list.className = 'pick-list';

                document.querySelectorAll('.contact').forEach(function(c) {
                    var item = document.createElement('label');
                    item.className = 'emp-row';

                    var av = c.querySelector('.avatar').cloneNode(true);
                    av.classList.remove('online');
                    item.appendChild(av);

                    var nm = document.createElement('span');
                    nm.className = 'emp-name';
                    nm.textContent = c.dataset.name + (c.dataset.group ? ' (group)' : '');
                    item.appendChild(nm);

                    var cb = document.createElement('input');
                    cb.type = 'checkbox';
                    item.appendChild(cb);

                    checks.push(cb);
                    targets.push({
                        id: c.dataset.target,
                        name: c.dataset.name
                    });

                    list.appendChild(item);
                });

                if (!targets.length) {
                    toast('No chats to forward to');
                    return;
                }
                wrap.appendChild(list);

                showModal({
                    title: 'Forward to...',
                    text: 'Select one or more chats to forward this message to.',
                    content: wrap,
                    actions: [{
                            icon: 'fas fa-share',
                            label: 'Forward',
                            onClick: function() {
                                var picked = targets.filter(function(t, i) {
                                    return checks[i].checked;
                                });
                                if (!picked.length) {
                                    toast('Select at least one chat');
                                    return;
                                }
                                picked.forEach(function(t) {
                                    forwardTo(row, t.id, t.name);
                                });
                                closeModal();
                                toast(picked.length === 1 ?
                                    'Forwarded to ' + picked[0].name :
                                    'Forwarded to ' + picked.length + ' chats');
                            }
                        },
                        {
                            icon: 'fas fa-xmark',
                            label: 'Cancel',
                            onClick: closeModal
                        }
                    ]
                });
            }

            function forwardTo(row, targetId) {
                var pane = targetId ? document.getElementById(targetId) : null;
                if (!pane) return;
                var body = pane.querySelector('.chat-body');
                var source = bubbleOf(row);
                if (!body || !source) return;

                var newRow = document.createElement('div');
                newRow.className = 'msg out first';
                var bubble = source.cloneNode(true);
                bubble.querySelectorAll('.quote, .reactions, .flag-badge, .edit-box').forEach(function(n) {
                    n.remove();
                });

                var fwd = document.createElement('div');
                fwd.style.cssText = 'font-size:11.5px;color:#94a3b8;font-style:italic;margin-bottom:2px;';
                fwd.textContent = 'Forwarded';
                bubble.insertBefore(fwd, bubble.firstChild);

                var meta = bubble.querySelector('.meta, .meta-over');
                if (meta) {
                    meta.textContent = nowTime() + ' ';
                    var tick = document.createElement('i');
                    tick.className = 'tick fas fa-check';
                    tick.dataset.status = 'sent';
                    tick.title = 'Sent';
                    meta.appendChild(tick);
                }

                newRow.appendChild(bubble);
                body.appendChild(newRow);
                decorateAll();
                scrollBottom(body, true);
            }

            /* ---------- star / pin ---------- */
            function syncBadges(row) {
                var b = bubbleOf(row);
                if (!b) return;
                b.querySelectorAll('.flag-badge').forEach(function(n) {
                    n.remove();
                });
                if (row.classList.contains('starred')) {
                    var s = document.createElement('span');
                    s.className = 'flag-badge star';
                    s.innerHTML = '<i class="fas fa-star"></i>';
                    b.appendChild(s);
                }
                if (row.classList.contains('pinned')) {
                    var p = document.createElement('span');
                    p.className = 'flag-badge pin';
                    p.style.top = row.classList.contains('starred') ? '13px' : '-8px';
                    p.innerHTML = '<i class="fas fa-thumbtack"></i>';
                    b.appendChild(p);
                }
            }

            function toggleStar(row) {
                row.classList.toggle('starred');
                syncBadges(row);
                toast(row.classList.contains('starred') ? 'Message starred' : 'Star removed');
            }

            function togglePin(row) {
                var pane = row.closest('.chat-pane');
                if (!pane) return;
                var willPin = !row.classList.contains('pinned');

                pane.querySelectorAll('.msg.pinned').forEach(function(r) {
                    r.classList.remove('pinned');
                    syncBadges(r);
                });
                if (willPin) row.classList.add('pinned');
                syncBadges(row);
                updatePinnedBar(pane);
                toast(willPin ? 'Message pinned' : 'Message unpinned');
            }

            function updatePinnedBar(pane) {
                if (!pane) return;
                var bar = pane.querySelector('.pinned-bar');

                if (!bar) {
                    bar = document.createElement('div');
                    bar.className = 'pinned-bar';
                    bar.innerHTML = '<i class="fas fa-thumbtack"></i><div class="txt"></div>' +
                        '<button type="button" title="Unpin"><i class="fas fa-xmark"></i></button>';
                    var head = pane.querySelector('.chat-head');
                    if (head) {
                        head.insertAdjacentElement('afterend', bar);
                    } else {
                        pane.insertBefore(bar, pane.firstChild);
                    }
                    bar.querySelector('button').addEventListener('click', function() {
                        var pinned = pane.querySelector('.msg.pinned');
                        if (pinned) {
                            pinned.classList.remove('pinned');
                            syncBadges(pinned);
                        }
                        updatePinnedBar(pane);
                        toast('Message unpinned');
                    });
                }

                var pinned = pane.querySelector('.msg.pinned');
                var txt = bar.querySelector('.txt');
                if (pinned) {
                    bar.classList.add('show');
                    txt.innerHTML = '';
                    var who = document.createElement('strong');
                    who.textContent = senderOf(pinned) + ': ';
                    txt.appendChild(who);
                    txt.appendChild(document.createTextNode(messageText(pinned)));
                } else {
                    bar.classList.remove('show');
                }
            }

            /* ---------- info ---------- */
            function messageInfo(row) {
                var meta = row.querySelector('.meta, .meta-over');
                var time = meta ? cleanText(meta).replace(/\s*$/, '') : '';
                var isOut = row.classList.contains('out');
                var tick = meta ? meta.querySelector('.tick, .read-tick, .single-tick') : null;
                var status;
                if (tick) {
                    status = tick.dataset.status || (tick.classList.contains('read') || tick.classList.contains(
                        'read-tick') ? 'read' : 'sent');
                } else {
                    status = isOut ? 'read' : 'received';
                }

                var statusText = status === 'sent' ? 'Sent' :
                    (status === 'delivered' ? 'Delivered' : (isOut ? 'Read' : 'Received'));

                showModal({
                    title: 'Message info',
                    text: 'From: ' + senderOf(row) + '\n' +
                        'Time: ' + (time || 'Unknown') + '\n' +
                        'Status: ' + statusText +
                        (row.dataset.edited === '1' ? '\nEdited: Yes' : '') +
                        (row.classList.contains('starred') ? '\nStarred: Yes' : '') +
                        (row.classList.contains('pinned') ? '\nPinned: Yes' : ''),
                    actions: [{
                        icon: 'fas fa-xmark',
                        label: 'Close',
                        onClick: closeModal
                    }]
                });
            }

            /* ---------- reply ---------- */
            var replyTo = null;
            var replyBar = document.getElementById('replyBar');
            var replyBarWho = document.getElementById('replyBarWho');
            var replyBarText = document.getElementById('replyBarText');

            document.getElementById('replyBarClose').addEventListener('click', cancelReply);

            function startReply(row) {
                replyTo = {
                    row: row,
                    who: senderOf(row),
                    text: messageText(row)
                };
                replyBarWho.textContent = replyTo.who;
                replyBarText.textContent = replyTo.text;
                replyBar.classList.add('show');
                input.focus();
            }

            function cancelReply() {
                replyTo = null;
                replyBar.classList.remove('show');
            }

            /* ---------- edit ---------- */
            function startEdit(row) {
                var b = bubbleOf(row);
                if (!b || b.querySelector('.edit-box')) return;

                var original = messageText(row);
                var removed = [];

                Array.prototype.slice.call(b.childNodes).forEach(function(n) {
                    if (n.nodeType === 1 && (n.classList.contains('meta') || n.classList.contains('quote') ||
                            n.classList.contains('flag-badge'))) {
                        return;
                    }
                    removed.push(n);
                    b.removeChild(n);
                });

                var box = document.createElement('div');
                box.className = 'edit-box';

                var ta = document.createElement('textarea');
                ta.value = original;

                var actions = document.createElement('div');
                actions.className = 'edit-actions';
                var cancelBtn = document.createElement('button');
                cancelBtn.type = 'button';
                cancelBtn.className = 'cancel';
                cancelBtn.textContent = 'Cancel';
                var saveBtn = document.createElement('button');
                saveBtn.type = 'button';
                saveBtn.className = 'save';
                saveBtn.textContent = 'Save';
                actions.appendChild(cancelBtn);
                actions.appendChild(saveBtn);
                box.appendChild(ta);
                box.appendChild(actions);

                if (b.querySelector('.meta')) {
                    b.insertBefore(box, b.querySelector('.meta'));
                } else {
                    b.appendChild(box);
                }

                ta.focus();
                ta.setSelectionRange(ta.value.length, ta.value.length);

                function restore() {
                    box.remove();
                    var anchor = b.querySelector('.meta');
                    removed.forEach(function(n) {
                        if (anchor) b.insertBefore(n, anchor);
                        else b.appendChild(n);
                    });
                }

                function save() {
                    var val = ta.value.trim();
                    if (!val) {
                        toast('Message cannot be empty');
                        return;
                    }
                    box.remove();
                    var anchor = b.querySelector('.meta');
                    var textNode = document.createTextNode(val);
                    if (anchor) b.insertBefore(textNode, anchor);
                    else b.appendChild(textNode);
                    row.dataset.edited = '1';
                    if (anchor && !anchor.querySelector('.edited-label')) {
                        var lbl = document.createElement('span');
                        lbl.className = 'edited-label';
                        lbl.textContent = 'edited · ';
                        anchor.insertBefore(lbl, anchor.firstChild);
                    }
                    toast('Message edited');
                }

                cancelBtn.addEventListener('click', restore);
                saveBtn.addEventListener('click', save);
                ta.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape') {
                        e.preventDefault();
                        restore();
                    } else if (e.key === 'Enter' && !e.shiftKey) {
                        e.preventDefault();
                        save();
                    }
                });
            }

            /* ---------- delete ---------- */
            function askDelete(row) {
                if (!row.classList.contains('out')) {
                    showModal({
                        title: 'Delete message?',
                        text: 'This message will be removed from this device.',
                        actions: [{
                                icon: 'fas fa-trash-can',
                                label: 'Delete for me',
                                cls: 'danger',
                                onClick: function() {
                                    removeMessage(row);
                                    closeModal();
                                }
                            },
                            {
                                icon: 'fas fa-xmark',
                                label: 'Cancel',
                                onClick: closeModal
                            }
                        ]
                    });
                    return;
                }

                showModal({
                    title: 'Delete message?',
                    actions: [{
                            icon: 'fas fa-user',
                            label: 'Delete for me',
                            cls: 'danger',
                            onClick: function() {
                                removeMessage(row);
                                closeModal();
                            }
                        },
                        {
                            icon: 'fas fa-users',
                            label: 'Delete for everyone',
                            cls: 'danger',
                            onClick: function() {
                                deleteForEveryone(row);
                                closeModal();
                            }
                        },
                        {
                            icon: 'fas fa-xmark',
                            label: 'Cancel',
                            onClick: closeModal
                        }
                    ]
                });
            }

            function removeMessage(row) {
                row.remove();
                toast('Message deleted');
            }

            function deleteForEveryone(row) {
                var b = bubbleOf(row);
                if (!b) return;

                row.classList.add('deleted');
                row.dataset.deleted = '1';
                row.classList.remove('starred', 'pinned', 'has-reaction');

                b.className = 'bubble';
                b.innerHTML = '';
                var ic = document.createElement('i');
                ic.className = 'fas fa-ban';
                ic.style.marginRight = '6px';
                ic.style.fontSize = '12px';
                b.appendChild(ic);
                b.appendChild(document.createTextNode('This message was deleted'));

                var m = document.createElement('span');
                m.className = 'meta';
                m.textContent = nowTime() + ' ';
                b.appendChild(m);

                var pane = row.closest('.chat-pane');
                if (pane) updatePinnedBar(pane);
                toast('Message deleted for everyone');
            }

            /* ---------- modal ---------- */
            function showModal(opts) {
                modalEl.innerHTML = '';
                var panel = document.createElement('div');
                panel.className = 'panel';

                var head = document.createElement('div');
                head.className = 'panel-head';
                head.textContent = opts.title || '';
                panel.appendChild(head);

                if (opts.text) {
                    var txt = document.createElement('div');
                    txt.className = 'panel-body';
                    txt.textContent = opts.text;
                    panel.appendChild(txt);
                }

                if (opts.content) panel.appendChild(opts.content);

                if (opts.actions && opts.actions.length) {
                    var foot = document.createElement('div');
                    foot.className = 'panel-foot';
                    opts.actions.forEach(function(a) {
                        var btn = document.createElement('button');
                        btn.type = 'button';
                        btn.className = a.cls || '';
                        if (a.icon) {
                            var i = document.createElement('i');
                            i.className = a.icon;
                            btn.appendChild(i);
                        }
                        btn.appendChild(document.createTextNode(a.label));
                        btn.addEventListener('click', a.onClick || closeModal);
                        foot.appendChild(btn);
                    });
                    panel.appendChild(foot);
                }

                modalEl.appendChild(panel);
                modalEl.classList.add('show');
            }

            function closeModal() {
                modalEl.classList.remove('show');
                modalEl.innerHTML = '';
            }

            modalEl.addEventListener('click', function(e) {
                if (e.target === modalEl) closeModal();
            });

            function confirmAction(title, text, label, onYes) {
                showModal({
                    title: title,
                    text: text,
                    actions: [{
                            icon: 'fas fa-check',
                            label: label,
                            cls: 'danger',
                            onClick: function() {
                                closeModal();
                                onYes();
                            }
                        },
                        {
                            icon: 'fas fa-xmark',
                            label: 'Cancel',
                            onClick: closeModal
                        }
                    ]
                });
            }

            /* ---------- chat header actions ---------- */
            function openChatMenu(head, anchor) {
                closeMsgMenu();
                var pane = head.closest('.chat-pane');
                var nameEl = head.querySelector('.who strong');
                var name = nameEl ? nameEl.textContent.trim() : 'this chat';
                var isGroup = !!getGroup(pane);

                menuEl.innerHTML = '';

                if (isGroup) {
                    addMenuItem('fas fa-circle-info', 'Group info', function() {
                        openGroupInfo(pane);
                    });
                    addMenuItem('fas fa-user-plus', 'Add participants', function() {
                        openGroupInfo(pane, 'add');
                    });
                } else {
                    addMenuItem('fas fa-circle-info', 'Contact info', function() {
                        chatInfo(pane, name);
                    });
                }

                addMenuItem('fas fa-list-check', 'Select messages', function() {
                    toast('Select messages — demo');
                });
                addMenuItem('fas fa-bell-slash', 'Mute notifications', function() {
                    toast('Notifications muted for ' + name);
                });
                menuEl.appendChild(divider());
                addMenuItem('fas fa-broom', 'Clear chat', function() {
                    confirmAction('Clear chat?', 'All messages in "' + name + '" will be removed.',
                        'Clear chat',
                        function() {
                            clearChat(pane);
                        });
                });

                if (isGroup) {
                    addMenuItem('fas fa-right-from-bracket', 'Exit group', function() {
                        confirmAction('Exit group?', 'You will no longer receive messages from "' + name + '".',
                            'Exit group',
                            function() {
                                deleteChat(pane);
                            });
                    }, 'danger');
                } else {
                    addMenuItem('fas fa-thumbs-down', 'Block ' + name, function() {
                        toast(name + ' blocked');
                    }, 'danger');
                    addMenuItem('fas fa-flag', 'Report ' + name, function() {
                        toast('Report sent');
                    }, 'danger');
                }

                addMenuItem('fas fa-trash-can', 'Delete chat', function() {
                    confirmAction('Delete chat?', 'The conversation with "' + name + '" will be removed.',
                        'Delete chat',
                        function() {
                            deleteChat(pane);
                        });
                }, 'danger');

                menuEl.classList.add('show');
                placeMenu(anchor, 'right');
            }

            function chatInfo(pane, name) {
                if (!pane) return;
                var status = pane.querySelector('.chat-head .who small');
                showModal({
                    title: name,
                    text: 'Status: ' + (status ? status.textContent.trim() : 'Available') + '\n' +
                        'Messages: ' + pane.querySelectorAll('.msg').length + '\n' +
                        'Media: ' + pane.querySelectorAll('.img-wrap, .doc-card').length,
                    actions: [{
                        icon: 'fas fa-xmark',
                        label: 'Close',
                        onClick: closeModal
                    }]
                });
            }

            function emptyState() {
                var d = document.createElement('div');
                d.className = 'empty-chat';
                var i = document.createElement('i');
                i.className = 'far fa-comments';
                var p = document.createElement('p');
                p.textContent = 'No messages here yet. Say hello!';
                d.appendChild(i);
                d.appendChild(p);
                return d;
            }

            function clearChat(pane) {
                if (!pane) return;
                var body = pane.querySelector('.chat-body');
                if (!body) return;
                body.innerHTML = '';
                body.appendChild(emptyState());
                updatePinnedBar(pane);
                toast('Chat cleared');
            }

            function deleteChat(pane) {
                if (!pane) return;
                var contact = pane.id ? document.querySelector('.contact[data-target="' + pane.id + '"]') :
                    activeContact();
                pane.remove();
                if (contact) contact.remove();
                closePanels();
                toast('Chat deleted');

                // back to the welcome screen
                receiverId = null;
                conversationId = null;
                $('#welcomeScreen').addClass('active');
                $('#chatForm').hide();
                app.classList.remove('open');
            }

            /* ---------- employees & groups (front-end demo) ---------- */
            var EMPLOYEES = [{
                    name: 'Rahul Sharma',
                    initials: 'RS',
                    color: '#2563eb'
                },
                {
                    name: 'Amit Verma',
                    initials: 'AV',
                    color: '#4f46e5'
                },
                {
                    name: 'Karan Mehta',
                    initials: 'KM',
                    color: '#ca8a04'
                },
                {
                    name: 'Neha Joshi',
                    initials: 'NJ',
                    color: '#0891b2'
                },
                {
                    name: 'Priya Patel',
                    initials: 'PP',
                    color: '#db2777'
                },
                {
                    name: 'Vikram Malhotra',
                    initials: 'VM',
                    color: '#7c3aed'
                },
                {
                    name: 'Suresh Kumar',
                    initials: 'SK',
                    color: '#ea580c'
                },
                {
                    name: 'Dinesh Rao',
                    initials: 'DR',
                    color: '#0d9488'
                }
            ];
            var GROUP_COLORS = ['#0d9488', '#ea580c', '#7c3aed', '#0891b2', '#db2777', '#4f46e5'];
            var groupCounter = 0;

            function makeMember(name, isAdmin) {
                var emp = null;
                EMPLOYEES.forEach(function(e) {
                    if (e.name === name) emp = e;
                });

                var initials, color;
                if (name === 'You') {
                    initials = 'ME';
                    color = '#2563eb';
                } else if (emp) {
                    initials = emp.initials;
                    color = emp.color;
                } else {
                    var parts = name.split(' ');
                    initials = ((parts[0] || '?').charAt(0) + (parts[1] ? parts[1].charAt(0) : '')).toUpperCase();
                    color = '#64748b';
                }
                return {
                    name: name,
                    initials: initials,
                    color: color,
                    admin: !!isAdmin
                };
            }

            function getGroup(pane) {
                if (!pane) return null;
                return pane._group || null;
            }

            function syncGroup(pane) {
                var g = getGroup(pane);
                if (!g) return;

                var title = pane.querySelector('.chat-head .who strong');
                if (title) title.textContent = g.name;

                var sub = pane.querySelector('.chat-head .who small');
                if (sub) {
                    sub.textContent = g.members.map(function(m) {
                        return m.name;
                    }).join(', ');
                    sub.classList.remove('on');
                }

                var contact = document.querySelector('.contact[data-target="' + pane.id + '"]');
                if (contact) {
                    contact.dataset.name = g.name;
                    var cName = contact.querySelector('.contact-top strong');
                    if (cName) cName.textContent = g.name;
                    var pv = contact.querySelector('.preview');
                    if (pv) {
                        pv.textContent = g.members.length + ' members · ' + g.members.filter(function(m) {
                            return m.admin;
                        }).length + ' admin(s)';
                    }
                }
            }

            function addSystemMessage(pane, text) {
                var body = pane ? pane.querySelector('.chat-body') : null;
                if (!body) return;

                body.querySelectorAll('.empty-chat').forEach(function(n) {
                    n.remove();
                });

                var wrap = document.createElement('div');
                wrap.className = 'sys-msg';
                var span = document.createElement('span');
                span.textContent = text;
                wrap.appendChild(span);
                body.appendChild(wrap);
                scrollBottom(body, true);

                var contact = document.querySelector('.contact[data-target="' + pane.id + '"]');
                if (contact) {
                    var t = contact.querySelector('.contact-top small');
                    if (t) t.textContent = nowTime();
                    var pv = contact.querySelector('.preview');
                    if (pv) pv.textContent = text;
                }
            }

            /* ---------- new group dialog ---------- */
            function openNewGroup() {
                closeMsgMenu();

                var wrap = document.createElement('div');
                wrap.className = 'panel-content';

                var nameInput = document.createElement('input');
                nameInput.type = 'text';
                nameInput.className = 'wa-input';
                nameInput.placeholder = 'Group name';
                nameInput.maxLength = 40;
                wrap.appendChild(nameInput);

                var hint = document.createElement('div');
                hint.className = 'pick-hint';
                hint.textContent = 'Add employees';
                wrap.appendChild(hint);

                var list = document.createElement('div');
                list.className = 'pick-list';
                var checks = [];

                EMPLOYEES.forEach(function(e) {
                    var row = document.createElement('label');
                    row.className = 'emp-row';

                    var av = document.createElement('div');
                    av.className = 'avatar';
                    av.style.background = e.color;
                    av.textContent = e.initials;
                    row.appendChild(av);

                    var nm = document.createElement('span');
                    nm.className = 'emp-name';
                    nm.textContent = e.name;
                    row.appendChild(nm);

                    var cb = document.createElement('input');
                    cb.type = 'checkbox';
                    cb.value = e.name;
                    row.appendChild(cb);
                    checks.push(cb);

                    list.appendChild(row);
                });
                wrap.appendChild(list);

                showModal({
                    title: 'New group',
                    content: wrap,
                    actions: [{
                            icon: 'fas fa-users',
                            label: 'Create group',
                            onClick: function() {
                                var name = nameInput.value.trim();
                                var picked = EMPLOYEES.filter(function(e, i) {
                                    return checks[i].checked;
                                });
                                if (!name) {
                                    toast('Please enter a group name');
                                    nameInput.focus();
                                    return;
                                }
                                if (!picked.length) {
                                    toast('Please select at least one employee');
                                    return;
                                }
                                createGroup(name, picked);
                                closeModal();
                            }
                        },
                        {
                            icon: 'fas fa-xmark',
                            label: 'Cancel',
                            onClick: closeModal
                        }
                    ]
                });

                setTimeout(function() {
                    nameInput.focus();
                }, 60);
            }

            function createGroup(name, picked) {
                groupCounter++;
                var id = 'group-' + groupCounter;
                var color = GROUP_COLORS[(groupCounter - 1) % GROUP_COLORS.length];

                var members = [makeMember('You', true)];
                picked.forEach(function(e) {
                    members.push(makeMember(e.name, false));
                });

                /* contact row */
                var contact = document.createElement('div');
                contact.className = 'contact';
                contact.dataset.target = id;
                contact.dataset.name = name;
                contact.dataset.group = '1';

                var avatar = document.createElement('div');
                avatar.className = 'avatar';
                avatar.style.background = color;
                avatar.innerHTML = '<i class="fas fa-users"></i>';
                contact.appendChild(avatar);

                var info = document.createElement('div');
                info.className = 'contact-info';

                var top = document.createElement('div');
                top.className = 'contact-top';
                var cName = document.createElement('strong');
                cName.textContent = name;
                var cTime = document.createElement('small');
                cTime.textContent = 'Just now';
                top.appendChild(cName);
                top.appendChild(cTime);
                info.appendChild(top);

                var bottom = document.createElement('div');
                bottom.className = 'contact-bottom';
                var preview = document.createElement('span');
                preview.className = 'preview';
                preview.textContent = 'Group created';
                bottom.appendChild(preview);
                info.appendChild(bottom);

                contact.appendChild(info);
                contactsEl.insertBefore(contact, contactsEl.firstChild);

                /* chat pane */
                var pane = document.createElement('div');
                pane.className = 'chat-pane';
                pane.id = id;

                var head = document.createElement('div');
                head.className = 'chat-head';
                var back = document.createElement('i');
                back.className = 'fas fa-arrow-left back';
                head.appendChild(back);
                head.appendChild(avatar.cloneNode(true));

                var who = document.createElement('div');
                who.className = 'who';
                var wName = document.createElement('strong');
                wName.textContent = name;
                var wSub = document.createElement('small');
                wSub.textContent = members.map(function(m) {
                    return m.name;
                }).join(', ');
                who.appendChild(wName);
                who.appendChild(wSub);
                head.appendChild(who);
                pane.appendChild(head);

                var body = document.createElement('div');
                body.className = 'chat-body';
                var chip = document.createElement('div');
                chip.className = 'day-chip';
                var chipText = document.createElement('span');
                chipText.textContent = 'Today';
                chip.appendChild(chipText);
                body.appendChild(chip);
                pane.appendChild(body);

                pane._group = {
                    name: name,
                    members: members
                };

                var panes = document.querySelector('.panes');
                var scrollBtnEl = panes.querySelector('.scroll-down');
                if (scrollBtnEl) panes.insertBefore(pane, scrollBtnEl);
                else panes.appendChild(pane);

                decorateAll();

                // show this group (it has no server conversation yet)
                $('.contact').removeClass('active');
                contact.classList.add('active');
                receiverId = null;
                conversationId = null;
                $('.chat-pane').removeClass('active');
                pane.classList.add('active');
                $('#chatForm').hide();
                app.classList.add('open');

                addSystemMessage(pane, 'You created group "' + name + '"');
                applyFilters();
                toast('Group "' + name + '" created');
            }

            /* ---------- group info / members ---------- */
            function groupActionsRow(pane, active) {
                var wrap = document.createElement('div');
                wrap.className = 'group-actions';

                [
                    ['add', 'add-part-btn', 'fas fa-user-plus', 'Add participants', function() {
                        openGroupInfo(pane, 'add');
                    }],
                    ['remove', 'add-part-btn danger', 'fas fa-user-minus', 'Remove participants', function() {
                        openGroupInfo(pane, 'remove');
                    }],
                    ['admins', 'add-part-btn', 'fas fa-user-shield', 'Group admins', function() {
                        openGroupInfo(pane, 'admins');
                    }]
                ].forEach(function(item) {
                    var btn = document.createElement('button');
                    btn.type = 'button';
                    btn.className = item[1] + (active === item[0] ? ' active' : '');
                    btn.innerHTML = '<i class="' + item[2] + '"></i> ' + item[3];
                    btn.addEventListener('click', item[4]);
                    wrap.appendChild(btn);
                });

                return wrap;
            }

            function memberRow(m) {
                var row = document.createElement('div');
                row.className = 'member-row';

                var av = document.createElement('div');
                av.className = 'avatar';
                av.style.background = m.color;
                av.textContent = m.initials;
                row.appendChild(av);

                var info = document.createElement('div');
                info.className = 'm-info';
                var nm = document.createElement('strong');
                nm.textContent = m.name;
                var role = document.createElement('small');
                role.textContent = m.admin ? 'Group admin' : 'Member';
                info.appendChild(nm);
                info.appendChild(role);
                row.appendChild(info);

                if (m.admin) {
                    var tag = document.createElement('span');
                    tag.className = 'admin-tag';
                    tag.textContent = 'Admin';
                    row.appendChild(tag);
                }

                return row;
            }

            function pickRow(person, checked, disabled) {
                var row = document.createElement('label');
                row.className = 'emp-row';

                var av = document.createElement('div');
                av.className = 'avatar';
                av.style.background = person.color;
                av.textContent = person.initials;
                row.appendChild(av);

                var nm = document.createElement('span');
                nm.className = 'emp-name';
                nm.textContent = person.name + (person.admin ? ' (admin)' : '');
                row.appendChild(nm);

                var cb = document.createElement('input');
                cb.type = 'checkbox';
                cb.checked = !!checked;
                if (disabled) cb.disabled = true;
                row.appendChild(cb);

                return {
                    row: row,
                    cb: cb
                };
            }

            function buildPickList(items, isChecked, isDisabled) {
                var list = document.createElement('div');
                list.className = 'pick-list';
                var checks = [];

                items.forEach(function(person) {
                    var r = pickRow(person, isChecked ? isChecked(person) : false, isDisabled ? isDisabled(
                        person) : false);
                    list.appendChild(r.row);
                    checks.push(r.cb);
                });

                return {
                    el: list,
                    checks: checks
                };
            }

            function availableMembers(g) {
                var taken = g.members.map(function(m) {
                    return m.name;
                });
                return EMPLOYEES.filter(function(e) {
                    return taken.indexOf(e.name) === -1;
                });
            }

            function openGroupInfo(pane, mode) {
                var g = getGroup(pane);
                if (!g) {
                    toast('This is not a group');
                    return;
                }

                mode = mode || 'info';

                var wrap = document.createElement('div');
                wrap.className = 'panel-content';
                wrap.appendChild(groupActionsRow(pane, mode === 'info' ? '' : mode));

                var hint = document.createElement('div');
                hint.className = 'pick-hint';
                wrap.appendChild(hint);

                var checks = [];
                var actions = [];
                var built;
                var closeBtn = {
                    icon: 'fas fa-xmark',
                    label: 'Close',
                    onClick: closeModal
                };

                if (mode === 'info') {
                    hint.textContent = 'Participants';

                    var list = document.createElement('div');
                    g.members.forEach(function(m) {
                        list.appendChild(memberRow(m));
                    });
                    wrap.appendChild(list);

                    actions = [closeBtn];
                } else if (mode === 'add') {
                    var available = availableMembers(g);

                    if (!available.length) {
                        hint.textContent = 'All employees are already in this group';
                    } else {
                        hint.textContent = 'Select employees to add';
                        built = buildPickList(available);
                        checks = built.checks;
                        wrap.appendChild(built.el);
                    }

                    actions = [{
                        icon: 'fas fa-user-plus',
                        label: 'Add selected',
                        onClick: function() {
                            var picked = available.filter(function(e, i) {
                                return checks[i] && checks[i].checked;
                            });

                            if (!picked.length) {
                                toast('Select at least one employee');
                                return;
                            }

                            picked.forEach(function(e) {
                                g.members.push(makeMember(e.name, false));
                            });

                            addSystemMessage(pane, 'You added ' + picked.map(function(e) {
                                return e.name;
                            }).join(', '));
                            syncGroup(pane);
                            toast(picked.length + ' member(s) added');
                            openGroupInfo(pane, 'add');
                        }
                    }, closeBtn];
                } else if (mode === 'remove') {
                    var removable = g.members.filter(function(m) {
                        return m.name !== 'You';
                    });

                    if (!removable.length) {
                        hint.textContent = 'There are no participants to remove';
                    } else {
                        hint.textContent = 'Uncheck the employees you want to remove';
                        built = buildPickList(removable, function() {
                            return true;
                        });
                        checks = built.checks;
                        wrap.appendChild(built.el);
                    }

                    actions = [{
                        icon: 'fas fa-user-minus',
                        label: 'Remove selected',
                        onClick: function() {
                            var removed = removable.filter(function(m, i) {
                                return checks[i] && !checks[i].checked;
                            });

                            if (!removed.length) {
                                toast('Uncheck at least one employee');
                                return;
                            }

                            var names = removed.map(function(m) {
                                return m.name;
                            });

                            g.members = g.members.filter(function(m) {
                                return names.indexOf(m.name) === -1;
                            });

                            addSystemMessage(pane, 'You removed ' + names.join(', '));
                            syncGroup(pane);
                            toast(removed.length + ' member(s) removed');
                            openGroupInfo(pane, 'remove');
                        }
                    }, closeBtn];
                } else {
                    hint.textContent = 'Tick employees to make them group admin';

                    built = buildPickList(
                        g.members,
                        function(m) {
                            return m.name === 'You' ? true : !!m.admin;
                        },
                        function(m) {
                            return m.name === 'You';
                        }
                    );
                    checks = built.checks;
                    wrap.appendChild(built.el);

                    actions = [{
                        icon: 'fas fa-user-shield',
                        label: 'Save admins',
                        onClick: function() {
                            var made = [];
                            var dismissed = [];

                            g.members.forEach(function(m, i) {
                                if (m.name === 'You') return;
                                var wantsAdmin = checks[i].checked;
                                if (wantsAdmin && !m.admin) {
                                    m.admin = true;
                                    made.push(m.name);
                                } else if (!wantsAdmin && m.admin) {
                                    m.admin = false;
                                    dismissed.push(m.name);
                                }
                            });

                            if (!made.length && !dismissed.length) {
                                toast('No admin changes');
                                return;
                            }

                            if (made.length) addSystemMessage(pane, 'You made ' + made.join(', ') +
                                ' group admin(s)');
                            if (dismissed.length) addSystemMessage(pane, 'You dismissed ' + dismissed.join(
                                ', ') + ' as group admin(s)');

                            syncGroup(pane);
                            toast('Admin changes saved');
                            openGroupInfo(pane, 'admins');
                        }
                    }, closeBtn];
                }

                showModal({
                    title: g.name,
                    text: g.members.length + ' members · ' + g.members.filter(function(m) {
                        return m.admin;
                    }).length + ' admin(s)',
                    content: wrap,
                    actions: actions
                });
            }

            document.getElementById('newGroupBtn').addEventListener('click', openNewGroup);

            /* ---------- decorate messages & headers ---------- */
            function decorateRow(row) {
                var b = bubbleOf(row);
                if (!b) return;

                var tick = row.querySelector('.meta .tick, .meta-over .tick');
                if (tick && tick.dataset.bound !== '1') {
                    tick.dataset.bound = '1';
                    tick.addEventListener('click', function(e) {
                        e.stopPropagation();
                        messageInfo(row);
                    });
                }

                if (!row.querySelector('.msg-menu-btn')) {
                    var btn = document.createElement('button');
                    btn.type = 'button';
                    btn.className = 'msg-menu-btn';
                    btn.setAttribute('aria-label', 'Message options');
                    btn.innerHTML = '<i class="fas fa-chevron-down"></i>';
                    btn.addEventListener('click', function(e) {
                        e.stopPropagation();
                        openMessageMenu(row, btn);
                    });
                    row.appendChild(btn);
                }

                if (!row.querySelector('.reactions')) {
                    var box = document.createElement('div');
                    box.className = 'reactions';
                    row.appendChild(box);
                }
            }

            function decorateHead(head) {
                if (head.querySelector('.head-actions')) return;
                var actions = document.createElement('div');
                actions.className = 'head-actions';

                var search = document.createElement('button');
                search.type = 'button';
                search.title = 'Search in chat';
                search.innerHTML = '<i class="fas fa-magnifying-glass"></i>';
                search.addEventListener('click', function() {
                    toast('Search in chat — demo');
                });
                actions.appendChild(search);

                var more = document.createElement('button');
                more.type = 'button';
                more.title = 'Chat menu';
                more.innerHTML = '<i class="fas fa-ellipsis-vertical"></i>';
                more.addEventListener('click', function(e) {
                    e.stopPropagation();
                    openChatMenu(head, more);
                });
                actions.appendChild(more);
                head.appendChild(actions);
            }

            function decorateAll() {
                document.querySelectorAll('.chat-head').forEach(decorateHead);
                document.querySelectorAll('.chat-body .msg').forEach(decorateRow);
            }

            decorateAll();

            var chatObserver = new MutationObserver(function() {
                decorateAll();
            });
            chatObserver.observe(document.getElementById('chatWindow'), {
                childList: true,
                subtree: true
            });

            /* ---------- global events ---------- */
            document.addEventListener('click', function(e) {
                if (!menuEl.contains(e.target) &&
                    !e.target.closest('.msg-menu-btn') &&
                    !e.target.closest('.head-actions button')) {
                    closeMsgMenu();
                }

                if (e.target.closest('.chat-head .back')) {
                    app.classList.remove('open');
                }
            });

            document.addEventListener('contextmenu', function(e) {
                var row = e.target.closest('.msg');
                if (!row) return;
                e.preventDefault();
                openMessageMenu(row, bubbleOf(row));
            });

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeMsgMenu();
                    closeModal();
                    cancelReply();
                }
            });

            window.addEventListener('resize', closeMsgMenu);

        })();
    </script>

</body>

</html>
