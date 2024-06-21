<?php

namespace App\Notifications;

use App\Events\BookingEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class BookingNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private $booking;

    /**
     * Create a new notification instance.
     *
     * @param $booking
     */
    public function __construct($booking)
    {
        $this->booking = $booking;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['broadcast'];
    }

    /**
     * Get the broadcast representation of the notification.
     *
     * @param mixed $notifiable
     * @return BroadcastMessage
     */
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'booking_id' => $this->booking->id,
            'user_id' => $this->booking->user_id,
        ]);
    }

    /**
     * Send the notification by broadcasting the event.
     *
     * @param mixed $notifiable
     * @return void
     */
    public function send($notifiable)
    {
        event(new BookingEvent($this->booking));
    }
}
