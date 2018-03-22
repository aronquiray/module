<?php

namespace App\Http\Controllers\Backend\Core\DummyClass;

use Illuminate\Http\Request;
use HalcyonLaravel\Base\Controllers\Backend\CRUDController as Controller;
use HalcyonLaravel\Base\Repository\BaseRepository as Repository;
use App\Models\Core\DummyClass as Model;

/**
 * Class DummyClassesController.
 */
class DummyClassesController extends Controller
{
    /**
     * DummyClassesController Constructor
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->repo = new Repository($model);
        parent::__construct();
    }

    /**
     * Specify Model class name.
     *
     * @return mixed
     */
    public function model()
    {
        return Model::class;
    }

    /**
     * @param Request $request
     * @param Model $model | nullable
     *
     * @return array
     */
    public function generateStub(Request $request) : array
    {
        return $request->only($this->model->getFillable());
    }


    /**
     * Validate input on store
     *
     * @return array
     */
    public function storeRules(Request $request) : array
    {
        $table = $this->model->getTable();
        return [
            'name' => "required|max:255|unique:$table",
            'description' => 'max:255',
            'content' => 'required',
        ];
    }
    
    /**
     * Validate input on update
     *
     * @param Model $model | nullable
     *
     * @return array
     */
    public function updateRules(Request $request, $model) : array
    {
        $table = $this->model->getTable();
        return [
            'name' => "required|max:255|unique:$table,name,{$model->id}",
            'description' => 'max:255',
            'content' => 'required',
        ];
    }

    public function testForMethodNotFound()
    {
        $this->repo->imNotExist();
    }
}
