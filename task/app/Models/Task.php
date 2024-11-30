<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    //
    protected $fillable = [
        'name',
        'description'
    ];

    public function subtasks(){
        return $this->hasMany(Subtask::class,'task_id');
    }

}
