@extends('admin.layouts.app')

@section('title', 'Ground Partner Details - ' . $gp->name . ' - Schoolwala')

@section('content')

<style>
  .kpi-card {
    border-radius: 12px;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
  }
  .kpi-card:hover {
    transform: translateY(-2px);
  }
  .kpi-label {
    display: block;
    font-weight: 700;
    font-size: 0.84rem;
    letter-spacing: 0.6px;
    text-transform: uppercase;
    color: #ffffff !important;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.35);
    margin-bottom: 4px;
  }
  .kpi-value {
    color: #ffffff !important;
    font-weight: 800;
    font-size: 1.9rem;
    margin: 0;
    line-height: 1.2;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.25);
  }
  .partner-avatar {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    font-weight: bold;
  }
</style>

<!-- Breadcrumb / Header -->
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
  <div>
    <h4 class="fw-bold py-1 mb-1">
      <span class="text-muted fw-light">Partners / <a href="{{ route('admin.admin-ground-partners') }}">Ground Partners</a> /</span>
      {{ $gp->name }}
    </h4>
    <p class="text-muted mb-0 small">Overview of partner profile and paid student registrations</p>
  </div>
  <div class="d-flex gap-2 mt-2 mt-sm-0">
    <a href="{{ route('admin.admin-ground-partners') }}" class="btn btn-outline-secondary">
      <i class="bx bx-arrow-back me-1"></i> Back to Partners
    </a>
  </div>
</div>

