<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AssignmentSubmitted extends Notification implements ShouldQueue
{
    use Queueable;

    public $studentName;
    public $assignmentTitle;
    public $submissionId;

    public function __construct($studentName, $assignmentTitle, $submissionId)
    {
        $this->studentName = $studentName;
        $this->assignmentTitle = $assignmentTitle;
        $this->submissionId = $submissionId;
    }

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('New Assignment Submission')
                    ->greeting('Hello Teacher!')
                    ->line("{$this->studentName} submitted '{$this->assignmentTitle}'.")
                    ->action('Review Submission', route('teacher.assignments.submissions', ['assignment_id' => $this->submissionId]))
                    ->line('Please log in to review and grade it.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'assignment_submitted',
            'message' => "{$this->studentName} submitted '{$this->assignmentTitle}'.",
            'url' => route('teacher.assignments.submissions', ['assignment_id' => $this->submissionId])
        ];
    }
}
