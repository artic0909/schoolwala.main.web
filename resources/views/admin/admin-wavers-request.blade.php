@extends('admin.layouts.app')

@section('title', 'Waver Requests - Schoolwala')

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
              List of Waiver Requests !
            </h5>
            <p class="mb-4">
              You can <strong>see/ delete</strong> waiver requests
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
        <div class="col-lg-12">
          <div class="table-responsive text-nowrap">
            <table class="table table-hover table-bordered">
              <thead>
                <tr>
                  <th>SL</th>
                  <th>Request Date</th>
                  <th>Student's/ Parent's Name</th>
                  <th>Student Age</th>
                  <th>Class</th>
                  <th>Email/ Mobile</th>
                  <th>Address</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody class="table-border-bottom-0">
                @foreach ($waverRequests as $requestt)
                <tr>
                  <td>
                    <strong>{{ $loop->iteration }}</strong>
                  </td>

                  <td>
                    <p class="m-0 p-0 badge bg-label-info">
                      {{ $requestt->created_at->format('d M, Y | h:i A') }}
                    </p>
                  </td>

                  <td>
                    <p class="m-0 p-0" style="text-transform: capitalize;">
                      <strong>STU Name:</strong> {{ $requestt->c_name }}
                    </p>
                    <p class="m-0 p-0" style="text-transform: capitalize;">
                      <strong>PRNT Name:</strong> {{ $requestt->p_name }}
                    </p>
                  </td>

                  <td>Age: {{ $requestt->c_age }}</td>

                  <td>
                    <span class="badge bg-label-primary">{{ $requestt->class->name }}</span>
                  </td>
                  <td>
                    <p class="m-0 p-0">
                      <strong>Email:</strong> {{ $requestt->email }}
                    </p>
                    <p class="m-0 p-0">
                      <strong>Mobile:</strong> {{ $requestt->mobile }}
                    </p>
                  </td>

                  <td>
                    <button
                      class="btn btn-primary"
                      type="button"
                      data-bs-toggle="modal"
                      data-bs-target="#backDropModalAddress{{ $requestt->id }}">
                      Address
                    </button>
                  </td>

                  <td>
                    <a href="{{ route('admin.admin-waiver-mail-back', $requestt->id) }}"
                      class="btn btn-info text-white">
                      Mail Back
                    </a>
                    

                    &nbsp;
                    <button
                      class="btn btn-danger"
                      type="button"
                      data-bs-toggle="modal"
                      data-bs-target="#backDropModalDeleteClass{{ $requestt->id }}">
                      Delete
                    </button>
                  </td>
                </tr>
                @endforeach
              </tbody>

              <!-- Pagination -->
              <tfoot>
                <tr>
                  <td colspan="8">
                    <div class="d-flex justify-content-center align-items-center mt-3">
                      @if ($waverRequests->onFirstPage())
                      <button class="btn btn-secondary me-2" disabled>Prev</button>
                      @else
                      <a href="{{ $waverRequests->previousPageUrl() }}" class="btn btn-primary me-2">Prev</a>
                      @endif

                      <form action="" method="GET" class="d-flex align-items-center">
                        <input type="number" name="page" value="{{ $waverRequests->currentPage() }}"
                          min="1" max="{{ $waverRequests->lastPage() }}"
                          class="form-control text-center me-1" style="width: 70px;"
                          onchange="this.form.submit()" readonly>

                        <span class="mx-1">/</span>
                        <input type="text" readonly value="{{ $waverRequests->lastPage() }}"
                          class="form-control text-center ms-1" style="width: 70px;">
                      </form>

                      @if ($waverRequests->hasMorePages())
                      <a href="{{ $waverRequests->nextPageUrl() }}" class="btn btn-primary ms-2">Next</a>
                      @else
                      <button class="btn btn-secondary ms-2" disabled>Next</button>
                      @endif
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

<!-- Address View Modal -->
@foreach ($waverRequests as $requestt)
<div
  class="modal fade"
  id="backDropModalAddress{{ $requestt->id }}"
  data-bs-backdrop="static"
  tabindex="-1">
  <div class="modal-dialog">
    <form class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="backDropModalTitle">
          Address
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
              <strong><i class="bx bx-mail-send"></i> Email: {{ $requestt->email }}</strong>
              <br />
              <i class="bx bx-map"></i> <strong>Address:</strong> {{ $requestt->address }}
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
      </div>
    </form>
  </div>
</div>
@endforeach

<!-- Delete Waver Request Modal -->
@foreach ($waverRequests as $requestt)
<div
  class="modal fade"
  id="backDropModalDeleteClass{{ $requestt->id }}"
  data-bs-backdrop="static"
  tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <form class="modal-content" method="POST" action="{{ route('admin.admin-wavers-request.delete', $requestt->id) }}">
      @csrf
      @method('DELETE')

      <div class="modal-header">
        <h5 class="modal-title" id="backDropModalTitle">
          Delete Request
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
              Are you sure you want to delete this request
              <span class="text-danger">{{ $requestt->email }} | {{ $requestt->mobile }}</span>?
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

@endsection