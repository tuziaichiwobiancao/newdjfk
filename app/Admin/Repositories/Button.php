<?php

namespace App\Admin\Repositories;

use App\Models\Button as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Button extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
