<?php

namespace App\Repositories;

use App\Models\Model;
use App\Repositories\BaseRepository;

class ModelRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'title',
        'latitude',
        'longitude',
        'altitude',
        'url',
        'options',
        'filename'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Model::class;
    }
}
