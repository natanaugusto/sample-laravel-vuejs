<?php

namespace Tests;

use App\User;
use Laravel\Passport\Passport;

trait PassportActingAsTrait
{
    /**
     * Create the passport way to request
     *
     * @param string $role
     * @return void
     */
    private function passportActingAs(string $role = null)
    {
        $user = factory(User::class)->create();
        if(!empty($role)) {
            $user->assignRole('admin');
        }
        Passport::actingAs($user, ['*']);
    }
}