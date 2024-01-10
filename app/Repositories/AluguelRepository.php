<?php

namespace App\Repositories;

use App\Models\AluguelModel;

class AluguelRepository extends BaseRepository
{
    protected $model;

    public function __construct(AluguelModel $model)
    {
        $this->model = $model;
    }
}
