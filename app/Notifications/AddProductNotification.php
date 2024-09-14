<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AddProductNotification extends Notification
{
    use Queueable;
    public $data;

    /**
     * Create a new notification instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'broadcast']; // سنرسل الإشعار عبر قاعدة البيانات والبث
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'هناك اشعار بطلب تعويض',
        ];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => $this->data['title'],    // الوصول إلى البيانات
            'number' => $this->data['number'],
            'created_by' => $this->data['created_by'],
            'company' => $this->data['company'],
        ];
    }

    // public function toBroadcast($notifiable)
    // {
    //     return new BroadcastMessage([
    //         'message' => 'هناك اشعار بطلب تعويض',
    //     ]);
    // }

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
}
