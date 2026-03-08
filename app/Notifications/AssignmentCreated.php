<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AssignmentCreated extends Notification implements ShouldQueue
{
    use Queueable;

    public $assignmentTitle;
    public $className;

    public function __construct($assignmentTitle, $className)
    {
        $this->assignmentTitle = $assignmentTitle;
        $this->className = $className;
    }

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('New Assignment Created')
                    ->greeting('Hello Student!')
                    ->line("A new assignment '{$this->assignmentTitle}' has been created in class '{$this->className}'.")
                    ->action('View Assignments', route('student.assignments.index'))
                    ->line('Please log in to complete it before the deadline.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'assignment_created',
            'message' => "New assignment '{$this->assignmentTitle}' created in class '{$this->className}'.",
            'url' => route('student.assignments.index')
        ];
    }
}
