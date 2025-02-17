<?php

namespace App\Models;

use Higgs\Model;

class JobModel extends Model
{
    protected $table         = 'jobs';
    protected $returnType    = \App\Entities\Job::class;
    protected $allowedFields = [
        'name', 'description',
    ];
}
