<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){
        $data['sidebar'] = 'user';
        $data['user'] = User::all();
        return view('admin.pages.user.index',$data);
    }
    public function tambah()
    {
        $data['sidebar'] = 'user';
        return view('admin.pages.user.tambah',$data);
    }
    public function edit($id)
    {
        $data['sidebar'] = 'user';
        $data['user'] = User::where('id',$id)->first();
        return view('admin.pages.user.edit',$data);
    }
    public function tambah_data(){
        request()->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $data = [
            'name' => request()->name,
            'email' => request()->email,
            'password' => Hash::make(request()->password),
            'level' => request()->level,
        ];

        User::create($data);

        return redirect()->to('/admin/user')->with('success','Data user telah di tambahkan');
    }
    public function edit_data($id){
        request()->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $data = [
            'name' => request()->name,
            'email' => request()->email,
            'password' => Hash::make(request()->password),
            'level' => request()->level,
        ];

        User::where('id',$id)->update($data);

        return redirect()->to('/admin/user')->with('update','Data user telah di ubah');
    }
    public function delete($id){

        User::where('id',$id)->delete();

        return redirect()->to('/admin/user')->with('delete','Data user telah di hapus');
    }
}
