@extends('admin.layouts.app')

@section('title', 'All Payments - Schoolwala')

@section('content')

<style>
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
  .table th {
    font-size: 0.78rem;
    letter-spacing: 0.5px;
    text-transform: uppercase;
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
</style>

<!-- Banner Header -->
<div class="row">
  <div class="col-lg-12 mb-4 order-0">
    <div class="card">
      <div class="d-flex align-items-end row">
        <div class="col-sm-7">
          <div class="card-body">
            <h5 class="card-title text-primary">All Payments!</h5>
            <p class="mb-4">
              You can <strong>view, filter, and export</strong> all student payment transactions and fees records.
            </p>
          </div>
        </div>
        <div class="col-sm-5 text-center text-sm-left">
          <div class="card-body pb-0 px-0 px-md-4">
            <img
              src="{{ asset('./admin/assets/img/illustrations/man-with-laptop-light.png') }}"
              height="140"
              alt="Payments User" />
          </div>
        </div>

        <!-- Success/Error Alerts -->
        @if(session('success'))
        <div class="col-12 px-4">
          <div class="alert alert-success alert-dismissible" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        </div>
        @endif

        @if(session('error'))
        <div class="col-12 px-4">
          <div class="alert alert-danger alert-dismissible" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        </div>
        @endif
      </div>
    </div>
  </div>
</div>

<!-- Quick Statistics KPI Cards -->
<div class="row mb-4">
  <div class="col-sm-6 col-lg-3 mb-3">
    <div class="card payment-stat-card h-100">
      <div class="card-body d-flex align-items-center justify-content-between">
        <div>
          <span class="text-muted fw-semibold d-block mb-1">Total Collected</span>
          <h4 class="card-title mb-0 text-success fw-bold">₹{{ number_format($totalAmountCollected, 2) }}</h4>
          <small class="text-muted">Filtered results revenue</small>
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
          <span class="text-muted fw-semibold d-block mb-1">Total Payments</span>
          <h4 class="card-title mb-0 text-primary fw-bold">{{ number_format($totalPaymentsCount) }}</h4>
          <small class="text-muted">Total payment records</small>
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
          <small class="text-muted">Completed transactions</small>
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
          <span class="text-muted fw-semibold d-block mb-1">Today's Collection</span>
          <h4 class="card-title mb-0 text-warning fw-bold">₹{{ number_format($todayCollection, 2) }}</h4>
          <small class="text-muted">Collected today</small>
        </div>
        <div class="stat-icon bg-label-warning">
          <i class="bx bx-calendar-event"></i>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Filters Card -->
<div class="card mb-4">
  <div class="card-header pb-2 d-flex justify-content-between align-items-center flex-wrap gap-2">
    <h5 class="card-title mb-0">
      <i class="bx bx-filter-alt me-1 text-primary"></i> Filter Payments
    </h5>
    @if(request()->anyFilled(['search', 'class_id', 'from_date', 'to_date', 'status', 'payment_method']))
    <span class="badge bg-label-primary">Active Filters Applied</span>
    @endif
  </div>
  <div class="card-body">
    <form action="{{ route('admin.admin-payments') }}" method="GET">
      <div class="row g-3">
        <!-- Search -->
        <div class="col-md-4">
          <label for="search" class="form-label">Search</label>
          <div class="input-group">
            <span class="input-group-text"><i class="bx bx-search"></i></span>
            <input
              type="text"
              name="search"
              class="form-control"
              id="search"
              placeholder="Student ID, Name, Email, Phone, Payment ID..."
              value="{{ request('search') }}">
          </div>
        </div>

        <!-- Choose Class -->
        <div class="col-md-3">
          <label for="class_id" class="form-label">Choose Class</label>
          <select name="class_id" class="form-select" id="class_id">
            <option value="">All Classes</option>
            @foreach($classes as $class)
            <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
              {{ $class->name }}
            </option>
            @endforeach
          </select>
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

        <!-- Payment Method -->
        <div class="col-md-3">
          <label for="payment_method" class="form-label">Payment Method</label>
          <select name="payment_method" class="form-select" id="payment_method">
            <option value="">All Methods</option>
            @if(isset($paymentMethods) && count($paymentMethods) > 0)
              @foreach($paymentMethods as $method)
              <option value="{{ $method }}" {{ request('payment_method') == $method ? 'selected' : '' }}>
                {{ ucfirst($method) }}
              </option>
              @endforeach
            @else
              <option value="upi" {{ request('payment_method') == 'upi' ? 'selected' : '' }}>UPI</option>
              <option value="card" {{ request('payment_method') == 'card' ? 'selected' : '' }}>Card</option>
              <option value="netbanking" {{ request('payment_method') == 'netbanking' ? 'selected' : '' }}>Netbanking</option>
              <option value="wallet" {{ request('payment_method') == 'wallet' ? 'selected' : '' }}>Wallet</option>
            @endif
          </select>
        </div>

        <!-- From Date -->
        <div class="col-md-3">
          <label for="from_date" class="form-label">From Date</label>
          <input
            type="date"
            name="from_date"
            class="form-control"
            id="from_date"
            value="{{ request('from_date') }}">
        </div>

        <!-- To Date -->
        <div class="col-md-3">
          <label for="to_date" class="form-label">To Date</label>
          <input
            type="date"
            name="to_date"
            class="form-control"
            id="to_date"
            value="{{ request('to_date') }}">
        </div>

        <!-- Buttons -->
        <div class="col-md-6 d-flex align-items-end justify-content-end gap-2 flex-wrap">
          <button type="submit" class="btn btn-primary">
            <i class="bx bx-search me-1"></i> Search
          </button>
          <a href="{{ route('admin.admin-payments') }}" class="btn btn-secondary">
            <i class="bx bx-reset me-1"></i> Reset
          </a>
          <a href="{{ route('admin.export-payments', array_merge(request()->all(), ['format' => 'xlsx'])) }}" class="btn btn-success">
            <i class="bx bx-file me-1"></i> Export Excel
          </a>
          <a href="{{ route('admin.export-payments', array_merge(request()->all(), ['format' => 'csv'])) }}" class="btn btn-info">
            <i class="bx bx-download me-1"></i> Export CSV
          </a>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Payments Table Card -->
<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center flex-wrap pb-2">
    <h5 class="card-title mb-0">Payments List</h5>
    <small class="text-muted">
      Showing {{ $transactions->firstItem() ?? 0 }} to {{ $transactions->lastItem() ?? 0 }} of {{ $transactions->total() }} records
    </small>
  </div>

  <div class="table-responsive text-nowrap">
    <table class="table table-hover table-bordered mb-0">
      <thead class="table-light">
        <tr>
          <th style="width: 50px;">SL</th>
          <th>Student ID</th>
          <th>Class</th>
          <th>Student Name</th>
          <th>Email / Mobile</th>
          <th>Payment Details</th>
          <th>Amount</th>
          <th>Status</th>
          <th style="width: 80px;" class="text-center">Action</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @forelse($transactions as $index => $tx)
        <tr>
          <!-- SL -->
          <td><strong>{{ $transactions->firstItem() + $index }}</strong></td>

          <!-- Student ID -->
          <td>
            <span class="badge bg-label-warning fw-bold">
              {{ $tx->student->student_id ?? 'N/A' }}
            </span>
          </td>

          <!-- Class -->
          <td>
            <span class="badge bg-label-primary">
              {{ $tx->class->name ?? 'N/A' }}
            </span>
          </td>

          <!-- Student Name -->
          <td>
            <div class="d-flex align-items-center">
              <div class="avatar avatar-sm me-2">
                <span class="avatar-initial rounded-circle bg-label-primary">
                  {{ strtoupper(substr($tx->student->student_name ?? 'S', 0, 1)) }}
                </span>
              </div>
              <div>
                <p class="m-0 p-0 fw-bold">{{ $tx->student->student_name ?? 'N/A' }}</p>
                <small class="text-muted">Type: {{ ucfirst($tx->student->type ?? 'regular') }}</small>
              </div>
            </div>
          </td>

          <!-- Email & Phone -->
          <td>
            <p class="m-0 p-0 text-nowrap">
              <i class="bx bx-envelope text-muted me-1"></i> {{ $tx->student->email ?? 'N/A' }}
            </p>
            <p class="m-0 p-0 text-nowrap">
              <i class="bx bx-phone text-muted me-1"></i> {{ $tx->student->mobile ?? 'N/A' }}
            </p>
          </td>

          <!-- Payment Details -->
          <td>
            <p class="m-0 p-0 text-nowrap">
              <small class="text-muted">ID:</small>
              <code class="text-primary">{{ $tx->razorpay_payment_id ?? 'N/A' }}</code>
            </p>
            <p class="m-0 p-0 text-nowrap">
              <small class="text-muted">Method:</small>
              <span class="badge bg-label-info">{{ $tx->payment_method ? ucfirst($tx->payment_method) : 'Online' }}</span>
            </p>
            <p class="m-0 p-0 text-nowrap">
              <small class="text-muted">
                <i class="bx bx-calendar me-1"></i>{{ $tx->created_at ? $tx->created_at->format('d-m-Y h:i A') : 'N/A' }}
              </small>
            </p>
          </td>

          <!-- Amount -->
          <td>
            <strong class="text-success fs-6">₹{{ number_format($tx->amount, 2) }}</strong>
          </td>

          <!-- Status -->
          <td>
            @if($tx->status === 'success')
              <span class="badge bg-success">Success</span>
            @elseif($tx->status === 'pending')
              <span class="badge bg-warning">Pending</span>
            @elseif($tx->status === 'failed')
              <span class="badge bg-danger">Failed</span>
            @else
              <span class="badge bg-secondary">{{ ucfirst($tx->status) }}</span>
            @endif
          </td>

          <!-- Action View Icon -->
          <td class="text-center">
            <button
              type="button"
              class="btn btn-sm btn-icon btn-outline-primary"
              data-bs-toggle="modal"
              data-bs-target="#viewModal{{ $tx->id }}"
              title="View Payment Details">
              <i class="bx bx-show fs-5"></i>
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
                <!-- Top Summary Alert Box -->
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
                    <p class="fw-bold mb-0"><span class="badge bg-label-info">{{ $tx->payment_method ? ucfirst($tx->payment_method) : 'Online Gateway' }}</span></p>
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
                    <p class="fw-bold mb-0"><span class="badge bg-label-warning">{{ $tx->student->student_id ?? 'N/A' }}</span></p>
                  </div>
                  <div class="col-md-4 mb-2">
                    <small class="text-muted d-block">Student Name</small>
                    <p class="fw-bold mb-0">{{ $tx->student->student_name ?? 'N/A' }}</p>
                  </div>
                  <div class="col-md-4 mb-2">
                    <small class="text-muted d-block">Parent / Guardian</small>
                    <p class="fw-bold mb-0">{{ $tx->student->parent_name ?? 'N/A' }}</p>
                  </div>
                  <div class="col-md-4 mb-2">
                    <small class="text-muted d-block">Email Address</small>
                    <p class="fw-bold mb-0 text-break">{{ $tx->student->email ?? 'N/A' }}</p>
                  </div>
                  <div class="col-md-4 mb-2">
                    <small class="text-muted d-block">Phone / Mobile</small>
                    <p class="fw-bold mb-0">{{ $tx->student->mobile ?? 'N/A' }}</p>
                  </div>
                  <div class="col-md-4 mb-2">
                    <small class="text-muted d-block">Student Type</small>
                    <p class="fw-bold mb-0">
                      <span class="badge bg-label-{{ ($tx->student->type ?? '') === 'waiver' ? 'success' : 'primary' }}">
                        {{ ucfirst($tx->student->type ?? 'Regular') }}
                      </span>
                    </p>
                  </div>
                  @if($tx->student && $tx->student->groundPartner)
                  <div class="col-12 mt-2">
                    <div class="p-2 rounded bg-label-info">
                      <small class="fw-bold text-info"><i class="bx bx-group me-1"></i>Referred Ground Partner (GP):</small>
                      <span class="fw-bold ms-1">{{ $tx->student->groundPartner->name }}</span>
                      <span class="badge bg-info ms-1">{{ $tx->student->groundPartner->code }}</span>
                      @if($tx->student->groundPartner->phone)
                      <span class="ms-2 text-muted"><i class="bx bx-phone"></i> {{ $tx->student->groundPartner->phone }}</span>
                      @endif
                    </div>
                  </div>
                  @endif
                </div>

                <!-- 3. Class & Subscription Details -->
                <div class="modal-section-title">
                  <i class="bx bx-book-open me-1"></i> Class & Subscription Status
                </div>
                @php
                  $subscriber = $tx->student ? $tx->student->subscribers->where('class_id', $tx->class_id)->first() : null;
                @endphp
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
                      @if($tx->student && $tx->student->type === 'waiver')
                        <span class="badge bg-label-success">Lifetime Free Access (Waiver)</span>
                      @elseif($subscriber && $subscriber->expiry_date)
                        <span class="text-danger">{{ date('d-m-Y', strtotime($subscriber->expiry_date)) }}</span>
                      @else
                        <span class="text-muted">N/A</span>
                      @endif
                    </p>
                  </div>
                  @if($subscriber && $subscriber->reciptimage)
                  <div class="col-12 mt-3">
                    <small class="text-muted d-block mb-1">Uploaded Payment Receipt</small>
                    <a href="{{ asset('storage/' . $subscriber->reciptimage) }}" target="_blank">
                      <img src="{{ asset('storage/' . $subscriber->reciptimage) }}"
                        alt="Receipt"
                        class="img-fluid rounded border"
                        style="max-height: 220px;">
                    </a>
                  </div>
                  @endif
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
              <p class="mt-2 mb-1 fw-bold">No payment records found.</p>
              <small class="text-muted">Try adjusting your search or filter options.</small>
            </div>
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <!-- Pagination -->
  @if($transactions->hasPages())
  <div class="card-footer d-flex justify-content-between align-items-center flex-wrap pt-3 pb-2">
    <div class="text-muted small mb-2 mb-sm-0">
      Showing {{ $transactions->firstItem() }} to {{ $transactions->lastItem() }} of {{ $transactions->total() }} payments
    </div>
    <div>
      {{ $transactions->links() }}
    </div>
  </div>
  @endif
</div>

@endsection

