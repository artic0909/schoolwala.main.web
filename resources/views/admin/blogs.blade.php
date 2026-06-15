@extends('admin.layouts.app')

@section('title', 'Manage Blogs - Schoolwala')

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
    color: #fff !important;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15),
      0 6px 10px rgba(0, 0, 0, 0.08);
    text-decoration: none;
    z-index: 1050;
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

  /* CKEditor min height */
  .ck-editor__editable_inline {
      min-height: 250px;
  }
</style>

<div class="row">
  <div class="col-lg-12 mb-4 order-0">
    <div class="card">
      <div class="d-flex align-items-end row">
        <div class="col-sm-7">
          <div class="card-body">
            <h5 class="card-title text-primary">
              List of Blogs!
            </h5>
            <p class="mb-4">
              You can <strong>add/ edit/ delete</strong> blogs
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
                  <th>Image</th>
                  <th>Title</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody class="table-border-bottom-0">
                @foreach($blogs as $blog)
                <tr>
                  <td>
                    <strong>{{ $loop->iteration }}</strong>
                  </td>
                  <td>
                    <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}" width="60" class="rounded">
                  </td>
                  <td>
                    <span title="{{ $blog->title }}">{{ \Illuminate\Support\Str::limit($blog->title, 40) }}</span>
                  </td>
                  <td>
                    @if($blog->status)
                        <span class="badge bg-label-success">Active</span>
                    @else
                        <span class="badge bg-label-danger">Inactive</span>
                    @endif
                  </td>
                  <td>
                    <button
                      type="button"
                      class="btn btn-warning"
                      data-bs-toggle="modal"
                      data-bs-target="#backDropModalEditBlog{{ $blog->id }}">
                      Edit
                    </button>
                    &nbsp;
                    <button
                      class="btn btn-danger"
                      type="button"
                      data-bs-toggle="modal"
                      data-bs-target="#backDropModalDeleteBlog{{ $blog->id }}">
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


<!-- Add Blog Modal -->
<div
  class="modal fade"
  id="backDropModalAddBlog"
  data-bs-backdrop="static"
  tabindex="-1">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <form class="modal-content" action="{{ route('admin.admin-blogs.store') }}" method="POST" enctype="multipart/form-data">
      @csrf

      <div class="modal-header">
        <h5 class="modal-title" id="backDropModalTitle">Add Blog</h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"></button>
      </div>
      <div class="modal-body">
        
        <div class="row">
          <div class="col-md-8 mb-3">
            <label class="form-label">Title <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="title" required placeholder="Enter Blog Title" />
          </div>
          <div class="col-md-4 mb-3">
            <label class="form-label">Status <span class="text-danger">*</span></label>
            <select class="form-control" name="status" required>
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12 mb-3">
            <label class="form-label">Image <span class="text-danger">*</span></label>
            <input type="file" class="form-control" name="image" required accept="image/*" />
          </div>
        </div>

        <div class="row">
          <div class="col-md-12 mb-3">
            <label class="form-label">Short Description <span class="text-danger">*</span></label>
            <textarea class="form-control" name="short_description" rows="3" required placeholder="Enter short description"></textarea>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12 mb-3">
            <label class="form-label">Content <span class="text-danger">*</span></label>
            <textarea class="form-control" name="content" id="content_add" placeholder="Enter full content"></textarea>
          </div>
        </div>

        <div class="row mt-3">
            <h6 class="text-muted">SEO Attributes</h6>
            <div class="col-md-6 mb-3">
                <label class="form-label">Meta Title</label>
                <input type="text" class="form-control" name="meta_title" placeholder="Meta Title" />
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Meta Description</label>
                <textarea class="form-control" name="meta_description" rows="2" placeholder="Meta Description"></textarea>
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

<!-- Edit Blog Modal -->
@foreach($blogs as $blog)
<div
  class="modal fade"
  id="backDropModalEditBlog{{ $blog->id }}"
  data-bs-backdrop="static"
  tabindex="-1">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <form class="modal-content" action="{{ route('admin.admin-blogs.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <div class="modal-header">
        <h5 class="modal-title" id="backDropModalTitle">
          Edit Blog
        </h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <div class="row">
          <div class="col-md-8 mb-3">
            <label class="form-label">Title <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="title" value="{{ $blog->title }}" required />
          </div>
          <div class="col-md-4 mb-3">
            <label class="form-label">Status <span class="text-danger">*</span></label>
            <select class="form-control" name="status" required>
                <option value="1" {{ $blog->status == 1 ? 'selected' : '' }}>Active</option>
                <option value="0" {{ $blog->status == 0 ? 'selected' : '' }}>Inactive</option>
            </select>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12 mb-3">
            <label class="form-label">Image (Leave empty to keep current)</label>
            <input type="file" class="form-control" name="image" accept="image/*" />
            <div class="mt-2">
                <img src="{{ asset('storage/' . $blog->image) }}" width="100" class="rounded">
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12 mb-3">
            <label class="form-label">Short Description <span class="text-danger">*</span></label>
            <textarea class="form-control" name="short_description" rows="3" required>{{ $blog->short_description }}</textarea>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12 mb-3">
            <label class="form-label">Content <span class="text-danger">*</span></label>
            <textarea class="form-control" name="content" id="content_edit_{{ $blog->id }}">{{ $blog->content }}</textarea>
          </div>
        </div>

        <div class="row mt-3">
            <h6 class="text-muted">SEO Attributes</h6>
            <div class="col-md-6 mb-3">
                <label class="form-label">Meta Title</label>
                <input type="text" class="form-control" name="meta_title" value="{{ $blog->meta_title }}" />
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Meta Description</label>
                <textarea class="form-control" name="meta_description" rows="2">{{ $blog->meta_description }}</textarea>
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

<!-- Delete Blog Modal -->
@foreach($blogs as $blog)
<div
  class="modal fade"
  id="backDropModalDeleteBlog{{ $blog->id }}"
  data-bs-backdrop="static"
  tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <form class="modal-content" action="{{ route('admin.admin-blogs.delete', $blog->id) }}" method="POST">
      @csrf
      @method('DELETE')

      <div class="modal-header">
        <h5 class="modal-title" id="backDropModalTitle">
          Delete Blog
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
            <p>Are you sure you want to delete this blog? <strong>{{ $blog->title }}</strong></p>
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
  data-bs-target="#backDropModalAddBlog"
  class="fab"
  aria-label="Add new item"
  title="Add">
  Add
</a>

<!-- CKEditor 5 Script -->
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Init CKEditor for Add Modal
        ClassicEditor
            .create(document.querySelector('#content_add'))
            .catch(error => {
                console.error(error);
            });

        // Init CKEditor for Edit Modals
        @foreach($blogs as $blog)
            ClassicEditor
                .create(document.querySelector('#content_edit_{{ $blog->id }}'))
                .catch(error => {
                    console.error(error);
                });
        @endforeach
    });
</script>

@endsection
