<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = DB::table('users')
            ->when($request->input('name'), function($query, $name){
                return $query->where('name', 'like', '%' . $name . '%');
            })
                ->paginate(5);
        return view('pages.user.index', compact('users'));
    }

    public function create()
    {
        return view('pages.user.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['password'] = Hash::make($request->input('password'));
        User::create($data);

        return redirect()->route('user.index')->with('success', 'User Berhasil di buat!');
    }

    public function show($id)
    {
        return view('pages.dashbiard');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('pages.user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $user = User::findOrFail($id);

        // check password if not empty
        if($request->input('password')) {
            $data['password'] = Hash::make($request->input('password'));
        }else{
            $data['password'] = $user->password;
        }
        $user->update($data);
        return redirect()->route('user.index')->with('success', 'User Berhasil di Edit!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('user.index')->with('success', 'User Berhasil di Hapus!');
    }
}
