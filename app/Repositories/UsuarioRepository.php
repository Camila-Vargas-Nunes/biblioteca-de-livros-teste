<?php

namespace App\Repositories;

use App\Models\UsuarioModel;

class UsuarioRepository extends BaseRepository
{
    protected $model;

    public function __construct(usuarioModel $model)
    {
        $this->model = $model;
    }
}
