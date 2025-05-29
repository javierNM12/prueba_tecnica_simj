<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'admin'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function list() {
        return self::get();
    }

    public function createUser($name, $email, $password, $admin) {
        try{
            $user = new User();

            $user->name = $name;
            $user->email = $email;
            $user->password = Hash::make($password);
            $user->admin = (bool) $admin;

            return $user->saveOrFail();
        } catch(\Illuminate\Database\QueryException $e) {
            \Illuminate\Support\Facades\Log::debug(print_r('Create user error:', true));
            \Illuminate\Support\Facades\Log::debug(print_r($e->getMessage(), true));
        }
    }

    public static function isEmailInUse($email, $id) {
        return self::where('email', $email)
        ->where('id', '!=', $id)
        ->exists();
    }

    public function deleteUser($id) {
        try{
            return User::where('id', $id)->delete();
        } catch(\Illuminate\Database\QueryException $e) {
            \Illuminate\Support\Facades\Log::debug(print_r('Delete user error:', true));
            \Illuminate\Support\Facades\Log::debug(print_r($e->getMessage(), true));
        }
    }

    public function editUser($id, $name, $email, $password, $admin) {
        try{
            $user = User::where('id', $id)->first();

            $user->name = $name;
            $user->email = $email;
            $user->password = Hash::make($password);
            $user->admin = (bool) $admin;

            return $user->saveOrFail();
        } catch(\Illuminate\Database\QueryException $e) {
            \Illuminate\Support\Facades\Log::debug(print_r('Edit user error:', true));
            \Illuminate\Support\Facades\Log::debug(print_r($e->getMessage(), true));
        }
    }
}
