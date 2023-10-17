<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'nip' => 'required|string|min:4|max:4|unique:users',
            'dept_id' => 'required|integer',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        if ($data['dept_id'] == 1) {

            $newUser = User::create([
                'name' => $data['name'],
                'nip' => $data['nip'],
                'role_id' => 1,
                'dept_id' => $data['dept_id'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            $newUser->permissions()->attach([1, 2, 3, 4, 5, 6, 7]);

        } elseif ($data['dept_id'] == 2) {

            $newUser = User::create([
                'name' => $data['name'],
                'nip' => $data['nip'],
                'role_id' => 2,
                'dept_id' => $data['dept_id'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            $newUser->permissions()->attach([1, 2, 3, 4, 5, 6, 7]);

        } else {
            $newUser = User::create([
                'name' => $data['name'],
                'nip' => $data['nip'],
                'role_id' => 3,
                'dept_id' => $data['dept_id'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            $newUser->permissions()->attach([6, 7]);
        }

        session()->flash('success', 'Registrasi Anda Berhasil! Selamat Datang');

        return $newUser;
    }
}
