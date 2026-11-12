@extends('admin.layouts.app')

@section('title', 'Student Payments - ' . $student->student_name . ' - Schoolwala')

@section('content')

<style>
  .student-avatar {
    width: 64px;
    height: 64px;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 26px;
    font-weight: 700;
  }
  .payment-stat-card {
    border-radius: 10px;
    border: none;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.06);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
  }
  .payment-stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  }
  .stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 8px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
  }
  .table-payments th {
    font-size: 0.78rem;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    white-space: nowrap;
    vertical-align: middle;
  }
  .table-payments td {
    vertical-align: middle;
    font-size: 0.88rem;
  }
  .sticky-action {
    position: sticky;
    right: 0;
    background-color: #ffffff;
    box-shadow: -4px 0 8px rgba(0, 0, 0, 0.04);
    z-index: 2;
  }
  thead th.sticky-action {
    background-color: #f5f5f9 !important;
    z-index: 3;
  }
  tbody tr:hover .sticky-action {
    background-color: #f8f9fa !important;
  }
  .modal-section-title {
    font-size: 0.82rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.6px;
    color: #696cff;
    border-bottom: 2px solid #eceef1;
    padding-bottom: 6px;
    margin-bottom: 12px;
  }
  .pagination-container .pagination {
    margin: 0;
    gap: 4px;
    display: flex;
    align-items: center;
  }
  .pagination-container .page-item .page-link {
    border-radius: 6px !important;
    padding: 6px 12px;
    font-size: 0.85rem;
    font-weight: 500;
    color: #566a7f;
    border: 1px solid #d9dee3;
    line-height: 1.2;
    display: inline-flex;
    align-items: center;
    justify-content: center;
  }
  .pagination-container .page-item.active .page-link {
    background-color: #696cff !important;
    border-color: #696cff !important;
    color: #ffffff !important;
  }
  .pagination-container .page-item.disabled .page-link {
    color: #b4bdc6;
    background-color: #f5f5f9;
    border-color: #e4e6ea;
  }
  .pagination-container svg {
    display: none !important;
  }
</style>

<!-- Breadcrumb / Header -->
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
  <div>
    <h4 class="fw-bold py-1 mb-1">
      <span class="text-muted fw-light">Students / <a href="{{ route('admin.admin-students') }}">All Students</a> /</span>
      {{ $student->student_name }} - Payments
    </h4>
    <p class="text-muted mb-0 small">
      Detailed payment history, transactions, and Excel download for this student
    </p>
  </div>
  <div class="d-flex gap-2 flex-wrap">
    <a href="{{ route('admin.admin-students') }}" class="btn btn-outline-secondary">
      <i class="bx bx-arrow-back me-1"></i> Back to Students
    </a>
    <a href="{{ route('admin.admin-student.payments.export', array_merge(['id' => $student->id], request()->all(), ['format' => 'xlsx'])) }}" class="btn btn-success">
      <i class="bx bx-file me-1"></i> Export Excel
    </a>
    <a href="{{ route('admin.admin-student.payments.export', array_merge(['id' => $student->id], request()->all(), ['format' => 'csv'])) }}" class="btn btn-info">
      <i class="bx bx-download me-1"></i> Export CSV
    </a>
  </div>
</div>

<!-- Student Profile Card -->
<div class="card mb-4">
  <div class="card-body">
    <div class="row align-items-center">
      <div class="col-lg-7 d-flex align-items-center mb-3 mb-lg-0">
        <div class="student-avatar bg-primary text-white me-3 flex-shrink-0">
          {{ strtoupper(substr($student->student_name ?? 'S', 0, 1)) }}
        </div>
        <div>
          <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
            <h4 class="mb-0 fw-bold">{{ $student->student_name }}</h4>
            <span class="badge bg-label-danger fs-6 fw-bold">
              {{ $student->student_id }}
            </span>
            <span class="badge bg-label-primary fs-6">
              {{ $student->classes->name ?? 'Class N/A' }}
            </span>
            <span class="badge bg-{{ $student->type === 'waiver' ? 'success' : 'info' }}">
              {{ ucfirst($student->type) }}
            </span>
          </div>
          <div class="text-muted small d-flex flex-wrap gap-3 mt-1">
            <span><i class="bx bx-user me-1"></i><strong>Parent:</strong> {{ $student->parent_name ?? 'N/A' }}</span>
            <span><i class="bx bx-envelope me-1"></i>{{ $student->email }}</span>
            <span><i class="bx bx-phone me-1"></i>{{ $student->mobile }}</span>
            <span><i class="bx bx-calendar me-1"></i><strong>Age:</strong> {{ $student->age }}</span>
          </div>
        </div>
      </div>

      <div class="col-lg-5 border-start-lg ps-lg-4">
        <div class="d-flex flex-column gap-2">
          @if($student->groundPartner)
          <div class="p-2 rounded bg-label-info d-flex align-items-center justify-content-between">
            <div>
              <small class="fw-bold text-info d-block">Referred Ground Partner (GP)</small>
              <a href="{{ route('admin.admin-ground-partner.view', $student->groundPartner->id) }}" class="fw-bold text-info">
                {{ $student->groundPartner->name }} ({{ $student->groundPartner->code }})
              </a>
            </div>
            @if($student->groundPartner->phone)
            <small class="text-muted"><i class="bx bx-phone me-1"></i>{{ $student->groundPartner->phone }}</small>
            @endif
          </div>
          @endif

          <div class="d-flex align-items-center justify-content-between p-2 rounded bg-light border">
            <div>
              <small class="text-muted d-block">Subscription Status</small>
              @if($student->type === 'waiver')
                <span class="badge bg-success">Lifetime Free Access (Waiver)</span>
              @elseif($subscriber && $subscriber->status === 'active')
                <span class="badge bg-success">Active</span>
                @if($subscriber->expiry_date)
                  <small class="text-muted ms-1">(Expires: {{ date('d-m-Y', strtotime($subscriber->expiry_date)) }})</small>
                @endif
              @elseif($subscriber && $subscriber->status === 'pending')
                <span class="badge bg-warning">Pending Verification</span>
              @else
                <span class="badge bg-danger">Inactive</span>
              @endif
            </div>
            <div>
              @if($subscriber && $subscriber->subscription_date)
              <small class="text-muted">
                Since: <strong>{{ date('d-m-Y', strtotime($subscriber->subscription_date)) }}</strong>
              </small>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- KPI Summary Cards -->
<div class="row mb-4">
  <div class="col-sm-6 col-lg-3 mb-3">
    <div class="card payment-stat-card h-100">
      <div class="card-body d-flex align-items-center justify-content-between">
        <div>
          <span class="text-muted fw-semibold d-block mb-1">Total Paid</span>
          <h4 class="card-title mb-0 text-success fw-bold">₹{{ number_format($totalPaid, 2) }}</h4>
          <small class="text-muted">Completed payments total</small>
        </div>
        <div class="stat-icon bg-label-success">
          <i class="bx bx-wallet"></i>
        </div>
      </div>
    </div>
  </div>

  <div class="col-sm-6 col-lg-3 mb-3">
    <div class="card payment-stat-card h-100">
      <div class="card-body d-flex align-items-center justify-content-between">
        <div>
          <span class="text-muted fw-semibold d-block mb-1">Total Records</span>
          <h4 class="card-title mb-0 text-primary fw-bold">{{ number_format($totalTransactionsCount) }}</h4>
          <small class="text-muted">All payment attempts</small>
        </div>
        <div class="stat-icon bg-label-primary">
          <i class="bx bx-receipt"></i>
        </div>
      </div>
    </div>
  </div>

  <div class="col-sm-6 col-lg-3 mb-3">
    <div class="card payment-stat-card h-100">
      <div class="card-body d-flex align-items-center justify-content-between">
        <div>
          <span class="text-muted fw-semibold d-block mb-1">Successful</span>
          <h4 class="card-title mb-0 text-info fw-bold">{{ number_format($successfulPaymentsCount) }}</h4>
          <small class="text-muted">Successful payments</small>
        </div>
        <div class="stat-icon bg-label-info">
          <i class="bx bx-check-circle"></i>
        </div>
      </div>
    </div>
  </div>

  <div class="col-sm-6 col-lg-3 mb-3">
    <div class="card payment-stat-card h-100">
      <div class="card-body d-flex align-items-center justify-content-between">
        <div>
          <span class="text-muted fw-semibold d-block mb-1">Pending</span>
          <h4 class="card-title mb-0 text-warning fw-bold">{{ number_format($pendingPaymentsCount) }}</h4>
          <small class="text-muted">Pending payments</small>
        </div>
        <div class="stat-icon bg-label-warning">
          <i class="bx bx-time-five"></i>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Filters Card -->
