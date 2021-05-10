<?php namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function list()
    {
        $users = User::paginate();

        return view('users.index', [
            'users' => $users
        ]);
    }

    public function delete(Request $request)
    {
        $user = User::find($request->id);

        if($user !== null) {
            $user->delete();
        }
    }
}
