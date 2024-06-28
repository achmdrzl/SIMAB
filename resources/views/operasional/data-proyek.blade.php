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
                            <h1 class="pg-title">Data Proyek</h1>
                            <p>Management Pengelolaan Data Proyek</p>
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
                                    <div class="card-header card-header-action">
                                        <h6>List Data Proyek
                                            <span class="badge badge-sm badge-light ms-1">{{ count($proyeks) }}</span>
                                        </h6>
                                        <div class="card-action-wrap">
                                            <button class="btn btn-sm btn-primary ms-3" id="alat-create"><span><span
                                                        class="icon"><span class="feather-icon"><i
                                                                data-feather="plus"></i></span></span><span
                                                        class="btn-text">Tambah
                                                        Proyek</span></span></button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="contact-list-view">
                                            <table id="datatable_7" class="table nowrap datatableUser table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Nama Proyek</th>
                                                        <th>Pelaksana</th>
                                                        <th>Lokasi</th>
                                                        <th>PIC</th>
                                                        <th>Status</th>
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
            <div class="modal fade" id="proyekModal" tabindex="-1" role="dialog" aria-labelledby="modalSupplier"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title" id="proyekHeading"></h6>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-danger alert-dismissible fade show" role="alert"
                                style="display: none;" style="color: red">
                            </div>
                            <form id="proyekForm">
                                <div class="row gx-3">
                                    <input type="hidden" id="proyek_id" name="proyek_id">
                                    <div class="col-sm-12">
                                        <label class="form-label">Nama Proyek</label>
                                        <div class="form-group">
                                            <input class="form-control" type="text" placeholder="Masukkan Nama Proyek"
                                                name="proyek_nama" id="proyek_nama" />
                                        </div>
                                        <label class="form-label">Pelaksana</label>
                                        <div class="form-group">
                                            <input class="form-control" type="text" value=""
                                                placeholder="Masukkan Pelaksana Proyek" name="proyek_pelaksana"
                                                id="proyek_pelaksana" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row gx-3">
                                    <div class="col-sm-12">
                                        <label class="form-label">Tanggal Mulai Proyek</label>
                                        <div class="form-group">
                                            <input class="form-control" type="date" placeholder="Masukkan Tanggal Mulai Proyek"
                                                name="proyek_tglMulai" id="proyek_tglMulai" />
                                        </div>
                                        <label class="form-label">Tanggal Akhir Proyek</label>
                                        <div class="form-group">
                                            <input class="form-control" type="date" placeholder="Masukkan Tanggal Akhir Proyek"
                                                name="proyek_tglAkhir" id="proyek_tglAkhir" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row gx-3">
                                    <div class="col-sm-12">
                                        <label class="form-label">Lokasi</label>
                                        <div class="form-group">
                                            <input class="form-control" type="text" placeholder="Masukkan Lokasi Proyek"
                                                name="proyek_lokasi" id="proyek_lokasi" />
                                        </div>
                                        <label class="form-label">PIC</label>
                                        <div class="form-group">
                                            <input class="form-control" type="text" value=""
                                                placeholder="Masukkan PIC Proyek" name="proyek_pic" id="proyek_pic" />
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <div class="modal-footer align-items-center">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary" id="submitAlat">Simpan</button>
                        </div>
                        </form>
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
                ajax: "{{ route('proyek.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'proyek_nama',
                        name: 'proyek_nama'
                    },
                    {
                        data: 'proyek_pelaksana',
                        name: 'proyek_pelaksana'
                    },
                    {
                        data: 'proyek_lokasi',
                        name: 'proyek_lokasi'
                    },
                    {
                        data: 'proyek_pic',
                        name: 'proyek_pic'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }
                ]
            });

            // Create Data User.
            $('#alat-create').click(function() {
                $('.alert').hide();
                $('#saveBtn').val("create-user");
                $('#proyek_id').val('');
                $('#proyekForm').trigger("reset");
                $('#proyekHeading').html("TAMBAH DATA PROYEK BARU");
                $('#proyekModal').modal('show');
            });

            $('#submitAlat').click(function(e) {
                e.preventDefault();
                $(this).html('Sending..');

                $.ajax({
                    url: "{{ route('proyek.store') }}",
                    data: new FormData(this.form),
                    cache: false,
                    processData: false,
                    contentType: false,
                    type: "POST",

                    success: function(response) {
                        console.log(response)
                        if (response.errors) {
                            $('.alert').html('');
                            $.each(response.errors, function(key, value) {
                                $('.alert-danger').show();
                                $('.alert-danger').append('<strong><li>' + value +
                                    '</li></strong>');
                            });
                            $('#submitAlat').html('Simpan');

                        } else {
                            $('.btn-warning').hide();

                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                            });

                            Toast.fire({
                                icon: 'success',
                                title: `${response.message}`,
                            })

                            $('#proyekForm').trigger("reset");
                            $('#submitAlat').html('Simpan');
                            $('#proyekModal').modal('hide');

                            datatable.draw();
                        }
                    }
                });
            });

            // Edit Data User
            $('body').on('click', '#proyek-edit', function() {
                var proyek_id = $(this).attr('data-id');
                $('.alert').hide();
                $.ajax({
                    type: "POST",
                    url: "{{ route('proyek.edit') }}",
                    data: {
                        proyek_id: proyek_id
                    },
                    dataType: "json",
                    success: function(response) {
                        console.log(response)
                        $('#submitBtnUser').val("alat-edit");
                        $('#proyekForm').trigger("reset");
                        $('#proyekHeading').html("EDIT DATA PROYEK");
                        $('#proyekModal').modal('show');
                        $('#proyek_id').val(response.proyek_id);
                        $('#proyek_nama').val(response.proyek_nama);
                        $('#proyek_pelaksana').val(response.proyek_pelaksana);
                        $('#proyek_tglMulai').val(response.proyek_tglMulai);
                        $('#proyek_tglAkhir').val(response.proyek_tglAkhir);
                        $('#proyek_lokasi').val(response.proyek_lokasi);
                        $('#proyek_pic').val(response.proyek_pic);
                    }
                });
            });

            // Arsipkan Data User
            $('body').on('click', '#proyek-delete', function() {

                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: "btn btn-success",
                        cancelButton: "btn btn-danger me-2",
                    },
                    buttonsStyling: false,

                });

                var proyek_id = $(this).attr('data-id');

                swalWithBootstrapButtons
                    .fire({
                        title: "Do you want to update, this data?",
                        text: "This data will be updated to finish!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonClass: "me-2",
                        cancelButtonText: "Tidak",
                        confirmButtonText: "Ya",
                        reverseButtons: true,
                    })
                    .then((result) => {
                        if (result.value) {
                            $.ajax({
                                type: "POST",
                                url: "{{ route('proyek.destroy') }}",
                                data: {
                                    proyek_id: proyek_id,
                                },
                                dataType: "json",
                                success: function(response) {
                                    const Toast = Swal.mixin({
                                        toast: true,
                                        position: 'top-end',
                                        showConfirmButton: false,
                                        timer: 3000,
                                        timerProgressBar: true,
                                    });

                                    Toast.fire({
                                        icon: 'success',
                                        title: `${response.status}`,
                                    })
                                    datatable.draw();
                                }
                            });
                        } else {
                            Swal.fire("Cancel!", "Perintah dibatalkan!", "error");
                        }
                    });

            });

        })
    </script>
@endpush
