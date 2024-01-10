<?php

namespace App\Repositories;

use App\Models\BaseModel;

abstract class BaseRepository
{
    protected $model;

    public function __construct(BaseModel $model)
    {
        $this->model = $model;
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(array $data, $id)
    {
        $model = $this->model->findOrFail($id);

        $updated = $model->update($data);

        return $updated;
    }

    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    public function all()
    {
        return $this->model->all();
    }
}
