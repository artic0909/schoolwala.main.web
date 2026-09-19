@extends('admin.layouts.app')

@section('title', 'Dashboard & Analytics - Schoolwala')

@section('content')
<!-- Filter & Welcome Header -->
<div class="row">
    <div class="col-lg-12 mb-4 order-0">
        <div class="card bg-light border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                    <div>
                        <h4 class="card-title text-primary mb-1">
                            Welcome Back, {{ Auth::user()->name ?? 'Admin' }}! 🎉
                        </h4>
                        <p class="mb-0 text-muted">
                            Overview of total revenue, student growth, subscriptions, and platform analytics.
                        </p>
                    </div>

                    <!-- Month & Year Filter Form -->
                    <form method="GET" action="{{ route('admin.admin-dashboard') }}" class="d-flex flex-wrap align-items-center gap-2">
                        <div class="input-group input-group-merge" style="width: auto;">
                            <span class="input-group-text"><i class="bx bx-calendar"></i></span>
                            <select name="month" class="form-select" style="min-width: 140px;">
                                <option value="">All Months (Full Year)</option>
                                @foreach ($monthsList as $num => $name)
                                    <option value="{{ $num }}" {{ (string)$selectedMonth === (string)$num ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="input-group input-group-merge" style="width: auto;">
                            <span class="input-group-text"><i class="bx bx-time-five"></i></span>
                            <select name="year" class="form-select" style="min-width: 110px;">
                                @foreach ($availableYears as $yr)
                                    <option value="{{ $yr }}" {{ (int)$selectedYear === (int)$yr ? 'selected' : '' }}>
                                        {{ $yr }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary d-flex align-items-center gap-1">
                            <i class="bx bx-filter-alt"></i> Filter
                        </button>

                        @if($selectedMonth || $selectedYear != date('Y'))
                            <a href="{{ route('admin.admin-dashboard') }}" class="btn btn-outline-secondary d-flex align-items-center gap-1" title="Reset Filters">
                                <i class="bx bx-reset"></i> Reset
                            </a>
                        @endif
                    </form>
                </div>

                <!-- Active Filter Pill Indicator -->
                <div class="mt-3 pt-2 border-top d-flex flex-wrap align-items-center justify-content-between gap-2">
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-label-primary px-3 py-2 fs-6">
                            <i class="bx bx-calendar-check me-1"></i>
                            Showing: <strong>{{ $selectedMonth ? $monthsList[$selectedMonth] : 'Full Year' }} {{ $selectedYear }}</strong>
                        </span>
                        @if($periodTransactionsCount > 0)
                            <span class="badge bg-label-success px-2 py-2">
                                <i class="bx bx-check-circle me-1"></i> {{ $periodTransactionsCount }} Transactions
                            </span>
                        @endif
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.admin-wavers-request') }}" class="btn btn-sm btn-outline-warning">
                            <i class="bx bx-receipt me-1"></i> Waiver Requests ({{ $kpas['waiver_pending'] ?? 0 }} pending)
                        </a>
                        <a href="{{ route('admin.admin-students') }}" class="btn btn-sm btn-outline-primary">
                            <i class="bx bx-user me-1"></i> Manage Students
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Primary Key Metric Cards -->
<div class="row">
    <!-- Total Revenue Card -->
    <div class="col-xl-3 col-md-6 col-sm-6 mb-4">
        <div class="card h-100 border-start border-primary border-4 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-muted fw-semibold">Filtered Revenue</span>
                    <div class="avatar avatar-sm">
                        <span class="avatar-initial rounded bg-label-primary">
                            <i class="bx bx-rupee fs-4"></i>
                        </span>
                    </div>
                </div>
                <h3 class="card-title mb-1 text-primary fw-bold">₹{{ number_format($periodRevenue, 2) }}</h3>
                <div class="d-flex justify-content-between align-items-center mt-2 pt-1 border-top">
                    <small class="text-muted">Lifetime: ₹{{ number_format($totalAllTimeRevenue, 2) }}</small>
                    <small class="badge bg-label-primary">{{ $periodTransactionsCount }} Txns</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Students Card -->
    <div class="col-xl-3 col-md-6 col-sm-6 mb-4">
        <div class="card h-100 border-start border-success border-4 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-muted fw-semibold">Total Students</span>
                    <div class="avatar avatar-sm">
                        <span class="avatar-initial rounded bg-label-success">
                            <i class="bx bx-user-circle fs-4"></i>
                        </span>
                    </div>
                </div>
                <h3 class="card-title mb-1 text-success fw-bold">{{ number_format($kpas['students'] ?? 0) }}</h3>
                <div class="d-flex justify-content-between align-items-center mt-2 pt-1 border-top">
                    <small class="text-muted"><i class="bx bx-user text-primary"></i> Regular: {{ $kpas['regular_students'] ?? 0 }}</small>
                    <small class="text-muted"><i class="bx bx-gift text-warning"></i> Waiver: {{ $kpas['waiver_students'] ?? 0 }}</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Subscriptions Card -->
    <div class="col-xl-3 col-md-6 col-sm-6 mb-4">
        <div class="card h-100 border-start border-info border-4 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-muted fw-semibold">Active Subscriptions</span>
                    <div class="avatar avatar-sm">
                        <span class="avatar-initial rounded bg-label-info">
                            <i class="bx bx-check-shield fs-4"></i>
                        </span>
                    </div>
                </div>
                <h3 class="card-title mb-1 text-info fw-bold">{{ number_format(($kpas['active_subscribers'] ?? 0) + ($kpas['waiver_students'] ?? 0)) }}</h3>
                <div class="d-flex justify-content-between align-items-center mt-2 pt-1 border-top">
                    <small class="text-muted">Paid Active: {{ $kpas['active_subscribers'] ?? 0 }}</small>
                    <small class="text-muted">Waiver Active: {{ $kpas['waiver_students'] ?? 0 }}</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Waiver Applications Card -->
    <div class="col-xl-3 col-md-6 col-sm-6 mb-4">
        <div class="card h-100 border-start border-warning border-4 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-muted fw-semibold">Waiver Requests</span>
                    <div class="avatar avatar-sm">
                        <span class="avatar-initial rounded bg-label-warning">
                            <i class="bx bx-envelope-open fs-4"></i>
                        </span>
                    </div>
                </div>
                <h3 class="card-title mb-1 text-warning fw-bold">{{ number_format($kpas['waiver_requests'] ?? 0) }}</h3>
                <div class="d-flex justify-content-between align-items-center mt-2 pt-1 border-top">
                    <small class="badge bg-label-warning">{{ $kpas['waiver_pending'] ?? 0 }} Pending</small>
                    <small class="badge bg-label-success">{{ $kpas['waiver_accepted'] ?? 0 }} Approved</small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Interactive Charts Row -->
<div class="row">
    <!-- Revenue & Transactions Trend Chart -->
    <div class="col-12 col-xl-8 mb-4">
        <div class="card h-100 shadow-sm">
            <div class="card-header d-flex flex-wrap justify-content-between align-items-center pb-0">
                <div>
                    <h5 class="card-title mb-1">
                        <i class="bx bx-line-chart text-primary me-2"></i>Total Revenue & Transactions Overview
                    </h5>
                    <p class="text-muted mb-0 small">
                        Trend of total collections and transaction volume for {{ $selectedMonth ? $monthsList[$selectedMonth] : 'Year' }} {{ $selectedYear }}
                    </p>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="d-flex align-items-center">
                        <span class="badge bg-primary p-1 me-1 rounded-circle"></span>
                        <small class="text-muted">Revenue (₹)</small>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="badge bg-info p-1 me-1 rounded-circle"></span>
                        <small class="text-muted">Transactions</small>
                    </div>
                </div>
            </div>
            <div class="card-body px-2">
                <div id="revenueTrendChart" style="min-height: 340px;"></div>
            </div>
        </div>
    </div>

    <!-- Student Registrations (Regular vs Waiver) Chart -->
    <div class="col-12 col-xl-4 mb-4">
        <div class="card h-100 shadow-sm">
            <div class="card-header pb-0">
                <h5 class="card-title mb-1">
                    <i class="bx bx-bar-chart-alt-2 text-success me-2"></i>Student Registrations
                </h5>
                <p class="text-muted mb-0 small">
                    Regular vs Waiver student signups for {{ $selectedMonth ? $monthsList[$selectedMonth] : 'Year' }} {{ $selectedYear }}
                </p>
            </div>
            <div class="card-body px-2">
                <div id="studentGrowthChart" style="min-height: 340px;"></div>
            </div>
        </div>
    </div>
</div>

<!-- Secondary Charts Row: Class Distribution & Subscription Statuses -->
<div class="row">
    <!-- Class-wise Student Distribution (Donut) -->
    <div class="col-12 col-md-6 col-xl-4 mb-4">
        <div class="card h-100 shadow-sm">
            <div class="card-header pb-0">
                <h5 class="card-title mb-1">
                    <i class="bx bx-pie-chart-alt text-primary me-2"></i>Class-wise Students
                </h5>
                <p class="text-muted mb-0 small">Enrolled students distribution per class</p>
            </div>
            <div class="card-body">
                <div id="classDistributionChart" style="min-height: 280px;"></div>
            </div>
        </div>
    </div>

    <!-- Revenue by Class (Bar Chart) -->
    <div class="col-12 col-md-6 col-xl-4 mb-4">
        <div class="card h-100 shadow-sm">
            <div class="card-header pb-0">
                <h5 class="card-title mb-1">
                    <i class="bx bx-rupee text-success me-2"></i>Revenue by Class
                </h5>
                <p class="text-muted mb-0 small">Financial collections categorized by Class</p>
            </div>
            <div class="card-body">
                <div id="classRevenueChart" style="min-height: 280px;"></div>
            </div>
        </div>
    </div>

    <!-- Subscription Status Breakdown (Donut) -->
    <div class="col-12 col-md-12 col-xl-4 mb-4">
        <div class="card h-100 shadow-sm">
            <div class="card-header pb-0">
                <h5 class="card-title mb-1">
                    <i class="bx bx-check-circle text-info me-2"></i>Subscription Statuses
                </h5>
                <p class="text-muted mb-0 small">Active regular, waiver lifetime & pending</p>
            </div>
            <div class="card-body">
                <div id="subscriptionStatusChart" style="min-height: 280px;"></div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Transactions & Waiver Requests Row -->
<div class="row">
    <!-- Recent Transactions Table -->
    <div class="col-12 col-xl-7 mb-4">
        <div class="card h-100 shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-0"><i class="bx bx-credit-card-front text-primary me-2"></i>Recent Transactions</h5>
                    <small class="text-muted">Latest payments received on Schoolwala</small>
                </div>
                <a href="{{ route('admin.admin-fees-report') }}" class="btn btn-sm btn-outline-primary">
                    View All Reports <i class="bx bx-right-arrow-alt"></i>
                </a>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Student</th>
                            <th>Class</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @forelse($recentTransactions as $tx)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-xs me-2">
                                        <span class="avatar-initial rounded-circle bg-label-primary">
                                            {{ strtoupper(substr($tx->student->student_name ?? 'S', 0, 1)) }}
                                        </span>
                                    </div>
                                    <div>
                                        <span class="fw-semibold">{{ $tx->student->student_name ?? 'N/A' }}</span>
                                        <div class="text-muted small">{{ $tx->student->student_id ?? '' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge bg-label-info">{{ $tx->class->name ?? 'N/A' }}</span></td>
                            <td><strong class="text-success">₹{{ number_format($tx->amount, 2) }}</strong></td>
                            <td><small class="text-muted">{{ $tx->created_at ? $tx->created_at->format('d M, Y h:i A') : 'N/A' }}</small></td>
                            <td>
                                @if($tx->status === 'success')
                                    <span class="badge bg-label-success">Success</span>
                                @else
                                    <span class="badge bg-label-warning">{{ ucfirst($tx->status) }}</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                <i class="bx bx-info-circle me-1"></i> No transactions recorded yet.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Recent Waiver Requests -->
    <div class="col-12 col-xl-5 mb-4">
        <div class="card h-100 shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-0"><i class="bx bx-receipt text-warning me-2"></i>Latest Waiver Requests</h5>
                    <small class="text-muted">Applications for free education</small>
                </div>
                <a href="{{ route('admin.admin-wavers-request') }}" class="btn btn-sm btn-outline-warning">
                    Review All <i class="bx bx-right-arrow-alt"></i>
                </a>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Student / Parent</th>
                            <th>Class</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentWaiverRequests as $wReq)
                        <tr>
                            <td>
                                <div class="fw-semibold">{{ $wReq->c_name ?? 'Student' }}</div>
                                <div class="text-muted small">Parent: {{ $wReq->p_name ?? 'N/A' }}</div>
                            </td>
                            <td><span class="badge bg-label-secondary">{{ $wReq->class->name ?? 'Class' }}</span></td>
                            <td>
                                @if($wReq->status === 'accepted')
                                    <span class="badge bg-label-success">Accepted</span>
                                @elseif($wReq->status === 'rejected')
                                    <span class="badge bg-label-danger">Rejected</span>
                                @else
                                    <span class="badge bg-label-warning">Pending</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center py-4 text-muted">
                                <i class="bx bx-info-circle me-1"></i> No waiver requests available.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Platform Overview (KPAs) Grid -->
<div class="row mt-2">
    <div class="col-12 mb-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0 fw-bold"><i class="bx bx-grid-alt me-2 text-primary"></i>Platform Overview & KPAs</h5>
            <small class="text-muted">Real-time system asset statistics</small>
        </div>
        <div class="row">
            @php
                $kpaItems = [
                    ['title' => 'Total Users', 'count' => $kpas['users'] ?? 0, 'color' => 'primary', 'icon' => 'bx-group', 'link' => '#'],
                    ['title' => 'Total Students', 'count' => $kpas['students'] ?? 0, 'color' => 'success', 'icon' => 'bx-user-circle', 'link' => route('admin.admin-students')],
                    ['title' => 'Total Faculties', 'count' => $kpas['faculties'] ?? 0, 'color' => 'info', 'icon' => 'bx-chalkboard', 'link' => route('admin.admin-upload-faculties')],
                    ['title' => 'Waiver Requests', 'count' => $kpas['waiver_requests'] ?? 0, 'color' => 'warning', 'icon' => 'bx-receipt', 'link' => route('admin.admin-wavers-request')],
                    ['title' => 'Total Classes', 'count' => $kpas['classes'] ?? 0, 'color' => 'danger', 'icon' => 'bx-book-reader', 'link' => route('admin.admin-classes')],
                    ['title' => 'Total Subjects', 'count' => $kpas['subjects'] ?? 0, 'color' => 'primary', 'icon' => 'bx-book', 'link' => route('admin.admin-subjects')],
                    ['title' => 'Total Videos', 'count' => $kpas['videos'] ?? 0, 'color' => 'success', 'icon' => 'bx-video', 'link' => route('admin.admin-videos')],
                    ['title' => 'Total Subscribers', 'count' => $kpas['subscribers'] ?? 0, 'color' => 'info', 'icon' => 'bx-bell', 'link' => route('admin.admin-fees-report')],
                    ['title' => 'Total Blogs', 'count' => $kpas['blogs'] ?? 0, 'color' => 'warning', 'icon' => 'bx-news', 'link' => route('admin.admin-blogs')],
                    ['title' => 'Total Referrals', 'count' => $kpas['referrals'] ?? 0, 'color' => 'danger', 'icon' => 'bx-share-alt', 'link' => route('admin.admin-referrals')],
                    ['title' => 'Contact Messages', 'count' => $kpas['contacts'] ?? 0, 'color' => 'primary', 'icon' => 'bx-envelope', 'link' => route('admin.admin-enquiry')],
                    ['title' => 'Waiver Accounts', 'count' => $kpas['waiver_students'] ?? 0, 'color' => 'warning', 'icon' => 'bx-gift', 'link' => route('admin.admin-waver-profiles')],
                ];
            @endphp

            @foreach ($kpaItems as $item)
            <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                <a href="{{ $item['link'] }}" class="text-decoration-none">
                    <div class="card h-100 shadow-sm border-0 card-action">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="content-left">
                                    <span class="d-block mb-1 text-muted small fw-semibold">{{ $item['title'] }}</span>
                                    <h4 class="card-title mb-0 fw-bold">{{ number_format($item['count']) }}</h4>
                                </div>
                                <div class="avatar avatar-md">
                                    <span class="avatar-initial rounded-circle bg-label-{{ $item['color'] }}">
                                        <i class="bx {{ $item['icon'] }} fs-4"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const primaryColor = '#696cff';
    const successColor = '#71dd37';
    const infoColor = '#03c3ec';
    const warningColor = '#ffab00';
    const dangerColor = '#ff3e1d';
    const secondaryColor = '#8592a3';

    // -------------------------------------------------------------
    // 1. REVENUE & TRANSACTIONS TREND CHART (Area & Line Chart)
    // -------------------------------------------------------------
    const categories = @json($chartCategories);
    const revenueData = @json($revenueSeriesData);
    const txData = @json($transactionSeriesData);

    const revenueTrendEl = document.querySelector('#revenueTrendChart');
    if (revenueTrendEl) {
        const revenueOptions = {
            series: [
                {
                    name: 'Revenue (₹)',
                    type: 'area',
                    data: revenueData
                },
                {
                    name: 'Transactions',
                    type: 'line',
                    data: txData
                }
            ],
            chart: {
                height: 330,
                type: 'line',
                stacked: false,
                toolbar: { show: true },
                parentHeightOffset: 0
            },
            colors: [primaryColor, infoColor],
            stroke: {
                width: [3, 3],
                curve: 'smooth',
                dashArray: [0, 5]
            },
            fill: {
                type: ['gradient', 'solid'],
                gradient: {
                    shade: 'light',
                    type: 'vertical',
                    shadeIntensity: 0.5,
                    opacityFrom: 0.5,
                    opacityTo: 0.05,
                    stops: [0, 90, 100]
                }
            },
            markers: {
                size: 4,
                hover: { size: 6 }
            },
            xaxis: {
                categories: categories,
                axisBorder: { show: false },
                axisTicks: { show: false }
            },
            yaxis: [
                {
                    title: { text: 'Revenue (₹)', style: { color: primaryColor } },
                    labels: {
                        formatter: function (val) {
                            return '₹' + Number(val).toLocaleString('en-IN');
                        }
                    }
                },
                {
                    opposite: true,
                    title: { text: 'Transactions Count', style: { color: infoColor } },
                    labels: {
                        formatter: function (val) {
                            return Math.round(val);
                        }
                    }
                }
            ],
            tooltip: {
                shared: true,
                intersect: false,
                y: {
                    formatter: function (y, { seriesIndex }) {
                        if (typeof y !== "undefined") {
                            return seriesIndex === 0 ? '₹' + Number(y).toLocaleString('en-IN') : y + ' txns';
                        }
                        return y;
                    }
                }
            },
            grid: {
                borderColor: '#f1f1f1',
                padding: { top: 10, bottom: 0, left: 10, right: 10 }
            }
        };

        const revenueChart = new ApexCharts(revenueTrendEl, revenueOptions);
        revenueChart.render();
    }

    // -------------------------------------------------------------
    // 2. STUDENT GROWTH (Regular vs Waiver) BAR CHART
    // -------------------------------------------------------------
    const regularStudentData = @json($regularStudentSeriesData);
    const waiverStudentData = @json($waiverStudentSeriesData);

    const studentGrowthEl = document.querySelector('#studentGrowthChart');
    if (studentGrowthEl) {
        const studentGrowthOptions = {
            series: [
                {
                    name: 'Regular Students',
                    data: regularStudentData
                },
                {
                    name: 'Waiver Students',
                    data: waiverStudentData
                }
            ],
            chart: {
                type: 'bar',
                height: 330,
                stacked: true,
                toolbar: { show: false }
            },
            colors: [successColor, warningColor],
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '45%',
                    borderRadius: 4
                }
            },
            dataLabels: { enabled: false },
            xaxis: {
                categories: categories,
                axisBorder: { show: false }
            },
            yaxis: {
                title: { text: 'New Students' },
                labels: {
                    formatter: function (val) { return Math.round(val); }
                }
            },
            legend: {
                position: 'top',
                horizontalAlign: 'right'
            },
            grid: {
                borderColor: '#f1f1f1'
            }
        };

        const studentGrowthChart = new ApexCharts(studentGrowthEl, studentGrowthOptions);
        studentGrowthChart.render();
    }

    // -------------------------------------------------------------
    // 3. CLASS-WISE STUDENT DISTRIBUTION (Donut Chart)
    // -------------------------------------------------------------
    const classLabels = @json($classDistributionLabels);
    const classSeries = @json($classDistributionSeries);

    const classDistributionEl = document.querySelector('#classDistributionChart');
    if (classDistributionEl) {
        const classDistOptions = {
            series: classSeries.length ? classSeries : [1],
            labels: classLabels.length ? classLabels : ['No Data'],
            chart: {
                type: 'donut',
                height: 280
            },
            colors: [primaryColor, successColor, infoColor, warningColor, dangerColor, '#6f42c1', '#e83e8c'],
            legend: {
                position: 'bottom'
            },
            dataLabels: {
                enabled: true,
                formatter: function (val) {
                    return Math.round(val) + '%';
                }
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return val + ' Students';
                    }
                }
            }
        };

        const classDistChart = new ApexCharts(classDistributionEl, classDistOptions);
        classDistChart.render();
    }

    // -------------------------------------------------------------
    // 4. REVENUE BY CLASS (Horizontal Bar Chart)
    // -------------------------------------------------------------
    const classRevLabels = @json($classRevenueLabels);
    const classRevSeries = @json($classRevenueSeries);

    const classRevEl = document.querySelector('#classRevenueChart');
    if (classRevEl) {
        const classRevOptions = {
            series: [{
                name: 'Revenue (₹)',
                data: classRevSeries
            }],
            chart: {
                type: 'bar',
                height: 280,
                toolbar: { show: false }
            },
            colors: [successColor],
            plotOptions: {
                bar: {
                    borderRadius: 4,
                    horizontal: true,
                    barHeight: '55%'
                }
            },
            dataLabels: {
                enabled: true,
                formatter: function (val) {
                    return '₹' + Number(val).toLocaleString('en-IN');
                },
                style: { fontSize: '11px' }
            },
            xaxis: {
                categories: classRevLabels,
                labels: {
                    formatter: function (val) {
                        return '₹' + Number(val).toLocaleString('en-IN');
                    }
                }
            },
            grid: { borderColor: '#f1f1f1' }
        };

        const classRevChart = new ApexCharts(classRevEl, classRevOptions);
        classRevChart.render();
    }

    // -------------------------------------------------------------
    // 5. SUBSCRIPTION STATUSES (Donut Chart)
    // -------------------------------------------------------------
    const subStatusObj = @json($subscriptionStatuses);
    const subLabels = Object.keys(subStatusObj);
    const subSeries = Object.values(subStatusObj);

    const subStatusEl = document.querySelector('#subscriptionStatusChart');
    if (subStatusEl) {
        const subStatusOptions = {
            series: subSeries.some(v => v > 0) ? subSeries : [1],
            labels: subLabels,
            chart: {
                type: 'donut',
                height: 280
            },
            colors: [successColor, warningColor, infoColor, dangerColor],
            legend: {
                position: 'bottom'
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '65%',
                        labels: {
                            show: true,
                            total: {
                                show: true,
                                label: 'Total Access',
                                formatter: function (w) {
                                    return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                }
                            }
                        }
                    }
                }
            }
        };

        const subStatusChart = new ApexCharts(subStatusEl, subStatusOptions);
        subStatusChart.render();
    }
});
</script>
@endpush