<div class="card mb-4">
  <div class="card-header pb-2 d-flex justify-content-between align-items-center flex-wrap gap-2">
    <h5 class="card-title mb-0">
      <i class="bx bx-filter-alt me-1 text-primary"></i> Filter {{ $student->student_name }}'s Payments
    </h5>
    @if(request()->anyFilled(['search', 'from_date', 'to_date', 'status']))
    <span class="badge bg-label-primary">Active Filters Applied</span>
    @endif
  </div>
  <div class="card-body">
    <form action="{{ route('admin.admin-student.payments', $student->id) }}" method="GET">
      <div class="row g-3">
        <!-- Search -->
        <div class="col-md-3">
          <label for="search" class="form-label">Search</label>
          <div class="input-group">
            <span class="input-group-text"><i class="bx bx-search"></i></span>
            <input
              type="text"
              name="search"
              class="form-control"
              id="search"
              placeholder="Payment ID, Order ID..."
              value="{{ request('search') }}">
          </div>
        </div>

        <!-- Status -->
        <div class="col-md-2">
          <label for="status" class="form-label">Status</label>
          <select name="status" class="form-select" id="status">
            <option value="">All Status</option>
            <option value="success" {{ request('status') == 'success' ? 'selected' : '' }}>Success</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
          </select>
        </div>

        <!-- From Date -->
        <div class="col-md-2">
          <label for="from_date" class="form-label">From Date</label>
          <input
            type="date"
            name="from_date"
            class="form-control"
            id="from_date"
            value="{{ request('from_date') }}">
        </div>

        <!-- To Date -->
        <div class="col-md-2">
          <label for="to_date" class="form-label">To Date</label>
          <input
            type="date"
            name="to_date"
            class="form-control"
            id="to_date"
            value="{{ request('to_date') }}">
        </div>

        <!-- Buttons -->
        <div class="col-md-3 d-flex align-items-end justify-content-end gap-2 flex-wrap">
          <button type="submit" class="btn btn-primary">
            <i class="bx bx-search me-1"></i> Search
          </button>
          <a href="{{ route('admin.admin-student.payments', $student->id) }}" class="btn btn-secondary">
            <i class="bx bx-reset me-1"></i> Reset
          </a>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Payments Table Card -->
