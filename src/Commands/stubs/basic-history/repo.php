<?php

namespace DummyNameSpaceClass\Repositories\DummyPath\DummyClass;

use DummyNameSpaceClass\Models\DummyPath\DummyClass\DummyClass;
use HalcyonLaravel\Base\Repository\BaseRepository;

/**
 * DummyClassRepository
 */
class DummyClassRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct();
        $this->setObserver(new DummyClassObserver);
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return DummyClass::class;
    }
}
