<?php

namespace App\Models;

use App\Traits\CanUseCommentsTrait;
use App\User;
use Backpack\Base\app\Notifications\ResetPasswordNotification as ResetPasswordNotification;
use Backpack\CRUD\CrudTrait;
use Spatie\Permission\Traits\HasRoles;
use Tightenco\Parental\HasParentModel;

class BackpackUser extends User
{
    use CrudTrait;
    use HasParentModel;
    use HasRoles;
    use CanUseCommentsTrait;

    protected $table = 'users';

    /**
     * Send the password reset notification.
     *
     * @param string $token
     *
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * Get the e-mail address where password reset links are sent.
     *
     * @return string
     */
    public function getEmailForPasswordReset()
    {
        return $this->email;
    }

    public function isAdmin()
    {
        return true;
    }
}
