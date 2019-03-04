<?php
/**
 * Created by PhpStorm.
 * User: imokhles
 * Date: 2019-03-01
 * Time: 18:41
 */

namespace App\Traits;


use App\Models\Review;

trait CanUseCommentsTrait
{

    /**
     * @param $package
     * @param string $commentText
     * @param int $rate
     * @return $this
     */
    public function comment($package, $commentText = '', $rate = 0)
    {
        $comment = new Review([
            'author_id'        => $this->id,
            'author_type' => get_class($this),
            'package_id'     => $package->id,
            'package_type' => get_class($package),
            'package_version' => $package->Version,
            'comment'        => $commentText,
            'rate'           => ($package->getCanBeRated()) ? $rate : null,
            'approved'       => ($package->mustBeApproved() && ! $this->isAdmin()) ? false : true,
        ]);
        $package->comments()->save($comment);
        return $this;
    }

    /**
     * @param $commentObject
     * @param string $commentText
     * @return $this
     */
    public function replyComment($commentObject, $commentText = '') {

        $parentComment = Review::whereId($commentObject->id)->first();
        $comment = new Review([
            'author_id'         => $this->id,
            'author_type'       => get_class($this),
            'package_id'        => $parentComment->package_id,
            'package_type'      => get_class($parentComment->package),
            'package_version'   => $parentComment->package->Version,
            'comment'           => $commentText,
            'rate'              => null,
            'approved'          => true,
            'parent_id'         => $parentComment->id
        ]);
        $parentComment->package->comments()->save($comment);
        return $this;
    }

    /**
     * @return bool
     */
    public function isAdmin()
    {
        return false;
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function comments()
    {
        return $this->morphMany(Review::class, 'user');
    }
}