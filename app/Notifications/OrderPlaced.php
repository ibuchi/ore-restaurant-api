<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderPlaced extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Order $order)
    {
        //
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
        $menus = $this->order->menus->map(function ($menu) {
            return $menu->name;
        })->join(', ');

        return (new MailMessage)
            ->subject(strtoupper(config('app.name')) . ': New Order Placed')
            ->greeting("Hello $notifiable->first_name!")
            ->line('A new order has been placed.')
            ->line("**Order Details:**")
            ->line('Order ID: ' . $this->order->unique_id)
            ->line('Customer Name: ' . $this->order->user->name)
            ->line('Email: ' . $this->order->email)
            ->line('Phone: ' . $this->order->phone)
            ->line('Address: ' . $this->order->address)
            ->line('Menus: ' . $menus)
            ->line('Quantity: ' . $this->order->quantity)
            ->line('Total Price: ' . format_money($this->order->total_price))
            ->action('View Order', route('orders.show', $this->order->id))
            ->line('Thank you!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