<!-- Partner Info Card & KPIs -->
<div class="row mb-4">
  <div class="col-lg-12">
    <div class="card shadow-sm border-0 mb-4">
      <div class="card-body">
        <div class="row align-items-center">
          <div class="col-md-7 d-flex align-items-center mb-3 mb-md-0">
            <div class="partner-avatar bg-primary text-white me-3">
              {{ strtoupper(substr($gp->name, 0, 1)) }}
            </div>
            <div>
              <div class="d-flex align-items-center gap-2 flex-wrap">
                <h4 class="mb-0 fw-bold">{{ $gp->name }}</h4>
                <span class="badge bg-label-info fs-6">
                  <i class="bx bx-barcode me-1"></i>{{ $gp->code }}
                </span>
                @if ($gp->status === 'Active')
                  <span class="badge bg-success">Active</span>
                @else
                  <span class="badge bg-danger">Inactive</span>
                @endif
              </div>
              <div class="text-muted small mt-1 d-flex flex-wrap gap-3">
                <span>
                  <i class="bx bx-phone me-1 text-primary"></i>
                  <a href="tel:{{ $gp->mobile }}" class="text-body">{{ $gp->mobile }}</a>
                </span>
                <span>
                  <i class="bx bx-user-pin me-1 text-info"></i>
                  Executive Partner:
                  @if($gp->executivePartner)
                    <strong>{{ $gp->executivePartner->name }}</strong> ({{ $gp->executivePartner->code }})
                  @else
                    <span class="text-muted">Not assigned</span>
                  @endif
                </span>
                <span>
                  <i class="bx bx-calendar me-1 text-secondary"></i>
                  Joined: {{ $gp->created_at ? $gp->created_at->format('d M, Y') : '-' }}
                </span>
              </div>
            </div>
          </div>

          <div class="col-md-5 text-md-end">
            @if(isset($otherGps) && $otherGps->count() > 1)
              <div class="d-inline-block text-start" style="min-width: 240px;">
                <label class="form-label small text-muted mb-1">Switch Ground Partner (Same EP)</label>
                <select class="form-select form-select-sm" onchange="if(this.value) window.location.href=this.value;">
                  @foreach($otherGps as $ogp)
                    <option value="{{ route('admin.admin-ground-partner.view', $ogp->id) }}" {{ $ogp->id == $gp->id ? 'selected' : '' }}>
                      {{ $ogp->name }} ({{ $ogp->code }})
                    </option>
                  @endforeach
                </select>
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- KPI 1: Total Referred -->
  <div class="col-lg-3 col-md-6 col-6 mb-3">
    <div class="card kpi-card bg-primary text-white shadow-sm">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <span class="kpi-label">Total Referred</span>
            <h2 class="kpi-value">{{ $totalStudents }}</h2>
          </div>
          <div class="avatar flex-shrink-0">
            <span class="avatar-initial rounded bg-white text-primary">
              <i class="bx bx-group fs-4"></i>
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- KPI 2: Paid Students -->
  <div class="col-lg-3 col-md-6 col-6 mb-3">
    <div class="card kpi-card bg-success text-white shadow-sm">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <span class="kpi-label">Paid Students</span>
            <h2 class="kpi-value">{{ $paidStudents }}</h2>
          </div>
          <div class="avatar flex-shrink-0">
            <span class="avatar-initial rounded bg-white text-success">
              <i class="bx bx-check-shield fs-4"></i>
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- KPI 3: Unpaid Students -->
  <div class="col-lg-3 col-md-6 col-6 mb-3">
    <div class="card kpi-card bg-warning text-white shadow-sm">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <span class="kpi-label">Unpaid / Pending</span>
            <h2 class="kpi-value">{{ $unpaidStudents }}</h2>
          </div>
          <div class="avatar flex-shrink-0">
            <span class="avatar-initial rounded bg-white text-warning">
              <i class="bx bx-time fs-4"></i>
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- KPI 4: Total Revenue -->
  <div class="col-lg-3 col-md-6 col-6 mb-3">
    <div class="card kpi-card bg-info text-white shadow-sm">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <span class="kpi-label">Total Revenue</span>
            <h2 class="kpi-value">₹{{ number_format($totalCollected, 2) }}</h2>
          </div>
          <div class="avatar flex-shrink-0">
            <span class="avatar-initial rounded bg-white text-info">
              <i class="bx bx-rupee fs-4"></i>
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Filter Toolbar -->
<div class="card shadow-sm mb-4">
  <div class="card-header bg-transparent border-bottom">
    <h5 class="card-title mb-0">
      <i class="bx bx-filter-alt me-1 text-primary"></i> Filter Paid Students
    </h5>
  </div>
  <div class="card-body pt-3">
    <form action="{{ route('admin.admin-ground-partner.view', $gp->id) }}" method="GET">
      <div class="row g-3 align-items-end">
        <div class="col-md-4 col-sm-6">
          <label class="form-label small">Search Student</label>
          <div class="input-group">
            <span class="input-group-text"><i class="bx bx-search"></i></span>
            <input
              type="text"
              name="search"
              class="form-control"
              placeholder="Name, STU ID, Mobile..."
              value="{{ request('search') }}">
          </div>
        </div>

        <div class="col-md-2 col-sm-6">
          <label class="form-label small">Class</label>
          <select name="class_id" class="form-select">
            <option value="">All Classes</option>
            @foreach($classes as $c)
              <option value="{{ $c->id }}" {{ request('class_id') == $c->id ? 'selected' : '' }}>
                {{ $c->name }}
              </option>
            @endforeach
          </select>
        </div>

        <div class="col-md-2 col-sm-6">
          <label class="form-label small">From Date</label>
          <input
            type="date"
            name="from_date"
            class="form-control"
            value="{{ request('from_date') }}">
        </div>

        <div class="col-md-2 col-sm-6">
          <label class="form-label small">To Date</label>
          <input
            type="date"
            name="to_date"
            class="form-control"
            value="{{ request('to_date') }}">
        </div>

        <div class="col-md-2 col-sm-12 d-flex gap-2">
          <button type="submit" class="btn btn-primary flex-grow-1">
            <i class="bx bx-filter-alt me-1"></i> Filter
          </button>
          <a href="{{ route('admin.admin-ground-partner.view', $gp->id) }}" class="btn btn-outline-secondary">
            Reset
          </a>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Paid Students Table Card -->
