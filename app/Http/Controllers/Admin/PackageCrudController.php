<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PackageSection;
use App\Helpers\IMPackageHelper;
use App\Models\ChangeLog;
use App\Models\Depiction;
use App\Models\Package;
use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\PackageRequest as StoreRequest;
use App\Http\Requests\PackageRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;

/**
 * Class PackageCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class PackageCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Package');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/packages');
        $this->crud->setEntityNameStrings('package', 'packages');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        // TODO: remove setFromDb() and manually define Fields and Columns
        $this->crud->setFromDb();
        $this->crud->removeAllFields();
        $this->crud->addField([
            'name' => 'Filename',
            'label' => 'Deb',
            'type' => 'upload',
            'upload' => true,
            'disk' => 'debs_disk',
            'attributes' => [
                'accept' => '.deb',
            ],
        ], 'create');
        $this->crud->addFields([
            [
                'name' => 'Author',
                'label' => 'Author',
                'type' => 'text',
            ],
            [
                'name' => 'Icon',
                'label' => 'Icon',
                'type' => 'image',
                'upload' => true,
            ],
            [
                'name' => 'Section',
                'label' => "Section",
                'type' => 'select2_from_array',
                'options' => PackageSection::toSelectArray(),
                'allows_null' => false,
                'default' => PackageSection::Tweaks,
            ],
            [
                'name' => 'Version',
                'label' => 'Version',
                'type' => 'text',
            ],
            [
                'name' => 'Depends',
                'label' => 'Depends',
                'type' => 'text',
            ],
            [
                'name' => 'Conflicts',
                'label' => 'Conflicts',
                'type' => 'text',
            ],
        ], 'update');

        // add asterisk for fields that are required in PackageRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');
    }

    public function store(StoreRequest $request)
    {
        // your additional operations before save here
        $request->request->set('user_id', backpack_user()->id);

        $redirect_location = parent::storeCrud($request);

        $package = Package::whereId($this->crud->entry->id)->first();
        $packageInfo = IMPackageHelper::GetPkgInfo(storage_path($package->Filename));

        \Log::info(print_r($packageInfo, true));
        $this->saveDebInfoInDatabase($packageInfo, $package);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::updateCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    /**
     * @param $control_info
     * @param $package Package
     * @return bool
     */
    public function saveDebInfoInDatabase($control_info, $package) {
        $deb_version = $control_info['Version'];
        $deb_identifier = $control_info['Package'];
        $isExist = Package::where([
            'Package' => $deb_identifier,
            'Version' => $deb_version
        ])->exists();
        if ($isExist) {
            return false;
        } else {
            $updated = Package::find($package->id)->update($control_info);
            if ($updated) {
                $this->createDepiction($control_info);
            }
            return $updated;
        }
    }

//    public function saveChangeLog($package_info) {
//        $isExist = Package::where([
//            'Package' => $package_info['Package'],
//        ])->first();
//        $isChangeLogExist = ChangeLog::where([
//            'package_identifier' => $package_info['Package'],
//        ])->first();
//        $text = "";
//        if (!is_null($isExist) && !is_null($isChangeLogExist)) {
//            $text = "* new release";
//        } else {
//            $text = "* new release";
//        }
//        $inserted = ChangeLog::create([
//            'package_id' => $isExist->id,
//            'package_hash' => $isExist->package_hash,
//            'package_version' => $package_info['Version'],
//            'user_id' => backpack_user()->id,
//            'changes' => $text,
//            'package_identifier' => $package_info['Package']
//        ]);
//        if ($inserted) {
//            $this->createDepiction($package_info);
//        }
//        return $inserted;
//    }

    public function createDepiction($package_info) {
        $isExist = Package::where([
            'Package' => $package_info['Package'],
        ])->first();
        $isDepictionExist = Depiction::where([
            'package_id' => $isExist->id,
        ])->first();
        if (!is_null($isExist) && is_null($isDepictionExist)) {

            $inserted = Depiction::create([

                'package_id' => $isExist->id,
                'long_description' => $isExist->Description,
                'price' => 'Free',
            ]);
            if ($inserted) {
                $updated = Package::find($isExist->id)->update([
                    'Depiction' => route('package.depiction', ['package_hash' => $isExist->package_hash])
                ]);
                if ($updated) {
                    return $inserted;
                }
            }

        }
        return false;
    }
}
