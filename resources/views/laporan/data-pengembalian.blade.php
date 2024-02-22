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
                            <h1 class="pg-title">Laporan Pengembalian</h1>
                            <p>Laporan Pengembalian</p>
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
                                <div class="row gx-3">
                                    <input type="hidden" id="suratjalan_id" name="suratjalan_id">
                                    <input type="hidden" id="suratjalan_edit" name="suratjalan_edit">
                                    <div class="col-sm-12">
                                        <label class="form-label">Proyek</label>
                                        <div class="form-group">
                                            <select class="form-control" name="proyek_id" id="proyek_id">
                                                <option disabled selected>-- Pilih Proyek --</option>
                                                @foreach ($proyek as $item)
                                                    <option value="{{ $item->proyek_id }}">{{ ucfirst($item->proyek_nama) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <label class="form-label">Tanggal Surat Jalan</label>
                                        <div class="form-group">
                                            <input class="form-control" type="date" placeholder="Masukkan Nama Proyek"
                                                name="suratjalan_tgl" id="suratjalan_tgl" />
                                        </div>
                                        <label class="form-label">Driver</label>
                                        <div class="form-group">
                                            <input class="form-control" type="text" value=""
                                                placeholder="Masukkan Driver Surat Jalan" name="suratjalan_driver"
                                                id="suratjalan_driver" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row gx-3">
                                    <div class="col-sm-12">
                                        <label class="form-label">Pengawas Lapangan</label>
                                        <div class="form-group">
                                            <input class="form-control" type="text"
                                                placeholder="Masukkan Pengawas Lapangan" name="suratjalan_pengawaslapangan"
                                                id="suratjalan_pengawaslapangan" />
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
                                        <div class="form-group">
                                            <button class="btn btn-success" type="button"
                                                id="tambahalat">Tambah</button>
                                        </div>
                                        <label class="form-label">Daftar Alat Di Pilih</label>
                                        <div class="form-group">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Nama Alat</th>
                                                        <th>Jumlah Alat</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="daftaralat">
                                                    {{-- INSERT ALAT DIPILIH --}}
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>Jumlah Alat</th>
                                                        <th id="jumlah" data-jumlah="0">0</th>
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
                ajax: "{{ route('laporan.pengembalian') }}",
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
                ]
            });

            // Edit Data User
            $('body').on('click', '#suratjalan-show', function() {
                var suratjalan_id = $(this).attr('data-id');
                $("#daftaralat").html('');
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
                        $('#suratjalan_id').val(response.suratjalan_id);
                        $('#proyek_id').val(response.proyek_id).attr('disabled', true);
                        $('#suratjalan_edit').val('show').attr('disabled', true);
                        $('#suratjalan_tgl').val(response.suratjalan_tgl).attr('disabled', true);
                        $('#suratjalan_driver').val(response.suratjalan_driver).attr('disabled', true);
                        $('#suratjalan_pengawaslapangan').val(response.suratjalan_pengawaslapangan).attr('disabled', true);
                        $("#alat").attr('hidden', true);
                        $("#jml").attr('hidden', true);
                        $("#labelalat").attr('hidden', true);
                        $("#labeljml").attr('hidden', true);
                        $("#tambahalat").attr('hidden', true);
                        $("#submitAlat").attr('hidden', true);

                        $.each(response.detailsurat, function(index, value) {

                            const newRowId  = `row_${index}`;
                            const alat_nama = value['alat']['alat_nama']
                            const alat_id   = value['alat']['alat_id']
                            const alat_jml  = value['alat_jml']

                            const newRow = `<tr id="${newRowId}">
                                    <td>
                                        <input class="text-center form-control alat_id" value="${alat_id}" type="hidden" name="alat_id[]" placeholder="Masukkan Pax" disabled>
                                        ${alat_nama.toUpperCase()}
                                    </td>
                                    <td>
                                        <input class="text-center form-control alat_jml" value="${alat_jml}" type="hidden" name="alat_jml[]" placeholder="Masukkan Pax" disabled>
                                        ${alat_jml}
                                    </td>
                                    <td>
                                       
                                    </td>
                                </tr>`;

                            // Append the new row to the tables
                            $("#daftaralat").append(newRow); 
                        });

                        var newjumlah = parseInt(response.suratjalan_jmlalat);

                        $("#jumlah").attr('data-jumlah', newjumlah).html(newjumlah);
                    }
                });
            });

        })
    </script>
@endpush
