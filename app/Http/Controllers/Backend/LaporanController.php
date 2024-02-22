<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use App\Models\Proyek;
use App\Models\SuratJalan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LaporanController extends Controller
{

    // INDEX SURAT JALAN
    public function laporanSuratjalan(Request $request)
    {
        $suratjalans   = SuratJalan::all();
        $alat          = Alat::where('status', 'aktif')->get();
        $proyek        = Proyek::all();

        if ($request->ajax()) {
            $suratjalans      =   SuratJalan::all();
            return DataTables::of($suratjalans)
                ->addIndexColumn()
                ->addColumn('suratjalan_tgl', function ($item) {
                    return $item->suratjalan_tgl;
                })
                ->addColumn('suratjalan_driver', function ($item) {
                    return ucfirst($item->suratjalan_driver);
                })
                ->addColumn('suratjalan_pengawaslapangan', function ($item) {
                    return ucfirst($item->suratjalan_pengawaslapangan);
                })
                ->addColumn('suratjalan_jmlalat', function ($item) {
                    return $item->suratjalan_jmlalat;
                })
                ->addColumn('status', function ($item) {
                    if ($item->status == 'selesai') {
                        $status = '<div class="badge badge-success">Selesai</div>';
                    } else {
                        $status = '<div class="badge badge-warning">On-Progress</div>';
                    }
                    return $status;
                })
                ->addColumn('action', function ($item) {

                    $btn = '<button class="btn btn-icon btn-primary btn-rounded flush-soft-hover me-1" title="SHOW DATA SURAT JALAN" id="suratjalan-show" data-id="' . $item->suratjalan_id . '"><span class="material-icons btn-sm">visibility</span></button>';

                    return $btn;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }
        return view('laporan.data-suratjalan', compact('suratjalans', 'alat', 'proyek'));
    }
        // INDEX PENGEMBALIAN SURAT JALAN
    public function laporanPengembalian(Request $request)
    {
        $suratjalans   = SuratJalan::all();
        $alat          = Alat::where('status', 'aktif')->get();
        $proyek        = Proyek::all();

        if ($request->ajax()) {
            $suratjalans      =   SuratJalan::all();
            return DataTables::of($suratjalans)
                ->addIndexColumn()
                ->addColumn('suratjalan_tgl', function ($item) {
                    return $item->suratjalan_tgl;
                })
                ->addColumn('suratjalan_driver', function ($item) {
                    return ucfirst($item->suratjalan_driver);
                })
                ->addColumn('suratjalan_pengawaslapangan', function ($item) {
                    return ucfirst($item->suratjalan_pengawaslapangan);
                })
                ->addColumn('suratjalan_jmlalat', function ($item) {
                    return $item->suratjalan_jmlalat;
                })
                ->addColumn('status', function ($item) {
                    if ($item->status == 'selesai') {
                        $status = '<div class="badge badge-success">Selesai</div>';
                    } else {
                        $status = '<div class="badge badge-warning">On-Progress</div>';
                    }
                    return $status;
                })
                ->addColumn('action', function ($item) {

                    $btn = '<button class="btn btn-icon btn-primary btn-rounded flush-soft-hover me-1" id="suratjalan-show" title="SHOW DATA SURAT JALAN" data-id="' . $item->suratjalan_id . '"><span class="material-icons btn-sm">visibility</span></button>';

                    return $btn;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }
        return view('laporan.data-pengembalian', compact('suratjalans', 'alat', 'proyek'));
    }

        // INDEX PROYEK
    public function laporanProyek(Request $request)
    {
        $proyeks   =   Proyek::all();
        if ($request->ajax()) {
            $proyeks      =   Proyek::all();
            return DataTables::of($proyeks)
                ->addIndexColumn()
                ->addColumn('proyek_nama', function ($item) {
                    return ucfirst($item->proyek_nama);
                })
                ->addColumn('proyek_pelaksana', function ($item) {
                    return $item->proyek_pelaksana;
                })
                ->addColumn('proyek_lokasi', function ($item) {
                    return $item->proyek_lokasi;
                })
                ->addColumn('proyek_pic', function ($item) {
                    return $item->proyek_pic;
                })
                ->addColumn('status', function ($item) {
                    if ($item->status == 'selesai') {
                        $status = '<div class="badge badge-success">Selesai</div>';
                    } else {
                        $status = '<div class="badge badge-warning">On-Progress</div>';
                    }
                    return $status;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }
        return view('laporan.data-proyek', compact('proyeks'));
    }
}
