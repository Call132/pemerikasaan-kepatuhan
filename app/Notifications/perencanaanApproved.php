<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class perencanaanApproved extends Notification
{
    use Queueable;
    public $note;

    /**
     * Create a new notification instance.
     */
    public function __construct($note)
    {
        $this->note = $note;
    }
   


    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Perencanaan Anda Telah Disetujui') // Subjek email
            ->greeting('Selamat! Perencanaan Anda telah Disetujui.')
            ->line('Anda dapat melanjutkan dengan perencanaan Anda yang telah disetujui.')
            ->line('Catatan : ' . $this->note)
            ->action('Lihat Perencanaan', url('/login'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'note' => $this->note
        ];
    }
}
