<?php
/**
 * Created by PhpStorm.
 * User: imokhles
 * Date: 2019-02-25
 * Time: 13:37
 */
return [
    // Settings configuration file
    // you can customize the disk name where you need save image ( if you use image field type )
    // and customize other configurations needed by the package
    'images_disk_name'      => 'uploads', // disk where images will be saved
    'images_folder'         => 'images', // folder where images will be saved inside it in the specified disk
    'image_upload_enabled'  => true, // set to true to allow uploading, false to disable
    'image_crop_enabled'    => true, // set to true to allow cropping, false to disable
    'image_aspect_ratio'    => 1, // ommit or set to 0 to allow any aspect ratio
    'image_prefix'          => 'uploads/',  // in case you only store the filename in the database, this text will be prepended to the database value
];