<div class="card shadow-sm">
  <div class="card-header d-flex justify-content-between align-items-center bg-transparent border-bottom">
    <h5 class="card-title mb-0">
      <i class="bx bx-check-shield me-1 text-success"></i>
      Paid Referred Students ({{ $students->total() }})
    </h5>
    <span class="badge bg-label-secondary">
      Page {{ $students->currentPage() }} of {{ $students->lastPage() }}
    </span>
  </div>

  <div class="card-body p-0">
    <div class="table-responsive text-nowrap">
      <table class="table table-hover table-bordered align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th style="width: 50px;">SL</th>
            <th>STU ID</th>
            <th>Student Name</th>
            <th>Class</th>
            <th>Parent's Name</th>
            <th>Mobile / Email</th>
            <th>Registered Date</th>
            <th>Payment Status</th>
            <th>Payment ID</th>
            <th>Amount Paid</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($students as $key => $student)
            @php
              $referral = $student->gpReferrals->where('gp_id', $gp->id)->first();
              $successTx = $student->transactions->where('status', 'success')->first();
              $paymentId = $referral->payment_id ?? ($successTx->razorpay_payment_id ?? null);
              $paidAmount = $referral->amount ?? ($successTx->amount ?? null);
              $paidDate = $successTx ? $successTx->created_at : ($referral ? $referral->created_at : $student->created_at);
            @endphp
            <tr>
              <td><strong>{{ $students->firstItem() + $key }}</strong></td>
              <td>
                <span class="badge bg-label-danger fw-bold">{{ $student->student_id }}</span>
              </td>
              <td>
                <span class="fw-semibold text-dark">{{ $student->student_name }}</span>
                <span class="badge bg-label-primary ms-1">Age: {{ $student->age }}</span>
              </td>
              <td>
                <span class="badge bg-label-warning">{{ $student->classes->name ?? '-' }}</span>
              </td>
              <td>{{ $student->parent_name }}</td>
              <td>
                <div>
                  <a href="tel:{{ $student->mobile }}" class="text-body small">
                    <i class="bx bx-phone me-1 text-primary"></i>{{ $student->mobile }}
                  </a>
                </div>
                <div class="text-muted small">
                  <i class="bx bx-envelope me-1"></i>{{ $student->email }}
                </div>
              </td>
              <td>
                <small class="text-muted">{{ $student->created_at ? $student->created_at->format('d M, Y') : '-' }}</small>
              </td>
              <td>
                <span class="badge bg-success">
                  <i class="bx bx-check-circle me-1"></i>PAID
                </span>
                @if($paidDate)
                  <div class="text-muted" style="font-size: 0.75rem;">
                    {{ $paidDate->format('d M, Y') }}
                  </div>
                @endif
              </td>
              <td>
                @if ($paymentId)
                  <span class="badge bg-label-info font-monospace">{{ $paymentId }}</span>
                @else
                  <span class="badge bg-label-secondary">Active</span>
                @endif
              </td>
              <td>
                @if ($paidAmount)
                  <strong class="text-success">₹{{ number_format($paidAmount, 2) }}</strong>
                @else
                  <span class="text-muted small">-</span>
                @endif
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="10" class="text-center py-4">
                <div class="text-muted">
                  <i class="bx bx-info-circle fs-3 d-block mb-1 text-warning"></i>
                  No paid referred students found for this Ground Partner.
                  <div class="small mt-1 text-muted">Students registered under this GP will appear here once they complete their subscription payment.</div>
                </div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    @if ($students->hasPages())
      <div class="card-footer bg-transparent border-top d-flex justify-content-between align-items-center flex-wrap">
        <small class="text-muted">
          Showing {{ $students->firstItem() }} to {{ $students->lastItem() }} of {{ $students->total() }} paid students
        </small>
        <div>
          {{ $students->links('pagination::bootstrap-5') }}
        </div>
      </div>
    @endif
  </div>
</div>

@endsection
