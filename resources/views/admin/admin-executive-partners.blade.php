@extends('admin.layouts.app')

@section('title', 'Executive Partners (EP) - Schoolwala')

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
    background: #696cff;
    color: #fff !important;
    box-shadow: 0 10px 25px rgba(105, 108, 255, 0.35),
      0 6px 10px rgba(0, 0, 0, 0.08);
    text-decoration: none;
    z-index: 1050;
    transition: transform 0.15s ease, box-shadow 0.15s ease, filter 0.15s ease;
  }

  .fab:hover {
    transform: translateY(-2px);
    box-shadow: 0 14px 30px rgba(105, 108, 255, 0.45),
      0 8px 14px rgba(0, 0, 0, 0.1);
    filter: brightness(1.05);
  }

  .kpi-card {
    border-radius: 10px;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
  }
  .kpi-card:hover {
    transform: translateY(-2px);
  }
</style>

<div class="row">
  <!-- KPI Metrics -->
  <div class="col-lg-3 col-md-6 col-6 mb-4">
    <div class="card kpi-card bg-primary text-white shadow-sm">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <span class="d-block fw-semibold text-white-50 small">Total EPs</span>
            <h3 class="card-title text-white mb-0 mt-1">{{ $totalEP }}</h3>
          </div>
          <div class="avatar flex-shrink-0">
            <span class="avatar-initial rounded bg-white text-primary">
              <i class="bx bx-user-pin fs-4"></i>
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-3 col-md-6 col-6 mb-4">
    <div class="card kpi-card bg-success text-white shadow-sm">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <span class="d-block fw-semibold text-white-50 small">Active EPs</span>
            <h3 class="card-title text-white mb-0 mt-1">{{ $activeEP }}</h3>
          </div>
          <div class="avatar flex-shrink-0">
            <span class="avatar-initial rounded bg-white text-success">
              <i class="bx bx-check-circle fs-4"></i>
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-3 col-md-6 col-6 mb-4">
    <div class="card kpi-card bg-warning text-white shadow-sm">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <span class="d-block fw-semibold text-white-50 small">Inactive EPs</span>
            <h3 class="card-title text-white mb-0 mt-1">{{ $inactiveEP }}</h3>
          </div>
          <div class="avatar flex-shrink-0">
            <span class="avatar-initial rounded bg-white text-warning">
              <i class="bx bx-x-circle fs-4"></i>
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-3 col-md-6 col-6 mb-4">
    <div class="card kpi-card bg-info text-white shadow-sm">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <span class="d-block fw-semibold text-white-50 small">Total Ground Partners</span>
            <h3 class="card-title text-white mb-0 mt-1">{{ $totalGP }}</h3>
          </div>
          <div class="avatar flex-shrink-0">
            <span class="avatar-initial rounded bg-white text-info">
              <i class="bx bx-group fs-4"></i>
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Main Card -->
  <div class="col-lg-12 mb-4 order-0">
    <div class="card">
      <div class="card-body">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
          <div>
            <h5 class="card-title text-primary mb-1">
              <i class="bx bx-user-pin me-1"></i> Executive Partners (EP)
            </h5>
            <p class="text-muted mb-0 small">
              Manage all Executive Partners, monitor their details, linked Ground Partners, and active status.
            </p>
          </div>
          <div class="mt-2 mt-sm-0">
            <button
              type="button"
              class="btn btn-primary"
              data-bs-toggle="modal"
              data-bs-target="#modalAddEP">
              <i class="bx bx-plus me-1"></i> Add Executive Partner
            </button>
          </div>
        </div>

        <!-- Filter & Search Bar -->
        <form action="{{ route('admin.admin-executive-partners') }}" method="GET" class="mb-4">
          <div class="row g-2 align-items-end">
            <div class="col-md-5 col-sm-6">
              <label class="form-label small">Search</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bx bx-search"></i></span>
                <input
                  type="text"
                  name="search"
                  class="form-control"
                  placeholder="Search by code, name, or mobile..."
                  value="{{ request('search') }}">
              </div>
            </div>

            <div class="col-md-3 col-sm-6">
              <label class="form-label small">Status</label>
              <select name="status" class="form-select">
                <option value="">All Statuses</option>
                <option value="Active" {{ request('status') === 'Active' ? 'selected' : '' }}>Active</option>
                <option value="Inactive" {{ request('status') === 'Inactive' ? 'selected' : '' }}>Inactive</option>
              </select>
            </div>

            <div class="col-md-4 col-sm-12 d-flex gap-2">
              <button type="submit" class="btn btn-outline-primary flex-grow-1">
                <i class="bx bx-filter-alt me-1"></i> Filter
              </button>
              <a href="{{ route('admin.admin-executive-partners') }}" class="btn btn-outline-secondary">
                Reset
              </a>
            </div>
          </div>
        </form>

        <!-- Table -->
        <div class="table-responsive text-nowrap">
          <table class="table table-hover table-bordered align-middle">
            <thead class="table-light">
              <tr>
                <th style="width: 60px;">SL</th>
                <th>Partner Code</th>
                <th>Name</th>
                <th>Mobile</th>
                <th>Linked GPs</th>
                <th>Status</th>
                <th>Created At</th>
                <th style="width: 160px;" class="text-center">Actions</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($executivePartners as $key => $ep)
              <tr>
                <td><strong>{{ $executivePartners->firstItem() + $key }}</strong></td>
                <td>
                  <span class="badge bg-label-primary fs-6 fw-bold">
                    <i class="bx bx-barcode me-1"></i>{{ $ep->code }}
                  </span>
                </td>
                <td>
                  <span class="fw-semibold">{{ $ep->name }}</span>
                </td>
                <td>
                  <a href="tel:{{ $ep->mobile }}" class="text-body">
                    <i class="bx bx-phone me-1 text-primary"></i>{{ $ep->mobile }}
                  </a>
                </td>
                <td>
                  <a href="{{ route('admin.admin-ground-partners', ['ep_id' => $ep->id]) }}" class="badge bg-label-info" title="View linked Ground Partners">
                    <i class="bx bx-group me-1"></i>{{ $ep->ground_partners_count }} GPs
                  </a>
                </td>
                <td>
                  @if ($ep->status === 'Active')
                    <span class="badge bg-success">Active</span>
                  @else
                    <span class="badge bg-danger">Inactive</span>
                  @endif

                  <form action="{{ route('admin.admin-executive-partner.toggle-status', $ep->id) }}" method="POST" class="d-inline ms-1">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-xs btn-outline-{{ $ep->status === 'Active' ? 'warning' : 'success' }}" title="Toggle Status">
                      <i class="bx {{ $ep->status === 'Active' ? 'bx-pause' : 'bx-play' }}"></i>
                    </button>
                  </form>
                </td>
                <td>
                  <small class="text-muted">{{ $ep->created_at ? $ep->created_at->format('Y-m-d H:i') : '-' }}</small>
                </td>
                <td class="text-center">
                  <button
                    type="button"
                    class="btn btn-sm btn-warning"
                    data-bs-toggle="modal"
                    data-bs-target="#modalEditEP{{ $ep->id }}"
                    title="Edit Partner">
                    <i class="bx bx-edit-alt"></i> Edit
                  </button>
                  <button
                    type="button"
                    class="btn btn-sm btn-danger"
                    data-bs-toggle="modal"
                    data-bs-target="#modalDeleteEP{{ $ep->id }}"
                    title="Delete Partner">
                    <i class="bx bx-trash"></i>
                  </button>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="8" class="text-center py-4">
                  <div class="text-muted">
                    <i class="bx bx-info-circle fs-3 d-block mb-1"></i>
                    No Executive Partners found.
                  </div>
                </td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-between align-items-center mt-3">
          <small class="text-muted">
            Showing {{ $executivePartners->firstItem() ?? 0 }} to {{ $executivePartners->lastItem() ?? 0 }} of {{ $executivePartners->total() }} entries
          </small>
          <div>
            {{ $executivePartners->links() }}
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="modalAddEP" data-bs-backdrop="static" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <form class="modal-content" action="{{ route('admin.admin-executive-partners.store') }}" method="POST">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title">
          <i class="bx bx-user-plus me-1 text-primary"></i> Add Executive Partner (EP)
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label class="form-label">Full Name <span class="text-danger">*</span></label>
          <input
            type="text"
            name="name"
            class="form-control"
            placeholder="e.g. Normai"
            required />
        </div>

        <div class="mb-3">
          <label class="form-label">Partner Code <span class="text-danger">*</span></label>
          <input
            type="text"
            name="code"
            class="form-control text-uppercase"
            placeholder="e.g. EPALL001"
            required />
          <small class="text-muted">Must be unique (e.g. EPALL001, EP001)</small>
        </div>

        <div class="mb-3">
          <label class="form-label">Mobile / Phone <span class="text-danger">*</span></label>
          <input
            type="tel"
            name="mobile"
            class="form-control"
            placeholder="e.g. 6292237205"
            required />
        </div>

        <div class="mb-3">
          <label class="form-label">Status <span class="text-danger">*</span></label>
          <select name="status" class="form-select" required>
            <option value="Active" selected>Active</option>
            <option value="Inactive">Inactive</option>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">
          <i class="bx bx-save me-1"></i> Save Partner
        </button>
      </div>
    </form>
  </div>
