<?php

namespace App\Http\Controllers\Admin;

use App\Models\ChangeLog;
use App\Models\Package;
use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\ChangeLogRequest as StoreRequest;
use App\Http\Requests\ChangeLogRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;

/**
 * Class ChangeLogCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class ChangeLogCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\ChangeLog');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/change_logs');
        $this->crud->setEntityNameStrings('changelog', 'change_logs');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        // TODO: remove setFromDb() and manually define Fields and Columns
        $this->crud->setFromDb();
        $this->crud->removeAllFields('update/create');
        $this->crud->removeColumns(['package_id', 'package_version']);

        $this->crud->addColumn([
            // 1-n relationship
            'label' => "Package", // Table column heading
            'type' => "select",
            'name' => 'package_id', // the column that contains the ID of that connected entity;
            'entity' => 'package', // the method that defines the relationship in your Model
            'attribute' => "Name", // foreign key attribute that is shown to user
            'model' => "App\Models\Package", // foreign key model
        ])->makeFirstColumn();
        $this->crud->addColumn([
            // 1-n relationship
            'label' => "Package Version", // Table column heading
            'type' => "select",
            'name' => 'package_version', // the column that contains the ID of that connected entity;
            'entity' => 'package', // the method that defines the relationship in your Model
            'attribute' => "Version", // foreign key attribute that is shown to user
            'model' => "App\Models\Package", // foreign key model
        ])->beforeColumn('user_id');
        $this->crud->addColumn([
            'name' => 'changes', // The db column name
            'label' => "Changes", // Table column heading
            'type' => 'table',
            'columns' => [
                'change' => 'Change',
            ]
        ])->beforeColumn('user_id');


        $this->crud->addFields([
            [
                'label' => "Package",
                'type' => 'select2',
                'name' => 'package_id', // the db column for the foreign key
                'entity' => 'package', // the method that defines the relationship in your Model
                'attribute' => 'Name', // foreign key attribute that is shown to user
                'model' => "App\Models\Package", // foreign key model
            ],
            [
                'label' => 'User',
                'name' => 'user_id',
                'default' => backpack_user()->id,
                'type' => 'hidden',
            ],
            [
                'label' => "Version",
                'type' => 'select2',
                'name' => 'package_version', // the db column for the foreign key
                'entity' => 'package', // the method that defines the relationship in your Model
                'attribute' => 'Version', // foreign key attribute that is shown to user
                'model' => "App\Models\Package", // foreign key model
            ],
            [ // Table
                'name' => 'changes',
                'label' => 'Chnages',
                'type' => 'table',
                'entity_singular' => 'change', // used on the "Add X" button
                'columns' => [
                    'change' => 'Change',
                ],
                'max' => 10, // maximum rows allowed in the table
                'min' => 0, // minimum rows allowed in the table
            ],
        ]);

        $this->crud->orderBy('package_version', 'desc');
        // add asterisk for fields that are required in ChangeLogRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');
    }

    public function store(StoreRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::storeCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        $package = Package::whereId($this->crud->entry->package_version)->first();
        ChangeLog::whereId($this->crud->entry->id)->update([
            'package_hash' => $package->package_hash,
            'package_identifier' => $package->Package
        ]);
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
}
