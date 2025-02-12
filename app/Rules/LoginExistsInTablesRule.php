<?php

namespace App\Rules;

use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Validation\ValidationRule;

class LoginExistsInTablesRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $exists = DB::table('users')
                    ->where('phoNum', $value)
                    ->orWhere('email', $value)
                    ->exists()
                ||
                DB::table('admins')
                    ->where('phoNum', $value)
                    ->orWhere('email', $value)
                    ->exists();

        if (!$exists) {
            $fail(__('The email or phone number is not registered in any account.'));
        }
    }
}
