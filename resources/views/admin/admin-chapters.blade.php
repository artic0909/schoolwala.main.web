@extends('admin.layouts.app')

@section('title', 'Add Chapters - Schoolwala')

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
              List of Capters !
            </h5>
            <p class="mb-4">
              You can <strong>add/ edit/ delete</strong> chapters
            </p>
          </div>
        </div>
        <div class="col-sm-12 text-center text-sm-left">
          <!-- filter -->
          <div class="card-body pb-0 px-0 px-md-4 d-flex justify-content-end gap-2 mb-4">

            <select name="class" id="classFilter" class="form-select w-px-200" style="width: 200px;">
              <option value="">Filter by Class</option>
              @foreach ($classes as $class)
              <option value="{{ $class->id }}" {{ $classId == $class->id ? 'selected' : '' }}>
                {{ $class->name }}
              </option>
              @endforeach
            </select>

            <select name="subject" id="subjectFilter" class="form-select w-px-200" style="width: 200px;">
              <option value="">Filter by Subject</option>
              @foreach ($subjects as $subject)
              <option value="{{ $subject->id }}" {{ $subjectId == $subject->id ? 'selected' : '' }}>
                {{ $subject->name }}
              </option>
              @endforeach
            </select>

            <button id="filterBtn" class="btn btn-primary">Filter</button>
            <button id="resetBtn" class="btn btn-secondary">Reset</button>

          </div>
        </div>

        <div class="col-lg-12">
          <div class="table-responsive text-nowrap">
            <table class="table table-hover table-bordered">
              <thead>
                <tr>
                  <th>SL</th>
                  <th>Class Names</th>
                  <th>Subjects</th>
                  <th>Chapters</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody class="table-border-bottom-0">
                @foreach($chapters as $chapter)
                <tr>
                  <td>
                    <strong>{{ ($chapters->currentPage() - 1) * $chapters->perPage() + $loop->iteration }}</strong>
                  </td>

                  <td>{{ $chapter->class->name }}</td>
                  <td>{{ $chapter->subject->name }}</td>
                  <td>{{ $chapter->name }}</td>

                  <td>
                    <button
                      type="button"
                      class="btn btn-warning"
                      data-bs-toggle="modal"
                      data-bs-target="#backDropModalEditClass{{ $chapter->id }}">
                      Edit
                    </button>
                    &nbsp;
                    <button
                      class="btn btn-danger"
                      type="button"
                      data-bs-toggle="modal"
                      data-bs-target="#backDropModalDeleteClass{{ $chapter->id }}">
                      Delete
                    </button>
                  </td>
                </tr>
                @endforeach
              </tbody>
              <!-- Pagination -->
              <tfoot>
                <tr>
                  <td colspan="5">
                    <div class="d-flex justify-content-center">
                      <div class="d-flex justify-content-center align-items-center mt-3">
                        @if ($chapters->onFirstPage())
                        <button class="btn btn-secondary me-2" disabled>Prev</button>
                        @else
                        <a href="{{ $chapters->previousPageUrl() }}" class="btn btn-primary me-2">Prev</a>
                        @endif

                        <form action="" method="GET" class="d-flex align-items-center">
                          <input type="number" name="page" value="{{ $chapters->currentPage() }}"
                            min="1" max="{{ $chapters->lastPage() }}"
                            class="form-control text-center me-1" style="width: 70px;"
                            onchange="this.form.submit()" readonly>

                          <span class="mx-1">/</span>
                          <input type="text" readonly value="{{ $chapters->lastPage() }}"
                            class="form-control text-center ms-1" style="width: 70px;">
                        </form>

                        @if ($chapters->hasMorePages())
                        <a href="{{ $chapters->nextPageUrl() }}" class="btn btn-primary ms-2">Next</a>
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

<!-- Add Chapter Modal -->
<div
  class="modal fade"
  id="backDropModalAddClass"
  data-bs-backdrop="static"
  tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <form class="modal-content" action="{{ route('admin.admin-chapters.store') }}" method="POST">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title" id="backDropModalTitle">
          Add Chapter
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
            <label for="nameBackdrop" class="form-label">Choose Class</label>
            <select name="class_id" id="class_id_add" class="form-select class-select">
              <option value="" selected>Choose Class</option>
              @foreach ($classes as $class)
              <option value="{{ $class->id }}">{{ $class->name }}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="row">
          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Choose Subject</label>
            <select name="subject_id" id="subject_id_add" class="form-select subject-select">
              <option value="" selected disabled>Choose Subject</option>
              <!-- Subjects will be appended dynamically -->
            </select>
          </div>
        </div>

        <div class="row g-2">
          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Chapter Name</label>
            <input type="text" class="form-control" name="name" id="name" />
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
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
    </form>
  </div>
