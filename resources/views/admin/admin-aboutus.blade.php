@extends('admin.layouts.app')

@section('title', 'About Company - Schoolwala')

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
              About Schoolwala !
            </h5>
            <p class="mb-4">
              You can <strong>add/ edit/ delete</strong> about
              details
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
                  <th>Happy Kids</th>
                  <th>Fun Lessons</th>
                  <th>Satisfaction</th>
                  <th>Our Story</th>
                  <th>Bold Message</th>
                  <th>Vision</th>
                  <th>Company Credentials</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody class="table-border-bottom-0">
                <tr>
                  <td>
                    <strong>1</strong>
                  </td>
                  <td>2000+</td>
                  <td>1200+</td>
                  <td>1900+</td>
                  <td>
                    <button
                      type="button"
                      class="btn btn-outline-primary"
                      data-bs-toggle="modal"
                      data-bs-target="#backDropModalStory">
                      Story
                    </button>
                  </td>
                  <td>
                    <button
                      type="button"
                      class="btn btn-outline-info"
                      data-bs-toggle="modal"
                      data-bs-target="#backDropModalMessage">
                      Message
                    </button>
                  </td>
                  <td>
                    <button
                      type="button"
                      class="btn btn-outline-success"
                      data-bs-toggle="modal"
                      data-bs-target="#backDropModalVision">
                      Vision
                    </button>
                  </td>
                  <td>
                    <button
                      type="button"
                      class="btn btn-outline-danger"
                      data-bs-toggle="modal"
                      data-bs-target="#backDropModalCred">
                      Cred
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


<!-- Story Modal -->
<div
  class="modal fade"
  id="backDropModalStory"
  data-bs-backdrop="static"
  tabindex="-1">
  <div class="modal-dialog">
    <form class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="backDropModalTitle">
          Our Story
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
              <strong>Our Story:</strong>
              <br />
              Lorem ipsum dolor sit amet consectetur adipisicing
              elit. Quisquam, quae?
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

<!-- Bold Message Modal -->
<div
  class="modal fade"
  id="backDropModalMessage"
  data-bs-backdrop="static"
  tabindex="-1">
  <div class="modal-dialog">
    <form class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="backDropModalTitle">
          Bold Message
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
              <strong>Bold Message:</strong>
              <br />
              Lorem ipsum dolor sit amet consectetur adipisicing
              elit. Quisquam, quae?
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

<!-- Vison Modal -->
<div
  class="modal fade"
  id="backDropModalVision"
  data-bs-backdrop="static"
  tabindex="-1">
  <div class="modal-dialog">
    <form class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="backDropModalTitle">
          Our Vision
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
              <strong>Our Vision:</strong>
              <br />
              Lorem ipsum dolor sit amet consectetur adipisicing
              elit. Quisquam, quae?
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

<!-- Cred Modal -->
<div
  class="modal fade"
  id="backDropModalCred"
  data-bs-backdrop="static"
  tabindex="-1">
  <div class="modal-dialog">
    <form class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="backDropModalTitle">
          Company Credentials
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
              <strong>Company Credentials:</strong>
              <br />
              <span><i class="bx bx-phone me-1"></i> +91
                9999999999</span>
              <br />
              <span><i class="bx bx-mail-send me-1"></i>
                YZ3Yi@example.com</span>
              <br />
              <span><i class="bx bx-map me-1"></i> Address</span>
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

<!-- Add Company About Details Modal -->
<div
  class="modal fade"
  id="backDropModalAddClass"
  data-bs-backdrop="static"
  tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <form class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="backDropModalTitle">
          Add About Schoolwala Details
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
            <label for="nameBackdrop" class="form-label">No. of Happy Kids</label>
            <input type="text" class="form-control" />
          </div>

          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">No. of Fun Lessons</label>
            <input type="text" class="form-control" />
          </div>

          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">No. of Happy Students</label>
            <input type="text" class="form-control" />
          </div>
        </div>

        <div class="row">
          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Company Email</label>
            <input type="text" class="form-control" />
          </div>

          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Company Mobile</label>
            <input type="text" class="form-control" />
          </div>
        </div>

        <div class="row">
          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Company Address</label>
            <textarea
              name=""
              id=""
              class="form-control"
              rows="3"></textarea>
          </div>
        </div>

        <div class="row">
          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Our Story</label>
            <textarea
              name=""
              id=""
              class="form-control"
              rows="5"></textarea>
          </div>
        </div>

        <div class="row">
          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Our Vision</label>
            <textarea
              name=""
              id=""
              class="form-control"
              rows="5"></textarea>
          </div>
        </div>

        <div class="row">
          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Bold Message</label>
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

<!-- Edit Company About Details Modal -->
<div
  class="modal fade"
  id="backDropModalEditClass"
  data-bs-backdrop="static"
  tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <form class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="backDropModalTitle">
          Edit About Schoolwala Details
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
            <label for="nameBackdrop" class="form-label">No. of Happy Kids</label>
            <input type="text" class="form-control" />
          </div>

          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">No. of Fun Lessons</label>
            <input type="text" class="form-control" />
          </div>

          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">No. of Happy Students</label>
            <input type="text" class="form-control" />
          </div>
        </div>

        <div class="row">
          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Company Email</label>
            <input type="text" class="form-control" />
          </div>

          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Company Mobile</label>
            <input type="text" class="form-control" />
          </div>
        </div>

        <div class="row">
          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Company Address</label>
            <textarea
              name=""
              id=""
              class="form-control"
              rows="3"></textarea>
          </div>
        </div>

        <div class="row">
          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Our Story</label>
            <textarea
              name=""
              id=""
              class="form-control"
              rows="5"></textarea>
          </div>
        </div>

        <div class="row">
          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Our Vision</label>
            <textarea
              name=""
              id=""
              class="form-control"
              rows="5"></textarea>
          </div>
        </div>

        <div class="row">
          <div class="col mb-3">
            <label for="nameBackdrop" class="form-label">Bold Message</label>
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

<!-- Delete Company About Details Modal -->
<div
  class="modal fade"
  id="backDropModalDeleteClass"
  data-bs-backdrop="static"
  tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <form class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="backDropModalTitle">
          Delete About Schoolwala
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
            <p>Are you sure you want to delete About Schoolwala?</p>
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