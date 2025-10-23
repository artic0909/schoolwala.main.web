@extends('admin.layouts.app')

@section('title', 'Fees Report - Schoolwala')

@section('content')

<style>
  .fab {
    position: fixed;
    right: 34px;
    bottom: 54px;
    width: 56px;
    height: 56px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 9999px;
    background: #0d6efd;
    /* change color as you like */
    color: #fff !important;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15),
      0 6px 10px rgba(0, 0, 0, 0.08);
    text-decoration: none;
    z-index: 1050;
    /* sits above most UI */
    transition: transform 0.15s ease, box-shadow 0.15s ease,
      filter 0.15s ease;
  }

  .fab:hover {
    transform: translateY(-2px);
    box-shadow: 0 14px 30px rgba(0, 0, 0, 0.18),
      0 8px 14px rgba(0, 0, 0, 0.1);
    filter: brightness(1.05);
  }

  .fab:focus-visible {
    outline: 3px solid rgba(13, 110, 253, 0.45);
    outline-offset: 2px;
  }

  @media (prefers-reduced-motion: reduce) {
    .fab {
      transition: none;
    }
  }
</style>

<div class="row">
  <div class="col-lg-12 mb-4 order-0">
    <div class="card">
      <div class="d-flex align-items-end row">
        <div class="col-sm-7">
          <div class="card-body">
            <h5 class="card-title text-primary">Fees Report!</h5>
            <p class="mb-4">
              You can <strong>view and manage</strong> all fees payments
            </p>
          </div>
        </div>
        <div class="col-sm-5 text-center text-sm-left">
          <div class="card-body pb-0 px-0 px-md-4">
            <img
              src="{{ asset('./admin/assets/img/illustrations/man-with-laptop-light.png') }}"
              height="140"
              alt="View Badge User" />
          </div>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
        <div class="col-12">
          <div class="alert alert-success alert-dismissible" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        </div>
        @endif

        @if(session('error'))
        <div class="col-12">
          <div class="alert alert-danger alert-dismissible" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        </div>
        @endif

        <!-- Filter Form -->
        <div class="col-lg-12 mb-4">
          <form action="{{ route('admin.admin-fees-report') }}" method="GET">
            <div class="row">
              <div class="col-md-4 mb-3">
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

              <div class="col-md-3 mb-3">
                <label for="from_date" class="form-label">From Date</label>
                <input type="date" name="from_date" class="form-control" id="from_date" value="{{ request('from_date') }}">
              </div>

              <div class="col-md-3 mb-3">
                <label for="to_date" class="form-label">To Date</label>
                <input type="date" name="to_date" class="form-control" id="to_date" value="{{ request('to_date') }}">
              </div>

              <div class="col-md-2 mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" class="form-select" id="status">
                  <option value="">All Status</option>
                  <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                  <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                  <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
              </div>
            </div>

            <div class="d-flex justify-content-end gap-2">
              <button type="submit" class="btn btn-primary">
                <i class="bx bx-search"></i> Search
              </button>
              <a href="{{ route('admin.admin-fees-report') }}" class="btn btn-secondary">
                <i class="bx bx-reset"></i> Reset
              </a>
              <a href="{{ route('admin.export-fees-report', request()->all()) }}" class="btn btn-info">
                <i class="bx bx-download"></i> Export CSV
              </a>
            </div>
          </form>
        </div>

        <!-- Table -->
        <div class="col-lg-12">
          <div class="table-responsive text-nowrap">
            <table class="table table-hover table-bordered">
              <thead>
                <tr>
                  <th>SL</th>
                  <th>Student ID</th>
                  <th>Class Name</th>
                  <th>Student Name</th>
                  <th>Email/Mobile</th>
                  <th>Fees/Date</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody class="table-border-bottom-0">
                @forelse($subscribers as $index => $subscriber)
                <tr>
                  <td><strong>{{ $subscribers->firstItem() + $index }}</strong></td>

                  <td>
                    <span class="badge bg-label-warning">
                      {{ $subscriber->student->student_id ?? 'N/A' }}
                    </span>
                  </td>

                  <td>
                    <span class="badge bg-label-primary">{{ $subscriber->class->name ?? 'N/A' }}</span>
                  </td>

                  <td>
                    <p class="m-0 p-0 fw-bold">{{ $subscriber->student->student_name ?? 'N/A' }}</p>
                    <small class="text-muted">Type: {{ ucfirst($subscriber->student->type ?? 'regular') }}</small>
                  </td>

                  <td>
                    <p class="m-0 p-0">
                      <i class="bx bx-envelope"></i> {{ $subscriber->student->email ?? 'N/A' }}
                    </p>
                    <p class="m-0 p-0">
                      <i class="bx bx-phone"></i> {{ $subscriber->student->mobile ?? 'N/A' }}
                    </p>
                  </td>

                  <td>
                    <p class="m-0 p-0 fw-bold">₹{{ number_format($subscriber->fees->amount ?? 0, 2) }}</p>
                    <p class="m-0 p-0">
                      Paid: <span class="badge bg-label-info">{{ date('d-m-Y', strtotime($subscriber->subscription_date)) }}</span>
                    </p>
                    @if($subscriber->expiry_date)
                    <p class="m-0 p-0">
                      Expiry: <span class="badge bg-label-danger">{{ date('d-m-Y', strtotime($subscriber->expiry_date)) }}</span>
                    </p>
                    @endif
                  </td>

                  <td>
                    @if($subscriber->status === 'active')
                    <span class="badge bg-success">Active</span>
                    @elseif($subscriber->status === 'pending')
                    <span class="badge bg-warning">Pending</span>
                    @else
                    <span class="badge bg-danger">Inactive</span>
                    @endif
                  </td>

                  <td>
                    <div class="d-flex gap-1 flex-wrap">
                      <!-- View Button -->
                      <button class="btn btn-sm btn-primary"
                        type="button"
                        data-bs-toggle="modal"
                        data-bs-target="#viewModal{{ $subscriber->id }}">
                        <i class="bx bx-show"></i> View
                      </button>

                      <!-- Accept Button (Only for pending status) -->
                      @if($subscriber->status === 'pending')
                      <form action="{{ route('admin.accept-fees', $subscriber->id) }}" method="POST" style="display: inline;">
                        @csrf
                        <button class="btn btn-sm btn-success"
                          type="submit"
                          onclick="return confirm('Are you sure you want to accept this payment?')">
                          <i class="bx bx-check"></i> Accept
                        </button>
                      </form>

                      <form action="{{ route('admin.reject-fees', $subscriber->id) }}" method="POST" style="display: inline;">
                        @csrf
                        <button class="btn btn-sm btn-danger"
                          type="submit"
                          onclick="return confirm('Are you sure you want to reject this payment?')">
                          <i class="bx bx-x"></i> Reject
                        </button>
                      </form>
                      @endif

                      <!-- Send Invoice Button -->
                      <button class="btn btn-sm btn-info"
                        type="button"
                        data-bs-toggle="modal"
                        data-bs-target="#invoiceModal{{ $subscriber->id }}">
                        <i class="bx bx-envelope"></i> Invoice
                      </button>
                    </div>
                  </td>
                </tr>

                <!-- View Modal -->
                <div class="modal fade" id="viewModal{{ $subscriber->id }}" tabindex="-1" aria-hidden="true">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title">Payment Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <div class="row">
                          <div class="col-md-6 mb-3">
                            <strong>Student Name:</strong>
                            <p>{{ $subscriber->student->student_name ?? 'N/A' }}</p>
                          </div>
                          <div class="col-md-6 mb-3">
                            <strong>Email:</strong>
                            <p>{{ $subscriber->student->email ?? 'N/A' }}</p>
                          </div>
                          <div class="col-md-6 mb-3">
                            <strong>Phone:</strong>
                            <p>{{ $subscriber->student->mobile ?? 'N/A' }}</p>
                          </div>
                          <div class="col-md-6 mb-3">
                            <strong>Class:</strong>
                            <p>{{ $subscriber->class->name ?? 'N/A' }}</p>
                          </div>
                          <div class="col-md-6 mb-3">
                            <strong>Amount:</strong>
                            <p class="text-success fw-bold">₹{{ number_format($subscriber->fees->amount ?? 0, 2) }}</p>
                          </div>
                          <div class="col-md-6 mb-3">
                            <strong>Status:</strong>
                            <p>
                              @if($subscriber->status === 'active')
                              <span class="badge bg-success">Active</span>
                              @elseif($subscriber->status === 'pending')
                              <span class="badge bg-warning">Pending</span>
                              @else
                              <span class="badge bg-danger">Inactive</span>
                              @endif
                            </p>
                          </div>
                          <div class="col-md-6 mb-3">
                            <strong>Subscription Date:</strong>
                            <p>{{ date('d-m-Y', strtotime($subscriber->subscription_date)) }}</p>
                          </div>
                          @if($subscriber->expiry_date)
                          <div class="col-md-6 mb-3">
                            <strong>Expiry Date:</strong>
                            <p>{{ date('d-m-Y', strtotime($subscriber->expiry_date)) }}</p>
                          </div>
                          @endif
                          @if($subscriber->reciptimage)
                          <div class="col-12 mb-3">
                            <strong>Payment Receipt:</strong><br>
                            <img src="{{ asset('storage/' . $subscriber->reciptimage) }}"
                              alt="Receipt"
                              class="img-fluid"
                              style="max-width: 100%; max-height: 400px; border: 2px solid #ddd; border-radius: 8px;">
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

                <!-- Send Invoice Modal -->
                <div class="modal fade" id="invoiceModal{{ $subscriber->id }}" tabindex="-1" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <form action="{{ route('admin.send-invoice', $subscriber->id) }}" method="POST">
                        @csrf
                        <div class="modal-header">
                          <h5 class="modal-title">Send Invoice</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <div class="mb-3">
                            <label for="invoice_email{{ $subscriber->id }}" class="form-label">Email Address</label>
                            <input type="email"
                              class="form-control"
                              id="invoice_email{{ $subscriber->id }}"
                              name="invoice_email"
                              value="{{ $subscriber->student->email ?? '' }}"
                              required>
                          </div>
                          <div class="mb-3">
                            <label for="invoice_message{{ $subscriber->id }}" class="form-label">Message (Optional)</label>
                            <textarea class="form-control"
                              id="invoice_message{{ $subscriber->id }}"
                              name="invoice_message"
                              rows="3"
                              placeholder="Add a custom message..."></textarea>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                          <button type="submit" class="btn btn-info">
                            <i class="bx bx-send"></i> Send Invoice
                          </button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>

                @empty
                <tr>
                  <td colspan="9" class="text-center">
                    <div class="alert alert-info mb-0">
                      <i class="bx bx-info-circle"></i> No payment records found.
                    </div>
                  </td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>

          <!-- Pagination -->
          <div class="mt-3">
            {{ $subscribers->appends(request()->all())->links() }}
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection