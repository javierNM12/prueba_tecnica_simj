<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\saveCorrect;
use Illuminate\Support\Facades\Notification;
class Users extends Controller
{
    public function list()
    {
        $user = new User();
        $users_list = $user->list();

        $data = [
            'users'             => $users_list,
            'pagintaionEnabled' => true,
        ];
        \Illuminate\Support\Facades\Log::debug(print_r('users', true));
        \Illuminate\Support\Facades\Log::debug(print_r($users_list->toArray(), true));

        // return view('list');
        return view('list', $data);
    }

    public function delete_user($id) {
        $user = new User();
        return $user->deleteUser($id);
    }

    public function create_user(Request $request) {
        \Illuminate\Support\Facades\Log::debug(print_r('create_user', true));
        // return json_encode(false); // force error
        $user = new User();
        $response = $user->createUser($request->name, $request->email, $request->password, $request->admin);

        return json_encode($response);
    }

    public function is_email_in_use(Request $request) {
        return User::isEmailInUse($request->email, $request->id);
    }

    public function edit_user(Request $request) {
        \Illuminate\Support\Facades\Log::debug(print_r('edit_user', true));
        // return json_encode(false); // force error
        $user = new User();
        $response = $user->editUser($request->id, $request->name, $request->email, $request->password, $request->admin);

        return json_encode($response);
    }
}
