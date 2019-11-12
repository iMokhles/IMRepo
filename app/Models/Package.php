<?php

namespace App\Models;

use App\Traits\CommentAbleTrait;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Package extends Model implements HasMedia
{
    use HasMediaTrait;
    use CrudTrait;
    use CommentAbleTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'packages';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $guarded = ['id'];
    protected $fillable = [
        'user_id',
        'Package',
        'Source',
        'Version',
        'Priority',
        'Section',
        'Architecture',
        'Essential',
        'Maintainer',
        'Pre-Depends',
        'Depends',
        'Recommends',
        'Suggests',
        'Conflicts',
        'Enhances',
        'Breaks',
        'Filename',
        'Size',
        'Installed-Size',
        'Description',
        'Homepage',
        'Website',
        'Depiction',
        'Icon',
        'MD5sum',
        'SHA1',
        'SHA256',
        'Origin',
        'Bugs',
        'Name',
        'Author',
        'Sponsor',
        'package_hash',
        'is_paid'
    ];
    // protected $hidden = [];
    protected $dates = ['created_at', 'updated_at'];

    // Review
    protected   $mustBeApproved = true;
    protected   $canBeRated = true;

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public static function boot()
    {
        parent::boot();
        static::deleting(function($obj) {
            \Storage::disk('storage')->delete($obj->Filename);
        });
    }

    /**
     * @param Media|null $media
     * @throws \Spatie\Image\Exceptions\InvalidManipulation
     */
    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
            ->width(130)
            ->height(230);
    }
    /**
     * @param Request $request
     * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded
     * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\InvalidBase64Data
     */
    public function uploadImage(Request $request) {
        $this->addMediaFromBase64($request->input("image"))->toMediaCollection('media', 'screenshots_disk');
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /**
     * Return author of this package
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    /**
     * Return packages's review list
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reviews()
    {
        return $this->hasMany(Review::class, 'package_id');
    }
    /**
     * Return packages's change logs list
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function changeLogs()
    {
        return $this->hasMany(ChangeLog::class, 'package_id');
    }
    /**
     * Return packages's downloads
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function downloads()
    {
        return $this->hasMany(Download::class, 'package_id');
    }
    /**
     * Return packages's depiction
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function depiction()
    {
        return $this->hasOne(Depiction::class, 'package_id');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */

    /**
     * Handle file upload and DB storage for a file:
     * - on CREATE
     *     - stores the file at the destination path
     *     - generates a name
     *     - stores the full path in the DB;
     * - on UPDATE
     *     - if the value is null, deletes the file and sets null in the DB
     *     - if the value is different, stores the different file and updates DB value.
     *
     * @param  [type] $value            Value for that column sent from the input.
     * @param  [type] $attribute_name   Model attribute name (and column in the db).
     * @param  [type] $disk             Filesystem disk used to store files.
     * @param  [type] $prefix           Add string before the value and save to database
     * @param  [type] $destination_path Path in disk where to store the files.
     */
    public function uploadFileToDisk($value, $attribute_name, $disk, $prefix, $destination_path)
    {
        $request = \Request::instance();

        // if a new file is uploaded, delete the file from the disk
        if ($request->hasFile($attribute_name) &&
            $this->{$attribute_name} &&
            $this->{$attribute_name} != null) {
            \Storage::disk($disk)->delete($this->{$attribute_name});
            $this->attributes[$attribute_name] = null;
        }

        // if the file input is empty, delete the file from the disk
        if (is_null($value) && $this->{$attribute_name} != null) {
            \Storage::disk($disk)->delete($this->{$attribute_name});
            $this->attributes[$attribute_name] = null;
        }

        // if a new file is uploaded, store it on disk and its filename in the database
        if ($request->hasFile($attribute_name) && $request->file($attribute_name)->isValid()) {
            // 1. Generate a new file name
            $file = $request->file($attribute_name);
            $new_file_name = md5($file->getClientOriginalName().time()).'.'.$file->getClientOriginalExtension();

            // 2. Move the new file to the correct path
            $file_path = $file->storeAs($destination_path, $new_file_name, $disk);

            // 3. Save the complete path to the database
            $this->attributes[$attribute_name] = $prefix.$file_path;
        }
    }

    public function setFilenameAttribute($value)
    {
        $attribute_name = "Filename";
        $disk = "debs_disk";

        $this->uploadFileToDisk($value, $attribute_name, $disk, 'debs/', '');
    }

}
