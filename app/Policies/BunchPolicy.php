<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Bunch;
use Illuminate\Auth\Access\HandlesAuthorization;

class BunchPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the bunch.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Bunch  $bunch
     * @return mixed
     */
    public function view(User $user, Bunch $bunch)
    {
        return $user->id === $bunch->updated_by;
    }

    /**
     * Determine whether the user can create bunches.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the bunch.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Bunch  $bunch
     * @return mixed
     */
    public function update(User $user, Bunch $bunch)
    {
        return $user->id === $bunch->updated_by;
    }

    /**
     * Determine whether the user can delete the bunch.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Bunch  $bunch
     * @return mixed
     */
    public function delete(User $user, Bunch $bunch)
    {
        return $user->id === $bunch->updated_by;
    }
}
