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
                            Welcome Back {{ Auth::user()->name }} ! 🎉
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
                            href="{{ route('admin.admin-wavers-request') }}"
                            class="btn btn-primary">
                            Waiver Request
                        </a>
                        &nbsp;
                        <a
                            href="{{ route('admin.admin-waver-profiles') }}"
                            class="btn btn-info">
                            Waiver Profiles
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12 mb-4">
        <h5 class="pb-1 mb-4">Platform Overview (KPAs)</h5>
        <div class="row">
            @php
                $kpaItems = [
                    ['title' => 'Total Users', 'count' => $kpas['users'] ?? 0, 'color' => 'primary', 'icon' => 'bx-group'],
                    ['title' => 'Total Students', 'count' => $kpas['students'] ?? 0, 'color' => 'success', 'icon' => 'bx-user-circle'],
                    ['title' => 'Total Faculties', 'count' => $kpas['faculties'] ?? 0, 'color' => 'info', 'icon' => 'bx-chalkboard'],
                    ['title' => 'Waiver Requests', 'count' => $kpas['waiver_requests'] ?? 0, 'color' => 'warning', 'icon' => 'bx-receipt'],
                    ['title' => 'Total Classes', 'count' => $kpas['classes'] ?? 0, 'color' => 'danger', 'icon' => 'bx-book-reader'],
                    ['title' => 'Total Subjects', 'count' => $kpas['subjects'] ?? 0, 'color' => 'primary', 'icon' => 'bx-book'],
                    ['title' => 'Total Videos', 'count' => $kpas['videos'] ?? 0, 'color' => 'success', 'icon' => 'bx-video'],
                    ['title' => 'Total Subscribers', 'count' => $kpas['subscribers'] ?? 0, 'color' => 'info', 'icon' => 'bx-bell'],
                    ['title' => 'Total Blogs', 'count' => $kpas['blogs'] ?? 0, 'color' => 'warning', 'icon' => 'bx-news'],
                    ['title' => 'Total Referrals', 'count' => $kpas['referrals'] ?? 0, 'color' => 'danger', 'icon' => 'bx-share-alt'],
                    ['title' => 'Contact Messages', 'count' => $kpas['contacts'] ?? 0, 'color' => 'primary', 'icon' => 'bx-envelope'],
                ];
            @endphp

            @foreach ($kpaItems as $item)
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="content-left">
                                <span class="d-block mb-1 text-muted">{{ $item['title'] }}</span>
                                <h4 class="card-title mb-0">{{ $item['count'] }}</h4>
                            </div>
                            <div class="avatar">
                                <span class="avatar-initial rounded bg-label-{{ $item['color'] }}">
                                    <i class="bx {{ $item['icon'] }} fs-4"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection