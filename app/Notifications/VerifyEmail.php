<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

class VerifyEmail extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
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
     * 
     * INI ADALAH TEMPLATE EMAIL VERIFIKASI
     */
    public function toMail(object $notifiable): MailMessage
    {
        $verificationUrl = $this->verificationUrl($notifiable);
        
        return (new MailMessage)
            ->subject('Verifikasi Alamat Email - Rumah Makan Cita Rasa')
            ->greeting('Halo!')
            ->line('Terima kasih telah mendaftar di Rumah Makan Cita Rasa!')
            ->line('Silakan verifikasi alamat email Anda dengan mengklik tombol di bawah ini.')
            ->line('**PENTING:**')
            ->line('• Jika Anda menggunakan aplikasi email (Gmail, Outlook, dll), link mungkin akan dibuka di aplikasi email.')
            ->line('• Untuk hasil terbaik, **salin URL di bawah ini** dan **tempel di browser Chrome/Safari/Firefox** Anda.')
            ->line('• Atau tekan lama pada tombol "Verifikasi Email" dan pilih "Buka di Browser".')
            ->action('Verifikasi Email', $verificationUrl)
            ->line('**URL Verifikasi (salin dan tempel di browser):**')
            ->line($verificationUrl)
            ->line('Jika Anda tidak membuat akun ini, tidak ada tindakan lebih lanjut yang diperlukan.')
            ->line('Catatan: Link verifikasi ini akan berakhir dalam 60 menit.')
            ->salutation('Salam, Tim Rumah Makan Cita Rasa');
    }

    /**
     * Get the verification URL for the given notifiable.
     */
    protected function verificationUrl($notifiable)
    {
        // Ensure absolute URL is used for email links
        // This is critical for email links to work correctly when clicked from email clients
        $url = URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ],
            true // Force absolute URL
        );
        
        // Double-check: if URL is still relative, make it absolute
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            $baseUrl = config('app.url');
            if (strpos($url, '/') === 0) {
                $url = rtrim($baseUrl, '/') . $url;
            } else {
                $url = rtrim($baseUrl, '/') . '/' . $url;
            }
        }
        
        // JANGAN tambahkan parameter apapun ke signed URL karena akan merusak signature!
        // Signed URL harus tetap utuh seperti yang di-generate oleh Laravel
        
        return $url;
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
