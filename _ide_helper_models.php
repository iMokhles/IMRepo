<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App{
/**
 * App\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Download
 *
 * @property int $id
 * @property int $package_id
 * @property int|null $user_id
 * @property int|null $device_id
 * @property string|null $package_version
 * @property string|null $package_hash
 * @property string|null $package_identifier
 * @property string|null $type
 * @property array|null $ip_addresses
 * @property int $count
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\User|null $author
 * @property-read \App\Models\Device|null $device
 * @property-read \App\Models\Package $package
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Download newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Download newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Download query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Download whereCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Download whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Download whereDeviceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Download whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Download whereIpAddresses($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Download wherePackageHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Download wherePackageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Download wherePackageIdentifier($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Download wherePackageVersion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Download whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Download whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Download whereUserId($value)
 */
	class Download extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Package
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $Package
 * @property string|null $Source
 * @property string|null $Version
 * @property string|null $Priority
 * @property string|null $Section
 * @property string|null $Architecture
 * @property string|null $Essential
 * @property string|null $Maintainer
 * @property string|null $Pre-Depends
 * @property string|null $Depends
 * @property string|null $Recommends
 * @property string|null $Suggests
 * @property string|null $Conflicts
 * @property string|null $Enhances
 * @property string|null $Breaks
 * @property string|null $Filename
 * @property int|null $Size
 * @property int|null $Installed-Size
 * @property string|null $Description
 * @property string|null $Homepage
 * @property string|null $Website
 * @property string|null $Depiction
 * @property string|null $Icon
 * @property string|null $MD5sum
 * @property string|null $SHA1
 * @property string|null $SHA256
 * @property string|null $Origin
 * @property string|null $Bugs
 * @property string|null $Name
 * @property string|null $Author
 * @property string|null $Sponsor
 * @property string $package_hash
 * @property int $is_paid
 * @property int $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\User $author
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ChangeLog[] $changeLogs
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Review[] $comments
 * @property-read \App\Models\Depiction $depiction
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Download[] $downloads
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\MediaLibrary\Models\Media[] $media
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Review[] $reviews
 * @property-write mixed $filename
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereArchitecture($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereAuthor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereBreaks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereBugs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereConflicts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereDepends($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereDepiction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereEnhances($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereEssential($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereFilename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereHomepage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereInstalledSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereIsPaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereMD5sum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereMaintainer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereOrigin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package wherePackage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package wherePackageHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package wherePreDepends($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereRecommends($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereSHA1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereSHA256($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereSection($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereSource($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereSponsor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereSuggests($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereVersion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereWebsite($value)
 */
	class Package extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Review
 *
 * @property int $id
 * @property string $package_type
 * @property int $package_id
 * @property string $author_type
 * @property int $author_id
 * @property string $package_version
 * @property string $comment
 * @property int|null $parent_id
 * @property bool $approved
 * @property float|null $rate
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $author
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $package
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Review newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Review newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Review query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Review whereApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Review whereAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Review whereAuthorType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Review whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Review whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Review whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Review wherePackageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Review wherePackageType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Review wherePackageVersion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Review whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Review whereRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Review whereUpdatedAt($value)
 */
	class Review extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Depiction
 *
 * @property int $id
 * @property int $package_id
 * @property string|null $long_description
 * @property string $mini_ios
 * @property string $max_ios
 * @property string|null $price
 * @property string $devices_support
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\MediaLibrary\Models\Media[] $media
 * @property-read \App\Models\Package $package
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Depiction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Depiction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Depiction query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Depiction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Depiction whereDevicesSupport($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Depiction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Depiction whereLongDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Depiction whereMaxIos($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Depiction whereMiniIos($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Depiction wherePackageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Depiction wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Depiction whereUpdatedAt($value)
 */
	class Depiction extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\BackpackUser
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Review[] $comments
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BackpackUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BackpackUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BackpackUser permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BackpackUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BackpackUser role($roles)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BackpackUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BackpackUser whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BackpackUser whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BackpackUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BackpackUser whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BackpackUser wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BackpackUser whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BackpackUser whereUpdatedAt($value)
 */
	class BackpackUser extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Customer
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $linked_social
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\LinkedSocial[] $linkedSocials
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Customer currentLinkedSocial($identifiers)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Customer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Customer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Customer otherCurrentStatus($identifiers)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Customer query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Customer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Customer whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Customer whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Customer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Customer whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Customer wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Customer whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Customer whereUpdatedAt($value)
 */
	class Customer extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\LinkedSocial
 *
 * @property int $id
 * @property string $provider_id
 * @property string $provider
 * @property string $model_type
 * @property int $model_id
 * @property string|null $token
 * @property string|null $refresh_token
 * @property string|null $token_secret
 * @property string|null $expires_in
 * @property string|null $nickname
 * @property string|null $name
 * @property string|null $email
 * @property string|null $avatar
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $model
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LinkedSocial newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LinkedSocial newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LinkedSocial query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LinkedSocial whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LinkedSocial whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LinkedSocial whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LinkedSocial whereExpiresIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LinkedSocial whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LinkedSocial whereModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LinkedSocial whereModelType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LinkedSocial whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LinkedSocial whereNickname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LinkedSocial whereProvider($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LinkedSocial whereProviderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LinkedSocial whereRefreshToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LinkedSocial whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LinkedSocial whereTokenSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LinkedSocial whereUpdatedAt($value)
 */
	class LinkedSocial extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Device
 *
 * @property int $id
 * @property int|null $customer_id
 * @property string|null $udid
 * @property string|null $version
 * @property string|null $model
 * @property string|null $model_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Customer|null $author
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Download[] $downloads
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Device newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Device newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Device query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Device whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Device whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Device whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Device whereModel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Device whereModelName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Device whereUdid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Device whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Device whereVersion($value)
 */
	class Device extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Setting.
 *
 * @property int $id
 * @property string $key
 * @property string $name
 * @property string|null $description
 * @property string|null $value
 * @property string $field
 * @property int $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting whereField($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting whereValue($value)
 */
	class Setting extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ChangeLog
 *
 * @property int $id
 * @property int $package_id
 * @property int|null $user_id
 * @property array|null $changes
 * @property string|null $package_version
 * @property string|null $package_hash
 * @property string|null $package_identifier
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\User|null $author
 * @property-read \App\Models\Package $package
 * @property-read \App\Models\Package $packageVersion
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ChangeLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ChangeLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ChangeLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ChangeLog whereChanges($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ChangeLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ChangeLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ChangeLog wherePackageHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ChangeLog wherePackageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ChangeLog wherePackageIdentifier($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ChangeLog wherePackageVersion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ChangeLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ChangeLog whereUserId($value)
 */
	class ChangeLog extends \Eloquent {}
}

