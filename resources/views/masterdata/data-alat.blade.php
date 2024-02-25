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
                            <h1 class="pg-title">Data Alat</h1>
                            <p>Management Pengelolaan Data Alat</p>
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
                                        <h6>List Data Alat
                                            <span class="badge badge-sm badge-light ms-1">{{ count($alats) }}</span>
                                        </h6>
                                        <div class="card-action-wrap">
                                            <button class="btn btn-sm btn-primary ms-3" id="alat-create"><span><span
                                                        class="icon"><span class="feather-icon"><i
                                                                data-feather="plus"></i></span></span><span
                                                        class="btn-text">Tambah
                                                        Alat</span></span></button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="contact-list-view">
                                            <table id="datatable_7" class="table datatableUser table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Kode Alat</th>
                                                        <th>Nama Alat</th>
                                                        <th>Jumlah</th>
                                                        <th>Kondisi</th>
                                                        <th>Jenis</th>
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
                                    <input type="hidden" id="alat_id" name="alat_id">
                                    <div class="col-sm-12">
                                        <label class="form-label">Nama Alat</label>
                                        <div class="form-group">
                                            <input class="form-control" type="text" placeholder="Masukkan Nama"
                                                name="alat_nama" id="alat_nama" />
                                        </div>
                                        <label class="form-label">Alat Jenis</label>
                                        <div class="form-group">
                                            <input class="form-control" type="text" placeholder="Masukkan Nama"
                                                name="alat_jenis" id="alat_jenis" />
                                        </div>
                                        <label class="form-label">Jumlah</label>
                                        <div class="form-group">
                                            <input class="form-control" type="number" value=""
                                                placeholder="Masukkan Jumlah Alat" name="alat_jml" id="alat_jml" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row gx-3">
                                    <div class="col-sm-12">
                                        <label class="form-label">Kondisi Alat</label>
                                        <div class="form-group">
                                            <textarea name="alat_kondisi" id="alat_kondisi" class="form-control"></textarea>
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
                ajax: "{{ route('alat.index') }}",
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
                        data: 'alat_jml',
                        name: 'alat_jml'
                    },
                    {
                        data: 'alat_kondisi',
                        name: 'alat_kondisi'
                    },
                    {
                        data: 'alat_jenis',
                        name: 'alat_jenis'
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
                $('#alat_id').val('');
                $('#alatForm').trigger("reset");
                $('#alatHeading').html("TAMBAH DATA ALAT BARU");
                $('#alatModal').modal('show');
            });

            $('#submitAlat').click(function(e) {
                e.preventDefault();
                $(this).html('Sending..');

                $.ajax({
                    url: "{{ route('alat.store') }}",
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

                            $('#alatForm').trigger("reset");
                            $('#submitAlat').html('Simpan');
                            $('#alatModal').modal('hide');

                            datatable.draw();
                        }
                    }
                });
            });

            // Edit Data User
            $('body').on('click', '#alat-edit', function() {
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
                        $('#alatHeading').html("EDIT DATA ALAT");
                        $('#alatModal').modal('show');
                        $('#alat_id').val(response.alat_id);
                        $('#alat_nama').val(response.alat_nama);
                        $('#alat_kondisi').val(response.alat_kondisi);
                        $('#alat_jml').val(response.alat_jml);
                        $('#alat_jenis').val(response.alat_jenis);
                    }
                });
            });

            // Arsipkan Data User
            $('body').on('click', '#alat-delete', function() {

                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: "btn btn-success",
                        cancelButton: "btn btn-danger me-2",
                    },
                    buttonsStyling: false,

                });

                var alat_id = $(this).attr('data-id');

                swalWithBootstrapButtons
                    .fire({
                        title: "Do you want to delete, this data?",
                        text: "This data will be deleted!",
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
                                url: "{{ route('alat.destroy') }}",
                                data: {
                                    alat_id: alat_id,
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
