<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Despesa;

class DespesaPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function view(User $user, Despesa $despesa)
    {
        return $user->id === $despesa->user_id;
    }

    public function update(User $user, Despesa $despesa)
    {
        return $user->id === $despesa->user_id;
    }

    public function delete(User $user, Despesa $despesa)
    {
        return $user->id === $despesa->user_id;
    }
}
