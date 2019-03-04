<?php
/**
 * Created by PhpStorm.
 * User: imokhles
 * Date: 2019-02-25
 * Time: 13:41
 */

namespace App\Models;


use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Prologue\Alerts\Facades\Alert;
/**
 * Class Setting.
 */
class Setting extends Model
{
    use CrudTrait;
    protected $table = 'settings';
    protected $fillable = ['name', 'key', 'value', 'field', 'description', 'active'];
    /**
     * Model Boot function
     * Need it to delete image file from disk if the field type == image.
     */
    public static function boot()
    {
        parent::boot();
        static::deleting(function ($obj) {
            // 1. get field type
            $type = $obj->field;
            // 2. check if it's image
            if ($type == 'image') {
                // 3. delete from disk
                if (!Storage::disk(config('backpack.settings.images_disk_name'))->delete($obj->value)) {
                    // filed to delete image file
                    Alert::error(trans('backpack::settings.delete_image_file_not_message'))->flash();
                }
            }
        });
    }
    /**
     * set field json to database.
     *
     * @param $field
     */
    public function setFieldAttribute($field)
    {
        $fieldJson = [];
        $fieldJson['name'] = 'value';
        $fieldJson['label'] = 'Value';
        $fieldJson['type'] = $field;
        $this->attributes['field'] = json_encode($fieldJson);
    }
    /**
     * get the correct type value for select2_from_array.
     *
     * @param $field
     *
     * @return string
     */
    public function getFieldAttribute($field)
    {
        $fieldDecoded = json_decode($field, true);
        return $fieldDecoded['type'];
    }
    /**
     * set the correct value and check if image field.
     *
     * @param $value
     */
    public function setValueAttribute($value)
    {
        // get item id
        $id = $this->id;
        // get setting object from database
        $setting = DB::table($this->table)->where('id', $id)->first();
        // decode field object
        $fieldDecoded = json_decode($setting->field, true);
        // get field type
        $type = $fieldDecoded['type'];
        // column attribute name
        $attribute_name = 'value';
        // get images disk
        $disk = config('backpack.settings.images_disk_name');
        // get destination folder
        $destination_path = config('backpack.settings.images_folder');
        switch ($type) {
            case 'image':
                // if the image was erased
                if (is_null($value)) {
                    // delete the image from disk
                    if (Storage::disk($disk)->delete($this->{$attribute_name})) {
                        // set null in the database after the successful delete
                        $this->attributes[$attribute_name] = null;
                    }
                }
                // if a base64 was sent, store it in the db
                if (starts_with($value, 'data:image')) {
                    // 0. Get image extension
                    preg_match("/^data:image\/(.*);base64/i", $value, $match);
                    $extension = $match[1];
                    // 1. Make the image
                    $image = Image::make($value);
                    if (!is_null($image)) {
                        // 2. Generate a filename.
                        $filename = md5($value.time()).'.'.$extension;
                        try {
                            // 3. Store the image on disk.
                            Storage::disk($disk)->put($destination_path.'/'.$filename, $image->stream());
                            // 4. Save the path to the database
                            $this->attributes[$attribute_name] = $destination_path.'/'.$filename;
                        } catch (\InvalidArgumentException $argumentException) {
                            // 3. failed to save file
                            Alert::error($argumentException->getMessage())->flash();
                            // 4. set as null when fail to save the image to disk
                            $this->attributes[$attribute_name] = null;
                        }
                    }
                }
                break;
            default:
                $this->attributes[$attribute_name] = $value;
                break;
        }
    }
    /**
     * get the correct value and check fields types
     * and return the correct tags.
     *
     * @return mixed
     */
    public function getValueFunction()
    {
        $attribute_name = 'value';
        // get item id
        $id = $this->id;
        // get setting object from database
        $setting = DB::table($this->table)->where('id', $id)->first();
        // decode field object
        $fieldDecoded = json_decode($setting->field, true);
        // get field type
        $type = $fieldDecoded['type'];
        // check value set
        if (!isset($setting->{$attribute_name})) {
            return false;
        }
        // get value
        $value = $setting->{$attribute_name};
        switch ($type) {
            case 'text':
                return str_limit(strip_tags($value), 80, '[...]');
                break;
            case 'url':
                return '<a href="'.$value.'">'.$value.'</a>';
                break;
            case 'email':
                return '<a href="mailto:'.$value.'" target="_top">'.$value.'</a>';
                break;
            case 'checkbox':
                if ($value == 1) {
                    // if true return success label with YES string
                    $html = '<span class="label label-success">YES</span>';
                } else {
                    // if false return danger label with NO string
                    $html = '<span class="label label-danger">NO</span>';
                }
                return $html;
                break;
            case 'image':
                return '<a href="'.url(config('backpack.settings.image_prefix').$value).'"><img class="img-circle" width="70px" height="70px" src="'.url('/uploads/'.$value).'" alt="User Avatar"></a>';
                break;
            case 'password':
                return '<a class="btn btn-default"><i class="fa fa-key"></i></a>';
                break;
            case 'number':
                return $value;
                break;
            case 'icon_picker':
                return '<a class="btn btn-default"><i class="fa '.$value.'"></i></a>';
                break;
            default:
                return $type;
                break;
        }
    }
}