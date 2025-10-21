<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Mail Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used for email messages throughout
    | the application. You are free to modify these language lines according
    | to your application's requirements.
    |
    */

    'greeting' => 'Halo!',
    'whoops' => 'Ups!',
    'regards' => 'Salam,',
    
    // Common email messages
    'Hello!' => 'Halo!',
    'Whoops!' => 'Ups!',
    'Regards,' => 'Salam,',
    'If you\'re having trouble clicking the ":actionText" button, copy and paste the URL below into your web browser:' => 'Jika Anda mengalami kesulitan mengklik tombol ":actionText", salin dan tempel URL di bawah ini ke browser web Anda:',
    
    'password_reset' => [
        'subject' => 'Notifikasi Reset Kata Sandi',
        'intro' => 'Anda menerima email ini karena kami menerima permintaan reset kata sandi untuk akun Anda.',
        'action' => 'Reset Kata Sandi',
        'outro' => 'Link reset kata sandi ini akan berakhir dalam :count menit.',
        'no_action' => 'Jika Anda tidak meminta reset kata sandi, tidak ada tindakan lebih lanjut yang diperlukan.',
        'subcopy' => 'Jika Anda mengalami kesulitan mengklik tombol ":actionText", salin dan tempel URL di bawah ini ke browser web Anda:',
    ],
    
    'email_verification' => [
        'subject' => 'Verifikasi Alamat Email',
        'intro' => 'Silakan klik tombol di bawah ini untuk memverifikasi alamat email Anda.',
        'action' => 'Verifikasi Alamat Email',
        'outro' => 'Jika Anda tidak membuat akun, tidak ada tindakan lebih lanjut yang diperlukan.',
        'subcopy' => 'Jika Anda mengalami kesulitan mengklik tombol ":actionText", salin dan tempel URL di bawah ini ke browser web Anda:',
    ],
    
    'welcome' => [
        'subject' => 'Selamat Datang di :app',
        'intro' => 'Selamat datang di :app! Akun Anda telah berhasil dibuat.',
        'action' => 'Mulai Sekarang',
        'outro' => 'Terima kasih telah bergabung dengan kami!',
    ],
    
    'order_confirmation' => [
        'subject' => 'Konfirmasi Pesanan #:order_number',
        'intro' => 'Terima kasih atas pesanan Anda! Berikut adalah detail pesanan Anda:',
        'action' => 'Lihat Pesanan',
        'outro' => 'Kami akan memproses pesanan Anda segera.',
    ],
    
    'order_shipped' => [
        'subject' => 'Pesanan #:order_number Telah Dikirim',
        'intro' => 'Pesanan Anda telah dikirim dan sedang dalam perjalanan.',
        'action' => 'Lacak Pesanan',
        'outro' => 'Terima kasih telah berbelanja dengan kami!',
    ],
    
    'review_reminder' => [
        'subject' => 'Bagikan Pengalaman Anda',
        'intro' => 'Bagaimana pengalaman Anda dengan pesanan terakhir?',
        'action' => 'Tulis Review',
        'outro' => 'Review Anda sangat berarti bagi kami dan pelanggan lainnya.',
    ],

];