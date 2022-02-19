<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::all();

        return view('user.index', compact('users'));
    }

    public function store(Request $request, CreatesNewUsers $createsNewUsers)
    {
        $input = array_merge($request->input(), [
            'password_confirmation' => $request->input('password'),
            'terms' => 'accepted',
        ]);
        
        $user = $createsNewUsers->create($input);

        $request->session()->flash('user.name', $user->name . ' added');

        return redirect()->route('user.index');
    }

    public function create(Request $request)
    {
        return view('user.create');
    }

    public function edit(Request $request, User $user)
    {
        return view('user.edit', compact('user'));
    }

    public function destroy(Request $request, User $user)
    {
        $user->delete();

        return redirect()->route('user.index');
    }

    public function update(Request $request, User $user)
    {
        $user->update($request->all());

        return redirect()->route('user.index');
    }
}
