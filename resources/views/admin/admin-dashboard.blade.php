@extends('admin.layouts.app')

@section('title', 'Dashboard - Schoolwala')

@section('content')
<div class="row">
    <div class="col-lg-12 mb-4 order-0">
        <div class="card">
            <div class="d-flex align-items-end row">
                <div class="col-sm-7">
                    <div class="card-body">
                        <h5
                            class="card-title text-primary">
                            Welcome Back Saklin! 🎉
                        </h5>
                        <p class="mb-4">
                            It's your space in the
                            world.
                        </p>
                    </div>
                </div>
                <div
                    class="col-sm-5 text-center text-sm-left">
                    <div
                        class="card-body pb-0 px-0 px-md-4">
                        <img
                            src="{{ asset('./admin/assets/img/illustrations/man-with-laptop-light.png') }}"
                            height="140"
                            alt="View Badge User" />
                    </div>
                </div>

                <div class="col-12">
                    <div
                        class="card-footer text-end">
                        <a
                            href="wavers-request.html"
                            class="btn btn-primary">
                            Waver Request
                        </a>
                        &nbsp;
                        <a
                            href="admin-waver-profiles.html"
                            class="btn btn-info">
                            Waver Profiles
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection