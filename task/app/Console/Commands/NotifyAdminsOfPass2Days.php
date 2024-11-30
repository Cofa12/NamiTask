<?php

namespace App\Console\Commands;

use App\Models\Admin;
use App\Models\Task;
use App\Notifications\NotifyAdminsOfPass2DaysNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class NotifyAdminsOfPass2Days extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify-admins-of-pass2-days';

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
        $admins = Admin::all();
        foreach ($tasks as $task){
            $finishedSubTasksCount = $task->subtasks()->where('status','finished')->count();
            if(count($task['subtasks'])>$finishedSubTasksCount){
                foreach ($admins as $admin){
                    $admin->notify(new NotifyAdminsOfPass2DaysNotification($task));
                }
            }
        }

    }
}
