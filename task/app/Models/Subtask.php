<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subtask extends Model
{
    //

    protected $fillable = [
        'name',
        'task_id',
        'due_to',
        'status',
    ];
    public function task(){
        return $this->belongsTo(Task::class,'id');
    }
}
