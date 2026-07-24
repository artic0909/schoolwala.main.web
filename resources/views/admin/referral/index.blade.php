@extends('admin.layouts.app')

@section('title', 'Referrals - Schoolwala')

@section('content')

<div class="row">
  <!-- KPIs -->
  <div class="col-lg-6 mb-4">
    <div class="card bg-primary text-white">
      <div class="card-body">
        <h5 class="card-title text-white">Total Referrals</h5>
        <h2 class="text-white mb-0">{{ $totalReferrals }}</h2>
      </div>
    </div>
  </div>
  <div class="col-lg-6 mb-4">
    <div class="card bg-info text-white">
      <div class="card-body">
        <h5 class="card-title text-white">Monthly Referrals</h5>
        <h2 class="text-white mb-0">{{ $monthlyReferrals }}</h2>
      </div>
    </div>
  </div>

  <div class="col-lg-12 mb-4 order-0">
    <div class="card">
      <div class="d-flex align-items-end row">
        <div class="col-sm-12">
          <div class="card-body">
            <h5 class="card-title text-primary">
              List of Referrals
            </h5>
            <p class="mb-4">
              View and filter all submitted referrals.
            </p>
          </div>
        </div>
        
        <!-- Filter & Search -->
        <div class="col-lg-12 mb-4">
          <div class="card-body pb-0">
            <form action="{{ route('admin.admin-referrals') }}" method="GET" id="filterForm">
              <div class="row g-3 align-items-center">
                
                <div class="col-auto">
                  <label for="from_date" class="form-label">From Date</label>
                  <input type="date" name="from_date" id="from_date" class="form-control" value="{{ request('from_date') }}">
                </div>
                
                <div class="col-auto">
                  <label for="to_date" class="form-label">To Date</label>
                  <input type="date" name="to_date" id="to_date" class="form-control" value="{{ request('to_date') }}">
                </div>

                <div class="col-auto">
                  <label for="search" class="form-label">Search</label>
                  <input type="text" name="search" id="search" class="form-control" placeholder="Student ID or Referral Code" value="{{ request('search') }}">
                </div>

                <div class="col-auto mt-4 pt-2">
                  <button type="submit" class="btn btn-primary">Filter</button>
                  <a href="{{ route('admin.admin-referrals') }}" class="btn btn-secondary">Reset</a>
                </div>

                <div class="col-auto mt-4 pt-2 ms-auto">
                  <button type="button" onclick="exportExcel()" class="btn btn-success">
                    <i class="bx bx-export me-1"></i> Export Excel
                  </button>
                </div>
                
              </div>
            </form>
          </div>
        </div>

        <div class="col-lg-12">
          <div class="table-responsive text-nowrap">
            <table class="table table-hover table-bordered">
              <thead>
                <tr>
                  <th>SL</th>
                  <th>Student ID</th>
                  <th>Referral Code</th>
                  <th>Screenshot</th>
                  <th>Submitted At</th>
                </tr>
              </thead>
              <tbody class="table-border-bottom-0">
                @forelse($referrals as $key => $referral)
                <tr>
                  <td>{{ $referrals->firstItem() + $key }}</td>
                  <td><strong>{{ $referral->student_id }}</strong></td>
                  <td><span class="badge bg-label-info">{{ $referral->referral_code }}</span></td>
                  <td>
                    @if($referral->screenshot)
                      <a href="{{ asset('storage/' . $referral->screenshot) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                        View Image
                      </a>
                    @else
                      <span class="text-muted">No Image</span>
                    @endif
                  </td>
                  <td>{{ $referral->created_at->format('d M, Y - h:i A') }}</td>
                </tr>
                @empty
                <tr>
                  <td colspan="5" class="text-center text-muted">No referrals found</td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>

        <!-- Pagination -->
        <div class="col-lg-12 mt-4 d-flex justify-content-center">
            {{ $referrals->links('pagination::bootstrap-5') }}
        </div>
        
      </div>
    </div>
  </div>
</div>

<script>
  function exportExcel() {
    let form = document.getElementById('filterForm');
    let url = new URL("{{ route('admin.admin-referrals.export') }}");
    
    // Add current form filters to the export URL
    let formData = new FormData(form);
    for (let [key, value] of formData.entries()) {
        if(value) {
            url.searchParams.append(key, value);
        }
    }
    
    window.location.href = url.toString();
  }
</script>

@endsection
