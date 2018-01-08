<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Template;
use Illuminate\Auth\Access\HandlesAuthorization;

class TemplatePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the template.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Template  $template
     * @return mixed
     */
    public function view(User $user, Template $template)
    {
        return $user->id === $template->updated_by;
    }

    /**
     * Determine whether the user can create templates.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the template.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Template  $template
     * @return mixed
     */
    public function update(User $user, Template $template)
    {
        return $user->id === $template->updated_by;
    }

    /**
     * Determine whether the user can delete the template.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Template  $template
     * @return mixed
     */
    public function delete(User $user, Template $template)
    {
        return $user->id === $template->updated_by;
    }
}
