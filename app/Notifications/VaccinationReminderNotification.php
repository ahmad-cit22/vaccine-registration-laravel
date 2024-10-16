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
            ->subject('Vaccination Reminder')
            ->line('Hope you are doing well.')
            ->line("This is a reminder for tomorrow's vaccination appointment.")
            ->line('Scheduled Date: ' . $this->vaccination->scheduled_date->format('F j, Y'))
            ->line('Vaccination Center: ' . $this->vaccination->vaccineCenter->name)
            ->line('Please visit the center tomorrow for vaccination.');
    }
}
