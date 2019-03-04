<?php

namespace App\Http\Controllers\Admin;

use App\Enums\DepictionDevices;
use App\Enums\DepictionVersions;
use App\Models\Depiction;
use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\DepictionRequest as StoreRequest;
use App\Http\Requests\DepictionRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;
use Illuminate\Support\Facades\DB;

/**
 * Class DepictionCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class DepictionCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Depiction');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/depictions');
        $this->crud->setEntityNameStrings('depiction', 'depictions');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        // TODO: remove setFromDb() and manually define Fields and Columns
        $this->crud->setFromDb();
        $this->crud->removeAllFields('update/create');
        $this->crud->addFields([
            [
                'label' => "Package",
                'type' => 'select2',
                'name' => 'package_id', // the db column for the foreign key
                'entity' => 'package', // the method that defines the relationship in your Model
                'attribute' => 'Name', // foreign key attribute that is shown to user
                'model' => "App\Models\Package", // foreign key model
            ],
            [ // select_from_array
                'name' => 'mini_ios',
                'label' => "Mini iOS",
                'type' => 'select2_from_array',
                'options' => DepictionVersions::toSelectArray(),
                'allows_null' => false,
                'default' => DepictionVersions::IOS_9,
            ],
            [ // select_from_array
                'name' => 'max_ios',
                'label' => "Max iOS",
                'type' => 'select2_from_array',
                'options' => DepictionVersions::toSelectArray(),
                'allows_null' => false,
                'default' => DepictionVersions::IOS_12_1,
            ],
            [ // select_from_array
                'name' => 'devices_support',
                'label' => "Devices Support",
                'type' => 'select2_from_array',
                'options' => DepictionDevices::toSelectArray(),
                'allows_null' => false,
                'default' => DepictionDevices::ALL,
            ],
            [   // WYSIWYG Editor
                'name' => 'long_description',
                'label' => 'Long Description',
                'type' => 'wysiwyg'
            ],
            [   // WYSIWYG Editor
                'name' => 'price',
                'label' => 'Price',
                'type' => 'text'
            ],
        ],'create/update');
        $this->crud->addField([   // Upload
            'name' => 'screenshots_preview',
            'label' => 'Screenshots',
            'type' => 'view',
            'view' => 'admin/admin_screenshots' // if you store files in the /public folder, please ommit this; if you store them in /storage or S3, please specify it;
        ],'update');
        $this->crud->addField([   // Upload
            'name' => 'screenshots',
            'label' => 'Upload Screenshots',
            'type' => 'upload_multiple',
            'upload' => true,
            'disk' => 'screenshots_disk' // if you store files in the /public folder, please ommit this; if you store them in /storage or S3, please specify it;
        ],'update/create');

        // add asterisk for fields that are required in DepictionRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');
    }

    public function store(StoreRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::storeCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
//        dd($request->screenshots);
        $request->request->remove('screenshots_preview');
        if (count($request->screenshots) == 0 ||
            (count($request->screenshots) == 1 && is_null($request->screenshots[0]))) {
            $request->request->remove('screenshots');
        }
        // your additional operations before save here
        $redirect_location = parent::updateCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry

        if (count($request->screenshots) > 0) {
            $depiction = Depiction::whereId($this->crud->entry->id)->first();
            $depiction->uploadScreenshots($request->screenshots);
        }

        return $redirect_location;
    }

    public function deleteScreenshot($id) {



        $deleted = DB::table('media')->where('id',$id)->delete();
        if ($deleted) {
            $removed = \Storage::disk('screenshots_disk')->deleteDirectory($id);
            if ($removed) {
                \Alert::success(trans('backpack::crud.screenshot_deleted'))->flash();
            }
            return back();
        }
    }
}
