<?php

namespace App\Observers;

use App\Models\DummyClass\DummyClass as Model;
use Log;

class DummyClassObserver
{

    private function _logging($method, $model)
    {
        $modelData = print_r($model->toArray(), true);
        Log::info("$method: $modelData");
    }

    public function retrieved(Model $model)
    {
        $this->_logging(__METHOD__, $model);
    }

    public function creating(Model $model)
    {
        $this->_logging(__METHOD__, $model);
    }

    public function created(Model $model)
    {
        $this->_logging(__METHOD__, $model);
    }

    public function updating(Model $model)
    {
        $this->_logging(__METHOD__, $model);
    }

    public function updated(Model $model)
    {
        $this->_logging(__METHOD__, $model);
    }

    public function saving(Model $model)
    {
        $this->_logging(__METHOD__, $model);
    }

    public function saved(Model $model)
    {
        $this->_logging(__METHOD__, $model);
    }

    public function deleting(Model $model)
    {
        $this->_logging(__METHOD__, $model);
    }

    public function deleted(Model $model)
    {
        $this->_logging(__METHOD__, $model);
    }

    public function restoring(Model $model)
    {
        $this->_logging(__METHOD__, $model);
    }

    public function restored(Model $model)
    {
        $this->_logging(__METHOD__, $model);
    }
}
