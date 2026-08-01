<?php

namespace App\Mail;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OverdueTaskMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Task $task) {}

    public function build()
    {
        return $this->subject('Action Required: Task Overdue')->html("<p>Hello,</p><p>The task <strong>{$this->task->title}</strong> is overdue!</p>");
    }
}
