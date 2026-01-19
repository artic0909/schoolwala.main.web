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
        <div class="col-lg-12 mb-4">
          <form action="{{ route('admin.admin-students') }}" method="GET">
            <div class="input-group mb-3">
              <label for="class_id" class="input-group-text">Choose Class</label>
              <select name="class_id" id="class_id" class="form-select">
                <option value="">All Classes</option>
                @foreach($classes as $class)
                <option value="{{ $class->id }}" {{ isset($classId) && $classId == $class->id ? 'selected' : '' }}>
                  {{ $class->name }}
                </option>
                @endforeach
              </select>

              <button class="btn btn-primary" type="submit">Search</button>
              &nbsp;&nbsp;
              <a href="{{ route('admin.admin-students') }}" class="btn btn-info">Reset</a>
            </div>
          </form>

        </div>

        <div class="col-lg-12">
          <div class="table-responsive text-nowrap">
            <table class="table table-hover table-bordered">
              <thead>
                <tr>
                  <th>SL</th>
                  <th>STU ID</th>
                  <th>STU Type</th>
                  <th>Student Name</th>
                  <th>Student Age</th>
                  <th>Class Name</th>
                  <th>Parent's Name</th>
                  <th>Email/ Mobile</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody class="table-border-bottom-0">
                @foreach ($students as $student)
                <tr>
                  <td>
                    <strong>{{$loop->iteration}}</strong>
                  </td>
                  <td>
                    <span class="badge bg-label-danger">{{$student->student_id}}</span>
                  </td>
                  <td style="text-transform: capitalize;">{{$student->type}}</td>
                  <td>{{$student->student_name}}</td>
                  <td>
                    <span class="badge bg-label-primary">Age: {{$student->age}}</span>
                  </td>
                  <td>
                    <span class="badge bg-label-warning">{{ $student->classes->name ?? '-' }}</span>
                  </td>
                  <td>{{$student->parent_name}}</td>
                  <td>
                    <p class="m-0 p-0">{{$student->email}}</p>
                    <p class="m-0 p-0">{{$student->mobile}}</p>
                  </td>

                  <td>
                    <div class="row g-2">
                      @if($student->type == 'regular')
                      <button
                        type="button"
                        class="btn btn-info"
                        data-bs-toggle="modal"
                        data-bs-target="#backDropModalTypeChange{{ $student->id }}">
                        Convert to Waiver
                      </button>

                      @else

                      <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-toggle="modal"
                        data-bs-target="#backDropModalTypeChangeRegular{{ $student->id }}">
                        Convert to Regular
                      </button>

                      @endif

                      <button
                        type="button"
                        class="btn btn-warning"
                        data-bs-toggle="modal"
                        data-bs-target="#backDropModalEditClass{{ $student->id }}">
                        Edit
                      </button>
                      <button
                        class="btn btn-danger"
                        type="button"
                        data-bs-toggle="modal"
                        data-bs-target="#backDropModalDeleteClass{{ $student->id }}">
                        Delete
                      </button>

                    </div>
                  </td>
                </tr>
                @endforeach
              </tbody>
              <!-- Pagination -->
              <tfoot>
                <tr>
                  <td colspan="10">
                    <div class="d-flex justify-content-center">
                      <div class="d-flex justify-content-center align-items-center mt-3">
                        @if ($students->onFirstPage())
                        <button class="btn btn-secondary me-2" disabled>Prev</button>
                        @else
                        <a href="{{ $students->previousPageUrl() }}" class="btn btn-primary me-2">Prev</a>
                        @endif

                        <form action="" method="GET" class="d-flex align-items-center">
                          <input type="number" name="page" value="{{ $students->currentPage() }}"
                            min="1" max="{{ $students->lastPage() }}"
                            class="form-control text-center me-1" style="width: 70px;"
                            onchange="this.form.submit()" readonly>

                          <span class="mx-1">/</span>
                          <input type="text" readonly value="{{ $students->lastPage() }}"
                            class="form-control text-center ms-1" style="width: 70px;">
                        </form>

                        @if ($students->hasMorePages())
                        <a href="{{ $students->nextPageUrl() }}" class="btn btn-primary ms-2">Next</a>
                        @else
                        <button class="btn btn-secondary ms-2" disabled>Next</button>
                        @endif
                      </div>
                    </div>
                  </td>
                </tr>
              </tfoot>
            </table>
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