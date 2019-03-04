<?php
/**
 * Created by PhpStorm.
 * User: imokhles
 * Date: 15/11/2018
 * Time: 02:50
 */

namespace App\Events;


use App\Models\LinkedSocial;
use Illuminate\Database\Eloquent\Model;

class LinkedSocialUpdated
{
    /** @var LinkedSocial|null */
    public $oldLinkedSocial;
    /** @var LinkedSocial */
    public $newLinkedSocial;
    /** @var \Illuminate\Database\Eloquent\Model */
    public $model;
    public function __construct(?LinkedSocial $oldLinkedSocial, LinkedSocial $newLinkedSocial, Model $model)
    {
        $this->oldLinkedSocial = $oldLinkedSocial;
        $this->newLinkedSocial = $newLinkedSocial;
        $this->model = $model;
    }
}