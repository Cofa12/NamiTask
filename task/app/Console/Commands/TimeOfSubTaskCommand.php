<?php

namespace App\Console\Commands;

use App\Models\Admin;
use App\Models\Subtask;
use App\Notifications\NotifyAdminsOfPass2DaysNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Notifications\TimeOfSubTask;

class TimeOfSubTaskCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'time-of-sub-task';

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
        $date = Carbon::now('Africa/Cairo')->format('y-m-d');
        $time = Carbon::now('Africa/Cairo')->format('H:i');
        $dueToTasks = Subtask::whereDate('due_to',$date)->whereTime('due_to',$time);
        $admins = Admin::all();
        foreach ($dueToTasks as $dueToTask){
            foreach ($admins as $admin){
                $admin->notify((new TimeOfSubTask($dueToTask))->onQueue('task_alert'));
            }
        }
    }
}
