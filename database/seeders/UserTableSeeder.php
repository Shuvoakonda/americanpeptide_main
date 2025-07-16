<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'thisiskazi@gmail.com',
            'phone' => '01795560431',
            'address' => 'Dhaka',
            'city' => 'Dhaka',
            'state' => 'Dhaka',
            'zip' => '1200',
            'country' => 'Bangladesh',
            'role_id' => 1,
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Customer',
            'email' => 'customer@gmail.com',
            'phone' => '01795560431',
            'address' => 'Dhaka',
            'city' => 'Dhaka',
            'state' => 'Dhaka',
            'zip' => '1200',
            'country' => 'Bangladesh',
            'role_id' => 2,
            'password' =>Hash::make('password'),
        ]);

        User::create([
            'name' => 'Wholesaler',
            'email' => 'wholesaler@gmail.com',
            'phone' => '01795560431',
            'address' => 'Dhaka',
            'password' => Hash::make('password'),
            'city' => 'Dhaka',
            'state' => 'Dhaka',
            'zip' => '1200',
            'country' => 'Bangladesh',
            'role_id' => 2,
            'is_wholesaler' => true,
            'details' => [
                'company_name'=>"Sohojware",
                'company_address'=>"Barisal",
                'company_city'=>"Barisal",
                'company_state'=>"Barisal",
                'company_zip'=>"1200",
                'company_country'=>"Bangladesh",
                'company_phone'=>"01795560431",
                'company_email'=>"sohojware@gmail.com",
                'company_website'=>"https://www.sohojware.com",
                'company_logo'=>"https://sohojware.com/assets/logo.png",
                'company_description'=>"Sohojware is a company that sells products to customers.",
            ],
       
        ]);
    
    }
}
