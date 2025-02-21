<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AddAlpNumberToUsersSeeder extends Seeder
{
    public function run()
    {
        // Loop through all users without an ALP number
        User::whereNull('alp_number')->each(function ($user) {
            do {
                // Generate a 4-digit unique random number
                $alpNumber = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
            } while (User::where('alp_number', $alpNumber)->exists());

            // Assign the generated number
            $user->alp_number = $alpNumber;
            $user->save();
        });

        $this->command->info('ALP numbers generated for all users without one.');
    }
}
