<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;
    protected $table = 'job';

    public function JobType()
    {
        return $this->belongsTo(JobType::class, 'jobtype_id','jobtyep_id');
    }

    public function category(){  
        return $this->belongsTo(Category::class, 'catagory_id');
    }
}
