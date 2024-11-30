<?php

namespace App\Console\Commands;

use App\Models\Subtask;
use App\Models\Task;
use App\Notifications\TimeOfSubTask;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DeleteFinishedAnd2DaysPassTasks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete-finished-and2-days-pass-tasks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $date = Carbon::now('Africa/Cairo')->subDay(2)->format('y-m-d');
        $tasks = Task::whereDate('created_at',$date)->with('subtasks')->get();
        foreach ($tasks as $task){
            $finishedSubTasksCount = $task->subtasks()->where('status','finished')->count();
            if(count($task['subtasks'])==$finishedSubTasksCount){
                $task->subtasks()->delete();
                $task->delete();
            }
        }
    }
}
