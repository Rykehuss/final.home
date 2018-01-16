<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Subscriber;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubscriberPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the subscriber.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Subscriber  $subscriber
     * @return mixed
     */
    public function view(User $user, Subscriber $subscriber)
    {
        return $user->id === $subscriber->updated_by;
    }

    /**
     * Determine whether the user can create subscribers.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the subscriber.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Subscriber  $subscriber
     * @return mixed
     */
    public function update(User $user, Subscriber $subscriber)
    {
        return $user->id === $subscriber->updated_by;
    }

    /**
     * Determine whether the user can delete the subscriber.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Subscriber  $subscriber
     * @return mixed
     */
    public function delete(User $user, Subscriber $subscriber)
    {
        return $user->id === $subscriber->updated_by;
    }
}
