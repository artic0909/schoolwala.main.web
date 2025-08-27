@extends('admin.layouts.app')

@section('title', 'Add Videos - Schoolwala')

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
              List of Videos !
            </h5>
            <p class="mb-4">
              You can <strong>add/ edit/ delete</strong> videos
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
        <div class="col-lg-12">
          <div class="table-responsive text-nowrap">
            <table class="table table-hover table-bordered">
              <thead>
                <tr>
                  <th>SL</th>
                  <th>Class Names</th>
                  <th>Subjects</th>
                  <th>Chapters</th>
                  <th>Paid/ Free</th>
                  <th>Videos</th>
                  <th>Practice Tests</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody class="table-border-bottom-0">
                <tr>
                  <td>
                    <strong>1</strong>
                  </td>
                  <td>Class 5</td>
                  <td>Bengali</td>
                  <td>Chapter 1</td>
                  <td>
                    <span class="badge bg-label-success">Paid</span>
                    /
                    <span class="badge bg-label-info">Free</span>
                  </td>
                  <td>
                    <button
                      type="button"
                      class="btn btn-info"
                      data-bs-toggle="modal"
                      data-bs-target="#backDropModalPlayVideo">
                      Play
                    </button>
                  </td>

                  <td>
                    <button
                      type="button"
                      class="btn btn-primary"
                      data-bs-toggle="modal"
                      data-bs-target="#backDropModalView">
                      View
                    </button>
                  </td>

                  <td>
                    <button
                      type="button"
                      class="btn btn-warning"
                      data-bs-toggle="modal"
                      data-bs-target="#backDropModalEditClass">
                      Edit
                    </button>
                    &nbsp;
                    <button
                      class="btn btn-danger"
                      type="button"
                      data-bs-toggle="modal"
                      data-bs-target="#backDropModalDeleteClass">
                      Delete
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Video Modal -->
<div
  class="modal fade"
  id="backDropModalPlayVideo"
  data-bs-backdrop="static"
  tabindex="-1">
  <div class="modal-dialog">
    <form class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="backDropModalTitle">
          Class 5 | Bengali | Chapter 1
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
            <p style="width: 100%">
              <strong>Video Title:</strong>
              <br />
              <br />
              <iframe
                src="https://www.youtube.com/embed/E3oG313_kps?si=mA1vie_IPCPwfeHv"
                title="YouTube video player"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen
                style="width: 100%; height: 300px"></iframe>
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

<!-- Practice Test Modal -->
<div
  class="modal fade"
  id="backDropModalView"
  data-bs-backdrop="static"
  tabindex="-1">
  <div class="modal-dialog">
    <form class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="backDropModalTitle">
          Practice Test | Class 5 | Bengali | Chapter 1
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
            <p class="fw-bold">Video Title</p>
            <p style="width: 100%">
              <strong>1.</strong>
              <span>Lorem ipsum dolor sit amet consectetur adipisicing
                elit.</span>
              <br />
              <span class="mx-3 me-2">A. Lorem</span>
              <span class="me-2">B. Lorem</span>
              <span class="me-2">C. Lorem</span>
              <span class="me-2">D. Lorem</span>
            </p>

            <p style="width: 100%">
              <strong>2.</strong>
              <span>Lorem ipsum dolor sit amet consectetur adipisicing
                elit.</span>
              <br />
              <span class="mx-3 me-2">A. Lorem</span>
              <span class="me-2">B. Lorem</span>
              <span class="me-2">C. Lorem</span>
              <span class="me-2">D. Lorem</span>
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

<!-- Add Video Modal -->
<div
  class="modal fade"
  id="backDropModalAddClass"
  data-bs-backdrop="static"
  tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <form class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="backDropModalTitle">
          Add Video
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
            <select name="" id="" class="form-select">
              <option value="1">Class 1</option>
              <option value="2">Class 2</option>
              <option value="3">Class 3</option>
              <option value="4">Class 4</option>
              <option value="5">Class 5</option>
            </select>
          </div>
        </div>

        <div class="row">
          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Choose Subject</label>
            <select name="" id="" class="form-select">
              <option value="1">Subject 1</option>
              <option value="2">Subject 2</option>
              <option value="3">Subject 3</option>
              <option value="4">Subject 4</option>
              <option value="5">Subject 5</option>
            </select>
          </div>
        </div>

        <div class="row">
          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Choose Chapter</label>
            <select name="" id="" class="form-select">
              <option value="1">Chapter 1</option>
              <option value="2">Chapter 2</option>
              <option value="3">Chapter 3</option>
              <option value="4">Chapter 4</option>
              <option value="5">Chapter 5</option>
            </select>
          </div>
        </div>

        <div class="row">
          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Video Type</label>
            <select name="" id="" class="form-select">
              <option value="paid">Paid</option>
              <option value="free">Free</option>
            </select>
          </div>
        </div>

        <div class="row g-2">
          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Video Title</label>
            <input type="text" class="form-control" />
          </div>
        </div>

        <div class="row g-2">
          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Video Link</label>
            <input type="text" class="form-control" />
          </div>
        </div>

        <div class="row g-2">
          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Video Description</label>
            <textarea
              name=""
              id=""
              class="form-control"
              rows="5"></textarea>
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
        <button type="button" class="btn btn-primary">Save</button>
      </div>
    </form>
  </div>
</div>

<!-- Edit Video Modal -->
<div
  class="modal fade"
  id="backDropModalEditClass"
  data-bs-backdrop="static"
  tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <form class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="backDropModalTitle">
          Edit Video
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
            <select name="" id="" class="form-select">
              <option value="1">Class 1</option>
              <option value="2">Class 2</option>
              <option value="3">Class 3</option>
              <option value="4">Class 4</option>
              <option value="5">Class 5</option>
            </select>
          </div>
        </div>

        <div class="row">
          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Choose Subject</label>
            <select name="" id="" class="form-select">
              <option value="1">Subject 1</option>
              <option value="2">Subject 2</option>
              <option value="3">Subject 3</option>
              <option value="4">Subject 4</option>
              <option value="5">Subject 5</option>
            </select>
          </div>
        </div>

        <div class="row">
          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Choose Chapter</label>
            <select name="" id="" class="form-select">
              <option value="1">Chapter 1</option>
              <option value="2">Chapter 2</option>
              <option value="3">Chapter 3</option>
              <option value="4">Chapter 4</option>
              <option value="5">Chapter 5</option>
            </select>
          </div>
        </div>

        <div class="row">
          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Video Type</label>
            <select name="" id="" class="form-select">
              <option value="paid">Paid</option>
              <option value="free">Free</option>
            </select>
          </div>
        </div>

        <div class="row g-2">
          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Video Title</label>
            <input type="text" class="form-control" />
          </div>
        </div>

        <div class="row g-2">
          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Video Link</label>
            <input type="text" class="form-control" />
          </div>
        </div>

        <div class="row g-2">
          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Video Description</label>
            <textarea
              name=""
              id=""
              class="form-control"
              rows="5"></textarea>
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
        <button type="button" class="btn btn-primary">Save</button>
      </div>
    </form>
  </div>
</div>

<!-- Delete Video Modal -->
<div
  class="modal fade"
  id="backDropModalDeleteClass"
  data-bs-backdrop="static"
  tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <form class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="backDropModalTitle">
          Delete Video
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
            <p>Are you sure you want to delete this Video?</p>
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
        <button type="button" class="btn btn-danger">Delete</button>
      </div>
    </form>
  </div>
</div>

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