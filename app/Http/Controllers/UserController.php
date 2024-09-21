<?php

namespace App\Http\Controllers;

use App\Models\PoliceRank;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $title = "Pengguna";
        $description = "Detail Pengguna";
        $users = User::orderBy('created_at', 'desc')->get();

        return view('admin.users.index', compact('title', 'users', 'description'));
    }

    public function create()
    {
        $title = "Tambah Pengguna";
        $role = Role::all();
        $policeRank = PoliceRank::all();
        $view = view('admin.users.create', compact('title', 'role','policeRank'));
        $view = $view->render();
        return $view;
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'email' => 'required|string|email|max:255',
            'nrp' => [
                'required',
                function ($attribute, $value, $fail) {
                    if ($value !== null && (strlen($value) !== 8 && strlen($value) !== 18)) {
                        $fail($attribute . ' must be either 8 or 18 characters.');
                    }
                },
            ],

            'password' => 'required|string|max:100|min:5',
            'jenis_kelamin' => 'required|string|max:20',
            'phone' => 'nullable|string|max:20',
            'role' => 'required|max:10',
            'police_rank_id' => 'required|max:10'
        ]);

        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return redirect()->back();
        }

        $userExists = User::where('nrp', $request->nrp)->exists();

        if ($userExists) {
            Alert::toast('NRP/NIP sudah terdaftar', 'error');
            return redirect()->back()->withErrors('NRP/NIP sudah terdaftar');
        }

        $userExistsByEmail = User::where('email', $request->email)->exists();

        if ($userExistsByEmail) {
            Alert::toast('Email Sudah Digunakan.', 'error');
            return redirect('/admin/users/create')->withErrors('Email Sudah Digunakan.');
        }

        $input = [
            'name' => $request->name,
            'nrp' => $request->nrp,
            'email' => $request->email,
            'phone' => $request->phone,
            'role_id' => $request->role,
            'jenis_kelamin' => $request->jenis_kelamin,
            'police_rank_id' => $request->police_rank_id,
            'password' => Hash::make($request->password),
            'email_verified_at' => now(),
        ];

        $file = $request->file('avatar');
        if ($file) {
            $filename = time() . '.' . $request->file('avatar')->getClientOriginalExtension();
            Storage::putFileAs('public/images', $file, $filename);
            $input['avatar'] = $filename;
        }

        User::create($input);

        Alert::toast('User Berhasil Ditambah', 'success');
        return redirect('/admin/users')->with('status', 'User Berhasil Ditambah');
    }


    public function edit(Request $request, $userId)
    {

        $id = crypt::decrypt($userId);
        $user = User::findOrFail($id);
        $title = "Edit Pengguna";
        $role = Role::all();
        $policeRank = PoliceRank::all();
        $view = view('admin.users.edit', compact('title', 'role', 'user','policeRank'));
        $view = $view->render();
        return $view;
    }

    public function update(Request $request, $userId)
    {
        $id = Crypt::decrypt($userId);
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'email' => 'string|email|max:255',
            'nrp' => [
                'string',
                function ($attribute, $value, $fail) {
                    if ($value !== null && (strlen($value) !== 8 && strlen($value) !== 18)) {
                        $fail($attribute . ' must be either 8 or 18 characters.');
                    }
                },
            ],

            'jenis_kelamin' => 'string|max:100',
            'phone' => 'string|max:20',
            'role' => 'required|max:10',
            'police_rank_id' => 'required|max:10'
        ]);

        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return redirect()->back()
                ->withInput();
        }

        if ($request->nrp) {
            $userExisting = User::where('nrp', $request->nrp)->first();

            if ($userExisting && $userExisting->id != $user->id) {
                Alert::toast('NRP sudah terdaftar', 'error');
                return redirect()->back()
                    ->withErrors('NRP sudah terdaftar');
            }
        }

        $input = [
            'name' => $request->name,
            'nrp' => $request->nrp,
            'jenis_kelamin' => $request->jenis_kelamin,
            'email' => $request->email,
            'phone' => $request->phone,
            'role_id' => $request->role,
            'police_rank_id' => $request->police_rank_id,
        ];

        try {

            $file = $request->file('avatar');
            if ($file) {
                $filename = time() . '.' . $request->file('avatar')->getClientOriginalExtension();
                Storage::putFileAs('public/images', $file, $filename);
                $input['avatar'] = $filename;
            }
        } catch (\Exception $e) {

            Alert::toast('Failed to upload image. Please try again.', 'error');
            return redirect()->back()
                ->withErrors('Failed to upload image. Please try again.')
                ->withInput();
        }

        $user->update($input);
        Alert::toast('User Berhasil Di Ubah', 'success');

        return redirect('/admin/users')->with('status', 'User Berhasil Di Ubah');
    }


    public function editProfile(Request $request, $userId)
    {
        $id = crypt::decrypt($userId);
        $user = User::findOrFail($id);
        $title = "Edit Pengguna";
        $role = Role::all();
        $view = view('admin.users.profile', compact('title', 'role', 'user'));
        $view = $view->render();
        return $view;
    }

    public function updateProfile(Request $request, $userId)
    {
        $id = Crypt::decrypt($userId);
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'email' => 'nullable|string|email|max:255',
            'nrp' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    if ($value !== null && (strlen($value) !== 8 && strlen($value) !== 18)) {
                        $fail($attribute . ' must be either 8 or 18 characters.');
                    }
                },
            ],

            'phone' => 'nullable|string|max:20',
        ]);
        if ($request->nrp) {
            $userExisting = User::where('nrp', $request->nrp)->first();

            if ($userExisting && $userExisting->id != $user->id) {
                Alert::toast('NRP/NIP sudah terdaftar', 'error');
                return redirect()->back()
                    ->withErrors('NRP/NIP sudah terdaftar');
            }
        }


        if ($request->currentPassword) {
            if (!Hash::check($request->currentPassword, $user->password)) {
                Alert::toast('Password Sebelumnya Salah', 'error');
                return redirect()->back()
                    ->withErrors('Password Sebelumnya Salah');
            } else {
                $validator->sometimes('password', 'required|string|min:5|max:100|confirmed', function ($input) {
                    return $input->password !== null;
                });
            }
        }


        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return redirect()->back();
        }
        $input = [
            'name' => $request->name,
            'nrp' => $request->nrp,
            'email' => $request->email,
            'phone' => $request->phone,
        ];

        if ($request->password) {
            $input['password'] = Hash::make($request->password);
        }

        if ($user->email !== $request->email) {
            $userExists = User::where('email', $request->email)->where('id', '!=', $id)->exists();
            if ($userExists) {
                Alert::toast('Email Sudah Digunakan', 'error');
                return redirect()->back()
                    ->withErrors('Email Sudah Digunakan.');
            }
        }

        $file = $request->file('avatar');
        if ($file) {
            $filename = time() . '.' . $request->file('avatar')->getClientOriginalExtension();
            Storage::putFileAs('public/images', $file, $filename);
            $input['avatar'] = $filename;
        }

        $user->update($input);
        Alert::toast('Profil Berhasil Di Ubah', 'success');
        return redirect()->back()->with('status', 'Profil Berhasil Di Ubah');
    }
    
    public function destroy(Request $request)
    {
        $userId = Crypt::decrypt($request->id);
        $user = User::findOrFail($userId);
        $user->delete();
        Alert::toast('user Berhasil Dihapus', 'success');
        return redirect('/admin/users')->with('status', 'user Berhasil Dihapus');
    }
    
    public function resetPassword(Request $request, $userId)
    {
        $validator = Validator::make($request->all(), [
            'resetPassword' => 'required|string|min:5|max:100',
        ]);
        
        if ($validator->fails()) {
            return redirect('/admin/users/edit')->withErrors($validator)->withErrors('Gagal reset password');
        }
        $user = User::findOrFail($userId);
        $user->password = Hash::make($request->resetPassword);
        $user->save();
        
        Alert::toast('Password Berhasil Di Reset', 'success');
        return redirect()->back()->with('status', 'Password Berhasil Di Reset');
    }
}
