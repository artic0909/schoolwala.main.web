@extends('admin.layouts.app')

@section('title', 'Students - Schoolwala')

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

  /* Table styling */
  .table-students th {
    font-size: 0.78rem;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    white-space: nowrap;
    vertical-align: middle;
  }
  .table-students td {
    vertical-align: middle;
    font-size: 0.88rem;
  }
  /* Clean Bootstrap 5 pagination */
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

<div class="row">
  <div class="col-lg-12 mb-4 order-0">
    <div class="card">
      <div class="d-flex align-items-end row">
        <div class="col-sm-7">
          <div class="card-body">
            <h5 class="card-title text-primary">
              List of Students !
            </h5>
            <p class="mb-4">
              You can <strong>add/ edit/ delete</strong> students
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

        <!-- Student Search Filter -->
        <div class="col-lg-12 mb-3">
          <form action="{{ route('admin.admin-students') }}" method="GET">
            <div class="row g-2 align-items-center">
              <!-- Choose Class -->
              <div class="col-md-3 col-sm-6">
                <label for="class_id" class="form-label small mb-1 fw-bold">Class</label>
                <select name="class_id" id="class_id" class="form-select form-select-sm">
                  <option value="">All Classes</option>
                  @foreach($classes as $class)
                  <option value="{{ $class->id }}" {{ (isset($classId) && $classId == $class->id) || request('class_id') == $class->id ? 'selected' : '' }}>
                    {{ $class->name }}
                  </option>
                  @endforeach
                </select>
              </div>

              <!-- Payment Status Filter -->
              <div class="col-md-2 col-sm-6">
                <label for="payment_status" class="form-label small mb-1 fw-bold">Payment Status</label>
                <select name="payment_status" id="payment_status" class="form-select form-select-sm">
                  <option value="">All Status</option>
                  <option value="active" {{ request('payment_status') == 'active' ? 'selected' : '' }}>Active</option>
                  <option value="expired" {{ request('payment_status') == 'expired' ? 'selected' : '' }}>Expired</option>
                  <option value="not_subscribed" {{ request('payment_status') == 'not_subscribed' ? 'selected' : '' }}>Not Subscribed</option>
                  <option value="waiver" {{ request('payment_status') == 'waiver' ? 'selected' : '' }}>Waiver</option>
                </select>
              </div>

              <!-- Search Input -->
              <div class="col-md-3 col-sm-6">
                <label for="search" class="form-label small mb-1 fw-bold">Search</label>
                <input type="text" name="search" id="search" class="form-control form-control-sm" placeholder="Name, ID, mobile, email..." value="{{ request('search') }}">
              </div>

              <!-- Rows Per Page Filter -->
              <div class="col-md-2 col-sm-6">
                <label for="per_page" class="form-label small mb-1 fw-bold">Rows Per Page</label>
                <select name="per_page" id="per_page" class="form-select form-select-sm">
                  <option value="10" {{ request('per_page', $perPage ?? 10) == 10 ? 'selected' : '' }}>10 rows</option>
                  <option value="25" {{ request('per_page', $perPage ?? 10) == 25 ? 'selected' : '' }}>25 rows</option>
                  <option value="50" {{ request('per_page', $perPage ?? 10) == 50 ? 'selected' : '' }}>50 rows</option>
                  <option value="100" {{ request('per_page', $perPage ?? 10) == 100 ? 'selected' : '' }}>100 rows</option>
                </select>
              </div>

              <!-- Actions: Search & Reset -->
              <div class="col-md-2 col-sm-12 d-flex align-items-end gap-1 mt-auto pt-sm-0 pt-2">
                <button class="btn btn-sm btn-primary w-100" type="submit">
                  <i class="bx bx-search me-1"></i> Filter
                </button>
                <a href="{{ route('admin.admin-students') }}" class="btn btn-sm btn-outline-secondary w-100">
                  <i class="bx bx-reset me-1"></i> Reset
                </a>
              </div>
            </div>
          </form>
        </div>

        <div class="col-lg-12">
          <div class="table-responsive">
            <table class="table table-hover table-bordered table-students align-middle mb-0">
              <thead class="table-light">
                <tr>
                  <th style="width: 45px;" class="text-center">SL</th>
                  <th style="width: 130px;">Student ID</th>
                  <th style="min-width: 200px;">Student Details</th>
                  <th style="width: 90px;" class="text-center">Class</th>
                  <th style="min-width: 170px;">Email / Mobile</th>
                  <th style="width: 130px;" class="text-center">Payment Status</th>
                  <th style="width: 160px;" class="text-center">Actions</th>
                </tr>
              </thead>
              <tbody class="table-border-bottom-0">
                @forelse ($students as $student)
                <tr>
                  <td class="text-center">
                    <strong>{{ $students->firstItem() ? ($students->firstItem() + $loop->index) : $loop->iteration }}</strong>
                  </td>

                  <td>
                    <span class="badge bg-label-danger text-nowrap">{{ $student->student_id }}</span>
                    @if($student->groundPartner)
                      <div class="mt-1">
                        <a href="{{ route('admin.admin-ground-partner.view', $student->groundPartner->id) }}" class="badge bg-label-info text-nowrap" title="Referred by GP: {{ $student->groundPartner->name }}">
                          <i class="bx bx-barcode me-1"></i>{{ $student->groundPartner->code }}
                        </a>
                      </div>
                    @endif
                  </td>

                  <td>
                    <div class="d-flex align-items-center">
                      <div class="avatar avatar-sm me-2 flex-shrink-0">
                        <span class="avatar-initial rounded-circle bg-label-primary">
                          {{ strtoupper(substr($student->student_name ?? 'S', 0, 1)) }}
                        </span>
                      </div>
                      <div>
                        <div class="fw-bold text-dark text-nowrap">{{ $student->student_name }}</div>
                        <div class="small text-muted d-flex align-items-center gap-2 flex-wrap">
                          <span><i class="bx bx-user me-1"></i>Parent: {{ $student->parent_name ?? 'N/A' }}</span>
                          <span><i class="bx bx-calendar me-1"></i>Age: {{ $student->age }} yrs</span>
                          <span class="badge bg-label-{{ $student->type === 'waiver' ? 'info' : 'secondary' }} py-0 px-1">{{ ucfirst($student->type) }}</span>
                        </div>
                      </div>
                    </div>
                  </td>

                  <td class="text-center">
                    <span class="badge bg-label-warning text-nowrap">{{ $student->classes->name ?? '-' }}</span>
                  </td>

                  <td>
                    <div class="small">
                      <div class="text-nowrap mb-1">
                        <i class="bx bx-envelope text-muted me-1"></i>{{ $student->email }}
                      </div>
                      <div class="text-nowrap">
                        <i class="bx bx-phone text-muted me-1"></i>{{ $student->mobile }}
                      </div>
                    </div>
                  </td>

                  <!-- Payment Status -->
                  <td class="text-center">
                    @php
                      $payStatus = $student->payment_status;
                    @endphp
                    @if($payStatus === 'Active')
                      <span class="badge bg-success text-nowrap px-3 py-2">Active</span>
                    @elseif($payStatus === 'Expired')
                      <span class="badge bg-danger text-nowrap px-3 py-2">Expired</span>
                    @elseif($payStatus === 'Waiver')
                      <span class="badge bg-info text-nowrap px-3 py-2">Waiver</span>
                    @else
                      <span class="badge bg-warning text-nowrap px-3 py-2">Not Subscribed</span>
                    @endif
                  </td>

                  <!-- Actions (Single Line, Just Icons, Waiver Text Only) -->
                  <td class="text-center">
                    <div class="d-flex align-items-center justify-content-center gap-1 flex-nowrap">
                      <!-- View Payments (Icon Only) -->
                      <a href="{{ route('admin.admin-student.payments', $student->id) }}"
                        class="btn btn-sm btn-icon btn-primary"
                        data-bs-toggle="tooltip"
                        title="View Payments">
                        <i class="bx bx-show"></i>
                      </a>

                      <!-- Edit (Icon Only) -->
                      <button
                        type="button"
                        class="btn btn-sm btn-icon btn-warning"
                        data-bs-toggle="modal"
                        data-bs-target="#backDropModalEditClass{{ $student->id }}"
                        title="Edit Student">
                        <i class="bx bx-edit-alt"></i>
                      </button>

                      <!-- Delete (Icon Only) -->
                      <button
                        type="button"
                        class="btn btn-sm btn-icon btn-danger"
                        data-bs-toggle="modal"
                        data-bs-target="#backDropModalDeleteClass{{ $student->id }}"
                        title="Delete Student">
                        <i class="bx bx-trash"></i>
                      </button>

                      <!-- Waiver (Waiver Text Only) -->
                      @if($student->type == 'regular')
                      <button
                        type="button"
                        class="btn btn-sm btn-outline-info px-2"
                        data-bs-toggle="modal"
                        data-bs-target="#backDropModalTypeChange{{ $student->id }}"
                        title="Convert to Waiver"
                        style="font-size: 0.78rem; font-weight: 600; line-height: 1.6;">
                        Waiver
                      </button>
                      @else
                      <button
                        type="button"
                        class="btn btn-sm btn-outline-secondary px-2"
                        data-bs-toggle="modal"
                        data-bs-target="#backDropModalTypeChangeRegular{{ $student->id }}"
                        title="Convert to Regular"
                        style="font-size: 0.78rem; font-weight: 600; line-height: 1.6;">
                        Regular
                      </button>
                      @endif
                    </div>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="7" class="text-center py-4">
                    <div class="text-muted">
                      <i class="bx bx-user-x fs-1 d-block mb-1"></i>
                      No students found matching your criteria.
                    </div>
                  </td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>

          <!-- Pagination -->
          <div class="card-footer d-flex justify-content-between align-items-center flex-wrap pt-3 pb-3 border-top">
            <div class="text-muted small mb-2 mb-sm-0">
              Showing {{ $students->firstItem() ?? 0 }} to {{ $students->lastItem() ?? 0 }} of {{ $students->total() }} students
            </div>
            <div class="pagination-container">
              {{ $students->links('pagination::bootstrap-5') }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Add Student Modal -->
<div
  class="modal fade"
  id="backDropModalAddClass"
  data-bs-backdrop="static"
  tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <form class="modal-content" method="POST" action="{{ route('admin.admin-students.add') }}">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title">Add Student</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <div class="row">
          <div class="col mb-3">
            <label class="form-label">Choose Student Type</label>
            <select name="type" class="form-select">
              <option value="regular" {{ old('type') == 'regular' ? 'selected' : '' }}>Regular</option>
              <option value="waiver" {{ old('type') == 'waiver' ? 'selected' : '' }}>Waiver</option>
            </select>
          </div>
        </div>

        <div class="row">
          <div class="col mb-3">
            <label class="form-label">Parent's Name</label>
            <input type="text" name="parent_name" class="form-control" value="{{ old('parent_name') }}" />
          </div>
          <div class="col mb-3">
            <label class="form-label">Student's Name</label>
            <input type="text" name="student_name" class="form-control" value="{{ old('student_name') }}" />
          </div>
        </div>

        <div class="row">
          <div class="col mb-3">
            <label class="form-label">Email ID</label>
            <input type="text" name="email" class="form-control" value="{{ old('email') }}" />
          </div>
          <div class="col mb-3">
            <label class="form-label">Mobile</label>
            <input type="text" name="mobile" class="form-control" value="{{ old('mobile') }}" />
          </div>
        </div>

        <div class="row">
          <div class="col mb-3">
            <label class="form-label">Student's Age</label>
            <input type="text" name="age" class="form-control" value="{{ old('age') }}" />
          </div>
          <div class="col mb-3">
            <label class="form-label">Choose Class</label>
            <select name="class_id" class="form-select">
              <option value="" selected disabled>Select Class</option>
              @foreach($classes as $class)
              <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                {{ $class->name }}
              </option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="row">
          <div class="col mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" />
          </div>
          <div class="col mb-3">
            <label class="form-label">Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control" />
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
    </form>

  </div>
</div>

<!-- Edit Student Modal -->
@foreach ($students as $student)
<div class="modal fade" id="backDropModalEditClass{{ $student->id }}" data-bs-backdrop="static" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <form class="modal-content" method="POST" action="{{ route('admin.admin-students.edit', $student->id) }}">
      @csrf
      @method('PUT')

      <div class="modal-header">
        <h5 class="modal-title">Edit Student</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        {{-- TYPE --}}
        <div class="row">
          <div class="col mb-3">
            <label class="form-label">Choose Student Type</label>
            <select name="type" class="form-select">
              <option value="regular" {{ $student->type == 'regular' ? 'selected' : '' }}>Regular</option>
              <option value="waiver" {{ $student->type == 'waiver' ? 'selected' : '' }}>Waiver</option>
            </select>
          </div>
        </div>

        {{-- PARENT + STUDENT NAME --}}
        <div class="row">
          <div class="col mb-3">
            <label class="form-label">Parent's Name</label>
            <input type="text" name="parent_name" class="form-control" value="{{ old('parent_name', $student->parent_name) }}" />
          </div>
          <div class="col mb-3">
            <label class="form-label">Student's Name</label>
            <input type="text" name="student_name" class="form-control" value="{{ old('student_name', $student->student_name) }}" />
          </div>
        </div>

        {{-- EMAIL + MOBILE --}}
        <div class="row">
          <div class="col mb-3">
            <label class="form-label">Email ID</label>
            <input type="text" name="email" class="form-control" value="{{ old('email', $student->email) }}" />
          </div>
          <div class="col mb-3">
            <label class="form-label">Mobile</label>
            <input type="text" name="mobile" class="form-control" value="{{ old('mobile', $student->mobile) }}" />
          </div>
        </div>

        {{-- AGE + CLASS --}}
        <div class="row">
          <div class="col mb-3">
            <label class="form-label">Student's Age</label>
            <input type="text" name="age" class="form-control" value="{{ old('age', $student->age) }}" />
          </div>
          <div class="col mb-3">
            <label class="form-label">Choose Class</label>
            <select name="class_id" class="form-select">
              @foreach($classes as $class)
              <option value="{{ $class->id }}" {{ $student->class_id == $class->id ? 'selected' : '' }}>
                {{ $class->name }}
              </option>
              @endforeach
            </select>
          </div>
        </div>

        {{-- PASSWORD --}}
        <div class="row">
          <div class="col mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" placeholder="Leave blank to keep current" />
          </div>
          <div class="col mb-3">
            <label class="form-label">Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control" />
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Update</button>
      </div>
    </form>
  </div>
</div>
@endforeach


<!-- Delete Student Modal -->
@foreach ($students as $student)
<div
  class="modal fade"
  id="backDropModalDeleteClass{{ $student->id }}"
  data-bs-backdrop="static"
  tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <form class="modal-content" method="POST" action="{{ route('admin.admin-students.delete', $student->id)}}">
      @csrf
      @method('DELETE')

      <div class="modal-header">
        <h5 class="modal-title" id="backDropModalTitle">
          Delete Student
        </h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col mb-3">
            <p>
              Are you sure you want to delete this student
              <span class="text-danger">{{ $student->student_id }}</span>?
            </p>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button
          type="button"
          class="btn btn-outline-secondary"
          data-bs-dismiss="modal">
          Close
        </button>
        <button type="submit" class="btn btn-danger">Delete</button>
      </div>
    </form>
  </div>
</div>
@endforeach


<!-- Student Type Change into Waiver Modal -->
@foreach ($students as $student)
<div
  class="modal fade"
  id="backDropModalTypeChange{{ $student->id }}"
  data-bs-backdrop="static"
  tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <form class="modal-content" method="POST" action="{{ route('admin.admin-students.type-waiver', $student->id)}}">
      @csrf

      <div class="modal-header">
        <h5 class="modal-title" id="backDropModalTitle">
          Change Type of Student
        </h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col mb-3">
            <p>
              Are you sure you want to change the type of this student
              <span class="text-danger">{{ $student->student_id }}</span>?
            </p>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button
          type="button"
          class="btn btn-outline-secondary"
          data-bs-dismiss="modal">
          Close
        </button>
        <button type="submit" class="btn btn-danger">Yes, Convert to Waiver</button>
      </div>
    </form>
  </div>
</div>
@endforeach

<!-- Student Type Change into Regular Modal -->
@foreach ($students as $student)
<div
  class="modal fade"
  id="backDropModalTypeChangeRegular{{ $student->id }}"
  data-bs-backdrop="static"
  tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <form class="modal-content" method="POST" action="{{ route('admin.admin-students.type-regular', $student->id)}}">
      @csrf

      <div class="modal-header">
        <h5 class="modal-title" id="backDropModalTitle">
          Change Type of Student
        </h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col mb-3">
            <p>
              Are you sure you want to change the type of this student
              <span class="text-danger">{{ $student->student_id }}</span>?
            </p>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button
          type="button"
          class="btn btn-outline-secondary"
          data-bs-dismiss="modal">
          Close
        </button>
        <button type="submit" class="btn btn-danger">Yes, Convert to Regular</button>
      </div>
    </form>
  </div>
</div>
@endforeach

<!-- Add Button -->
<a
  type="button"
  data-bs-toggle="modal"
  data-bs-target="#backDropModalAddClass"
  class="fab"
  aria-label="Add new item"
  title="Add">
  Add
</a>

@endsection