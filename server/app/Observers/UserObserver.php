<?php

namespace App\Observers;

use App\Enums\AccountStatus;
use App\Enums\Role;
use App\Models\Account;
use App\Models\User;

class UserObserver
{
    /**
     * Handle the User "creating" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function creating(User $user)
    {
        $account = Account::create([
            'role' => Role::member,
            'status' => AccountStatus::not_verified,
        ]);
        $user->account_id = $account->id;
    }
}
