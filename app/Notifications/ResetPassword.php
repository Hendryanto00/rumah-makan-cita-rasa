<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class ResetPassword extends Notification
{
    use Queueable;

    /**
     * The password reset token.
     *
     * @var string
     */
    public $token;

    /**
     * Create a new notification instance.
     */
    public function __construct(string $token)
    {
        $this->token = $token;
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
     * 
     * INI ADALAH TEMPLATE EMAIL RESET PASSWORD
     */
    public function toMail(object $notifiable): MailMessage
    {
        $resetUrl = $this->resetUrl($notifiable);
        
        return (new MailMessage)
            ->subject('Reset Kata Sandi - Rumah Makan Cita Rasa')
            ->greeting('Halo!')
            ->line('Anda menerima email ini karena kami menerima permintaan reset kata sandi untuk akun Anda.')
            ->line('Silakan klik tombol di bawah ini untuk mengatur ulang kata sandi Anda.')
            ->action('Reset Kata Sandi', $resetUrl)
            ->line('Link reset kata sandi ini akan berakhir dalam 60 menit.')
            ->line('Jika Anda tidak meminta reset kata sandi, tidak ada tindakan lebih lanjut yang diperlukan.')
            ->salutation('Salam, Tim Rumah Makan Cita Rasa');
    }

    /**
     * Get the reset URL for the given notifiable.
     */
    protected function resetUrl($notifiable)
    {
        return URL::route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ]);
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
