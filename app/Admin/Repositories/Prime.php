<?php

namespace App\Admin\Repositories;

use App\Models\Prime as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Prime extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
