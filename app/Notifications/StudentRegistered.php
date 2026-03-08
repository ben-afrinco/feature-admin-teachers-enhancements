<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StudentRegistered extends Notification implements ShouldQueue
{
    use Queueable;

    public $studentName;

    public function __construct($studentName)
    {
        $this->studentName = $studentName;
    }

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('New Student Registered')
                    ->greeting('Hello Admin!')
                    ->line('A new student has registered: ' . $this->studentName)
                    ->action('View Dashboard', route('developer'))
                    ->line('Thank you for using LingoPulse!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'student_registered',
            'message' => 'New student registered: ' . $this->studentName,
            'url' => route('developer')
        ];
    }
}
