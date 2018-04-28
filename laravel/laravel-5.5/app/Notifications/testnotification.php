<?php

namespace App\Notifications;

use App\User as User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class testnotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $users;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $users)
    {
        $this -> users = $users;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['nexmo'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        echo "inside to array";
        return [
            'service' => "Test Service",
            'status' => 'failed',
            'payload' => $this -> users,
            'send_from' => 'test array'
        ];
    }

    /**
     * @param $notifiable
     * @return array
     */
    public function toDatabase($notifiable) {
        echo "inside to database";
        return [
            'service' => "Test Service",
            'status' => 'failed',
            'payload' => $this -> users,
            'send_from' => 'test database'
        ];
    }

    public function toNexmo() {
        return (new NexmoMessage) -> content("This is a test message {$this->users}");
    }
}
