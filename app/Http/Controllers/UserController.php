<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\ResetUserPassword;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
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
        if (
            $request->input('password') !== '' &&
            $request->input('password') !== null &&
            $request->input('password') !== ' ' &&
            $request->input('password') !== $user->password
        ) {
            (new ResetUserPassword)->reset($this->model, ['password' => $request->input('password'), 'password_confirmation' => $request->input('password')]);
        }

        $dataWithoutPassword = Arr::except($request->all(), ['password', 'password_confirmation']);

        $user->update($dataWithoutPassword);

        return redirect()->route('user.index');
    }
}
