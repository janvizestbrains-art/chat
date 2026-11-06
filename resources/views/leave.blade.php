<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaves | HVAC Employee Portal</title>

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

        .leave-card {
            position: relative;
            background: #fff;
            border: 1px solid var(--border);
            border-left: 4px solid transparent;
            border-radius: 14px;
            padding: 18px 20px;
            margin-bottom: 14px;
            display: flex;
            gap: 16px;
            align-items: flex-start;
            transition: all .25s ease;
        }

        .leave-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 28px rgba(15, 23, 42, .10);
        }

        .leave-card.approved {
            border-left-color: #10b981;
        }

        .leave-card.pending {
            border-left-color: #f59e0b;
        }

        .leave-card.rejected {
            border-left-color: #ef4444;
        }

        .leave-icon {
            width: 48px;
            height: 48px;
            min-width: 48px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 19px;
            color: #fff;
        }

        .icon-approved {
            background: linear-gradient(135deg, #34d399, #059669);
        }

        .icon-pending {
            background: linear-gradient(135deg, #fbbf24, #ea580c);
        }

        .icon-rejected {
            background: linear-gradient(135deg, #f87171, #dc2626);
        }

        .leave-content {
            flex: 1;
        }

        .leave-content h6 {
            font-size: 15.5px;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .leave-content p {
            font-size: 13.5px;
            color: var(--muted);
            margin-bottom: 10px;
            line-height: 1.6;
        }

        .leave-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
            font-size: 12.5px;
            color: #94a3b8;
        }

        .leave-meta span {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .status-pill {
            font-size: 11.5px;
            font-weight: 600;
            padding: 4px 12px;
            border-radius: 20px;
            white-space: nowrap;
        }

        .pill-approved {
            background: #d1fae5;
            color: #065f46;
        }

        .pill-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .pill-rejected {
            background: #fee2e2;
            color: #991b1b;
        }

        .modal-content {
            border: 0;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 25px 60px rgba(15, 23, 42, .25);
        }

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

        .input-icon {
            position: relative;
        }

        .input-icon i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 14px;
            pointer-events: none;
        }

        .input-icon .form-control {
            padding-left: 40px;
        }

        .char-count {
            font-size: 12px;
            color: #94a3b8;
            text-align: right;
            margin-top: 4px;
        }

        .days-summary {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 18px;
            border-radius: 12px;
            background: #eff6ff;
            border: 1px dashed #93c5fd;
            margin-bottom: 22px;
        }

        .days-summary .badge-days {
            width: 46px;
            height: 46px;
            border-radius: 12px;
            background: linear-gradient(135deg, #60a5fa, #2563eb);
            color: #fff;
            font-weight: 700;
            font-size: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .days-summary strong {
            display: block;
            font-size: 14px;
        }

        .days-summary small {
            color: var(--muted);
            font-size: 12.5px;
        }

        .modal-footer-custom {
            flex-shrink: 0;
            padding: 16px 26px;
            background: #f8fafc;
            border-top: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: flex-end;
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
            box-shadow: 0 6px 16px rgba(37, 99, 235, .35);
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-send:hover {
            color: #fff;
            box-shadow: 0 10px 22px rgba(37, 99, 235, .45);
        }

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

        .toast-error {
            background: #dc2626;
            color: #fff;
            border: 0;
            border-radius: 12px;
            box-shadow: 0 10px 28px rgba(220, 38, 38, .35);
        }

        /* Form validation */
        .validation-error {
            display: none;
            color: #dc2626;
            font-size: 13px;
            margin-top: 5px;
        }

        .form-control.is-invalid {
            border-color: #dc3545;
        }

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

            .leave-card {
                padding: 14px;
                gap: 12px;
                flex-wrap: wrap;
            }

            .leave-icon {
                width: 40px;
                height: 40px;
                min-width: 40px;
                font-size: 16px;
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

    @include('layouts.header')

    <main class="main">

        <div class="topbar">
            <div>
                <h4>My Leaves</h4>
                <p>Track your leave requests and apply for new leave.</p>
            </div>

            <button type="button" class="btn-create" data-bs-toggle="modal" data-bs-target="#applyLeaveModal">
                <i class="fas fa-calendar-plus"></i>
                <span>Apply Leave</span>
            </button>
        </div>

        <div class="content">

            <div id="leaveList">

                @forelse ($leaves as $leave)
                    @php
                        $status = strtolower($leave->status);
                    @endphp

                    <div class="leave-card {{ $status }}">

                        <div class="leave-icon icon-{{ $status }}">
                            @if ($status === 'approved')
                                <i class="fas fa-check"></i>
                            @elseif ($status === 'rejected')
                                <i class="fas fa-xmark"></i>
                            @else
                                <i class="fas fa-hourglass-half"></i>
                            @endif
                        </div>

                        <div class="leave-content">

                            <h6>
                                {{ \Carbon\Carbon::parse($leave->from_date)->format('d M Y') }}
                                &rarr;
                                {{ \Carbon\Carbon::parse($leave->to_date)->format('d M Y') }}
                            </h6>

                            <p>Reason: {{ $leave->reason }}</p>

                            <div class="leave-meta">
                                <span>
                                    <i class="far fa-clock"></i>
                                    Applied {{ $leave->created_at->diffForHumans() }}
                                </span>
                            </div>

                        </div>

                        <span class="status-pill pill-{{ $status }}">
                            {{ ucfirst($status) }}
                        </span>

                    </div>

                @empty

                    <div class="text-center text-muted py-5">
                        <i class="fas fa-calendar-xmark fa-2x mb-3"></i>
                        <p>No leave requests found.</p>
                    </div>
                @endforelse

            </div>

        </div>

    </main>

    <!-- Apply Leave Modal -->

    <div class="modal fade" id="applyLeaveModal" tabindex="-1" aria-labelledby="applyLeaveLabel" aria-hidden="true">

        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">

            <div class="modal-content">

                <div class="modal-header-custom">

                    <div class="title-wrap">

                        <div class="title-icon">
                            <i class="fas fa-calendar-plus"></i>
                        </div>

                        <div>
                            <h5 id="applyLeaveLabel">Apply Leave</h5>
                            <small>Select your leave dates and write the reason.</small>
                        </div>

                    </div>

                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>

                </div>

                <form id="leaveForm" method="POST" action="{{ route('applyLeave') }}" novalidate>

                    @csrf

                    <div class="modal-body">

                        <div class="row g-3 mb-3">

                            <!-- From Date -->

                            <div class="col-md-6">

                                <label for="fromDate" class="form-label">
                                    From Date <span class="text-danger">*</span>
                                </label>

                                <div class="input-icon">

                                    <i class="far fa-calendar-alt"></i>

                                    <input type="date" class="form-control @error('from_date') is-invalid @enderror"
                                        id="fromDate" name="from_date" value="{{ old('from_date') }}">

                                </div>

                                <div class="validation-error" id="fromDateError">
                                    @error('from_date')
                                        {{ $message }}
                                    @else
                                        Please select a valid start date.
                                    @enderror
                                </div>

                            </div>

                            <!-- To Date -->

                            <div class="col-md-6">

                                <label for="toDate" class="form-label">
                                    To Date <span class="text-danger">*</span>
                                </label>

                                <div class="input-icon">

                                    <i class="far fa-calendar-check"></i>

                                    <input type="date" class="form-control @error('to_date') is-invalid @enderror"
                                        id="toDate" name="to_date" value="{{ old('to_date') }}">

                                </div>

                                <div class="validation-error" id="toDateError">
                                    @error('to_date')
                                        {{ $message }}
                                    @else
                                        Please select an end date.
                                    @enderror
                                </div>

                            </div>

                        </div>

                        <!-- Total Days -->

                        <div class="days-summary">

                            <div class="badge-days" id="totalDays">0</div>

                            <div>
                                <strong>Total Leave Days</strong>

                                <small id="daysText">
                                    Select both dates to see the duration.
                                </small>
                            </div>

                        </div>

                        <!-- Reason -->

                        <div>

                            <label for="reason" class="form-label">
                                Reason <span class="text-danger">*</span>
                            </label>

                            <textarea class="form-control @error('reason') is-invalid @enderror" id="reason" name="reason" rows="4"
                                minlength="3" maxlength="300" placeholder="Write the reason for your leave...">{{ old('reason') }}</textarea>

                            <div class="char-count">
                                <span id="reasonCount">0</span>/300
                            </div>

                            <div class="validation-error" id="reasonError">
                                @error('reason')
                                    {{ $message }}
                                @else
                                    Please enter a valid reason.
                                @enderror
                            </div>

                        </div>

                    </div>

                    <div class="modal-footer-custom">

                        <button type="button" class="btn-cancel" data-bs-dismiss="modal">
                            Cancel
                        </button>

                        <button type="submit" class="btn-send" id="submitLeave">
                            <i class="fas fa-paper-plane"></i>
                            Submit Request
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

    <!-- Toast: Laravel messages only -->

    <div class="toast-wrap">

        <div id="messageToast" class="toast align-items-center" role="alert" aria-live="assertive"
            aria-atomic="true" data-bs-delay="3000">

            <div class="d-flex">

                <div class="toast-body">
                    <i id="toastIcon" class="fas me-2"></i>
                    <span id="toastMessage"></span>
                </div>

                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>

            </div>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        (function() {

            const modalEl = document.getElementById('applyLeaveModal');
            const form = document.getElementById('leaveForm');

            const fromDate = document.getElementById('fromDate');
            const toDate = document.getElementById('toDate');
            const reason = document.getElementById('reason');

            const reasonCount = document.getElementById('reasonCount');
            const totalDays = document.getElementById('totalDays');
            const daysText = document.getElementById('daysText');

            const fromDateError = document.getElementById('fromDateError');
            const toDateError = document.getElementById('toDateError');
            const reasonError = document.getElementById('reasonError');

            const submitButton = document.getElementById('submitLeave');

            // Today's date

            function getToday() {

                const now = new Date();

                const year = now.getFullYear();
                const month = String(now.getMonth() + 1).padStart(2, '0');
                const day = String(now.getDate()).padStart(2, '0');

                return `${year}-${month}-${day}`;
            }

            const today = getToday();

            fromDate.min = today;
            toDate.min = today;


            // Toast function for Laravel messages only

            function showToast(message, type = 'success') {

                const toastElement = document.getElementById('messageToast');
                const toastMessage = document.getElementById('toastMessage');
                const toastIcon = document.getElementById('toastIcon');

                toastMessage.textContent = message;

                toastElement.classList.remove('toast-success', 'toast-error');

                if (type === 'success') {

                    toastElement.classList.add('toast-success');
                    toastIcon.className = 'fas fa-check-circle me-2';

                } else {

                    toastElement.classList.add('toast-error');
                    toastIcon.className = 'fas fa-exclamation-circle me-2';

                }

                bootstrap.Toast.getOrCreateInstance(toastElement).show();
            }


            // Display error below the input

            function showError(field, errorElement, message) {

                field.classList.add('is-invalid');

                errorElement.textContent = message;
                errorElement.style.display = 'block';
            }


            // Remove error from the input

            function clearError(field, errorElement) {

                field.classList.remove('is-invalid');

                errorElement.style.display = 'none';
            }


            // Clear all errors

            function clearAllErrors() {

                clearError(fromDate, fromDateError);
                clearError(toDate, toDateError);
                clearError(reason, reasonError);
            }


            // Character counter

            function updateReasonCount() {

                reasonCount.textContent = reason.value.length;
            }

            reason.addEventListener('input', function() {

                updateReasonCount();

                const value = reason.value.trim();

                if (value.length >= 3 && reason.value.length <= 300) {

                    clearError(reason, reasonError);

                } else if (value.length > 0) {

                    showError(
                        reason,
                        reasonError,
                        'Reason must contain at least 3 characters.'
                    );

                } else {

                    clearError(reason, reasonError);

                }
            });

            updateReasonCount();


            // Calculate total leave days

            function calcDays() {

                toDate.min = fromDate.value || today;

                if (
                    fromDate.value &&
                    toDate.value &&
                    toDate.value >= fromDate.value
                ) {

                    const start = new Date(fromDate.value + 'T00:00:00');
                    const end = new Date(toDate.value + 'T00:00:00');

                    const diff = Math.round(
                        (end - start) / 86400000
                    ) + 1;

                    totalDays.textContent = diff;

                    daysText.textContent =
                        diff + (diff === 1 ? ' day' : ' days') +
                        ' of leave selected.';

                    return diff;
                }

                totalDays.textContent = '0';

                daysText.textContent =
                    'Select both dates to see the duration.';

                return 0;
            }


            // Validate From Date

            function validateFromDate() {

                if (!fromDate.value) {

                    showError(
                        fromDate,
                        fromDateError,
                        'Please select your start date.'
                    );

                    return false;
                }

                if (fromDate.value < today) {

                    showError(
                        fromDate,
                        fromDateError,
                        'Past dates are not allowed.'
                    );

                    return false;
                }

                clearError(fromDate, fromDateError);

                return true;
            }


            // Validate To Date

            function validateToDate() {

                if (!toDate.value) {

                    showError(
                        toDate,
                        toDateError,
                        'Please select your end date.'
                    );

                    return false;
                }

                if (toDate.value < today) {

                    showError(
                        toDate,
                        toDateError,
                        'Past dates are not allowed.'
                    );

                    return false;
                }

                if (fromDate.value && toDate.value < fromDate.value) {

                    showError(
                        toDate,
                        toDateError,
                        'End date cannot be before start date.'
                    );

                    return false;
                }

                clearError(toDate, toDateError);

                return true;
            }


            // Validate Reason

            function validateReason() {

                const trimmedReason = reason.value.trim();

                if (!trimmedReason) {

                    showError(
                        reason,
                        reasonError,
                        'Please enter your leave reason.'
                    );

                    return false;
                }

                if (trimmedReason.length < 3) {

                    showError(
                        reason,
                        reasonError,
                        'Reason must contain at least 3 characters.'
                    );

                    return false;
                }

                if (reason.value.length > 300) {

                    showError(
                        reason,
                        reasonError,
                        'Reason cannot exceed 300 characters.'
                    );

                    return false;
                }

                clearError(reason, reasonError);

                return true;
            }


            // From Date Change

            fromDate.addEventListener('change', function() {

                validateFromDate();

                if (toDate.value && toDate.value < fromDate.value) {

                    toDate.value = '';

                    showError(
                        toDate,
                        toDateError,
                        'End date cannot be before start date.'
                    );

                } else if (toDate.value) {

                    validateToDate();
                }

                calcDays();
            });


            // To Date Change

            toDate.addEventListener('change', function() {

                validateToDate();

                calcDays();
            });


            // Form Submit

            form.addEventListener('submit', function(e) {

                clearAllErrors();

                const fromValid = validateFromDate();
                const toValid = validateToDate();
                const reasonValid = validateReason();

                const daysValid = calcDays() > 0;

                if (!daysValid && fromValid && toValid) {

                    showError(
                        toDate,
                        toDateError,
                        'Please select valid leave dates.'
                    );
                }

                const isValid =
                    fromValid &&
                    toValid &&
                    reasonValid &&
                    daysValid;

                // If invalid, stop submission.
                // Validation messages appear below the fields.

                if (!isValid) {

                    e.preventDefault();

                    const firstInvalid = form.querySelector('.is-invalid');

                    if (firstInvalid) {
                        firstInvalid.focus();
                    }

                    return;
                }

                // Prevent multiple submissions

                submitButton.disabled = true;

                submitButton.innerHTML =
                    '<i class="fas fa-spinner fa-spin"></i> Submitting...';
            });


            // Reset modal after closing

            modalEl.addEventListener('hidden.bs.modal', function() {

                form.reset();

                clearAllErrors();

                updateReasonCount();

                totalDays.textContent = '0';

                daysText.textContent =
                    'Select both dates to see the duration.';

                fromDate.min = today;
                toDate.min = today;

                submitButton.disabled = false;

                submitButton.innerHTML =
                    '<i class="fas fa-paper-plane"></i> Submit Request';
            });


            // Initial calculation

            calcDays();


            // Laravel success message

            @if (session('success'))
                showToast(@json(session('success')), 'success');
            @endif


            // Laravel general error message

            @if (session('error'))
                showToast(@json(session('error')), 'error');
            @endif


            // Laravel validation errors

            @if ($errors->any())

                // Reopen modal when server-side validation fails

                bootstrap.Modal.getOrCreateInstance(modalEl).show();

                // Display server-side errors below the correct fields

                @if ($errors->has('from_date'))
                    showError(
                        fromDate,
                        fromDateError,
                        @json($errors->first('from_date'))
                    );
                @endif

                @if ($errors->has('to_date'))
                    showError(
                        toDate,
                        toDateError,
                        @json($errors->first('to_date'))
                    );
                @endif

                @if ($errors->has('reason'))
                    showError(
                        reason,
                        reasonError,
                        @json($errors->first('reason'))
                    );
                @endif
            @endif

        })();
    </script>

</body>

</html>
