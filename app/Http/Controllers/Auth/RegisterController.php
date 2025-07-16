<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Mail\WelcomeEmail;
use Illuminate\Support\Facades\Mail;

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
    protected $redirectTo = '/dashboard';

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
        $rules = [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'terms' => ['accepted'],
        ];
        if (!empty($data['is_wholesaler'])) {
            $rules = array_merge($rules, [
                'company_name' => ['required', 'string', 'max:255'],
                'business_type' => ['required', 'string', 'max:255'],
                'tax_id' => ['required', 'string', 'max:255'],
                'business_address' => ['required', 'string', 'max:255'],
                'business_phone' => ['required', 'string', 'max:255'],
                'contact_person_name' => ['required', 'string', 'max:255'],
                'contact_person_email' => ['required', 'string', 'email', 'max:255'],
            ]);
        }
        return Validator::make($data, $rules);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $isWholesaler = !empty($data['is_wholesaler']);
        $details = null;
        if ($isWholesaler) {
            $details = [
                'company_name' => $data['company_name'] ?? null,
                'business_type' => $data['business_type'] ?? null,
                'tax_id' => $data['tax_id'] ?? null,
                'business_address' => $data['business_address'] ?? null,
                'business_phone' => $data['business_phone'] ?? null,
                'website' => $data['website'] ?? null,
                'contact_person_name' => $data['contact_person_name'] ?? null,
                'contact_person_email' => $data['contact_person_email'] ?? null,
                'reseller_permit' => $data['reseller_permit'] ?? null,
                'years_in_business' => $data['years_in_business'] ?? null,
                'business_description' => $data['business_description'] ?? null,
            ];
        }
        $user = User::create([
            'name' => trim(($data['first_name'] ?? '') . ' ' . ($data['last_name'] ?? '')),
            'email' => $data['email'],
            'role_id' => 2,
            'is_wholesaler' => $isWholesaler,
            'details' => $details ? json_encode($details) : null,
            'password' => \Illuminate\Support\Facades\Hash::make($data['password']),
        ]);
        // Send welcome email
        \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\WelcomeEmail($user));
        return $user;
    }
}
