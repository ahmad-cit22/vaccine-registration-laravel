<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VaccinationScheduledNotification extends Notification implements ShouldQueue
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
            ->subject('Vaccination Scheduled')
            ->line('Hope you are doing well.')
            ->line('Your vaccination has been scheduled successfully.')
            ->line('Scheduled Date: ' . $this->vaccination->scheduled_date->format('F j, Y'))
            ->line('Vaccine Center: ' . $this->vaccination->vaccineCenter->name)
            ->line('Please visit the center on your scheduled date for vaccination.')
            ->line('Thank you for your registration!');
    }
}
