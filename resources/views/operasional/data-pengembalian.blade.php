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
                            <h1 class="pg-title">Data Pengembalian</h1>
                            <p>Management Pengelolaan Data Pengembalian</p>
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
                                        <h6>List Data Pengembalian
                                            <span class="badge badge-sm badge-light ms-1">{{ count($suratjalans) }}</span>
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="contact-list-view">
                                            <table id="datatable_7" class="table nowrap datatableUser table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Tgl</th>
                                                        <th>Driver</th>
                                                        <th>Pengawas Lapangan</th>
                                                        <th>Jml Alat</th>
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
            <div class="modal fade" id="suratjalanModal" tabindex="-1" role="dialog" aria-labelledby="modalSupplier"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title" id="suratjalanHeading"></h6>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-danger alert-dismissible fade show" role="alert"
                                style="display: none;" style="color: red">
                            </div>
                            <form id="suratjalanForm">
                                <div class="row gx-3" id="proyek">
                                    <input type="hidden" id="suratjalan_id" name="suratjalan_id">
                                    <input type="hidden" id="suratjalan_edit" name="suratjalan_edit">
                                    <div class="col-sm-12">
                                        <label class="form-label">Proyek</label>
                                        <div class="form-group">
                                            <select class="form-control" name="proyek_id" id="proyek_id">
                                                <option disabled selected value="-">-- Pilih Proyek --</option>
                                                @foreach ($proyek as $item)
                                                    <option value="{{ $item->proyek_id }}">{{ ucfirst($item->proyek_nama) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <label class="form-label" id="labelsuratjalan_tgl">Tanggal Surat Jalan</label>
                                        <div class="form-group">
                                            <input class="form-control" type="date" placeholder="Masukkan Nama Proyek"
                                                name="suratjalan_tgl" id="suratjalan_tgl" />
                                        </div>
                                        <label class="form-label" id="labelsuratjalan_pengirim">Pengirim</label>
                                        <div class="form-group">
                                            <input class="form-control" type="text" placeholder="Masukkan Nama Proyek"
                                                name="suratjalan_pengirim" id="suratjalan_pengirim" />
                                        </div>
                                        <label class="form-label" id="labelsuratjalan_driver">Driver</label>
                                        <div class="form-group">
                                            <input class="form-control" type="text" value=""
                                                placeholder="Masukkan Driver Surat Jalan" name="suratjalan_driver"
                                                id="suratjalan_driver" />
                                        </div>
                                        <label class="form-label" id="labelsuratjalan_platno">Plat No</label>
                                        <div class="form-group">
                                            <input class="form-control" type="text" value=""
                                                placeholder="Masukkan Plat No Pengirim" name="suratjalan_platno"
                                                id="suratjalan_platno" />
                                        </div>
                                        <label class="form-label" id="labelsuratjalan_jenis">Jenis</label>
                                        <div class="form-group">
                                            <input class="form-control" type="text" value=""
                                                placeholder="Masukkan Jenis Pengirim" name="suratjalan_jenis"
                                                id="suratjalan_jenis" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row gx-3" id="driver">
                                    <div class="col-sm-12">
                                        <label class="form-label" id="labelsuratjalan_pengawaslapangan">Pengawas Lapangan</label>
                                        <div class="form-group">
                                            <input class="form-control" type="text"
                                                placeholder="Masukkan Pengawas Lapangan"
                                                name="suratjalan_pengawaslapangan" id="suratjalan_pengawaslapangan" />
                                        </div>
                                        <label class="form-label" id="labelsuratjalan_ket">Keterangan</label>
                                        <div class="form-group">
                                            <textarea name="suratjalan_ket" id="suratjalan_ket" class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row gx-3">
                                    <div class="col-sm-12">
                                        <label class="form-label" id="labelalat">Alat Berangkat</label>
                                        <div class="form-group">
                                            <select class="form-control" name="alat" id="alat">
                                                <option disabled selected value="-">-- Pilih Alat --</option>
                                                @foreach ($alat as $item)
                                                    <option value="{{ $item->alat_id }}">{{ ucfirst($item->alat_nama) }} --
                                                        {{ $item->alat_jml }} buah
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <label class="form-label" id="labeljml">Jumlah Alat</label>
                                        <div class="form-group">
                                            <input class="form-control" type="text" placeholder="Masukkan Jumlah Alat"
                                                name="jml" id="jml" />
                                        </div>
                                        {{-- <label class="form-label" id="labelplat">Plat No</label>
                                        <div class="form-group">
                                            <input class="form-control" type="text" placeholder="Masukkan Plat Nomor"
                                                name="plat" id="plat" />
                                        </div> --}}
                                        <div class="form-group">
                                            <button class="btn btn-success" type="button"
                                                id="tambahalat">Tambah</button>
                                        </div>
                                        <label class="form-label">Daftar Alat Di Pilih</label>
                                        <div class="form-group">
                                            <table class="table" id="show">
                                                <thead>
                                                    <tr>
                                                        <th>Nama Alat</th>
                                                        <th>Jumlah Alat</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="daftaralatshow">
                                                    {{-- INSERT ALAT DIPILIH --}}
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>Jumlah Alat</th>
                                                        <th id="jumlahShow" data-jumlah="0">0</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            <table class="table" id="delete">
                                                <thead>
                                                    <tr>
                                                        <th>Nama Alat</th>
                                                        <th>Jumlah Alat</th>
                                                        <th>Jumlah Alat Kondisi Baik</th>
                                                        <th>Jumlah Alat Kondisi Tidak Baik</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="daftaralatdelete">
                                                    {{-- INSERT ALAT DIPILIH --}}
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>Jumlah Alat</th>
                                                        <th id="jumlahDelete" data-jumlah="0">0</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                ajax: "{{ route('pengembalian.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'suratjalan_tgl',
                        name: 'suratjalan_tgl'
                    },
                    {
                        data: 'suratjalan_driver',
                        name: 'suratjalan_driver'
                    },
                    {
                        data: 'suratjalan_pengawaslapangan',
                        name: 'suratjalan_pengawaslapangan'
                    },
                    {
                        data: 'suratjalan_jmlalat',
                        name: 'suratjalan_jmlalat'
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

            // Show Data User
            $('body').on('click', '#suratjalan-show', function() {
                var suratjalan_id = $(this).attr('data-id');
                $("#daftaralatshow").html('');
                $('.alert').hide();
                $.ajax({
                    type: "POST",
                    url: "{{ route('suratjalan.edit') }}",
                    data: {
                        suratjalan_id: suratjalan_id
                    },
                    dataType: "json",
                    success: function(response) {
                        console.log(response)
                        $('#submitBtnUser').val("alat-edit");
                        $('#suratjalanForm').trigger("reset");
                        $('#suratjalanHeading').html("SHOW DATA SURAT JALAN");
                        $('#suratjalanModal').modal('show');
                        $('#show').attr('hidden', false);
                        $('#delete').attr('hidden', true);
                        $('#suratjalan_id').val(response.suratjalan_id);
                        $('#proyek_id').val(response.proyek_id).attr('disabled', true);
                        $('#suratjalan_edit').val('show').attr('disabled', true);
                        $('#suratjalan_tgl').val(response.suratjalan_tgl).attr('disabled', true);
                        $('#suratjalan_driver').val(response.suratjalan_driver).attr('disabled', true);
                        $('#suratjalan_pengirim').val(response.suratjalan_pengirim).attr('disabled', true);
                        $('#suratjalan_pengawaslapangan').val(response.suratjalan_pengawaslapangan).attr('disabled', true);
                        $('#suratjalan_platno').val(response.suratjalan_platno).attr('disabled', true);
                        $('#suratjalan_jenis').val(response.suratjalan_jenis).attr('disabled', true);
                        $('#suratjalan_ket').val(response.suratjalan_ket).attr('disabled', true);
                        $("#alat").attr('hidden', true);
                        $("#jml").attr('hidden', true);
                        $("#proyek_id").attr('hidden', false);
                        $("#suratjalan_tgl").attr('hidden', false);
                        $("#suratjalan_pengirim").attr('hidden', false);
                        $("#suratjalan_driver").attr('hidden', false);
                        $("#suratjalan_platno").attr('hidden', false);
                        $("#suratjalan_jenis").attr('hidden', false);
                        $("#suratjalan_pengawaslapangan").attr('hidden', false);
                        $("#suratjalan_ket").attr('hidden', false);
                        $("#labelsuratjalan_pengirim").attr('hidden', false);
                        $("#labelsuratjalan_driver").attr('hidden', false);
                        $("#labelsuratjalan_platno").attr('hidden', false);
                        $("#labelsuratjalan_jenis").attr('hidden', false);
                        $("#labelsuratjalan_pengawaslapangan").attr('hidden', false);
                        $("#labelsuratjalan_ket").attr('hidden', false);
                        $("#labelalat").attr('hidden', true);
                        $("#labeljml").attr('hidden', true);
                        $("#tambahalat").attr('hidden', true);
                        $("#submitAlat").attr('hidden', true);

                        $.each(response.detailsurat, function(index, value) {
                            const newRowId = `row_${index}`;
                            const alat_nama = value['alat']['alat_nama'];
                            const alat_id = value['alat']['alat_id'];
                            const alat_jml = value['alat_jml'];
                            const alat_jenis = value['alat_jenis'];
                            const alat_platno = value['alat_platno'];

                            const newRow = `<tr id="${newRowId}">
                                <td>
                                    <input class="text-center form-control alat_id" value="${alat_id}" type="hidden" name="alat_id[]" placeholder="Masukkan Pax" disabled>
                                    ${alat_nama.toUpperCase()}
                                </td>
                                <td>
                                    <input class="text-center form-control alat_jml" value="${alat_jml}" type="hidden" name="alat_jml[]" placeholder="Masukkan Pax" disabled>
                                    ${alat_jml}
                                </td>
                                <td></td>
                            </tr>`;

                            // Append the new row to the tables
                            $("#daftaralatshow").append(newRow); 
                        });

                        var newjumlah = parseInt(response.suratjalan_jmlalat);
                        $("#jumlahShow").attr('data-jumlah', newjumlah).html(newjumlah);
                    }
                });
            });

            // Delete Data User
            $('body').on('click', '#suratjalan-delete', function() {
                var suratjalan_id = $(this).attr('data-id');
                $("#daftaralatdelete").html('');
                $('.alert').hide();
                $.ajax({
                    type: "POST",
                    url: "{{ route('suratjalan.edit') }}",
                    data: {
                        suratjalan_id: suratjalan_id
                    },
                    dataType: "json",
                    success: function(response) {
                        console.log(response)
                        $('#submitBtnUser').val("alat-edit");
                        $('#suratjalanForm').trigger("reset");
                        $('#suratjalanHeading').html("PENGEMBALIAN SURAT JALAN");
                        $('#suratjalanModal').modal('show');
                        $('#show').attr('hidden', true);
                        $('#delete').attr('hidden', false);
                        $('#suratjalan_id').val(response.suratjalan_id);
                        $('#proyek_id').val(response.proyek_id).attr('disabled', true);
                        $('#suratjalan_edit').val('show').attr('disabled', true);
                        $('#suratjalan_tgl').val(response.suratjalan_tgl).attr('disabled', true);
                        $('#suratjalan_driver').val(response.suratjalan_driver).attr('disabled', true);
                        $('#suratjalan_pengirim').val(response.suratjalan_pengirim).attr('disabled', true);
                        $('#suratjalan_pengawaslapangan').val(response.suratjalan_pengawaslapangan).attr('disabled', true);
                        $('#suratjalan_platno').val(response.suratjalan_platno).attr('disabled', true);
                        $('#suratjalan_jenis').val(response.suratjalan_jenis).attr('disabled', true);
                        $('#suratjalan_ket').val(response.suratjalan_ket).attr('disabled', true);
                        $("#alat").attr('hidden', true);
                        $("#jml").attr('hidden', true);
                        $("#proyek_id").attr('hidden', false);
                        $("#suratjalan_tgl").attr('hidden', false);
                        $("#suratjalan_pengirim").attr('hidden', true);
                        $("#suratjalan_driver").attr('hidden', true);
                        $("#suratjalan_platno").attr('hidden', true);
                        $("#suratjalan_jenis").attr('hidden', true);
                        $("#suratjalan_pengawaslapangan").attr('hidden', true);
                        $("#suratjalan_ket").attr('hidden', true);
                        $("#labelsuratjalan_pengirim").attr('hidden', true);
                        $("#labelsuratjalan_driver").attr('hidden', true);
                        $("#labelsuratjalan_platno").attr('hidden', true);
                        $("#labelsuratjalan_jenis").attr('hidden', true);
                        $("#labelsuratjalan_pengawaslapangan").attr('hidden', true);
                        $("#labelsuratjalan_ket").attr('hidden', true);
                        $("#labelalat").attr('hidden', true);
                        $("#labeljml").attr('hidden', true);
                        $("#tambahalat").attr('hidden', true);
                        $("#submitAlat").attr('hidden', false);

                        $.each(response.detailsurat, function(index, value) {
                            const newRowId          = `row_${index}`;
                            const alat_nama         = value['alat']['alat_nama'];
                            const alat_id           = value['alat_id'];
                            const alat_jml          = value['alat_jml'];
                            const alat_jenis        = value['alat_jenis'];
                            const alat_platno       = value['alat_platno'];
                            const alat_baik         = alat_jml;
                            const alat_tidak_baik   = 0;
                            
                            const newRow = `<tr id="${newRowId}">
                                <td>
                                    ${alat_nama.toUpperCase()}
                                </td>
                                <td>
                                    ${alat_jml}
                                </td>
                                <td>
                                    <input class="text-center form-control alat_id" value="${alat_id}" type="hidden" name="alat_id[]" placeholder="Masukkan Pax">
                                    <input class="text-center form-control alat_kembali_jml" value="${alat_jml}" type="hidden" name="alat_kembali_jml[]" placeholder="Masukkan Pax">
                                    <input class="text-center form-control alat_kondisi_baik" value="${alat_baik}" type="text" name="alat_kondisi_baik[]" placeholder="Masukkan Jumlah Alat Kondisi Baik">
                                </td>
                                <td>
                                    <input class="text-center form-control alat_kondisi_tidak_baik" value="${alat_tidak_baik}" type="text" name="alat_kondisi_tidak_baik[]" placeholder="Masukkan Jumlah Alat Kondisi Tidak Baik">
                                </td>
                            </tr>`;

                            // Append the new row to the tables
                            $("#daftaralatdelete").append(newRow); 
                        });

                        var newjumlah = parseInt(response.suratjalan_jmlalat);
                        $("#jumlahDelete").attr('data-jumlah', newjumlah).html(newjumlah);
                    }
                });
            });

            // Custom validation function
            function validateForm() {
                let isValid = true;
                $('.alert-danger').hide().html('');

                $('tbody#daftaralatdelete tr').each(function() {
                    const alat_jml = parseInt($(this).find('.alat_kembali_jml').val());
                    const alat_kondisi_baik = parseInt($(this).find('.alat_kondisi_baik').val());
                    const alat_kondisi_tidak_baik = parseInt($(this).find('.alat_kondisi_tidak_baik').val());
                    const total = alat_kondisi_baik + alat_kondisi_tidak_baik;

                    if (total > alat_jml) {
                        isValid = false;
                        $('.alert-danger').show().append('<strong><li>Jumlah Alat Kondisi Baik dan Tidak Baik tidak boleh lebih dari Jumlah Alat.</li></strong>');
                    }
                });

                return isValid;
            }

            $('#submitAlat').click(function(e) {
                e.preventDefault();
                $(this).html('Sending..');

                if (!validateForm()) {
                    $('#submitAlat').html('Simpan');
                    return;
                }else{
                    $.ajax({
                        url: "{{ route('pengembalian.destroy') }}",
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
    
                                $('#suratjalanForm').trigger("reset");
                                $('#submitAlat').html('Simpan');
                                $('#suratjalanModal').modal('hide');
    
                                $("#daftaralat").html('');
                                $("#jumlah").attr('data-jumlah', 0).html('0');
    
                                datatable.draw();
    
                                // // Set a timeout before reloading the window
                                // setTimeout(function() {
                                //     window.location.reload();
                                // }, 2000); // 2000 milliseconds = 2 seconds
                            }
                        }
                    });
                }

            });

            // Arsipkan Data User
            // $('body').on('click', '#suratjalan-delete', function() {

            //     const swalWithBootstrapButtons = Swal.mixin({
            //         customClass: {
            //             confirmButton: "btn btn-success",
            //             cancelButton: "btn btn-danger me-2",
            //         },
            //         buttonsStyling: false,

            //     });

            //     var suratjalan_id = $(this).attr('data-id');

            //     swalWithBootstrapButtons
            //         .fire({
            //             title: "Do you want to update, this data?",
            //             text: "This data will be updated to finish!",
            //             icon: "warning",
            //             showCancelButton: true,
            //             confirmButtonClass: "me-2",
            //             cancelButtonText: "Tidak",
            //             confirmButtonText: "Ya",
            //             reverseButtons: true,
            //         })
            //         .then((result) => {
            //             if (result.value) {
            //                 $.ajax({
            //                     type: "POST",
            //                     url: "{{ route('pengembalian.destroy') }}",
            //                     data: {
            //                         suratjalan_id: suratjalan_id,
            //                     },
            //                     dataType: "json",
            //                     success: function(response) {
            //                         const Toast = Swal.mixin({
            //                             toast: true,
            //                             position: 'top-end',
            //                             showConfirmButton: false,
            //                             timer: 3000,
            //                             timerProgressBar: true,
            //                         });

            //                         Toast.fire({
            //                             icon: 'success',
            //                             title: `${response.status}`,
            //                         })
            //                         datatable.draw();
            //                     }
            //                 });
            //             } else {
            //                 Swal.fire("Cancel!", "Perintah dibatalkan!", "error");
            //             }
            //         });

            // });

        })
    </script>
@endpush
