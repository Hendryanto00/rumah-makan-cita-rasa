<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Error Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used for error messages throughout
    | the application. You are free to modify these language lines according
    | to your application's requirements.
    |
    */

    '404' => [
        'title' => 'Halaman Tidak Ditemukan',
        'message' => 'Maaf, halaman yang Anda cari tidak ditemukan.',
        'description' => 'Halaman yang Anda cari mungkin telah dipindahkan, dihapus, atau tidak pernah ada.',
    ],
    
    '403' => [
        'title' => 'Akses Ditolak',
        'message' => 'Anda tidak memiliki izin untuk mengakses halaman ini.',
        'description' => 'Silakan hubungi administrator jika Anda merasa ini adalah kesalahan.',
    ],
    
    '500' => [
        'title' => 'Kesalahan Server',
        'message' => 'Terjadi kesalahan pada server.',
        'description' => 'Tim kami telah diberitahu tentang masalah ini. Silakan coba lagi nanti.',
    ],
    
    '503' => [
        'title' => 'Layanan Tidak Tersedia',
        'message' => 'Layanan sedang dalam pemeliharaan.',
        'description' => 'Kami sedang melakukan pemeliharaan rutin. Silakan coba lagi dalam beberapa saat.',
    ],
    
    'session' => [
        'expired' => 'Sesi Anda telah berakhir. Silakan login kembali.',
        'invalid' => 'Sesi tidak valid. Silakan login kembali.',
    ],
    
    'csrf' => [
        'mismatch' => 'Token keamanan tidak cocok. Silakan coba lagi.',
        'expired' => 'Token keamanan telah berakhir. Silakan refresh halaman.',
    ],
    
    'file' => [
        'upload_failed' => 'Gagal mengunggah file.',
        'too_large' => 'File terlalu besar.',
        'invalid_type' => 'Tipe file tidak valid.',
        'not_found' => 'File tidak ditemukan.',
    ],
    
    'database' => [
        'connection_failed' => 'Gagal terhubung ke database.',
        'query_failed' => 'Gagal menjalankan query database.',
        'constraint_violation' => 'Pelanggaran kendala database.',
    ],
    
    'validation' => [
        'required' => 'Field :field wajib diisi.',
        'email' => 'Format email tidak valid.',
        'min' => 'Field :field minimal :min karakter.',
        'max' => 'Field :field maksimal :max karakter.',
        'numeric' => 'Field :field harus berupa angka.',
        'unique' => 'Field :field sudah digunakan.',
        'confirmed' => 'Konfirmasi :field tidak cocok.',
    ],
    
    'auth' => [
        'login_required' => 'Anda harus login terlebih dahulu.',
        'permission_denied' => 'Anda tidak memiliki izin untuk melakukan aksi ini.',
        'account_suspended' => 'Akun Anda telah ditangguhkan.',
        'account_locked' => 'Akun Anda telah dikunci.',
    ],
    
    'payment' => [
        'failed' => 'Pembayaran gagal.',
        'cancelled' => 'Pembayaran dibatalkan.',
        'expired' => 'Pembayaran telah berakhir.',
        'insufficient_funds' => 'Saldo tidak mencukupi.',
    ],
    
    'order' => [
        'not_found' => 'Pesanan tidak ditemukan.',
        'already_processed' => 'Pesanan sudah diproses.',
        'cancelled' => 'Pesanan dibatalkan.',
        'expired' => 'Pesanan telah berakhir.',
    ],
    
    'cart' => [
        'empty' => 'Keranjang kosong.',
        'item_not_found' => 'Item tidak ditemukan di keranjang.',
        'quantity_exceeded' => 'Jumlah melebihi stok yang tersedia.',
    ],
    
    'review' => [
        'not_found' => 'Review tidak ditemukan.',
        'already_exists' => 'Anda sudah memberikan review untuk item ini.',
        'not_allowed' => 'Anda tidak dapat memberikan review untuk item ini.',
    ],

];
