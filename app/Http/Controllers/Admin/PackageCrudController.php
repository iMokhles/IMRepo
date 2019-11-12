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

        $this->crud->orderBy('Version', 'desc');
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
                $this->saveChangeLog($deb_version, $deb_identifier);
            }
            return $updated;
        }
    }

    public function saveChangeLog($deb_version, $deb_identifier) {
        $package = Package::where([
            'Package' => $deb_identifier,
            'Version' => $deb_version
        ])->first();
        if ($package) {
            $changeLog = ChangeLog::where([
                'package_identifier' => $package->Package,
            ])->first();
            $isHasChangeLog = false;
            if ($changeLog) {
                $isHasChangeLog = true;
            } else {
                $isHasChangeLog = false;
            }

            $insertChangeLog = ChangeLog::create([
                'package_id' => $package->id,
                'package_hash' => $package->package_hash,
                'package_version' => $package->id,
                'user_id' => backpack_user()->id,
                'changes' => ($isHasChangeLog === true) ? '[{"change":"* new update"}]' : '[{"change":"* first release"}]',
                'package_identifier' => $package->Package,
            ]);

            if ($insertChangeLog) {
                $this->createDepiction($deb_version, $deb_identifier);
            }
        }
    }

    public function createDepiction($deb_version, $deb_identifier) {
        $package = Package::where([
            'Package' => $deb_identifier,
            'Version' => $deb_version
        ])->first();
        if ($package) {
            $depiction = Depiction::where([
                'package_id' => $package->id,
            ])->first();
            if (!$depiction) {
                $insertDepiction = Depiction::create([

                    'package_id' => $package->id,
                    'long_description' => $package->Description,
                    'price' => 'Free',
                ]);
                if ($insertDepiction) {
                    $updatedPackage = $package->update([
                        'Depiction' => route('package.depiction', ['package_hash' => $package->package_hash])
                    ]);
                    if ($updatedPackage) {
                        return $insertDepiction;
                    }
                }
            }
        }
        return false;
    }
}
