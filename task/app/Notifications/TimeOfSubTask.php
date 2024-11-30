<?php

namespace App\Notifications;

use App\Models\Subtask;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TimeOfSubTask extends Notification
{
    use Queueable;
    protected Subtask $dueToTask;
    /**
     * Create a new notification instance.
     */
    public function __construct(Subtask $dueToTask)
    {
        //
        $this->dueToTask = $dueToTask;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'subtask_id' => $this->dueToTask->id,
            'title' => $this->dueToTask->name,
            'due_date' => $this->dueToTask->due_to->format('Y-m-d H:i'),
            'message' => 'A subtask is due soon.',
        ];
    }
}
