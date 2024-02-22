@extends('layouts.main')

@section('content')
    <!-- Main Content -->
    <div class="hk-pg-wrapper">
        <div class="container-xxl">
            <!-- Page Header -->
            <div class="hk-pg-header pg-header-wth-tab pt-7">
                <div class="d-flex">
                    <div class="d-flex flex-wrap justify-content-between flex-1">
                        <div class="mb-lg-0 mb-2 me-8">
                            <h1 class="pg-title">Welcome back</h1>
                            <p>Hello, {{ Auth::user()->name }}!</p>
                        </div>
                        <div class="pg-header-action-wrap">
                            <div class="input-group w-300p">
                                <span class="input-affix-wrapper">
                                    <div class="" id="clock"></div>
                                    <div>&nbsp;</div>
                                    <div id="date"></div>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <!-- Page Body -->
            <div class="hk-pg-body">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="data_order">
                            <div class="row">
                                <hr>
                                <div class="row">
                                    <div class="col-md-6 mb-md-4 mb-3">
                                        <div class="card card-border mb-0 h-100">
                                            <div class="card-header card-header-action">
                                                <h6>Total Surat Jalan
                                                </h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="col-md-12">
                                                    <h1 id="pendingOrder">{{ $suratjalan }} </h1>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-md-4 mb-3">
                                        <div class="card card-border mb-0 h-100">
                                            <div class="card-header card-header-action">
                                                <h6>Total Surat Jalan Kembali
                                                </h6>
                                            </div>
                                            <div class="card-body">
                                                <h1 id="settleOrder">{{ $suratjalanKembali }}</h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-md-4 mb-3">
                                        <div class="card card-border mb-0 h-100">
                                            <div class="card-header card-header-action">
                                                <h6>Total Proyek</h6>
                                            </div>
                                            <div class="card-body">
                                                <h1 id="totalOrder">{{ $proyek }}</h1>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-md-4 mb-3">
                                        <div class="card card-border mb-0 h-100">
                                            <div class="card-header card-header-action">
                                                <h6>Total Proyek Selesai</h6>
                                            </div>
                                            <div class="card-body">
                                                <h1 id="totalOrder">{{ $proyekSelesai }}</h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Page Body -->
                </div>
            <!-- /Page Body -->
        </div>

        <!-- Page Footer -->
        @include('layouts.footer')
        <!-- / Page Footer -->

    </div>
    <!-- /Main Content -->
@endsection

@push('script-alt')
        <script>
            function updateClockAndDate() {
                const clockElement = document.getElementById('clock');
                const dateElement = document.getElementById('date');
                const now = new Date();

                // Update the clock
                const hours = String(now.getHours()).padStart(2, '0');
                const minutes = String(now.getMinutes()).padStart(2, '0');
                const seconds = String(now.getSeconds()).padStart(2, '0');
                const timeString = `${hours}:${minutes}:${seconds}`;
                clockElement.textContent = timeString;

                // Update the date
                const year = now.getFullYear();
                const month = String(now.getMonth() + 1).padStart(2, '0');
                const day = String(now.getDate()).padStart(2, '0');
                const dateString = `${day}/${month}/${year}`;
                dateElement.textContent = dateString;
            }

            // Call the function to update the clock and date every second
            setInterval(updateClockAndDate, 1000);

            // Initial update
            updateClockAndDate();

        </script>
    @endpush