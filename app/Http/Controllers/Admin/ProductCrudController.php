<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProductRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ProductCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ProductCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Product::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/product');
        CRUD::setEntityNameStrings('product', 'products');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {

//        $this->crud->setColumns(['title', 'slug' ]); // columns
        $this->crud->addColumn([
            'name'      => 'row_number',
            'type'      => 'row_number',
            'label'     => 'Si',
            'orderable' => false,
            'priority'  => 1,
        ]);
        CRUD::addColumn([
            'name'      => 'title',
            'orderable' => true,
        ]);
        CRUD::addColumn([
            'name' => 'slug',
        ]);
        CRUD::addColumn([
            'name'   => 'brand_id',
            'entity' => 'brand',
        ]);
        CRUD::addColumn([
            'name'   => 'category_id',
            'entity' => 'category',
        ]);


        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(ProductRequest::class);

        CRUD::setFromDb(); // fields
        $this->crud->removeField([ 'slug', 'image', 'created_by', 'status', 'brand_id', 'category_id', 'description' ]);

        CRUD::addField([
            'name'    => 'status',
            'type'    => 'select_from_array',
            'options' => [ 'Inactive', 'Active' ],
            'value'   => 1
        ]);
        CRUD::addField([
            'name'   => 'brand_id',
            'type'   => 'select2',
            'entity' => 'brand',
        ]);
        CRUD::addField([
            'name'   => 'category_id',
            'type'   => 'select2',
            'entity' => 'category',
        ]);
        CRUD::field('image')->type('image');
        CRUD::addField([
            'name' => 'description',
            'type' => 'ckeditor',
        ]);

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
