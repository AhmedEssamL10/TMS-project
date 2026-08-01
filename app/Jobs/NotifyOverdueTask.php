<?php

namespace App\Jobs;

use App\Models\Task;
use App\Mail\OverdueTaskMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class NotifyOverdueTask implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Task $task) {}

    public function handle(): void
    {
        $user = $this->task->project->user;
        Mail::to($user->email)->send(new OverdueTaskMail($this->task));
    }
}
