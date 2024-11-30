<?php

namespace Database\Seeders;

use App\Jobs\TaskSeederJob;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Queue;

class TasksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $numberOfChunks = 100;
        $chunks = collect(range(1,10000))->chunk($numberOfChunks);
        foreach ($chunks as $chunk){
            TaskSeederJob::dispatch()->onQueue('task_seeder');
        }
    }
}
