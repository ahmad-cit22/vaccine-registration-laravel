<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VaccinationReminderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $vaccination;

    public function __construct($vaccination)
    {
        $this->vaccination = $vaccination;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('This is a reminder for your vaccination appointment.')
            ->line('Scheduled Date: ' . $this->vaccination->scheduled_date)
            ->line('Vaccination Center: ' . $this->vaccination->vaccineCenter->name)
            ->line('Please visit the center on your scheduled date.');
    }
}
