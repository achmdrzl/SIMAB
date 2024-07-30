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
                            <h1 class="pg-title">Monitoring Alat</h1>
                            <p>Monitoring Pengelolaan Data Alat</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->

            <!-- Page Body -->
            <div class="hk-pg-body">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="tab_block_1">
                        <div class="row">
                            <div class="col-md-12 mb-md-4 mb-3">
                                <div class="card card-border mb-0 h-100">
                                    <div class="card-body">
                                        <div class="contact-list-view">
                                            <table id="datatable_7" class="table datatableUser table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Kode Alat</th>
                                                        <th>Nama Alat</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Page Body -->

            {{-- Modal User --}}
            <div class="modal fade" id="alatModal" tabindex="-1" role="dialog" aria-labelledby="modalSupplier"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title" id="alatHeading"></h6>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-danger alert-dismissible fade show" role="alert"
                                style="display: none;" style="color: red">
                            </div>
                            <form id="alatForm">
                                <div class="row gx-3">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Proyek</th>
                                                <th>Proyek Tgl Mulai</th>
                                                <th>Proyek Tgl Selesai</th>
                                                <th>Jumlah Alat</th>
                                            </tr>
                                        </thead>
                                        <tbody id="show-alat">

                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Page Footer -->
        @include('layouts.footer')
        <!-- / Page Footer -->

    </div>
    <!-- /Main Content -->
@endsection

@push('script-alt')
    <script>
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var datatable = $('#datatable_7').DataTable({
                scrollX: true,
                autoWidth: false,
                language: {
                    search: "",
                    searchPlaceholder: "Search",
                    sLengthMenu: "_MENU_item",
                    paginate: {
                        next: '<i class="ri-arrow-right-s-line"></i>', // or '→'
                        previous: '<i class="ri-arrow-left-s-line"></i>' // or '←' 
                    }
                },
                "drawCallback": function() {
                    $('.dataTables_paginate > .pagination').addClass(
                        'custom-pagination pagination-simple');
                },
                processing: true,
                serverSide: true,
                ajax: "{{ route('monitoring.alat') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'alat_kode',
                        name: 'alat_kode'
                    },
                    {
                        data: 'alat_nama',
                        name: 'alat_nama'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }
                ]
            });

            // Edit Data User
            $('body').on('click', '#alat-show', function() {
                var alat_id = $(this).attr('data-id');
                $('.alert').hide();
                $.ajax({
                    type: "POST",
                    url: "{{ route('alat.edit') }}",
                    data: {
                        alat_id: alat_id
                    },
                    dataType: "json",
                    success: function(response) {
                        console.log(response)
                        $('#submitBtnUser').val("alat-edit");
                        $('#alatForm').trigger("reset");
                        $('#alatHeading').html("DATA ALAT");
                        $('#alatModal').modal('show');
                        var showalat = ''
                        $.each(response.suratdetail, function (index, value) { 
                             const jmlalat      = value['alat_jml']
                             const proyeknama   = value['surat']['proyek']['proyek_nama']
                             const tglmulai     = value['surat']['proyek']['proyek_tglMulai']
                             const tglakhir     = value['surat']['proyek']['proyek_tglAkhir']

                             showalat += `
                                        <tr>
                                            <td>${proyeknama}</td>
                                            <td>${tglmulai}</td>
                                            <td>${tglakhir}</td>
                                            <td>${jmlalat}</td>
                                        </tr>`;
                        });

                        $("#show-alat").html(showalat)
                    }
                });
            });

        })
    </script>
@endpush
