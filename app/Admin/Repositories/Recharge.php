<?php

namespace App\Admin\Repositories;

use App\Models\Recharge as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Recharge extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
