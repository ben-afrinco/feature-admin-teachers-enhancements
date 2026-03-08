<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\AssignmentSubmission;

class AssignmentGradedNotification extends Notification
{
    use Queueable;

    public $submission;

    /**
     * Create a new notification instance.
     */
    public function __construct(AssignmentSubmission $submission)
    {
        $this->submission = $submission;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database']; // optionally 'mail'
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('تم تقييم تكليفك: ' . $this->submission->assignment->title)
            ->line('لقد قام المعلم بتقييم تسليمك لتكليف ' . $this->submission->assignment->title)
            ->line('الدرجة: ' . $this->submission->grade . ' / ' . $this->submission->assignment->max_grade)
            ->action('عرض التقييم', url('/student/assignments'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'assignment_id' => $this->submission->assignment_id,
            'title' => 'تقييم تكليف: ' . $this->submission->assignment->title,
            'message' => 'حصلت على درجة ' . $this->submission->grade . ' من ' . $this->submission->assignment->max_grade,
            'type' => 'assignment_graded',
        ];
    }
}
