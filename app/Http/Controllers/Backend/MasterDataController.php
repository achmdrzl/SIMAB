<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use App\Models\ControlAlat;
use App\Models\Proyek;
use App\Models\SuratJalan;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class MasterDataController extends Controller
{
    // INDEX DASHBOARD
    public function index()
    {
        $proyek = Proyek::count();
        $proyekSelesai = Proyek::where('status', 'selesai')->count();

        $suratjalan = SuratJalan::count();
        $suratjalanKembali = SuratJalan::where('status', 'selesai')->count();

        return view('dashboard', compact('proyek', 'proyekSelesai', 'suratjalan', 'suratjalanKembali'));
    }

    // INDEX USER
    public function userIndex(Request $request)
    {
        $users   =   User::all();
        if ($request->ajax()) {
            $users   =   User::all();
            return DataTables::of($users)
                ->addIndexColumn()
                ->addColumn('name', function ($item) {
                    return ucfirst($item->name);
                })
                ->addColumn('email', function ($item) {
                    return $item->email;
                })
                ->addColumn('role', function ($item) {
                    if ($item->role == 'user') {
                        return ucfirst('kasir');
                    } else {
                        return ucfirst($item->role);
                    }
                })
                ->addColumn('phone_number', function ($item) {
                    return $item->phone_number;
                })
                ->addColumn('status', function ($item) {
                    if ($item->status == 'aktif') {
                        $status = '<div class="badge badge-success">Aktif</div>';
                    } else {
                        $status = '<div class="badge badge-danger">Non-Aktif</div>';
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

                    $btn = '<button class="btn btn-icon btn-primary btn-rounded flush-soft-hover me-1" id="user-edit" data-id="' . $item->user_id . '"><span class="material-icons btn-sm">edit</span></button>';

                    $btn = $btn . '<button class="btn btn-icon btn-' . $class . ' btn-rounded flush-soft-hover me-1" id="user-delete" data-id="' . $item->user_id . '"><span class="material-icons btn-sm">' . $icon . '</span></button>';

                    return $btn;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }
        return view('masterdata.data-user', compact('users'));
    }

    // USER STORED DATA
    public function userStore(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            // 'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'email' => 'required|email',
            'role' => 'required',
            'phone_number' => 'required',
            'password' => 'required|min:8',
            'password_confirmation' => 'required_with:password|same:password'
        ], [
            'name.required' => 'Name Harus di Isi!',
            'email.required' => 'Email Harus di Isi!',
            'phone_number.required' => 'Phone Number Harus di Isi!',
            'role.required' => 'Position Harus di Isi',
            'password' => 'Password Harus minimal 8 Karakter',
            'password_confirmation' => 'Password Confirmation Harus minimal 8 Karakter',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        // insert data to table user 
        $user = User::updateOrCreate([
            'user_id' => $request->user_id
        ], [
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        $user->syncRoles($request->role);

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Your data has been saved successfully!',
        ]);
    }

    // USER EDIT DATA
    public function userEdit(Request $request)
    {
        $user = User::where('user_id', $request->user_id)->first();
        return response()->json($user);
    }

    // USER DELETE DATA
    public function userDestroy(Request $request)
    {
        $user = User::find($request->user_id);

        if ($user->status == 'aktif') {
            $user->update([
                'status'    => 'non-aktif',
            ]);
        } else {
            $user->update([
                'status'    => 'aktif',
            ]);
        }

        return response()->json(['status' => 'Data Deleted Successfully!']);
    }

    // INDEX ALAT
    public function alatIndex(Request $request)
    {
        $alats   =   Alat::all();
        if ($request->ajax()) {
            $alats      =   Alat::all();
            return DataTables::of($alats)
                ->addIndexColumn()
                ->addColumn('alat_kode', function ($item) {
                    return ucfirst($item->alat_kode);
                })
                ->addColumn('alat_nama', function ($item) {
                    return ucfirst($item->alat_nama);
                })
                ->addColumn('alat_kondisi', function ($item) {
                    return $item->alat_kondisi;
                })
                ->addColumn('alat_jumlah', function ($item) {
                    return $item->alat_jumlah . 'bh';
                })
                ->addColumn('alat_jenis', function ($item) {
                    return ucfirst($item->alat_jenis);
                })
                ->addColumn('status', function ($item) {
                    if ($item->status == 'aktif') {
                        $status = '<div class="badge badge-success">Aktif</div>';
                    } else {
                        $status = '<div class="badge badge-danger">Non-Aktif</div>';
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

                    $btn = '<button class="btn btn-icon btn-primary btn-rounded flush-soft-hover me-1" id="alat-edit" data-id="' . $item->alat_id . '"><span class="material-icons btn-sm">edit</span></button>';

                    $btn = $btn . '<button class="btn btn-icon btn-' . $class . ' btn-rounded flush-soft-hover me-1" id="alat-delete" data-id="' . $item->alat_id . '"><span class="material-icons btn-sm">' . $icon . '</span></button>';

                    return $btn;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }
        return view('masterdata.data-alat', compact('alats'));
    }

    // ALAT STORED DATA
    public function alatStore(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'alat_nama'     => 'required',
            'alat_kondisi'  => 'required',
            'alat_jml'      => 'required',
            'alat_jenis'    => 'required',
        ], [
            'alat_nama.required'        => 'Nama Alat Harus di Isi!',
            'alat_kondisi.required'     => 'Alat Kondisi Harus di Isi!',
            'alat_jml.required'         => 'Jumlah Alat Harus di Isi!',
            'alat_jenis.required'       => 'Alat Jenis Harus di Isi!',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $randomInteger = rand(100, 999); // Generate a random integer between 100 and 999

        $alat_kode = 'ALT-' . $randomInteger;

        // insert data to table alat 
        $alat = Alat::updateOrCreate([
            'alat_id' => $request->alat_id
        ], [
            'alat_kode'     => $alat_kode,
            'alat_nama'     => $request->alat_nama,
            'alat_kondisi'  => $request->alat_kondisi,
            'alat_jml'      => $request->alat_jml,
            'alat_jenis'    => $request->alat_jenis,
        ]);

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Your data has been saved successfully!',
        ]);
    }

    // ALAT EDIT DATA
    public function alatEdit(Request $request)
    {
        $alat = Alat::with(['suratdetail.surat.proyek'])->where('alat_id', $request->alat_id)->first();
        return response()->json($alat);
    }

    // ALAT DELETE DATA
    public function alatDestroy(Request $request)
    {
        $alat = Alat::find($request->alat_id);

        if ($alat->status == 'aktif') {
            $alat->update([
                'status'    => 'non-aktif',
            ]);
        } else {
            $alat->update([
                'status'    => 'aktif',
            ]);
        }

        return response()->json(['status' => 'Data Saved Successfully!']);
    }


    // INDEX CONTROL ALAT
    public function controlAlatIndex(Request $request)
    {
        $alats   = ControlAlat::with(['alat'])->where('alat_jml', '!=', 0)->get();
        if ($request->ajax()) {
            $alats      = ControlAlat::with(['alat'])->where('alat_jml', '!=', 0)->get();
            return DataTables::of($alats)
                ->addIndexColumn()
                ->addColumn('alat_nama', function ($item) {
                    return ucfirst($item->alat->alat_nama);
                })
                ->addColumn('alat_kondisi', function ($item) {
                    return ucwords($item->alat_kondisi);
                })
                ->addColumn('alat_jumlah', function ($item) {
                    return $item->alat_jml . 'bh';
                })
                ->addColumn('action', function ($item) {

                    if ($item->status == 'aktif') {
                        $class = 'danger';
                        $icon = 'visibility_off';
                    } else {
                        $class = 'success';
                        $icon = 'visibility';
                    }

                    $btn = '<button class="btn btn-icon btn-primary btn-rounded flush-soft-hover me-1" id="alat-edit" data-id="' . $item->alat_id . '"><span class="material-icons btn-sm">edit</span></button>';

                    return $btn;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }
        return view('masterdata.control-alat', compact('alats'));
    }

    // ALAT STORED DATA
    public function controlAlatStore(Request $request)
    {
        
        //define validation rules
        $validator = Validator::make($request->all(), [
            'alat_jml_baik'      => 'required',
        ], [
            'alat_jml_baik.required'         => 'Jumlah Alat Harus di Isi!',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $controlAlat = ControlAlat::where('alat_id', $request->alat_id)->first();

        if ($controlAlat) {
            // Update alat_jml based on your logic
            $controlAlat->decrement('alat_jml', $request->alat_jml_baik);
        }

        $alat = Alat::find($request->alat_id);

        if ($alat) {
            // Update alat_jml based on your logic
            $alat->increment('alat_jml', $request->alat_jml_baik);
        }

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Your data has been saved successfully!',
        ]);
    }

    // ALAT EDIT DATA
    public function controlAlatEdit(Request $request)
    {
        $alat = ControlAlat::with(['alat'])->where('alat_id', $request->alat_id)->first();
        return response()->json($alat);
    }
}
