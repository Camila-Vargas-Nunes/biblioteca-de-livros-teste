<?php

namespace App\Repositories;

use App\Models\LivroModel;

class LivroRepository extends BaseRepository
{
    protected $model;

    public function __construct(LivroModel $model)
    {
        $this->model = $model;
    }
}
