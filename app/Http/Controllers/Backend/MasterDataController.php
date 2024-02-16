<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use App\Models\Barang;
use App\Models\Kadar;
use App\Models\Merk;
use App\Models\ModelBarang;
use App\Models\Pabrik;
use App\Models\Supplier;
use App\Models\TransaksiHutang;
use App\Models\TransaksiInOut;
use App\Models\User;
use DateTime;
use Illuminate\Console\View\Components\Alert;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\Rules;
use PDO;
use Termwind\Components\Dd;

class MasterDataController extends Controller
{
    // INDEX DASHBOARD
    public function index()
    {
        return view('dashboard');
    }

    // INDEX USER
    public function userIndex(Request $request)
    {
        if ($request->ajax()) {
            $users   =   User::where('status', 'aktif')->get();
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
                    if($item->status == 'aktif'){
                        $status = '<div class="bagde bg-success">Aktif</div>';
                    }else{
                        $status = '<div class="bagde bg-danger">Non-Aktif</div>';
                    }
                    return $status;
                })
                ->addColumn('action', function ($item) {

                    $btn = '<button class="btn btn-icon btn-primary btn-rounded flush-soft-hover me-1" id="user-edit" data-id="' . $item->user_id . '"><span class="material-icons btn-sm">edit</span></button>';

                    $btn = $btn . '<button class="btn btn-icon btn-danger btn-rounded flush-soft-hover me-1" id="user-delete" data-id="' . $item->user_id . '"><span class="material-icons btn-sm">visibility_off</span></button>';

                    return $btn;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }
        return view('masterdata.data-user');
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
            'name.required' => 'Name Must Be Included!',
            'email.required' => 'Email Must Be Included!',
            'phone_number.required' => 'Phone Number Must Be Included!',
            'role.required' => 'Position Must Be Included',
            'password' => 'Password Must be at least 8 Characters',
            'password_confirmation' => 'Password Confirmation Must be at least 8 Characters',
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
        $user = User::find($request->user_id)->delete();

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
                ->addColumn('action', function ($item) {

                    $btn = '<button class="btn btn-icon btn-primary btn-rounded flush-soft-hover me-1" id="user-edit" data-id="' . $item->user_id . '"><span class="material-icons btn-sm">edit</span></button>';

                    $btn = $btn . '<button class="btn btn-icon btn-danger btn-rounded flush-soft-hover me-1" id="user-delete" data-id="' . $item->user_id . '"><span class="material-icons btn-sm">visibility_off</span></button>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('masterdata.data-user', compact('users'));
    }

    // ALAT STORED DATA
    public function alatStore(Request $request)
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
            'name.required' => 'Name Must Be Included!',
            'email.required' => 'Email Must Be Included!',
            'phone_number.required' => 'Phone Number Must Be Included!',
            'role.required' => 'Position Must Be Included',
            'password' => 'Password Must be at least 8 Characters',
            'password_confirmation' => 'Password Confirmation Must be at least 8 Characters',
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

    // ALAT EDIT DATA
    public function alatEdit(Request $request)
    {
        $user = User::where('user_id', $request->user_id)->first();
        return response()->json($user);
    }

    // ALAT DELETE DATA
    public function alatDestroy(Request $request)
    {
        $user = User::find($request->user_id)->delete();

        return response()->json(['status' => 'Data Deleted Successfully!']);
    }

}
