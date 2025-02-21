<?php
namespace App\Observers;

use App\Models\User;

class UserObserver
{
    public function creating(User $user)
    {
        // Generate a unique 4-digit ALP number
        $user->alp_number = $this->generateUniqueAlpNumber();
    }

    private function generateUniqueAlpNumber()
    {
        do {
            $alpNumber = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
        } while (User::where('alp_number', $alpNumber)->exists());

        return $alpNumber;
    }
}
