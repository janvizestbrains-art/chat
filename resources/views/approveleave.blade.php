<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approve Leaves | HVAC Employee Portal</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --sidebar-w: 260px;
            --primary: #2563eb;
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

        .content {
            padding: 28px 32px;
            max-width: 1150px;
        }

        .stats-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 13px;
            padding: 17px;
            display: flex;
            align-items: center;
            gap: 13px;
        }

        .stat-icon {
            width: 43px;
            height: 43px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 17px;
        }

        .stat-icon.total {
            background: #dbeafe;
            color: #2563eb;
        }

        .stat-icon.pending {
            background: #fef3c7;
            color: #d97706;
        }

        .stat-icon.approved {
            background: #d1fae5;
            color: #059669;
        }

        .stat-icon.rejected {
            background: #fee2e2;
            color: #dc2626;
        }

        .stat-card strong {
            display: block;
            font-size: 21px;
            line-height: 1.2;
        }

        .stat-card small {
            color: var(--muted);
            font-size: 12px;
        }

        .filter-card {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 13px;
            padding: 16px;
            margin-bottom: 20px;
        }

        .form-control,
        .form-select {
            border: 1px solid var(--border);
            border-radius: 9px;
            padding: 10px 13px;
            font-size: 13.5px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, .1);
        }

        .leave-card {
            background: #fff;
            border: 1px solid var(--border);
            border-left: 4px solid #f59e0b;
            border-radius: 14px;
            padding: 19px 20px;
            margin-bottom: 14px;
            transition: all .2s ease;
        }

        .leave-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(15, 23, 42, .08);
        }

        .leave-card.approved {
            border-left-color: #10b981;
        }

        .leave-card.rejected {
            border-left-color: #ef4444;
        }

        .employee-info {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 14px;
        }

        .employee-avatar {
            width: 43px;
            height: 43px;
            border-radius: 50%;
            background: #dbeafe;
            color: #2563eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 14px;
        }

        .employee-info h6 {
            margin: 0 0 3px;
            font-size: 14px;
            font-weight: 700;
        }

        .employee-info small {
            color: var(--muted);
            font-size: 12px;
        }

        .leave-details {
            display: flex;
            flex-wrap: wrap;
            gap: 22px;
            margin-bottom: 12px;
        }

        .detail-item {
            font-size: 13px;
            color: var(--muted);
        }

        .detail-item i {
            color: #64748b;
            margin-right: 6px;
        }

        .reason-text {
            background: #f8fafc;
            padding: 11px 13px;
            border-radius: 9px;
            font-size: 13px;
            color: #475569;
            margin-bottom: 14px;
        }

        .status-pill {
            font-size: 11.5px;
            font-weight: 600;
            padding: 5px 12px;
            border-radius: 20px;
            white-space: nowrap;
        }

        .pill-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .pill-approved {
            background: #d1fae5;
            color: #065f46;
        }

        .pill-rejected {
            background: #fee2e2;
            color: #991b1b;
        }

        .action-buttons {
            display: flex;
            gap: 9px;
            justify-content: flex-end;
        }

        .btn-approve,
        .btn-reject {
            border: 0;
            padding: 8px 15px;
            border-radius: 8px;
            font-size: 12.5px;
            font-weight: 600;
        }

        .btn-approve {
            background: #d1fae5;
            color: #047857;
        }

        .btn-approve:hover {
            background: #a7f3d0;
        }

        .btn-reject {
            background: #fee2e2;
            color: #dc2626;
        }

        .btn-reject:hover {
            background: #fecaca;
        }

        .btn-approve:disabled,
        .btn-reject:disabled {
            opacity: .5;
            cursor: not-allowed;
        }

        .modal-content {
            border: 0;
            border-radius: 16px;
            overflow: hidden;
        }

        .modal-header-custom {
            background: linear-gradient(135deg, #1e3a8a, #2563eb);
            color: #fff;
            padding: 19px 24px;
        }

        .modal-body {
            padding: 24px;
        }

        .modal-footer-custom {
            padding: 15px 24px;
            background: #f8fafc;
            border-top: 1px solid var(--border);
        }

        .btn-confirm-reject {
            border: 0;
            background: #dc2626;
            color: #fff;
            padding: 9px 19px;
            border-radius: 9px;
            font-size: 13px;
            font-weight: 600;
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
        }

        .toast-error {
            background: #dc2626;
            color: #fff;
            border: 0;
            border-radius: 12px;
        }

        @media (max-width: 992px) {
            :root {
                --sidebar-w: 78px;
            }

            .stats-row {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 576px) {

            .topbar,
            .content {
                padding-left: 15px;
                padding-right: 15px;
            }

            .stats-row {
                grid-template-columns: 1fr 1fr;
            }

            .leave-card {
                padding: 15px;
            }

            .action-buttons {
                justify-content: flex-start;
            }

            .leave-details {
                gap: 10px;
            }
        }
    </style>
</head>

<body>

    @include('layouts.header')

    <main class="main">

        <div class="topbar">
            <div>
                <h4>Approve Leaves</h4>
                <p>Review employee leave requests and manage approvals.</p>
            </div>
        </div>

        <div class="content">

            <!-- Statistics -->

            <div class="stats-row">

                <div class="stat-card">
                    <div class="stat-icon total"><i class="fas fa-calendar-days"></i></div>
                    <div>
                        <strong id="totalCount">5</strong>
                        <small>Total Requests</small>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon pending"><i class="fas fa-clock"></i></div>
                    <div>
                        <strong id="pendingCount">3</strong>
                        <small>Pending</small>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon approved"><i class="fas fa-check-circle"></i></div>
                    <div>
                        <strong id="approvedCount">1</strong>
                        <small>Approved</small>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon rejected"><i class="fas fa-xmark-circle"></i></div>
                    <div>
                        <strong id="rejectedCount">1</strong>
                        <small>Rejected</small>
                    </div>
                </div>

            </div>

            <!-- Search and Filter -->

            <!-- Leave Requests -->

            <div id="leaveList">
                @forelse ($leaves as $leave)
                    <div class="leave-card pending" data-name="rahul patel" data-status="pending">

                        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">

                            <div class="employee-info">
                                <div class="employee-avatar">RP</div>
                                <div>
                                    <h6>{{ $leave->user->employee->full_name }}</h6>
                                    <small>{{ $leave->user->employee->employee_code }} ·
                                        {{ $leave->user->employee->designation }}</small>
                                </div>
                            </div>

                            <span class="status-pill pill-pending">{{ $leave->status }}</span>

                        </div>

                        <div class="leave-details">
                            <div class="detail-item">
                                <i class="far fa-calendar"></i> {{ $leave->from_date }} - {{ $leave->end_date }}
                            </div>

                            <div class="detail-item">
                                <i class="far fa-clock"></i>{{ $leave->created_at->diffforHumans() }}
                            </div>
                        </div>

                        <div class="reason-text">
                            <strong>Reason:</strong> {{ $leave->reason }}
                        </div>

                        <div class="action-buttons">
                            <button class="btn-approve" onclick="approveLeave(this)">
                                <i class="fas fa-check me-1"></i> Approve
                            </button>
                            <button class="btn-reject" onclick="openRejectModal(this)">
                                <i class="fas fa-xmark me-1"></i> Reject
                            </button>
                        </div>

                    </div>
                @empty
                    <div id="emptyState" class="text-center text-muted py-5 d-none">
                        <i class="fas fa-calendar-xmark fa-2x mb-3"></i>
                        <p>No leave requests found.</p>
                @endforelse
            </div>
        </div>

        </div>

    </main>

    <!-- Reject Leave Modal -->

    <div class="modal fade" id="rejectModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header-custom d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-1">Reject Leave Request</h5>
                        <small class="text-white-50">Please provide a reason for rejection.</small>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <label class="form-label fw-semibold" for="rejectReason">
                        Rejection Reason <span class="text-danger">*</span>
                    </label>

                    <textarea class="form-control" id="rejectReason" rows="4" maxlength="300"
                        placeholder="Enter the reason for rejecting this leave..."></textarea>

                    <div class="text-end text-muted small mt-1">
                        <span id="rejectCount">0</span>/300
                    </div>

                    <div class="invalid-feedback" id="rejectError">
                        Please enter a rejection reason.
                    </div>

                </div>

                <div class="modal-footer-custom d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-light border" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="button" class="btn-confirm-reject" id="confirmReject">
                        <i class="fas fa-xmark me-1"></i> Reject Leave
                    </button>
                </div>

            </div>
        </div>
    </div>

    <!-- Toast -->

    <div class="toast-wrap">
        <div id="messageToast" class="toast align-items-center" role="alert" aria-live="assertive" aria-atomic="true"
            data-bs-delay="3000">
            <div class="d-flex">
                <div class="toast-body">
                    <i id="toastIcon" class="fas me-2"></i>
                    <span id="toastMessage"></span>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        let selectedLeaveCard = null;

        const rejectModalElement = document.getElementById('rejectModal');
        const rejectModal = bootstrap.Modal.getOrCreateInstance(rejectModalElement);

        const rejectReason = document.getElementById('rejectReason');
        const rejectCount = document.getElementById('rejectCount');

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

        function updateCounts() {
            const cards = [...document.querySelectorAll('.leave-card')];

            document.getElementById('totalCount').textContent = cards.length;
            document.getElementById('pendingCount').textContent =
                cards.filter(card => card.dataset.status === 'pending').length;
            document.getElementById('approvedCount').textContent =
                cards.filter(card => card.dataset.status === 'approved').length;
            document.getElementById('rejectedCount').textContent =
                cards.filter(card => card.dataset.status === 'rejected').length;
        }

        function filterLeaves() {
            const search = document.getElementById('searchInput').value.toLowerCase().trim();
            const status = document.getElementById('statusFilter').value;

            let visibleCount = 0;

            document.querySelectorAll('.leave-card').forEach(card => {
                const matchesName = card.dataset.name.includes(search);
                const matchesStatus = status === 'all' || card.dataset.status === status;
                const visible = matchesName && matchesStatus;

                card.classList.toggle('d-none', !visible);

                if (visible) visibleCount++;
            });

            document.getElementById('emptyState').classList.toggle('d-none', visibleCount !== 0);
        }

        function approveLeave(button) {
            const card = button.closest('.leave-card');

            if (card.dataset.status !== 'pending') return;

            if (!confirm('Are you sure you want to approve this leave request?')) return;

            card.dataset.status = 'approved';
            card.classList.remove('pending');
            card.classList.add('approved');

            const pill = card.querySelector('.status-pill');
            pill.className = 'status-pill pill-approved';
            pill.textContent = 'Approved';

            card.querySelector('.action-buttons').innerHTML = `
                <small class="text-success fw-semibold">
                    <i class="fas fa-check-circle me-1"></i> Leave approved
                </small>
            `;

            updateCounts();
            filterLeaves();
            showToast('Leave request approved successfully.');
        }

        function openRejectModal(button) {
            const card = button.closest('.leave-card');

            if (card.dataset.status !== 'pending') return;

            selectedLeaveCard = card;
            rejectReason.value = '';
            rejectCount.textContent = '0';
            rejectReason.classList.remove('is-invalid');

            rejectModal.show();
        }

        rejectReason.addEventListener('input', function() {
            rejectCount.textContent = rejectReason.value.length;
            rejectReason.classList.remove('is-invalid');
        });

        document.getElementById('confirmReject').addEventListener('click', function() {
            const reason = rejectReason.value.trim();

            if (!reason) {
                rejectReason.classList.add('is-invalid');
                showToast('Please enter a rejection reason.', 'error');
                rejectReason.focus();
                return;
            }

            if (!selectedLeaveCard) return;

            selectedLeaveCard.dataset.status = 'rejected';
            selectedLeaveCard.classList.remove('pending');
            selectedLeaveCard.classList.add('rejected');

            const pill = selectedLeaveCard.querySelector('.status-pill');
            pill.className = 'status-pill pill-rejected';
            pill.textContent = 'Rejected';

            const reasonBox = selectedLeaveCard.querySelector('.reason-text');
            reasonBox.innerHTML += `
                <hr>
                <strong class="text-danger">Rejection Reason:</strong>
                ${escapeHtml(reason)}
            `;

            selectedLeaveCard.querySelector('.action-buttons').remove();

            rejectModal.hide();
            updateCounts();
            filterLeaves();
            showToast('Leave request rejected successfully.');

            selectedLeaveCard = null;
        });

        function escapeHtml(value) {
            const div = document.createElement('div');
            div.textContent = value;
            return div.innerHTML;
        }

        document.getElementById('searchInput').addEventListener('input', filterLeaves);
        document.getElementById('statusFilter').addEventListener('change', filterLeaves);

        document.getElementById('resetFilter').addEventListener('click', function() {
            document.getElementById('searchInput').value = '';
            document.getElementById('statusFilter').value = 'pending';
            filterLeaves();
        });

        updateCounts();
        filterLeaves();
    </script>

</body>

</html>
