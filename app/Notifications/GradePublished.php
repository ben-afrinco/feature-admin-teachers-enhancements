<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class GradePublished extends Notification implements ShouldQueue
{
    use Queueable;

    public $assignmentTitle;
    public $grade;

    public function __construct($assignmentTitle, $grade)
    {
        $this->assignmentTitle = $assignmentTitle;
        $this->grade = $grade;
    }

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Grade Published')
                    ->greeting('Hello Student!')
                    ->line("Your grade for '{$this->assignmentTitle}' is published: {$this->grade}")
                    ->action('View Grades', route('student.assignments.index'))
                    ->line('Keep up the good work!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'grade_published',
            'message' => "Your grade for '{$this->assignmentTitle}' is published: {$this->grade}",
            'url' => route('student.assignments.index')
        ];
    }
}