</div>

<!-- Edit Chapter Modal -->
@foreach($chapters as $chapter)
<div
  class="modal fade"
  id="backDropModalEditClass{{ $chapter->id }}"
  data-bs-backdrop="static"
  tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <form class="modal-content" action="{{ route('admin.admin-chapters.update', $chapter->id) }}" method="POST">
      @csrf
      @method('PUT')
      <div class="modal-header">
        <h5 class="modal-title" id="backDropModalTitle">
          Edit Chapter
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
            <label for="class_id_edit{{ $chapter->id }}" class="form-label">Choose Class</label>
            <select name="class_id"
              id="class_id_edit{{ $chapter->id }}"
              class="form-select class-select"
              data-chapter-id="{{ $chapter->id }}"
              data-selected-class="{{ $chapter->class_id }}"
              data-selected-subject="{{ $chapter->subject_id }}">
              @foreach ($classes as $class)
              <option value="{{ $class->id }}" {{ $class->id == $chapter->class_id ? 'selected' : '' }}>
                {{ $class->name }}
              </option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="row">
          <div class="col mb-3">
            <label for="subject_id_edit{{ $chapter->id }}" class="form-label">Choose Subject</label>
            <select name="subject_id"
              id="subject_id_edit{{ $chapter->id }}"
              class="form-select subject-select">
              <!-- subjects will be loaded dynamically -->
            </select>
          </div>
        </div>

        <div class="row g-2">
          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Chapter Name</label>
            <input type="text" class="form-control" name="name" id="name" value="{{ $chapter->name }}" />
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
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
    </form>
  </div>
</div>
@endforeach

<!-- Delete Chapter Modal -->
@foreach($chapters as $chapter)
<div
  class="modal fade"
  id="backDropModalDeleteClass{{ $chapter->id }}"
  data-bs-backdrop="static"
  tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <form class="modal-content" action="{{ route('admin.admin-chapters.delete', $chapter->id) }}" method="POST">
      @csrf
      @method('DELETE')
      <div class="modal-header">
        <h5 class="modal-title" id="backDropModalTitle">
          Delete Chapter
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
            <p>Are you sure you want to delete this {{ $chapter->name }}?</p>
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


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
  $(document).ready(function() {
    // --- Filter Logic ---
    $('#classFilter').on('change', function() {
      let classId = $(this).val();
      $('#subjectFilter').html('<option value="">Filter by Subject</option>');

      if (classId) {
        let url = "{{ route('admin.get-subjects', ':id') }}".replace(':id', classId);
        $.get(url, function(data) {
          $.each(data, function(key, subject) {
            $('#subjectFilter').append('<option value="' + subject.id + '">' + subject.name + '</option>');
          });
        });
      }
    });

    $('#filterBtn').on('click', function() {
      let classId = $('#classFilter').val();
      let subjectId = $('#subjectFilter').val();

      let url = new URL(window.location.href);
      url.searchParams.set('class', classId || '');
      url.searchParams.set('subject', subjectId || '');
      url.searchParams.set('page', 1);
      window.location.href = url.toString();
    });

    $('#resetBtn').on('click', function() {
      window.location.href = "{{ route('admin.admin-chapters') }}";
    });

    // --- Modal Logic ---
    function loadSubjects(classId, subjectDropdown, selectedSubjectId) {
      subjectDropdown.empty().append('<option value="">Loading...</option>');

      if (classId) {
        let url = "{{ route('admin.get-subjects', ':id') }}".replace(':id', classId);

        $.ajax({
          url: url,
          type: "GET",
          success: function(data) {
            subjectDropdown.empty().append('<option value="">Choose Subject</option>');
            $.each(data, function(key, subject) {
              let selected = subject.id == selectedSubjectId ? 'selected' : '';
              subjectDropdown.append('<option value="' + subject.id + '" ' + selected + '>' + subject.name + '</option>');
            });
          }
        });
      } else {
        subjectDropdown.empty().append('<option value="">Choose Subject</option>');
      }
    }

    // On change event for modals
    $(document).on('change', '.modal-body .class-select', function() {
      let classId = $(this).val();
      let modalBody = $(this).closest('.modal-body');
      let subjectDropdown = modalBody.find('.subject-select');

      loadSubjects(classId, subjectDropdown, null);
    });

    // On modal open (for edit) → load subjects for the preselected class
    $('.modal-body .class-select').each(function() {
      let classId = $(this).val() || $(this).data('selected-class');
      let selectedSubjectId = $(this).data('selected-subject');
      let modalBody = $(this).closest('.modal-body');
      let subjectDropdown = modalBody.find('.subject-select');

      if (classId) {
        loadSubjects(classId, subjectDropdown, selectedSubjectId);
      }
    });

  });
</script>





@endsection