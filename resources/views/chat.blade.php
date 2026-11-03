<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat | HVAC Employee Portal</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">

    <style>
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

        /* ================= Sidebar (same as leaves page) ================= */
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

        /* scrollable names */
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

        /* scrollable history */
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

        /* message status ticks */
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

        /* ================= Message actions (WhatsApp style) ================= */
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

        /* dropdown menu */
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

        /* reactions under a message */
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

        /* badges (star / pin) */
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

        /* reply quote inside a bubble */
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

        /* reply bar above composer */
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

        /* pinned message bar */
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

        /* inline edit */
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

        /* deleted placeholder */
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

        /* empty chat */
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

        /* chat header actions */
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

        /* system message (group created / member added) */
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

        /* toast */
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

                <!-- ====================================================
                     LEFT : chat names (scrollable)
                     {{-- Laravel: wrap one .contact in @foreach ($chats as $chat) --}}
                     ==================================================== -->
                <aside class="chat-list">

                    <div class="chat-list-head">
                        <span>Chats</span>
                        <button type="button" class="new-group-btn" id="newGroupBtn" title="Create a new group">
                            <i class="fas fa-users"></i>
                            <span>New group</span>
                        </button>
                    </div>

                    <div class="contacts" id="contacts">
                        {{-- @foreach ($users as $user)
                            <div class="contact {{ $loop->iteration == 1 ? 'active' : '' }} has-unread"
                                data-user-id="{{ $user->id }}" data-target="pane-{{ $loop->iteration }}"
                                data-conversation-id="{{ $user->conversationParticipants->first()?->conversation_id }}"
                                data-name="{{ $user->employee?->full_name }}">

                                <img class="avatar online" src="{{ $user->employee?->profile_url }}"
                                    style="background:#2563eb">

                                <div class="contact-info">
                                    <div class="contact-top">
                                        <strong>{{ $user->employee?->full_name }}</strong>
                                        <small></small>
                                    </div>

                                    <div class="contact-bottom">
                                        <span class="preview"></span>
                                        <em class="unread">2</em>
                                    </div>
                                </div>
                            </div>
                        @endforeach --}}
                        {{-- <div class="contact has-unread" data-target="pane-3" data-name="Site Engineers"
                            data-group="1">
                            <div class="avatar" style="background:#ea580c"><i class="fas fa-users"></i></div>
                            <div class="contact-info">
                                <div class="contact-top"><strong>Site Engineers</strong><small>4:30 PM</small></div>
                                <div class="contact-bottom">
                                    <span class="preview">Amit: AC unit installation done at site 4.</span>
                                    <em class="unread">5</em>
                                </div>
                            </div>
                        </div>

                        <div class="contact" data-target="pane-2" data-name="HR Team">
                            <div class="avatar online" style="background:#059669">HR</div>
                            <div class="contact-info">
                                <div class="contact-top"><strong>HR Team</strong><small>4:17 PM</small></div>
                                <div class="contact-bottom">
                                    <span class="preview"><i class="fas fa-check-double"></i>Thank you so much!</span>
                                </div>
                            </div>
                        </div>

                        <div class="contact has-unread" data-target="pane-7" data-name="Karan Mehta">
                            <div class="avatar" style="background:#ca8a04">KM</div>
                            <div class="contact-info">
                                <div class="contact-top"><strong>Karan Mehta</strong><small>11:30 AM</small></div>
                                <div class="contact-bottom">
                                    <span class="preview">Is this the correct connection?</span>
                                    <em class="unread">1</em>
                                </div>
                            </div>
                        </div>

                        <div class="contact" data-target="pane-4" data-name="Priya Patel">
                            <div class="avatar" style="background:#db2777">PP</div>
                            <div class="contact-info">
                                <div class="contact-top"><strong>Priya Patel</strong><small>3:10 PM</small></div>
                                <div class="contact-bottom">
                                    <span class="preview"><i class="fas fa-check-double"></i>Thanks! See you
                                        tomorrow.</span>
                                </div>
                            </div>
                        </div>

                        <div class="contact" data-target="pane-5" data-name="Manager - Vikram">
                            <div class="avatar" style="background:#7c3aed">VM</div>
                            <div class="contact-info">
                                <div class="contact-top"><strong>Manager - Vikram</strong><small>Yesterday</small></div>
                                <div class="contact-bottom">
                                    <span class="preview"><i class="fas fa-check-double"></i>Received, thank you.</span>
                                </div>
                            </div>
                        </div>

                        <div class="contact" data-target="pane-8" data-name="Warehouse" data-group="1">
                            <div class="avatar" style="background:#0d9488"><i class="fas fa-users"></i></div>
                            <div class="contact-info">
                                <div class="contact-top"><strong>Warehouse</strong><small>Yesterday</small></div>
                                <div class="contact-bottom">
                                    <span class="preview"><i class="fas fa-check-double"></i>Please keep 5 aside for
                                        Site 4.</span>
                                </div>
                            </div>
                        </div>

                        <div class="contact" data-target="pane-6" data-name="Neha Joshi">
                            <div class="avatar online" style="background:#0891b2">NJ</div>
                            <div class="contact-info">
                                <div class="contact-top"><strong>Neha Joshi</strong><small>Sunday</small></div>
                                <div class="contact-bottom">
                                    <span class="preview">Ok, noted.</span>
                                </div>
                            </div>
                        </div>

                        <div class="contact" data-target="pane-9" data-name="Accounts Dept">
                            <div class="avatar" style="background:#dc2626">AD</div>
                            <div class="contact-info">
                                <div class="contact-top"><strong>Accounts Dept</strong><small>Saturday</small></div>
                                <div class="contact-bottom">
                                    <span class="preview"><i class="fas fa-check-double"></i>Received, thank
                                        you.</span>
                                </div>
                            </div>
                        </div>

                        <div class="contact" data-target="pane-10" data-name="Amit Verma">
                            <div class="avatar" style="background:#4f46e5">AV</div>
                            <div class="contact-info">
                                <div class="contact-top"><strong>Amit Verma</strong><small>Friday</small></div>
                                <div class="contact-bottom">
                                    <span class="preview">Almost done, will send in 10 minutes.</span>
                                </div>
                            </div>
                        </div> --}}

                    </div>
                </aside>

                <!-- ====================================================
                     RIGHT : conversation (scrollable history)
                     {{-- Laravel: wrap one .chat-pane in @foreach ($chats as $chat) --}}
                     ==================================================== -->
                <section class="chat-window" id="chatWindow">

                    <div class="panes">

                        <!-- ============ PANE 1 : Rahul Sharma ============ -->
                        {{-- @foreach ($users as $user)
                            <div class="chat-pane {{ $loop->first ? 'active' : '' }}" id="pane-{{ $loop->iteration }}"
                                data-user-id="{{ $user->id }}">

                                <div class="chat-head">
                                    <i class="fas fa-arrow-left back"></i>
                                    <img class="avatar online" src="{{ $user->profile_url }}"
                                        style="background:#2563eb">
                                    <div class="who">
                                        <strong>{{ $user->full_name }}</strong>
                                        <small class="on">online</small>
                                    </div>
                                </div>

                                <div class="chat-body">

                                    <div class="day-chip"><span>Saturday, 31 October</span></div>

                                    <div class="msg in first">
                                        <div class="bubble">Morning! Did you check the schedule?<span
                                                class="meta">9:05
                                                AM</span></div>
                                    </div>
                                    <div class="msg out first">
                                        <div class="bubble">Yes, I have the list for today.<span class="meta">9:12 AM
                                                <i class="fas fa-check-double"></i></span></div>
                                    </div>
                                    <div class="msg in first">
                                        <div class="bubble">Please carry the pressure gauge and spare filters.<span
                                                class="meta">9:19 AM</span></div>
                                    </div>
                                    <div class="msg in">
                                        <div class="bubble">Customer is asking for an ETA as well.<span
                                                class="meta">9:20
                                                AM</span></div>
                                    </div>
                                    <div class="msg out first">
                                        <div class="bubble">Noted. Starting from site 2, will reach by 1 PM.<span
                                                class="meta">9:26 AM <i class="fas fa-check-double"></i></span></div>
                                    </div>
                                    <div class="msg in first">
                                        <div class="bubble">Compressor reading is normal now?<span class="meta">11:40
                                                AM</span></div>
                                    </div>
                                    <div class="msg out first">
                                        <div class="bubble">Yes, it is normal. I will note it in the report.<span
                                                class="meta">11:45 AM <i class="fas fa-check-double"></i></span></div>
                                    </div>
                                    <div class="msg in first">
                                        <div class="bubble">Great, good job!<span class="meta">11:47 AM</span></div>
                                    </div>
                                    <div class="msg out first">
                                        <div class="bubble">Thanks Rahul 😊<span class="meta">11:48 AM <i
                                                    class="fas fa-check-double"></i></span></div>
                                    </div>
                                    <div class="msg in first">
                                        <div class="bubble">Any update on the spare parts order?<span
                                                class="meta">3:15
                                                PM</span></div>
                                    </div>
                                    <div class="msg out first">
                                        <div class="bubble">Supplier confirmed delivery for tomorrow.<span
                                                class="meta">3:22
                                                PM <i class="fas fa-check-double"></i></span>
                                        </div>
                                    </div>
                                    <div class="msg in first">
                                        <div class="bubble">Perfect, thanks for following up.<span class="meta">3:25
                                                PM</span></div>
                                    </div>

                                    <div class="day-chip"><span>Sunday, 1 November</span></div>

                                    <div class="msg out first">
                                        <div class="bubble">Hi Rahul, happy Sunday! Just checking tomorrow's plan.<span
                                                class="meta">11:02 AM <i class="fas fa-check-double"></i></span>
                                        </div>
                                    </div>
                                    <div class="msg in first">
                                        <div class="bubble">Hi! Tomorrow we have two AC installations and one service
                                            call.<span class="meta">11:05 AM</span></div>
                                    </div>
                                    <div class="msg in first">
                                        <div class="bubble has-img">
                                            <div class="img-wrap"
                                                data-caption="This is the spot for the outdoor unit at site 4.">
                                                <img src="https://picsum.photos/seed/hvac-site4/600/420"
                                                    alt="Outdoor unit">
                                            </div>
                                            <div class="img-caption">This is the spot for the outdoor unit at site
                                                4.<span class="meta">11:06 AM</span></div>
                                        </div>
                                    </div>
                                    <div class="msg out first">
                                        <div class="bubble">Looks good. Is the mounting bracket available?<span
                                                class="meta">11:09 AM <i class="fas fa-check-double"></i></span>
                                        </div>
                                    </div>
                                    <div class="msg in first">
                                        <div class="bubble">Yes, it is in the store room. I will pick it up.<span
                                                class="meta">11:10 AM</span></div>
                                    </div>
                                    <div class="msg in first">
                                        <div class="bubble">
                                            <div class="doc-card">
                                                <i class="fas fa-file-pdf ico"></i>
                                                <div>
                                                    <div class="name">Service_Schedule_Nov.pdf</div>
                                                    <small>248 KB</small>
                                                </div>
                                            </div>
                                            <span class="meta">11:12 AM</span>
                                        </div>
                                    </div>
                                    <div class="msg out first">
                                        <div class="bubble">Got it, thanks 👍<span class="meta">11:14 AM <i
                                                    class="fas fa-check-double"></i></span></div>
                                    </div>

                                    <div class="day-chip"><span>Today</span></div>

                                    <div class="msg in first">
                                        <div class="bubble">Good morning! Site 2 service is done?<span
                                                class="meta">9:30
                                                AM</span></div>
                                    </div>
                                    <div class="msg out first">
                                        <div class="bubble">Good morning. Yes, finished and filter replaced.<span
                                                class="meta">9:41 AM <i class="fas fa-check-double"></i></span>
                                        </div>
                                    </div>
                                    <div class="msg out first">
                                        <div class="bubble has-img">
                                            <div class="img-wrap shade" data-caption="">
                                                <img src="https://picsum.photos/seed/hvac-filter/600/420"
                                                    alt="Filter">
                                                <span class="meta-over">12:40 PM <i
                                                        class="fas fa-check-double"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="msg out">
                                        <div class="bubble">Photo of the new filter after replacement.<span
                                                class="meta">12:41 PM <i class="fas fa-check-double"></i></span>
                                        </div>
                                    </div>
                                    <div class="msg in first">
                                        <div class="bubble">Looks clean. Thanks!<span class="meta">12:50 PM</span>
                                        </div>
                                    </div>
                                    <div class="msg in first">
                                        <div class="bubble">Good afternoon! Can you send me the maintenance report for
                                            last
                                            week?<span class="meta">5:32 PM</span></div>
                                    </div>
                                    <div class="msg out first">
                                        <div class="bubble">Good afternoon. I am finishing it now, will send it
                                            shortly.<span class="meta">5:35 PM <i
                                                    class="fas fa-check-double"></i></span>
                                        </div>
                                    </div>
                                    <div class="msg in first">
                                        <div class="bubble">Sure, I will share the report today.<span
                                                class="meta">5:40
                                                PM</span></div>
                                    </div>

                                </div>
                            </div>
                        @endforeach --}}

                        <!-- ============ PANE 2 : HR Team ============ -->
                        {{-- <div class="chat-pane" id="pane-2">

                            <div class="chat-head">
                                <i class="fas fa-arrow-left back"></i>
                                <div class="avatar online" style="background:#059669">HR</div>
                                <div class="who">
                                    <strong>HR Team</strong>
                                    <small class="on">online</small>
                                </div>
                            </div>

                            <div class="chat-body">

                                <div class="day-chip"><span>Yesterday</span></div>

                                <div class="msg out first">
                                    <div class="bubble">Hello, I applied for leave from 10 Nov to 12 Nov.<span
                                            class="meta">3:20 PM <i class="fas fa-check-double"></i></span></div>
                                </div>
                                <div class="msg in first">
                                    <div class="bubble">Hello! We have received your request. It is under review.<span
                                            class="meta">3:45 PM</span></div>
                                </div>
                                <div class="msg out first">
                                    <div class="bubble">Okay, thank you.<span class="meta">3:47 PM <i
                                                class="fas fa-check-double"></i></span></div>
                                </div>

                                <div class="day-chip"><span>Today</span></div>

                                <div class="msg in first">
                                    <div class="bubble">Your leave request has been approved.<span class="meta">4:15
                                            PM</span></div>
                                </div>
                                <div class="msg out first">
                                    <div class="bubble">Thank you so much!<span class="meta">4:17 PM <i
                                                class="fas fa-check-double"></i></span></div>
                                </div>

                            </div>
                        </div>

                        <!-- ============ PANE 3 : Site Engineers (group) ============ -->
                        <div class="chat-pane" id="pane-3">

                            <div class="chat-head">
                                <i class="fas fa-arrow-left back"></i>
                                <div class="avatar" style="background:#ea580c"><i class="fas fa-users"></i></div>
                                <div class="who">
                                    <strong>Site Engineers</strong>
                                    <small>Amit, Karan, Neha, Priya, You</small>
                                </div>
                            </div>

                            <div class="chat-body">

                                <div class="day-chip"><span>Friday, 30 October</span></div>

                                <div class="msg in first">
                                    <div class="bubble"><span class="sender" style="color:#2563eb">Amit</span>Morning
                                        team! Today's visit list is in the sheet.<span class="meta">9:02 AM</span>
                                    </div>
                                </div>
                                <div class="msg in first">
                                    <div class="bubble"><span class="sender" style="color:#db2777">Karan</span>Got
                                        it. I will take site 6.<span class="meta">9:10 AM</span></div>
                                </div>
                                <div class="msg out first">
                                    <div class="bubble">I will cover site 4 and site 5.<span class="meta">9:15 AM <i
                                                class="fas fa-check-double"></i></span></div>
                                </div>
                                <div class="msg in first">
                                    <div class="bubble"><span class="sender" style="color:#059669">Neha</span>Please
                                        carry the pressure gauge and spare filters.<span class="meta">9:20 AM</span>
                                    </div>
                                </div>
                                <div class="msg in first">
                                    <div class="bubble"><span class="sender" style="color:#7c3aed">Priya</span>Customer
                                        is asking for an ETA at site
                                        5.<span class="meta">10:05 AM</span></div>
                                </div>
                                <div class="msg out first">
                                    <div class="bubble">Tell them we will reach by 1 PM.<span class="meta">10:08 AM
                                            <i class="fas fa-check-double"></i></span></div>
                                </div>
                                <div class="msg in first">
                                    <div class="bubble"><span class="sender" style="color:#2563eb">Amit</span>Compressor
                                        reading is normal at site
                                        3.<span class="meta">12:30 PM</span></div>
                                </div>
                                <div class="msg out first">
                                    <div class="bubble">Great, please note it in the report.<span class="meta">12:34
                                            PM <i class="fas fa-check-double"></i></span></div>
                                </div>
                                <div class="msg in first">
                                    <div class="bubble"><span class="sender" style="color:#db2777">Karan</span>Gas
                                        refill completed at the second floor.<span class="meta">4:10 PM</span></div>
                                </div>
                                <div class="msg out first">
                                    <div class="bubble">Good job, team! 👏<span class="meta">4:15 PM <i
                                                class="fas fa-check-double"></i></span></div>
                                </div>

                                <div class="day-chip"><span>Yesterday</span></div>

                                <div class="msg in first">
                                    <div class="bubble has-img">
                                        <span class="sender" style="color:#2563eb">Amit</span>
                                        <div class="img-wrap" data-caption="AC unit installation done at site 4.">
                                            <img src="https://picsum.photos/seed/hvac-ac-unit/600/420" alt="AC unit">
                                        </div>
                                        <div class="img-caption">AC unit installation done at site 4.<span
                                                class="meta">2:10 PM</span></div>
                                    </div>
                                </div>
                                <div class="msg in">
                                    <div class="bubble"><span class="sender" style="color:#2563eb">Amit</span>Cable
                                        routing is also finished.<span class="meta">2:11 PM</span></div>
                                </div>
                                <div class="msg out first">
                                    <div class="bubble">Excellent work, Amit!<span class="meta">2:20 PM <i
                                                class="fas fa-check-double"></i></span></div>
                                </div>
                                <div class="msg in first">
                                    <div class="bubble has-img">
                                        <span class="sender" style="color:#db2777">Karan</span>
                                        <div class="img-wrap shade" data-caption="">
                                            <img src="https://picsum.photos/seed/hvac-duct/600/420" alt="Duct work">
                                            <span class="meta-over">3:02 PM</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="msg in">
                                    <div class="bubble"><span class="sender" style="color:#db2777">Karan</span>Duct
                                        work for site 6 is 80% done.<span class="meta">3:03 PM</span></div>
                                </div>
                                <div class="msg out first">
                                    <div class="bubble">Nice. Finish it by tomorrow evening.<span class="meta">3:10
                                            PM <i class="fas fa-check-double"></i></span></div>
                                </div>

                                <div class="day-chip"><span>Today</span></div>

                                <div class="msg in first">
                                    <div class="bubble"><span class="sender" style="color:#059669">Neha</span>Who has
                                        the thermal camera today?<span class="meta">10:15 AM</span></div>
                                </div>
                                <div class="msg in first">
                                    <div class="bubble"><span class="sender" style="color:#7c3aed">Priya</span>I have
                                        it, will return by evening.<span class="meta">10:22 AM</span></div>
                                </div>
                                <div class="msg out first">
                                    <div class="bubble">Okay, please keep it safe.<span class="meta">10:25 AM <i
                                                class="fas fa-check-double"></i></span></div>
                                </div>
                                <div class="msg in first">
                                    <div class="bubble"><span class="sender" style="color:#2563eb">Amit</span>AC unit
                                        installation done at site 4.<span class="meta">4:30 PM</span></div>
                                </div>

                            </div>
                        </div>

                        <!-- ============ PANE 4 : Priya Patel ============ -->
                        <div class="chat-pane" id="pane-4">

                            <div class="chat-head">
                                <i class="fas fa-arrow-left back"></i>
                                <div class="avatar" style="background:#db2777">PP</div>
                                <div class="who">
                                    <strong>Priya Patel</strong>
                                    <small>last seen today at 3:10 PM</small>
                                </div>
                            </div>

                            <div class="chat-body">

                                <div class="day-chip"><span>Yesterday</span></div>

                                <div class="msg in first">
                                    <div class="bubble">Did you get the customer feedback form?<span class="meta">1:00
                                            PM</span></div>
                                </div>
                                <div class="msg out first">
                                    <div class="bubble">Yes, I will fill it in this evening.<span class="meta">1:08
                                            PM <i class="fas fa-check-double"></i></span></div>
                                </div>

                                <div class="day-chip"><span>Today</span></div>

                                <div class="msg in first">
                                    <div class="bubble has-img">
                                        <div class="img-wrap" data-caption="Scan of the signed form.">
                                            <img src="https://picsum.photos/seed/hvac-form/600/420" alt="Form">
                                        </div>
                                        <div class="img-caption">Scan of the signed form.<span class="meta">2:55
                                                PM</span></div>
                                    </div>
                                </div>
                                <div class="msg out first">
                                    <div class="bubble">Thanks! See you tomorrow.<span class="meta">3:10 PM <i
                                                class="fas fa-check-double"></i></span></div>
                                </div>

                            </div>
                        </div>

                        <!-- ============ PANE 5 : Manager - Vikram ============ -->
                        <div class="chat-pane" id="pane-5">

                            <div class="chat-head">
                                <i class="fas fa-arrow-left back"></i>
                                <div class="avatar" style="background:#7c3aed">VM</div>
                                <div class="who">
                                    <strong>Manager - Vikram</strong>
                                    <small>last seen yesterday at 6:45 PM</small>
                                </div>
                            </div>

                            <div class="chat-body">

                                <div class="day-chip"><span>Saturday, 31 October</span></div>

                                <div class="msg in first">
                                    <div class="bubble">Please submit the timesheet by Friday.<span class="meta">6:45
                                            PM</span></div>
                                </div>
                                <div class="msg out first">
                                    <div class="bubble">Sure sir, I will submit it on time.<span class="meta">6:50
                                            PM <i class="fas fa-check-double"></i></span></div>
                                </div>

                                <div class="day-chip"><span>Yesterday</span></div>

                                <div class="msg in first">
                                    <div class="bubble">
                                        <div class="doc-card">
                                            <i class="fas fa-file-excel ico" style="color:#16a34a"></i>
                                            <div>
                                                <div class="name">Timesheet_Template.xlsx</div>
                                                <small>36 KB</small>
                                            </div>
                                        </div>
                                        <span class="meta">10:00 AM</span>
                                    </div>
                                </div>
                                <div class="msg out first">
                                    <div class="bubble">Received, thank you.<span class="meta">10:04 AM <i
                                                class="fas fa-check-double"></i></span></div>
                                </div>

                            </div>
                        </div>

                        <!-- ============ PANE 6 : Neha Joshi ============ -->
                        <div class="chat-pane" id="pane-6">

                            <div class="chat-head">
                                <i class="fas fa-arrow-left back"></i>
                                <div class="avatar online" style="background:#0891b2">NJ</div>
                                <div class="who">
                                    <strong>Neha Joshi</strong>
                                    <small class="on">online</small>
                                </div>
                            </div>

                            <div class="chat-body">

                                <div class="day-chip"><span>Sunday, 1 November</span></div>

                                <div class="msg in first">
                                    <div class="bubble">Can you cover my shift on Thursday?<span class="meta">8:10
                                            PM</span></div>
                                </div>
                                <div class="msg out first">
                                    <div class="bubble">Yes, no problem.<span class="meta">8:15 PM <i
                                                class="fas fa-check-double"></i></span></div>
                                </div>
                                <div class="msg in first">
                                    <div class="bubble">Ok, noted.<span class="meta">8:16 PM</span></div>
                                </div>

                            </div>
                        </div>

                        <!-- ============ PANE 7 : Karan Mehta ============ -->
                        <div class="chat-pane" id="pane-7">

                            <div class="chat-head">
                                <i class="fas fa-arrow-left back"></i>
                                <div class="avatar" style="background:#ca8a04">KM</div>
                                <div class="who">
                                    <strong>Karan Mehta</strong>
                                    <small>last seen today at 11:30 AM</small>
                                </div>
                            </div>

                            <div class="chat-body">

                                <div class="day-chip"><span>Today</span></div>

                                <div class="msg in first">
                                    <div class="bubble has-img">
                                        <div class="img-wrap" data-caption="Please check the wiring panel photo.">
                                            <img src="https://picsum.photos/seed/hvac-panel/600/420" alt="Wiring panel">
                                        </div>
                                        <div class="img-caption">Please check the wiring panel photo.<span
                                                class="meta">11:28 AM</span></div>
                                    </div>
                                </div>
                                <div class="msg in">
                                    <div class="bubble">Is this the correct connection?<span class="meta">11:30
                                            AM</span></div>
                                </div>

                            </div>
                        </div>

                        <!-- ============ PANE 8 : Warehouse (group) ============ -->
                        <div class="chat-pane" id="pane-8">

                            <div class="chat-head">
                                <i class="fas fa-arrow-left back"></i>
                                <div class="avatar" style="background:#0d9488"><i class="fas fa-users"></i></div>
                                <div class="who">
                                    <strong>Warehouse</strong>
                                    <small>Suresh, Dinesh, You</small>
                                </div>
                            </div>

                            <div class="chat-body">

                                <div class="day-chip"><span>Yesterday</span></div>

                                <div class="msg in first">
                                    <div class="bubble"><span class="sender" style="color:#ea580c">Suresh</span>20
                                        new filters arrived.<span class="meta">11:00 AM</span></div>
                                </div>
                                <div class="msg in first">
                                    <div class="bubble has-img">
                                        <span class="sender" style="color:#ea580c">Suresh</span>
                                        <div class="img-wrap" data-caption="Stock photo.">
                                            <img src="https://picsum.photos/seed/hvac-stock/600/420" alt="Stock">
                                        </div>
                                        <div class="img-caption">Stock photo.<span class="meta">11:01 AM</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="msg out first">
                                    <div class="bubble">Please keep 5 aside for Site 4.<span class="meta">11:20 AM
                                            <i class="fas fa-check-double"></i></span></div>
                                </div>

                            </div>
                        </div>

                        <!-- ============ PANE 9 : Accounts Dept ============ -->
                        <div class="chat-pane" id="pane-9">

                            <div class="chat-head">
                                <i class="fas fa-arrow-left back"></i>
                                <div class="avatar" style="background:#dc2626">AD</div>
                                <div class="who">
                                    <strong>Accounts Dept</strong>
                                    <small>last seen Saturday</small>
                                </div>
                            </div>

                            <div class="chat-body">

                                <div class="day-chip"><span>Saturday, 31 October</span></div>

                                <div class="msg in first">
                                    <div class="bubble">
                                        <div class="doc-card">
                                            <i class="fas fa-file-pdf ico"></i>
                                            <div>
                                                <div class="name">Salary_Slip_Oct.pdf</div>
                                                <small>120 KB</small>
                                            </div>
                                        </div>
                                        <span class="meta">5:00 PM</span>
                                    </div>
                                </div>
                                <div class="msg out first">
                                    <div class="bubble">Received, thank you.<span class="meta">5:30 PM <i
                                                class="fas fa-check-double"></i></span></div>
                                </div>

                            </div>
                        </div>

                        <!-- ============ PANE 10 : Amit Verma ============ -->
                        <div class="chat-pane" id="pane-10">

                            <div class="chat-head">
                                <i class="fas fa-arrow-left back"></i>
                                <div class="avatar" style="background:#4f46e5">AV</div>
                                <div class="who">
                                    <strong>Amit Verma</strong>
                                    <small>last seen Friday</small>
                                </div>
                            </div>

                            <div class="chat-body">

                                <div class="day-chip"><span>Friday, 30 October</span></div>

                                <div class="msg out first">
                                    <div class="bubble">Amit, did you finish the Site 3 report?<span class="meta">4:00
                                            PM <i class="fas fa-check-double"></i></span></div>
                                </div>
                                <div class="msg in first">
                                    <div class="bubble">Almost done, will send in 10 minutes.<span class="meta">4:05
                                            PM</span></div>
                                </div>

                            </div>
                        </div> --}}

                        <button type="button" class="scroll-down" id="scrollDown" aria-label="Scroll to latest">
                            <i class="fas fa-chevron-down"></i>
                            <span class="badge-new" id="newBadge">0</span>
                        </button>

                    </div>

                    <div class="emoji-panel" id="emojiPanel"></div>

                    <div class="attach-menu" id="attachMenu" style="display: none;">

                    </div>

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

                    <form class="chat-footer" id="chatForm" autocomplete="off">
                        <button type="button" class="tool" id="emojiBtn" aria-label="Emoji"><i
                                class="far fa-face-smile"></i></button>
                        <button type="button" class="tool" id="attachBtn" aria-label="Attach"><i
                                class="fas fa-paperclip"></i></button>
                        <input type="text" id="msgInput" placeholder="Type a message">
                        <button type="submit" class="btn-send-chat" aria-label="Send">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>

                    <!-- Image preview before sending -->
                    <div class="preview-screen" id="previewScreen">
                        <div class="preview-top">
                            <i class="fas fa-xmark" id="previewClose"></i>
                            <span>Preview</span>
                        </div>
                        <div class="preview-main"><img id="previewImg" alt="preview"></div>
                        <div class="preview-thumbs" id="previewThumbs"></div>
                        <div class="preview-foot">
                            <input type="text" id="previewCaption" placeholder="Add a caption...">
                            <button type="button" class="btn-send-chat" id="previewSend" aria-label="Send photos">
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
            var previewThumbs = document.getElementById('previewThumbs');
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

            function sizeText(bytes) {
                if (bytes > 1048576) return (bytes / 1048576).toFixed(1) + ' MB';
                return Math.max(1, Math.round(bytes / 1024)) + ' KB';
            }

            function activePane() {
                return document.querySelector('.chat-pane.active');
            }

            function activeBody() {
                const activePane = document.querySelector('.chat-pane.active');

                if (!activePane) {
                    return null;
                }

                return activePane.querySelector('.chat-body');
            }

            function activeContact() {
                return document.querySelector('.contact.active');
            }

            function isNearBottom(body) {
                return body.scrollHeight - body.scrollTop - body.clientHeight < 120;
            }

            function scrollBottom(body, smooth = false) {

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

            function loadContacts() {

                $.ajax({
                    url: "{{ route('loadContact') }}",
                    type: "GET",

                    success: function(response) {

                        let html = '';

                        $.each(response.users, function(index, user) {

                            console.log(user);

                            let name = user.employee?.full_name ?? '';
                            let profile = user.employee?.profile_url ?? '';

                            let latestMessage = null;
                            let latestParticipant = null;

                            user.conversation_participants.forEach(function(participant) {

                                let message = participant.conversation?.latest_message;

                                if (message && (!latestMessage ||
                                        new Date(message.created_at) > new Date(
                                            latestMessage.created_at))) {

                                    latestMessage = message;
                                    latestParticipant = participant;
                                }
                            });

                            let conversationId = latestParticipant?.conversation_id ?? '';
                            let messageText = latestMessage?.message ?? '';

                            let time = '';

                            if (latestMessage) {
                                time = new Date(latestMessage.created_at).toLocaleTimeString([], {
                                    hour: '2-digit',
                                    minute: '2-digit'
                                });
                            }

                            html += `
                    <div class="contact"
                        data-user-id="${user.id}"
                        data-conversation-id="${conversationId}"
                        data-name="${escapeHtml(name)}">

                        <img class="avatar online"
                            src="${escapeHtml(profile)}"
                            style="background:#2563eb">

                        <div class="contact-info">
                            <div class="contact-top">
                                <strong>${escapeHtml(name)}</strong>
                                <small>${time}</small>
                            </div>

                            <div class="contact-bottom">
                                <span class="preview">${escapeHtml(messageText)}</span>
                            </div>
                        </div>
                    </div>
                `;
                        });

                        // Display all contacts
                        $('#contacts').html(html);

                        // Automatically open first contact
                        let firstContact = $('#contacts .contact').first();

                        if (firstContact.length) {
                            openChat(firstContact[0]);
                        }
                    },

                    error: function(xhr) {
                        console.log(xhr.responseJSON || xhr.responseText);
                    }
                });
            }

            function escapeHtml(value) {
                return $('<div>').text(value ?? '').html();
            }


            //load chat

            $(document).ready(function() {
                loadContacts();
            });



            function openChat(contact) {

                // Remove active class from all contacts
                $('.contact').removeClass('active');

                // Add active class to selected contact
                $(contact).addClass('active');

                // Get selected user's details
                receiverId = $(contact).data('user-id');
                conversationId = $(contact).data('conversation-id');

                // Close other panels
                closePanels();
                resetNew();

                // Open chat panel
                app.classList.add('open');

                // Load selected user's chat
                loadChat(conversationId, receiverId);
            }

            function loadChat(conversationId, receiverId, target) {

                let chatContent = $('.panes');
                console.log("Reciver id", receiverId);
                $.ajax({
                    url: "{{ route('loadChat') }}",
                    type: "GET",
                    data: {
                        conversationId: conversationId,
                        receiverId: receiverId
                    },

                    success: function(response) {

                        let chatContent = $('.panes');

                        // Get user details even if there are no messages
                        let userName = response.user?.employee?.full_name || '';
                        let profileUrl = response.user?.employee?.profile_url || '';

                        // Create chat header and body first
                        let html = `
        <div class="chat-pane active" data-user-id="${receiverId}">

            <div class="chat-head">
                <i class="fas fa-arrow-left back"></i>

                <img class="avatar online"
                    src="${profileUrl}"
                    style="background:#2563eb">

                <div class="who">
                    <strong>${$('<div>').text(userName).html()}</strong>

                </div>
            </div>

            <div class="chat-body"></div>

        </div>
    `;

                        chatContent.find('.chat-pane').remove();

                        chatContent.prepend(html);

                        let body = chatContent.find('.chat-body');

                        // Display empty message if no messages exist
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

                            let messageType =
                                Number(message.sender_id) === {{ Auth::id() }} ?
                                'out' :
                                'in';

                            let time = messageDate.toLocaleTimeString([], {
                                hour: '2-digit',
                                minute: '2-digit'
                            });
                            let ticks = '';

                            if (messageType === 'out') {
                                ticks = message.is_read ?
                                    '<i class="fas fa-check-double read-tick"></i>' :
                                    '<i class="fas fa-check single-tick"></i>';
                            }
                            let messageText = $('<div>')
                                .text(message.message ?? '')
                                .html();

                            let messageHtml = `
            <div class="msg ${messageType}">
                <div class="bubble">
                    ${messageText}

                    <span class="meta">
                        ${time} ${ticks}
                    </span>
                </div>
            </div>
        `;

                            body.append(messageHtml);
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


            /* ---------- add a new outgoing message ---------- */
            function ensureToday(body) {
                var chips = body.querySelectorAll('.day-chip span');
                var last = chips.length ? chips[chips.length - 1].textContent : '';
                if (last !== 'Today') {
                    var chip = el('div', 'day-chip');
                    chip.appendChild(el('span', '', 'Today'));
                    body.appendChild(chip);
                }
            }

            function outRow(body) {
                var lastEl = body.lastElementChild;
                var first = !(lastEl && lastEl.classList.contains('msg') && lastEl.classList.contains('out'));
                return el('div', 'msg out' + (first ? ' first' : ''));
            }


            function appendRow(row) {
                var body = activeBody();
                body.appendChild(row);
                scrollBottom(body, true);
                resetNew();
            }

            function updateContact(previewNode) {
                var c = activeContact();
                c.querySelector('.contact-top small').textContent = nowTime();

                var pv = c.querySelector('.preview');
                pv.innerHTML = '';
                pv.appendChild(el('i', 'fas fa-check-double'));
                pv.appendChild(previewNode);

                // newest chat goes to the top (like WhatsApp)
                contactsEl.insertBefore(c, contactsEl.firstChild);
            }

            function sendText(text) {

                if (!receiverId) return;
                console.log("conversation id ", conversationId);
                console.log("reciver id", receiverId);

                $.ajax({
                    url: "{{ route('chatSend') }}",
                    type: "POST",
                    data: {
                        conversation_id: conversationId || null,
                        reciver_id: receiverId,
                        message: text,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.status === true) {
                            loadChat(response.conversation.id, receiverId);
                        }
                    }
                })
                // var body = activeBody();
                // ensureToday(body);

                // var row = outRow(body);
                // var bubble = el('div', 'bubble');
                // if (replyTo) bubble.appendChild(buildQuote(replyTo));
                // bubble.appendChild(document.createTextNode(text));
                // bubble.appendChild(tickMeta('meta'));
                // row.appendChild(bubble);

                // appendRow(row);
                // watchTicks(row);
                // updateContact(document.createTextNode(text));
                // cancelReply();

                // TODO (Laravel): post the message to the server here, e.g. fetch('/chat/send', {...})
            }

            // function sendImages(list, caption) {
            //     var body = activeBody();
            //     ensureToday(body);

            //     list.forEach(function(p, i) {
            //         var cap = i === 0 ? caption : '';
            //         var row = outRow(body);
            //         var bubble = el('div', 'bubble has-img');

            //         var wrap = el('div', 'img-wrap' + (cap ? '' : ' shade'));
            //         wrap.dataset.caption = cap;
            //         var img = document.createElement('img');
            //         img.src = p.url;
            //         img.alt = p.name;
            //         wrap.appendChild(img);

            //         if (!cap) wrap.appendChild(tickMeta('meta-over'));
            //         bubble.appendChild(wrap);

            //         if (cap) {
            //             var c = el('div', 'img-caption', cap);
            //             c.appendChild(tickMeta('meta'));
            //             bubble.appendChild(c);
            //         }

            //         row.appendChild(bubble);
            //         appendRow(row);
            //         watchTicks(row);
            //         body = activeBody();
            //     });

            //     var pv = document.createElement('span');
            //     pv.appendChild(el('i', 'fas fa-camera'));
            //     pv.appendChild(document.createTextNode(caption || 'Photo'));
            //     updateContact(pv);
            // }

            // function sendDoc(file) {
            //     var body = activeBody();
            //     ensureToday(body);

            //     var row = outRow(body);
            //     var bubble = el('div', 'bubble');

            //     var card = el('div', 'doc-card');
            //     card.appendChild(el('i', 'fas fa-file-lines ico'));
            //     var t = el('div');
            //     t.appendChild(el('div', 'name', file.name));
            //     t.appendChild(el('small', '', sizeText(file.size)));
            //     card.appendChild(t);

            //     bubble.appendChild(card);
            //     bubble.appendChild(tickMeta('meta'));
            //     row.appendChild(bubble);

            //     appendRow(row);
            //     watchTicks(row);

            //     var pv = document.createElement('span');
            //     pv.appendChild(el('i', 'fas fa-file-lines'));
            //     pv.appendChild(document.createTextNode(file.name));
            //     updateContact(pv);
            // }

            form.addEventListener('submit', function(e) {
                e.preventDefault();
                var text = input.value.trim();
                if (!text) return;
                sendText(text);
                input.value = '';
                emojiPanel.classList.remove('show');
            });

            /* ---------- scroll-down button ---------- */
            document.querySelectorAll('.chat-body').forEach(function(b) {
                b.addEventListener('scroll', function() {
                    if (b !== activeBody()) return;
                    if (isNearBottom(b)) {
                        resetNew();
                    } else {
                        scrollBtn.classList.add('show');
                    }
                });
            });

            scrollBtn.addEventListener('click', function() {
                scrollBottom(activeBody(), true);
                resetNew();
            });

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

            /* ---------- image pick, preview, send ---------- */
            function showPreview() {
                if (!pending.length) {
                    previewScreen.classList.remove('show');
                    return;
                }
                previewImg.src = pending[pendingIndex].url;

                previewThumbs.innerHTML = '';
                pending.forEach(function(p, i) {
                    var t = document.createElement('img');
                    t.src = p.url;
                    t.alt = p.name;
                    if (i === pendingIndex) t.className = 'active';
                    t.addEventListener('click', function() {
                        pendingIndex = i;
                        showPreview();
                    });
                    previewThumbs.appendChild(t);
                });
                previewScreen.classList.add('show');
            }

            function closePreview() {
                pending = [];
                previewScreen.classList.remove('show');
            }

            imgInput.addEventListener('change', function() {
                pending = [];
                pendingIndex = 0;

                Array.prototype.forEach.call(imgInput.files, function(f) {
                    if (f.type.indexOf('image/') === 0) {
                        pending.push({
                            url: URL.createObjectURL(f),
                            name: f.name
                        });
                    }
                });

                imgInput.value = '';
                attachMenu.classList.remove('show');
                previewCaption.value = '';
                showPreview();
                previewCaption.focus();
            });

            docInput.addEventListener('change', function() {
                if (!docInput.files.length) return;
                sendDoc(docInput.files[0]);
                docInput.value = '';
                attachMenu.classList.remove('show');
            });

            document.getElementById('previewClose').addEventListener('click', closePreview);

            document.getElementById('previewSend').addEventListener('click', function() {
                if (!pending.length) return;
                sendImages(pending, previewCaption.value.trim());
                closePreview();
            });

            previewCaption.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    document.getElementById('previewSend').click();
                }
            });

            /* ---------- lightbox (works for server-rendered images too) ---------- */
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
                    var ok = c.dataset.name.toLowerCase().indexOf(q) > -1;
                    if (filter === 'unread' && !c.querySelector('.unread')) ok = false;
                    if (filter === 'groups' && !c.dataset.group) ok = false;
                    c.style.display = ok ? '' : 'none';
                    if (ok) shown++;
                });

                noResult.style.display = shown ? 'none' : 'block';
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

            /* ---------- init ---------- */
            var first = document.querySelector('.contact.active');
            if (first) {
                var badge = first.querySelector('.unread');
                if (badge) badge.remove();
                first.classList.remove('has-unread');
            }
            scrollBottom(activeBody(), false);

            /* ============================================================
               WhatsApp-style message & chat actions (static front-end only)
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

            /* ---------- tiny helpers ---------- */
            function toast(msg) {
                toastEl.textContent = msg;
                toastEl.classList.add('show');
                clearTimeout(toastTimer);
                toastTimer = setTimeout(function() {
                    toastEl.classList.remove('show');
                }, 2200);
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
                var pane = document.getElementById(targetId);
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
                watchTicks(newRow);
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
                var tick = meta ? meta.querySelector('.tick') : null;
                var status = tick ? (tick.dataset.status || (tick.classList.contains('read') ? 'read' : 'sent')) : (
                    isOut ? 'read' : 'received');

                var statusText = status === 'sent' ? 'Sent' :
                    (status === 'delivered' ? 'Delivered' :
                        (isOut ? 'Read' : 'Received'));

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

            function buildQuote(ref) {
                var q = document.createElement('div');
                q.className = 'quote';
                q.innerHTML = '<i class="fas fa-reply q-ico"></i>';

                var t = document.createElement('div');
                t.className = 'q-txt';
                var who = document.createElement('span');
                who.className = 'q-who';
                who.textContent = ref.who;
                var bodyTxt = document.createElement('span');
                bodyTxt.className = 'q-body';
                bodyTxt.textContent = ref.text;
                t.appendChild(who);
                t.appendChild(bodyTxt);
                q.appendChild(t);

                q.addEventListener('click', function() {
                    if (ref.row && document.body.contains(ref.row)) {
                        ref.row.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                        ref.row.classList.add('flash');
                        setTimeout(function() {
                            ref.row.classList.remove('flash');
                        }, 1300);
                    }
                });
                return q;
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
                        if (anchor) {
                            b.insertBefore(n, anchor);
                        } else {
                            b.appendChild(n);
                        }
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
                    if (anchor) {
                        b.insertBefore(textNode, anchor);
                    } else {
                        b.appendChild(textNode);
                    }
                    row.dataset.edited = '1';
                    if (anchor && !anchor.querySelector('.edited-label')) {
                        var lbl = document.createElement('span');
                        lbl.className = 'edited-label';
                        lbl.textContent = 'edited · ';
                        anchor.insertBefore(lbl, anchor.firstChild);
                    }
                    pruneRow(row);
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

            function pruneRow() {
                /* no-op, kept for readability */
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
                        openAddParticipants(pane);
                    });
                } else {
                    addMenuItem('fas fa-circle-info', 'Contact info', function() {
                        chatInfo(pane, name);
                    });
                }

                addMenuItem('fas fa-list-check', 'Select messages', function() {
                    toast('Select messages — static demo');
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
                var contact = document.querySelector('.contact[data-target="' + pane.id + '"]');
                var wasActive = pane.classList.contains('active');
                pane.remove();
                if (contact) contact.remove();
                closePanels();
                toast('Chat deleted');

                if (wasActive) {
                    var next = document.querySelector('.contact');
                    if (next) openChat(next);
                }
            }

            /* ---------- employees & groups (static) ---------- */
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
                if (pane._group) return pane._group;

                var contact = document.querySelector('.contact[data-target="' + pane.id + '"]');
                if (!contact || contact.dataset.group !== '1') return null;

                var sub = pane.querySelector('.chat-head .who small');
                var members = [];
                (sub ? sub.textContent : '').split(',').forEach(function(n) {
                    n = n.trim();
                    if (!n) return;

                    /* the static groups list first names — map them to full employee names */
                    var full = n;
                    EMPLOYEES.forEach(function(e) {
                        if (full !== e.name &&
                            (e.name.toLowerCase() === n.toLowerCase() ||
                                e.name.split(' ')[0].toLowerCase() === n.toLowerCase())) {
                            full = e.name;
                        }
                    });

                    if (members.filter(function(m) {
                            return m.name === full;
                        }).length) return;

                    members.push(makeMember(full, full === 'You'));
                });
                if (!members.filter(function(m) {
                        return m.name === 'You';
                    }).length) {
                    members.push(makeMember('You', true));
                }

                var title = pane.querySelector('.chat-head .who strong');
                pane._group = {
                    name: title ? title.textContent.trim() : 'Group',
                    members: members
                };
                return pane._group;
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
                if (scrollBtnEl) {
                    panes.insertBefore(pane, scrollBtnEl);
                } else {
                    panes.appendChild(pane);
                }

                body.addEventListener('scroll', function() {
                    if (!pane.classList.contains('active')) return;
                    if (isNearBottom(body)) {
                        resetNew();
                    } else {
                        scrollBtn.classList.add('show');
                    }
                });

                decorateAll();
                openChat(contact);
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

                if (mode === 'info') {
                    hint.textContent = 'Participants';

                    var list = document.createElement('div');
                    g.members.forEach(function(m) {
                        list.appendChild(memberRow(m));
                    });
                    wrap.appendChild(list);

                    actions = [{
                        icon: 'fas fa-xmark',
                        label: 'Close',
                        onClick: closeModal
                    }];
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
                        },
                        {
                            icon: 'fas fa-xmark',
                            label: 'Close',
                            onClick: closeModal
                        }
                    ];
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
                        },
                        {
                            icon: 'fas fa-xmark',
                            label: 'Close',
                            onClick: closeModal
                        }
                    ];
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
                                if (dismissed.length) addSystemMessage(pane, 'You dismissed ' +
                                    dismissed.join(', ') + ' as group admin(s)');

                                syncGroup(pane);
                                toast('Admin changes saved');
                                openGroupInfo(pane, 'admins');
                            }
                        },
                        {
                            icon: 'fas fa-xmark',
                            label: 'Close',
                            onClick: closeModal
                        }
                    ];
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

            function openAddParticipants(pane) {
                openGroupInfo(pane, 'add');
            }
            document.getElementById('newGroupBtn').addEventListener('click', openNewGroup);

            /* ---------- decorate messages & headers ---------- */
            function decorateRow(row) {
                var b = bubbleOf(row);
                if (!b) return;

                // normalizeTick(row);

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

                [
                    ['fas fa-magnifying-glass', 'Search in chat']
                ].forEach(function(item) {
                    var btn = document.createElement('button');
                    btn.type = 'button';
                    btn.title = item[1];
                    btn.innerHTML = '<i class="' + item[0] + '"></i>';
                    btn.addEventListener('click', function() {
                        toast(item[1] + ' — static demo');
                    });
                    actions.appendChild(btn);
                });

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

            document.querySelectorAll('.chat-body').forEach(function(b) {
                b.addEventListener('scroll', closeMsgMenu);
            });
            window.addEventListener('resize', closeMsgMenu);

        })();
    </script>

</body>

</html>