</div>

<!-- Edit & Delete Modals -->
@foreach ($executivePartners as $ep)
<!-- Edit Modal -->
<div class="modal fade" id="modalEditEP{{ $ep->id }}" data-bs-backdrop="static" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <form class="modal-content" action="{{ route('admin.admin-executive-partner.update', $ep->id) }}" method="POST">
      @csrf
      @method('PUT')
      <div class="modal-header">
        <h5 class="modal-title">
          <i class="bx bx-edit me-1 text-warning"></i> Edit Executive Partner ({{ $ep->code }})
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label class="form-label">Full Name <span class="text-danger">*</span></label>
          <input
            type="text"
            name="name"
            class="form-control"
            value="{{ $ep->name }}"
            required />
        </div>

        <div class="mb-3">
          <label class="form-label">Partner Code <span class="text-danger">*</span></label>
          <input
            type="text"
            name="code"
            class="form-control text-uppercase"
            value="{{ $ep->code }}"
            required />
        </div>

        <div class="mb-3">
          <label class="form-label">Mobile / Phone <span class="text-danger">*</span></label>
          <input
            type="tel"
            name="mobile"
            class="form-control"
            value="{{ $ep->mobile }}"
            required />
        </div>

        <div class="mb-3">
          <label class="form-label">Status <span class="text-danger">*</span></label>
          <select name="status" class="form-select" required>
            <option value="Active" {{ $ep->status === 'Active' ? 'selected' : '' }}>Active</option>
            <option value="Inactive" {{ $ep->status === 'Inactive' ? 'selected' : '' }}>Inactive</option>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-warning">
          <i class="bx bx-check me-1"></i> Update Partner
        </button>
      </div>
    </form>
  </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="modalDeleteEP{{ $ep->id }}" data-bs-backdrop="static" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <form class="modal-content" action="{{ route('admin.admin-executive-partner.delete', $ep->id) }}" method="POST">
      @csrf
      @method('DELETE')
      <div class="modal-header">
        <h5 class="modal-title">
          <i class="bx bx-trash me-1 text-danger"></i> Delete Executive Partner
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p class="mb-2">Are you sure you want to delete <strong>{{ $ep->name }}</strong> (<code>{{ $ep->code }}</code>)?</p>
        @if ($ep->ground_partners_count > 0)
        <div class="alert alert-warning py-2 mb-0">
          <i class="bx bx-error me-1"></i>
          <strong>Warning:</strong> This partner currently has <strong>{{ $ep->ground_partners_count }}</strong> linked Ground Partner(s). Deleting this EP will also remove its linked GPs.
        </div>
        @endif
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-danger">Yes, Delete</button>
      </div>
    </form>
  </div>
</div>
@endforeach

<!-- Floating Add Button -->
<a
  type="button"
  data-bs-toggle="modal"
  data-bs-target="#modalAddEP"
  class="fab"
  aria-label="Add Executive Partner"
  title="Add Executive Partner">
  <i class="bx bx-plus fs-3"></i>
</a>

@endsection
