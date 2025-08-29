@extends('admin.layouts.app')

@section('title', 'Dashboard - Schoolwala')

@section('content')

<h4 class="fw-bold py-3 mb-4">Account Settings</h4>

<div class="row">
  <div class="col-md-12">
    <div class="card mb-4">
      <h5 class="card-header">Profile Details</h5>
      <!-- Account -->
      <div class="card-body">
        <div
          class="d-flex align-items-start align-items-sm-center gap-4">
          <img
            src="{{ asset('./admin/assets/img/avatars/1.png') }}"
            alt="user-avatar"
            class="d-block rounded"
            height="100"
            width="100"
            id="uploadedAvatar" />
        </div>
      </div>
      <hr class="my-0" />
      <div class="card-body">
        <form
          id="formAccountSettings"
          method="POST"
          onsubmit="return false">
          <div class="row">
            <div class="mb-3 col-md-6">
              <label for="firstName" class="form-label">Admin Name</label>
              <input
                class="form-control"
                type="text"
                value="Saklin" />
            </div>
            <div class="mb-3 col-md-6">
              <label for="lastName" class="form-label">Admin Email Address</label>
              <input
                class="form-control"
                type="text"
                value="saklin@example.com" />
            </div>
            <div class="mb-3 col-md-6">
              <label for="email" class="form-label">Admin Password</label>
              <input
                class="form-control"
                type="text"
                value="Password" />
            </div>
            <div class="mb-3 col-md-6">
              <label for="organization" class="form-label">Admin Confirm Password</label>
              <input
                type="text"
                class="form-control"
                value="Password" />
            </div>
          </div>
          <div class="mt-2">
            <button type="submit" class="btn btn-primary me-2">
              Save changes
            </button>
            <button
              type="reset"
              class="btn btn-outline-secondary">
              Cancel
            </button>
          </div>
        </form>
      </div>
      <!-- /Account -->
    </div>
    <div class="card">
      <h5 class="card-header">Delete Account</h5>
      <div class="card-body">
        <div class="mb-3 col-12 mb-0">
          <div class="alert alert-warning">
            <h6 class="alert-heading fw-bold mb-1">
              Are you sure you want to delete your account?
            </h6>
            <p class="mb-0">
              Once you delete your account, there is no going
              back. Please be certain.
            </p>
          </div>
        </div>
        <form
          id="formAccountDeactivation"
          onsubmit="return false">
          <div class="form-check mb-3">
            <input
              class="form-check-input"
              type="checkbox"
              name="accountActivation"
              id="accountActivation" />
            <label
              class="form-check-label"
              for="accountActivation">I confirm my account deactivation</label>
          </div>
          <button
            type="submit"
            class="btn btn-danger deactivate-account">
            Deactivate Account
          </button>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection