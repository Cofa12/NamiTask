<?php

namespace App\Jobs;

use App\Models\Subtask;
use App\Models\Task;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class TaskSeederJob implements ShouldQueue
{
    use Queueable;
    protected $chunk;
    /**
     * Create a new job instance.
     */
    public function __construct($chunk)
    {
        //
        $this->chunk = $chunk;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $tasks = [];
        $subTasks = [];
        foreach ($this->chunk as $id){
            $tasks []= [
                'name'=>fake()->text,
                'description'=>fake()->text,
                'created_at'=>now()
            ];
            for ($i = 1; $i<=5; $i++){
                $subTasks []= [
                    'task_id' => $id,
                    'name'=>fake()->text,
                    'due_to'=>now()->addDay(2),
                    'created_at'=>now()
                ];
            }
        }

        Task::insert($tasks);
        Subtask::insert($subTasks);
    }
}