<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center flex-wrap pb-2 gap-2">
    <div>
      <h5 class="card-title mb-0">Payments History</h5>
      <small class="text-muted">
        Showing {{ $transactions->firstItem() ?? 0 }} to {{ $transactions->lastItem() ?? 0 }} of {{ $transactions->total() }} payments for this student
      </small>
    </div>
    <div class="d-flex gap-2">
      <a href="{{ route('admin.admin-student.payments.export', array_merge(['id' => $student->id], request()->all(), ['format' => 'xlsx'])) }}" class="btn btn-sm btn-success">
        <i class="bx bx-file me-1"></i> Download Excel
      </a>
      <a href="{{ route('admin.admin-student.payments.export', array_merge(['id' => $student->id], request()->all(), ['format' => 'csv'])) }}" class="btn btn-sm btn-info">
        <i class="bx bx-download me-1"></i> Download CSV
      </a>
    </div>
  </div>

  <div class="table-responsive">
    <table class="table table-hover table-bordered table-payments mb-0">
      <thead class="table-light">
        <tr>
          <th style="width: 45px;" class="text-center">SL</th>
          <th style="min-width: 170px;">Payment ID</th>
          <th style="min-width: 170px;">Order ID</th>
          <th style="width: 90px;" class="text-center">Class</th>
          <th style="width: 110px;">Amount</th>
          <th style="width: 110px;">Method</th>
          <th style="width: 90px;" class="text-center">Status</th>
          <th style="min-width: 160px;">Date & Time</th>
          <th style="width: 85px;" class="text-center sticky-action">Action</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @forelse($transactions as $index => $tx)
        <tr>
          <!-- SL -->
          <td class="text-center"><strong>{{ $transactions->firstItem() + $index }}</strong></td>

          <!-- Payment ID -->
          <td>
            <code class="text-primary text-break">{{ $tx->razorpay_payment_id ?? 'N/A' }}</code>
          </td>

          <!-- Order ID -->
          <td>
            <code class="text-muted text-break">{{ $tx->razorpay_order_id ?? 'N/A' }}</code>
          </td>

          <!-- Class -->
          <td class="text-center">
            <span class="badge bg-label-primary text-nowrap">
              {{ $tx->class->name ?? 'N/A' }}
            </span>
          </td>

          <!-- Amount -->
          <td>
            <strong class="text-success fs-6 text-nowrap">₹{{ number_format($tx->amount, 2) }}</strong>
          </td>

          <!-- Method -->
          <td>
            <span class="badge bg-label-info text-nowrap">
              {{ $tx->payment_method ? ucfirst($tx->payment_method) : 'Online' }}
            </span>
          </td>

          <!-- Status -->
          <td class="text-center">
            @if($tx->status === 'success')
              <span class="badge bg-success text-nowrap">Success</span>
            @elseif($tx->status === 'pending')
              <span class="badge bg-warning text-nowrap">Pending</span>
            @elseif($tx->status === 'failed')
              <span class="badge bg-danger text-nowrap">Failed</span>
            @else
              <span class="badge bg-secondary text-nowrap">{{ ucfirst($tx->status) }}</span>
            @endif
          </td>

          <!-- Date & Time -->
          <td>
            <div class="small">
              <div>{{ $tx->created_at ? $tx->created_at->format('d-m-Y h:i A') : 'N/A' }}</div>
              @if($tx->created_at)
              <small class="text-muted">({{ $tx->created_at->diffForHumans() }})</small>
              @endif
            </div>
          </td>

          <!-- Action View Details Modal Button -->
          <td class="text-center sticky-action">
            <button
              type="button"
              class="btn btn-sm btn-primary py-1 px-2 text-nowrap"
              data-bs-toggle="modal"
              data-bs-target="#viewModal{{ $tx->id }}"
              title="View Payment Details">
              <i class="bx bx-show me-1"></i> View
            </button>
          </td>
        </tr>

        <!-- View Details Modal -->
        <div class="modal fade" id="viewModal{{ $tx->id }}" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header bg-label-primary pb-3">
                <h5 class="modal-title text-primary fw-bold">
                  <i class="bx bx-receipt me-2"></i> Payment Details #{{ $tx->id }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>

              <div class="modal-body p-4">
                <!-- Summary Alert Box -->
                <div class="d-flex justify-content-between align-items-center p-3 mb-4 rounded" style="background-color: #f5f5f9; border: 1px solid #e7e7e8;">
                  <div>
                    <span class="text-muted d-block small">Amount Paid</span>
                    <h3 class="text-success fw-bold m-0">₹{{ number_format($tx->amount, 2) }}</h3>
                  </div>
                  <div class="text-end">
                    <span class="text-muted d-block small mb-1">Transaction Status</span>
                    @if($tx->status === 'success')
                      <span class="badge bg-success fs-6 px-3 py-1">Success</span>
                    @elseif($tx->status === 'pending')
                      <span class="badge bg-warning fs-6 px-3 py-1">Pending</span>
                    @else
                      <span class="badge bg-danger fs-6 px-3 py-1">{{ ucfirst($tx->status) }}</span>
                    @endif
                  </div>
                </div>

                <!-- 1. Payment & Gateway Details -->
                <div class="modal-section-title">
                  <i class="bx bx-credit-card me-1"></i> Transaction & Gateway Information
                </div>
                <div class="row mb-3">
                  <div class="col-md-6 mb-2">
                    <small class="text-muted d-block">Razorpay Payment ID</small>
                    <p class="fw-bold mb-0 text-break"><code>{{ $tx->razorpay_payment_id ?? 'N/A' }}</code></p>
                  </div>
                  <div class="col-md-6 mb-2">
                    <small class="text-muted d-block">Razorpay Order ID</small>
                    <p class="fw-bold mb-0 text-break"><code>{{ $tx->razorpay_order_id ?? 'N/A' }}</code></p>
                  </div>
                  <div class="col-md-6 mb-2">
                    <small class="text-muted d-block">Payment Method</small>
                    <p class="fw-bold mb-0">
                      <span class="badge bg-label-info">{{ $tx->payment_method ? ucfirst($tx->payment_method) : 'Online Gateway' }}</span>
                    </p>
                  </div>
                  <div class="col-md-6 mb-2">
                    <small class="text-muted d-block">Payment Date & Time</small>
                    <p class="fw-bold mb-0">
                      {{ $tx->created_at ? $tx->created_at->format('d-m-Y h:i A') : 'N/A' }}
                      @if($tx->created_at)
                      <small class="text-muted">({{ $tx->created_at->diffForHumans() }})</small>
                      @endif
                    </p>
                  </div>
                  @if($tx->razorpay_signature)
                  <div class="col-12 mb-2">
                    <small class="text-muted d-block">Razorpay Signature</small>
                    <p class="mb-0 text-break font-monospace small bg-light p-2 rounded">{{ $tx->razorpay_signature }}</p>
                  </div>
                  @endif
                </div>

                <!-- 2. Student Details -->
                <div class="modal-section-title">
                  <i class="bx bx-user me-1"></i> Student Information
                </div>
                <div class="row mb-3">
                  <div class="col-md-4 mb-2">
                    <small class="text-muted d-block">Student ID</small>
                    <p class="fw-bold mb-0"><span class="badge bg-label-warning">{{ $student->student_id }}</span></p>
                  </div>
                  <div class="col-md-4 mb-2">
                    <small class="text-muted d-block">Student Name</small>
                    <p class="fw-bold mb-0">{{ $student->student_name }}</p>
                  </div>
                  <div class="col-md-4 mb-2">
                    <small class="text-muted d-block">Parent / Guardian</small>
                    <p class="fw-bold mb-0">{{ $student->parent_name ?? 'N/A' }}</p>
                  </div>
                  <div class="col-md-4 mb-2">
                    <small class="text-muted d-block">Email Address</small>
                    <p class="fw-bold mb-0 text-break">{{ $student->email }}</p>
                  </div>
                  <div class="col-md-4 mb-2">
                    <small class="text-muted d-block">Phone / Mobile</small>
                    <p class="fw-bold mb-0">{{ $student->mobile }}</p>
                  </div>
                  <div class="col-md-4 mb-2">
                    <small class="text-muted d-block">Student Type</small>
                    <p class="fw-bold mb-0">
                      <span class="badge bg-label-{{ $student->type === 'waiver' ? 'success' : 'primary' }}">
                        {{ ucfirst($student->type) }}
                      </span>
                    </p>
                  </div>
                </div>

                <!-- 3. Class & Subscription Details -->
                <div class="modal-section-title">
                  <i class="bx bx-book-open me-1"></i> Class & Subscription Status
                </div>
                <div class="row">
                  <div class="col-md-4 mb-2">
                    <small class="text-muted d-block">Class</small>
                    <p class="fw-bold mb-0"><span class="badge bg-label-primary">{{ $tx->class->name ?? 'N/A' }}</span></p>
                  </div>
                  <div class="col-md-4 mb-2">
                    <small class="text-muted d-block">Current Subscription Status</small>
                    <p class="fw-bold mb-0">
                      @if($subscriber)
                        @if($subscriber->status === 'active')
                          <span class="badge bg-success">Active</span>
                        @elseif($subscriber->status === 'pending')
                          <span class="badge bg-warning">Pending</span>
                        @else
                          <span class="badge bg-danger">Inactive</span>
                        @endif
                      @else
                        <span class="badge bg-secondary">N/A</span>
                      @endif
                    </p>
                  </div>
                  <div class="col-md-4 mb-2">
                    <small class="text-muted d-block">Expiry / Access</small>
                    <p class="fw-bold mb-0">
                      @if($student->type === 'waiver')
                        <span class="badge bg-label-success">Lifetime Free Access (Waiver)</span>
                      @elseif($subscriber && $subscriber->expiry_date)
                        <span class="text-danger">{{ date('d-m-Y', strtotime($subscriber->expiry_date)) }}</span>
                      @else
                        <span class="text-muted">N/A</span>
                      @endif
                    </p>
                  </div>
                </div>
              </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>

        @empty
        <tr>
          <td colspan="9" class="text-center py-4">
            <div class="text-center">
              <i class="bx bx-receipt text-muted" style="font-size: 3rem;"></i>
              <p class="mt-2 mb-1 fw-bold">No payments found for this student.</p>
              <small class="text-muted">This student hasn't made any fee payment yet or no records match the filter.</small>
            </div>
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <!-- Pagination -->
  @if($transactions->hasPages())
  <div class="card-footer d-flex justify-content-between align-items-center flex-wrap pt-3 pb-3">
    <div class="text-muted small mb-2 mb-sm-0">
      Showing {{ $transactions->firstItem() }} to {{ $transactions->lastItem() }} of {{ $transactions->total() }} payments
    </div>
    <div class="pagination-container">
      {{ $transactions->links('pagination::bootstrap-5') }}
    </div>
  </div>
  @endif
</div>

@endsection

