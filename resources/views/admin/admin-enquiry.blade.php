@extends('admin.layouts.app')

@section('title', 'Enquiries - Schoolwala')

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
              List of Enquiries !
            </h5>
            <p class="mb-4">
              You can <strong>reply/ delete</strong> enquiries
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
        <div
          class="col-lg-12 mb-4 d-flex px-5 justify-content-end">
          <button class="btn btn-info">Export</button>
        </div>

        <div class="col-lg-12">
          <div class="table-responsive text-nowrap">
            <table class="table table-hover table-bordered">
              <thead>
                <tr>
                  <th>SL</th>
                  <th>Enquiry Date</th>
                  <th>Reply Date</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Subject</th>
                  <th>Status</th>
                  <th>Enquiry/ Reply</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody class="table-border-bottom-0">
                @foreach ($enquiries as $enquiry)
                <tr>
                  <td>
                    <strong>{{$loop->iteration}}</strong>
                  </td>

                  <td>
                    <span class="badge bg-label-warning">{{ $enquiry->created_at->format('d M, Y | h:i A') }}</span>
                  </td>
                  <td>
                    @if($enquiry->reply == 0)
                    <span class="badge bg-label-danger">N/A</span>
                    @else
                    <span class="badge bg-label-primary">{{$enquiry->updated_at->format('d M, Y | h:i A')}}</span>
                    @endif
                  </td>
                  <td>{{$enquiry->name}}</td>
                  <td>{{$enquiry->email}}</td>
                  <td>{{$enquiry->subject}}</td>
                  <td>
                    @if($enquiry->reply == 0)
                    <span class="badge bg-label-danger">Not Replied</span>
                    @else
                    <span class="badge bg-label-success">Replied</span>
                    @endif
                  </td>

                  <td>
                    <button
                      type="button"
                      class="btn btn-primary"
                      data-bs-toggle="modal"
                      data-bs-target="#backDropModalEnquiry{{$enquiry->id}}">
                      Enquiry
                    </button>
                    &nbsp;
                    <button
                      class="btn btn-info"
                      type="button"
                      data-bs-toggle="modal"
                      data-bs-target="#backDropModalReply{{$enquiry->id}}">
                      Reply
                    </button>
                  </td>

                  <td>
                    <button
                      class="btn btn-danger"
                      type="button"
                      data-bs-toggle="modal"
                      data-bs-target="#backDropModalDeleteClass{{$enquiry->id}}">
                      Delete
                    </button>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Enquiry Modal -->
@foreach ($enquiries as $enquiry)
<div
  class="modal fade"
  id="backDropModalEnquiry{{$enquiry->id}}"
  data-bs-backdrop="static"
  tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <form class="modal-content" method="POST" action="{{ route('admin.admin-enquiry.reply', $enquiry->id) }}">
      @csrf
      @method('PUT')

      <div class="modal-header">
        <h5 class="modal-title" id="backDropModalTitle">Enquiry</h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col d-flex justify-content-between mb-3">
            <p class="m-0 p-0 mb-2">
              <strong>Enquiry Date:
                <span class="badge bg-label-primary">{{$enquiry->created_at->format('d M, Y | h:i A')}}</span></strong>
            </p>
            <p class="m-0 p-0">
              <strong>Name:
                <span
                  class="badge bg-label-info"
                  style="text-transform: capitalize">{{$enquiry->name}}</span></strong>
            </p>

            <p class="m-0 p-0">
              <strong>Email:
                <span
                  class="badge bg-label-success"
                  style="text-transform: lowercase">{{$enquiry->email}}</span></strong>
            </p>
          </div>
        </div>

        <div class="row">
          <div class="col mb-3">
            <p class="m-0 p-0 mb-2">
              <strong>Subject:
                <span
                  class="badge bg-label-warning"
                  style="text-transform: capitalize">{{$enquiry->subject}}</span></strong>
            </p>

            <p class="m-0 p-0">
              <strong>Enquiry:</strong><br />
              {{$enquiry->message}}
            </p>
          </div>
        </div>

        <div class="row">
          <div class="col mb-3">
            <label for="subject" class="form-label"><strong>Email Subject:</strong></label>
            <input
              type="text"
              name="subject"
              class="form-control"
              id="subject"
              placeholder="Enter email subject"
              value="{{$enquiry->subject}}"
              required />
          </div>
        </div>

        <div class="row">
          <div class="col">
            <label for="reply" class="form-label"><strong>Reply Message:</strong></label>
            <textarea
              name="reply"
              class="form-control"
              id="reply"
              rows="10"
              placeholder="Enter your reply message"
              required></textarea>
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
        <button type="submit" class="btn btn-primary">
          Send Reply
        </button>
      </div>
    </form>
  </div>
</div>
@endforeach

<!-- Reply Modal -->
@foreach ($enquiries as $enquiry)
<div
  class="modal fade"
  id="backDropModalReply{{$enquiry->id}}"
  data-bs-backdrop="static"
  tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <form class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="backDropModalTitle">Reply</h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col d-flex justify-content-between mb-3">
            <p class="m-0 p-0 mb-2">
              <strong>Enquiry Date:
                <span class="badge bg-label-warning">{{$enquiry->created_at->format('d M, Y | h:i A')}}</span></strong>
            </p>

            <p class="m-0 p-0 mb-2">
              <strong>Reply Date:
                <span class="badge bg-label-success">{{$enquiry->updated_at->format('d M, Y | h:i A')}}</span></strong>
            </p>
          </div>
        </div>
        <div class="row">
          <div class="col mb-3">
            <p>
              <strong>Subject:</strong>
              <br />
              {{$enquiry->subject}}
            </p>
            <p>
              <strong>Enquiry:</strong>
              <br />
              {{$enquiry->message}}
            </p>

            <p>
              <strong>Reply:</strong>
              <br />
              {{$enquiry->reply ? $enquiry->reply : 'N/A'}}
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

<!-- Delete Enquiry Modal -->
@foreach ($enquiries as $enquiry)
<div
  class="modal fade"
  id="backDropModalDeleteClass{{$enquiry->id}}"
  data-bs-backdrop="static"
  tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <form class="modal-content" method="POST" action="{{ route('admin.admin-enquiry.delete', $enquiry->id) }}">
      @csrf
      @method('DELETE')
      
      <div class="modal-header">
        <h5 class="modal-title" id="backDropModalTitle">
          Delete Enquiry
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
              Are you sure you want to delete this enquiry
              <span class="text-danger">{{$enquiry->subject}}</span>?
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