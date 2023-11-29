<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'first_name' => 'Johar',
                'last_name' => 'Yousuf',
                'email' => 'joharshakilyousuf@gmail.com',
                'username' => 'johar.yousuf100',
                'type' => 3,
                'group_id' => 2
            ],
            // Social Networking
            ['first_name' => "Alexandre", 'last_name' => "Figueiredo", 'email' => "figueiredo@icloud.com", 'type' => 3, 'group_id' => 2],
            ['first_name' => "André", 'last_name' => "Grilo", 'email' => "gril95@gmail.com", 'type' => 3, 'group_id' => 2],
            ['first_name' => "Rabia", 'last_name' => "Mehmood", 'email' => "rabiamahmood@yahoo.com", 'type' => 3, 'group_id' => 2],
            ['first_name' => "Agnes", 'last_name' => "Flora", 'email' => "agnesflora@mailchimp.com", 'type' => 3, 'group_id' => 2],
            ['first_name' => "Julia", 'last_name' => "Albert", 'email' => "julia1996@gmail.com", 'type' => 3, 'group_id' => 2],
            ['first_name' => "Diogo", 'last_name' => "Borges", 'email' => "diogoborges56@hotmail.com", 'type' => 3, 'group_id' => 2],
            ['first_name' => "Hassan", 'last_name' => "Jamil", 'email' => "hasanjam@yahoo.com", 'type' => 3, 'group_id' => 2],
            ['first_name' => "Muhammad", 'last_name' => "Asif", 'email' => "asifmuhammad@gmail.com", 'type' => 3, 'group_id' => 2],

            // Networking
            ['first_name' => "James", 'last_name' => "Smith", 'email' => "JamesSmith@gmail.com", 'type' => 3, 'group_id' => 3],
            ['first_name' => "Christopher", 'last_name' => "Anderson", 'email' => "ChristopherAnderson@gmail.com", 'type' => 3, 'group_id' => 3],
            ['first_name' => "Ronald", 'last_name' => "Clark", 'email' => "ronaldclark@gmail.com", 'type' => 3, 'group_id' => 3],
            ['first_name' => "Lisa", 'last_name' => "Mitchell", 'email' => "lisamitchell@gmail.com", 'type' => 3, 'group_id' => 3],
            ['first_name' => "Anthony", 'last_name' => "Lopez", 'email' => "anthonylopez@gmail.com", 'type' => 3, 'group_id' => 3],
            ['first_name' => "Nancy", 'last_name' => "Borges", 'email' => "nancywilliams@hotmail.com", 'type' => 3, 'group_id' => 3],

            // Digital Marketing
            ['first_name' => "Betty", 'last_name' => "Walker", 'email' => "bettywalker@aol.com", 'type' => 3, 'group_id' => 4],
            ['first_name' => "Helen", 'last_name' => "Adams", 'email' => "helenadams@aol.com", 'type' => 3, 'group_id' => 4],
            ['first_name' => "Pedro", 'last_name' => "Clark", 'email' => "pedroclark@gmail.com", 'type' => 3, 'group_id' => 4],
            ['first_name' => "Meriam", 'last_name' => "Kassab", 'email' => "mariamkassab@gmail.com", 'type' => 3, 'group_id' => 4],
            ['first_name' => "Ruth", 'last_name' => "Lopez", 'email' => "ruthlopez@gmail.com", 'type' => 3, 'group_id' => 4],
            ['first_name' => "Thomas", 'last_name' => "Robinson", 'email' => "thomasrobinson@gmail.com", 'type' => 3, 'group_id' => 4],
            ['first_name' => "Ricardo", 'last_name' => "Rito", 'email' => "ricardorito@hotmail.com", 'type' => 3, 'group_id' => 4],
            ['first_name' => "Rawad", 'last_name' => "Tawk", 'email' => "rawadtawk1988@icloud.com", 'type' => 3, 'group_id' => 4],

            // Data Analytics
            ['first_name' => "Robert", 'last_name' => "Lewis", 'email' => "robertlewis@gmail.com", 'type' => 3, 'group_id' => 5],
            ['first_name' => "Christopher", 'last_name' => "Anderson", 'email' => "ChristopherAnderson@gmail.com", 'type' => 3, 'group_id' => 5],
            ['first_name' => "Ronald", 'last_name' => "Clark", 'email' => "ronaldclark@gmail.com", 'type' => 3, 'group_id' => 5],
            ['first_name' => "Sarah", 'last_name' => "Lee", 'email' => "lisamitchell@gmail.com", 'type' => 3, 'group_id' => 5],
            ['first_name' => "Anthony", 'last_name' => "Lopez", 'email' => "anthonylopez@gmail.com", 'type' => 3, 'group_id' => 5],
            ['first_name' => "Nancy", 'last_name' => "Borges", 'email' => "nancywilliams@hotmail.com", 'type' => 3, 'group_id' => 5],
        ];

        foreach ($users as $user_data) {
            $user = null;
            $email_found = \App\Models\User::where('email', $user_data['email'])->first();
            if (!$email_found) {
                do {
                    $username = strtolower($user_data['first_name'] . '.' . $user_data['last_name']) . '.' . mt_rand(111, 999);
                    $user = \App\Models\User::where('username', $username)->first();
                } while ($user);

                $user = \App\Models\User::create([
                    'last_name' => $user_data['last_name'],
                    'first_name' => $user_data['first_name'],
                    'username' => $username,
                    'email' => $user_data['email'],
                    'password' => Hash::make('P@s$w0rD'),
                ]);
            } else {
                $user = $email_found;
            }

            $user->groups()->attach($user_data['group_id']);
        }
    }
}
