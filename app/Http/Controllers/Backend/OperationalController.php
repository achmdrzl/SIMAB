<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use App\Models\Proyek;
use App\Models\SuratJalan;
use App\Models\SuratJalanDetail;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class OperationalController extends Controller
{
    
    // INDEX PROYEK
    public function proyekIndex(Request $request)
    {
        $proyeks   =   Proyek::where('status', 'on-progress')->get();
        if ($request->ajax()) {
            $proyeks      =   Proyek::where('status', 'on-progress')->get();
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
                ->addColumn('action', function ($item) {

                    if ($item->status == 'aktif') {
                        $class = 'danger';
                        $icon = 'visibility_off';
                    } else {
                        $class = 'success';
                        $icon = 'visibility';
                    }

                    $btn = '<button class="btn btn-icon btn-primary btn-rounded flush-soft-hover me-1" title="EDIT DATA PROYEK" id="proyek-edit" data-id="' . $item->proyek_id . '"><span class="material-icons btn-sm">edit</span></button>';

                    if ($item->status == 'on-progress') {
                        $btn = $btn . '<button class="btn btn-icon btn-' . $class . ' btn-rounded flush-soft-hover me-1" title="UPDATE STATUS PROYEK" id="proyek-delete" data-id="' . $item->proyek_id . '"><span class="material-icons btn-sm">' . $icon . '</span></button>';
                    }

                    return $btn;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }
        return view('operasional.data-proyek', compact('proyeks'));
    }

    // PROYEK STORED DATA
    public function proyekStore(Request $request)
    {
        // Define validation rules and custom error messages
        $validator = Validator::make($request->all(), [
            'proyek_nama'       => 'required',
            'proyek_pelaksana'  => 'required',
            'proyek_lokasi'     => 'required',
            'proyek_tglMulai'   => 'required|date',
            'proyek_tglAkhir'   => 'required|date|after_or_equal:proyek_tglMulai',
            'proyek_pic'        => 'required',
        ], [
            'proyek_nama.required'          => 'Nama Proyek Harus di Isi!',
            'proyek_pelaksana.required'     => 'Pelaksana Proyek Harus di Isi!',
            'proyek_lokasi.required'        => 'Lokasi Proyek Harus di Isi!',
            'proyek_tglMulai.required'      => 'Tanggal Mulai Proyek Harus di Isi!',
            'proyek_tglMulai.date'          => 'Tanggal Mulai Proyek Harus dalam Format Tanggal yang Valid!',
            'proyek_tglAkhir.required'      => 'Tanggal Akhir Proyek Harus di Isi!',
            'proyek_tglAkhir.date'          => 'Tanggal Akhir Proyek Harus dalam Format Tanggal yang Valid!',
            'proyek_tglAkhir.after_or_equal'=> 'Tanggal Akhir Proyek Harus Setelah atau Sama dengan Tanggal Mulai Proyek!',
            'proyek_pic.required'           => 'PIC Proyek Harus di Isi!',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        // insert data to table proyek 
        $proyek = Proyek::updateOrCreate([
            'proyek_id' => $request->proyek_id
        ], [
            'proyek_nama'       => $request->proyek_nama,
            'proyek_pelaksana'  => $request->proyek_pelaksana,
            'proyek_lokasi'     => $request->proyek_lokasi,
            'proyek_tglMulai'   => $request->proyek_tglMulai,
            'proyek_tglAkhir'   => $request->proyek_tglAkhir,
            'proyek_pic'        => $request->proyek_pic,
            'fk_user'           => Auth::user()->user_id,
        ]);

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Your data has been saved successfully!',
        ]);
    }

    // PROYEK EDIT DATA
    public function proyekEdit(Request $request)
    {
        $proyek = Proyek::where('proyek_id', $request->proyek_id)->first();
        return response()->json($proyek);
    }

    // PROYEK DELETE DATA
    public function proyekDestroy(Request $request)
    {
        $proyek = Proyek::find($request->proyek_id);

        if ($proyek->status == 'selesai') {
            $proyek->update([
                'status'    => 'on-progress',
            ]);
        } else {
            $proyek->update([
                'status'    => 'selesai',
            ]);
        }

        return response()->json(['status' => 'Data Saved Successfully!']);
    }

    // INDEX SURAT JALAN
    public function suratJalanIndex(Request $request)
    {
        $suratjalans   = SuratJalan::where('status', 'on-progress')->get();
        $alat          = Alat::where('status', 'aktif')->get();
        $proyek        = Proyek::all();

        if ($request->ajax()) {
            $suratjalans      =   SuratJalan::where('status', 'on-progress')->get();
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


                    $btn = '<button class="btn btn-icon btn-primary btn-rounded flush-soft-hover me-1" title="EDIT DATA SURAT JALAN" id="suratjalan-edit" data-id="' . $item->suratjalan_id . '"><span class="material-icons btn-sm">edit</span></button>';

                    $btn = $btn . '<button class="btn btn-icon btn-primary btn-rounded flush-soft-hover me-1" title="SHOW DATA SURAT JALAN" id="suratjalan-show" data-id="' . $item->suratjalan_id . '"><span class="material-icons btn-sm">visibility</span></button>';

                    $btn = $btn . '<button class="btn btn-icon btn-primary btn-rounded flush-soft-hover me-1" title="CETAK SURAT JALAN" id="suratjalan-cetak" data-id="' . $item->suratjalan_id . '"><span class="material-icons btn-sm">print</span></button>';

                    return $btn;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }
        return view('operasional.data-suratjalan', compact('suratjalans', 'alat', 'proyek'));
    }

    // CEK KUOTA ALAT
    public function checkKuotaAlat(Request $request)
    {
        $alat = Alat::find($request->alat);

        if ($alat && $request->jml) {
            if ($alat->alat_jml >= $request->jml) {
                $alert = 'true';
            } else {
                $alert = 'false';
            }
            //return response
            return response()->json([
                'success'       => $alert,
                'alat_id'       => $alat->alat_id,
                'alat_nama'     => $alat->alat_nama,
                'alat_jenis'    => $alat->alat_jenis,
                'alat_jml'      => $request->jml,
                'message'       => 'Your data has been saved successfully!',
            ]);
        } else {
            $alert = 'null';
            //return response
            return response()->json([
                'success'   => $alert,
                'message'   => 'Your data has been saved successfully!',
            ]);
        }
    }

    // SURAT JALAN STORED DATA
    public function suratJalanStore(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'proyek_id'                     => 'required',
            'suratjalan_tgl'                => 'required',
            'suratjalan_driver'             => 'required',
            'suratjalan_pengirim'           => 'required',
            'suratjalan_pengawaslapangan'   => 'required',
            'suratjalan_platno'             => 'required',
            'suratjalan_jenis'              => 'required',
            'alat_id.*'                     => 'required',
            'alat_jml.*'                    => 'required',
        ], [
            'proyek_id.required'                        => 'Proyek Harus di Isi!',
            'suratjalan_tgl.required'                   => 'Tanggal Harus di Isi!',
            'suratjalan_driver.required'                => 'Driver Harus di Isi!',
            'suratjalan_pengirim.required'              => 'Nama Pengirim Harus di Isi!',
            'suratjalan_pengawaslapangan.required'      => 'Pengawas Lapangan Harus di Isi!',
            'suratjalan_platno.required'                => 'Plat No Harus di Isi!',
            'suratjalan_jenis.required'                 => 'Jenis Harus di Isi!',
            'alat_id.*.required'                        => 'Alat Harus di Isi!',
            'alat_jml.*.required'                       => 'Alat Jumlah Harus di Isi!',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        // insert data to table surat jalan 
        $suratjalan = SuratJalan::updateOrCreate([
            'suratjalan_id' => $request->suratjalan_id
        ], [
            'proyek_id'                         => $request->proyek_id,
            'suratjalan_tgl'                    => $request->suratjalan_tgl,
            'suratjalan_pengirim'               => $request->suratjalan_pengirim,
            'suratjalan_driver'                 => $request->suratjalan_driver,
            'suratjalan_pengawaslapangan'       => $request->suratjalan_pengawaslapangan,
            'suratjalan_platno'                 => $request->suratjalan_platno,
            'suratjalan_jenis'                  => $request->suratjalan_jenis,
            'suratjalan_ket'                    => $request->suratjalan_ket ?? '-',
            'suratjalan_jmlalat'                => array_sum($request->alat_jml),
        ]);

        // Initialize an array to store original alat_jml values
        $originalAlatJml = [];

        // Insert into detail surat jalan
        for ($i = 0; $i < count($request->alat_id); $i++) {

            // Store the original alat_jml value
            $originalAlatJml[] = $request->alat_jml[$i];

            $detailsuratjalan = SuratJalanDetail::updateOrCreate(
                [
                    'suratjalan_id' => $suratjalan->suratjalan_id,
                    'alat_id'       => $request->alat_id[$i],
                ],
                [
                    'alat_id'       => $request->alat_id[$i],
                    'alat_jml'      => $request->alat_jml[$i] ?? 0,
                    'alat_jenis'    => $request->alat_jenis[$i] ?? '-',
                    'alat_platno'   => $request->alat_platno[$i] ?? '-',
                ]
            );

            // Retrieve the corresponding alat record
            $alat = Alat::find($request->alat_id[$i]);

            // Decrement alat_jml
            if ($alat) {
                if(!$request->suratjalan_edit == 'edit'){
                    $alat->decrement('alat_jml', $request->alat_jml[$i] ?? 0);
                }
            }

            // Collect alat_id values to update
            $alatIdsToUpdate[] = $request->alat_id[$i];
        }

        // Retrieve the alat_ids to delete
        $alatIdsToDelete = SuratJalanDetail::where('suratjalan_id', $suratjalan->suratjalan_id)
            ->whereNotIn('alat_id', $alatIdsToUpdate)
            ->pluck('alat_id');

        // Increment alat_jml for the deleted records
        foreach ($alatIdsToDelete as $alatId) {

            // Retrieve the corresponding alat record
            $alat = Alat::find($alatId);
            
            // Increment alat_jml by the original value
            if ($alat) {
                $incrementValue = $originalAlatJml ?? 0;
                $alat->update(['alat_jml', $incrementValue]);
            }
        }

        // Delete records that are not in the updated data
        SuratJalanDetail::where('suratjalan_id', $suratjalan->suratjalan_id)
            ->whereNotIn('alat_id', $alatIdsToUpdate)
            ->delete();

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Your data has been saved successfully!',
        ]);
    }

    // SURAT JALAN EDIT DATA
    public function suratJalanEdit(Request $request)
    {
        $suratjalan = SuratJalan::with(['proyek', 'detailsurat.alat'])->where('suratjalan_id', $request->suratjalan_id)->first();
        return response()->json($suratjalan);
    }

    // SURAT JALAN DELETE DATA
    public function suratJalanDestroy(Request $request)
    {
        $proyek = Proyek::find($request->proyek_id);

        if ($proyek->status == 'selesai') {
            $proyek->update([
                'status'    => 'on-progress',
            ]);
        } else {
            $proyek->update([
                'status'    => 'selesai',
            ]);
        }

        return response()->json(['status' => 'Data Saved Successfully!']);
    }

    public function suratjalanCetak(Request $request)
    {
        $data = $request->query('data');
        $dataArray = json_decode($data, true);

        $suratjalan = SuratJalan::with(['proyek', 'detailsurat.alat'])->where('suratjalan_id', $dataArray[0])->first();

        $filename = 'Laporan Detail Return Penjualan-';
        $formatPaper = 'Potrait';

        // Load the HTML view with the data
        $html = view('operasional.suratjalan', ['data' => $suratjalan])->render();

        // Create Dompdf instance
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true); // Enable HTML5 parser
        $options->set('isPhpEnabled', true); // Enable PHP
        $options->set('isHtml5ParserEnabled', true); // Enable HTML5 parser
        $options->set('isPhpEnabled', true); // Enable PHP
        $options->set('isHtml5ParserEnabled', true); // Enable HTML5 parser
        $options->set('isPhpEnabled', true); // Enable PHP

        $options->set('isHtml5ParserEnabled', true); // Enable HTML5 parser
        $options->set('isPhpEnabled', true); // Enable PHP
        $options->set('isHtml5ParserEnabled', true); // Enable HTML5 parser
        $options->set('isPhpEnabled', true); // Enable PHP
        $options->set('isHtml5ParserEnabled', true); // Enable HTML5 parser
        $options->set('isPhpEnabled', true); // Enable PHP
        $options->set('isHtml5ParserEnabled', true); // Enable HTML5 parser
        $options->set('isPhpEnabled', true); // Enable PHP

        // Set the option to enable remote fetching
        $options->set('isHtml5ParserEnabled', true);

        // Create a new Dompdf instance with the options
        $dompdf = new Dompdf($options);

        // Load the HTML into Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Set paper size and orientation
        $dompdf->setPaper('A4', $formatPaper);

        // Render the HTML as PDF
        $dompdf->render();

        // Get the PDF content as a string
        $pdfContent = $dompdf->output();

        // Return the PDF content with appropriate headers
        return response($pdfContent)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="suratjalan.pdf"');
    }

    // INDEX PENGEMBALIAN SURAT JALAN
    public function pengembalianIndex(Request $request)
    {
        $suratjalans   = SuratJalan::where('status', 'on-progress')->get();
        $alat          = Alat::where('status', 'aktif')->get();
        $proyek        = Proyek::all();

        if ($request->ajax()) {
            $suratjalans      =   SuratJalan::where('status', 'on-progress')->get();
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

                    $btn = $btn . '<button class="btn btn-icon btn-danger btn-rounded flush-soft-hover me-1" title="UPDATE STATUS SURAT JALAN" id="suratjalan-delete" data-id="' . $item->suratjalan_id . '"><span class="material-icons btn-sm">visibility_off</span></button>';

                    return $btn;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }
        return view('operasional.data-pengembalian', compact('suratjalans', 'alat', 'proyek'));
    }

    // PENGEMBALIAN SURAT JALAN DELETE DATA
    public function pengembalianDestroy(Request $request)
    {
        $suratjalan = SuratJalan::with(['proyek', 'detailsurat.alat'])->where('suratjalan_id', $request->suratjalan_id)->first();

        // Assuming $suratjalan is not null and detailsurat relationship is loaded
        foreach ($suratjalan->detailsurat as $detail) {
            $alat = Alat::find($detail->alat_id);

            if ($alat) {
                // Update alat_jml based on your logic
                $alat->increment('alat_jml', $detail->alat_jml);
            }
        }

        // Update the status in SuratJalan
        $suratjalan->update([
            'status' => $suratjalan->status == 'selesai' ? 'on-progress' : 'selesai',
        ]);

        return response()->json(['status' => 'Data Saved Successfully!']);
    }
}
