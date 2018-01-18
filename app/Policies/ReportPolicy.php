<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Report;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReportPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the campaign.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Report  $report
     * @return mixed
     */
    public function view(User $user, Report $report)
    {
        return $user->id === $report->updated_by;
    }
}
