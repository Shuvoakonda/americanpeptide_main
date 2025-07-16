<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WholeSalerController extends Controller
{
    public function showWholesalerRegistrationForm()
    {
        return view('auth.wholesaler');
    }

    public function registerWholesaler(Request $request)
    {
        $request->validate([
            'first_name'     => 'required|string|max:255',
            'last_name'      => 'required|string|max:255',
            'email'          => 'required|string|email|max:255|unique:users',
            'password'       => 'required|string|min:8|confirmed',
            'company_name'   => 'required|string|max:255',
            'contact_number' => 'required|string|max:255',
            'tax_id'         => 'required|string|max:255',
            'website'        => 'nullable|url',
        ]);
        $user = User::create([
            'name'          => $request->first_name . ' ' . $request->last_name,
            'email'         => $request->email,
            'role_id'       => 2,
            'password'      => bcrypt($request->password),
            'is_wholesaler' => false, // pending approval
            'details'       => [
                'company_name'   => $request->company_name,
                'contact_number' => $request->contact_number,
                'tax_id'         => $request->tax_id,
                'website'        => $request->website,
            ],
        ]);

        Auth::login($user); // login user

        // Send email to admin
        // $adminEmail = config('mail.admin_email', 'admin@yourdomain.com');
        // Mail::to($adminEmail)->send(new NewWholesalerRegistration($user));

        return redirect()->route('dashboard')->with('success', 'Your wholesaler request has been submitted. You will receive access after admin approval.');
    }

}
