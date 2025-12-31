<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function list()
    {
        return datatables(User::select(['id', 'name', 'email', 'created_at']))
            ->addColumn('action', function ($user) {
                return '
                    <button class="btn btn-sm btn-primary editUser" data-id="'.$user->id.'">
                        Edit
                    </button>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function show(User $user)
    {
        return response()->json($user);
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id),
            ],
        ]);

        $user->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'User updated successfully',
        ]);
    }
}
