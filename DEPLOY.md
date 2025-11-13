# Deploy ke Render.com

## Persiapan

1. **Pastikan file sudah di-commit ke Git:**
   ```bash
   git add .
   git commit -m "Add Docker configuration"
   git push
   ```

2. **Buat repository di GitHub/GitLab/Bitbucket** (jika belum ada)

## Setup di Render.com

### 1. Buat Web Service Baru

1. Login ke [Render.com](https://render.com)
2. Klik **"New +"** → **"Web Service"**
3. Connect repository Anda (GitHub/GitLab/Bitbucket)
4. Pilih repository project Laravel Anda

### 2. Konfigurasi Service

- **Name**: `rumah-makan-cita-rasa` (atau nama yang Anda inginkan)
- **Environment**: `Docker`
- **Region**: Pilih yang terdekat (Singapore untuk Indonesia)
- **Branch**: `main` (atau branch yang Anda gunakan)
- **Root Directory**: (kosongkan, atau `.` jika perlu)
- **Dockerfile Path**: `Dockerfile`
- **Docker Context**: `.`

### 3. Environment Variables

Tambahkan environment variables berikut di Render.com dashboard:

**Wajib:**
```
APP_NAME=Rumah Makan Cita Rasa
APP_ENV=production
APP_KEY=base64:... (generate dengan: php artisan key:generate --show)
APP_DEBUG=false
APP_URL=https://your-app-name.onrender.com

LOG_CHANNEL=stack
LOG_LEVEL=error
```

**Database (sesuaikan dengan database yang Anda gunakan):**
```
DB_CONNECTION=sqlite
DB_DATABASE=/var/www/html/database/database.sqlite
```

**Atau jika menggunakan PostgreSQL (disarankan untuk production):**
```
DB_CONNECTION=pgsql
DB_HOST=your-postgres-host
DB_PORT=5432
DB_DATABASE=your-database
DB_USERNAME=your-username
DB_PASSWORD=your-password
```

**Midtrans (jika menggunakan):**
```
MIDTRANS_SERVER_KEY=your-server-key
MIDTRANS_CLIENT_KEY=your-client-key
MIDTRANS_IS_PRODUCTION=true
```

**Mail (jika menggunakan):**
```
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="${APP_NAME}"
```

### 4. Build Command (Opsional)

Render.com akan otomatis menggunakan Dockerfile, jadi tidak perlu build command.

### 5. Start Command (Opsional)

Tidak perlu, karena sudah ada di Dockerfile (supervisord).

## Setelah Deploy

1. **Jalankan Migration:**
   - Masuk ke Shell di Render.com dashboard
   - Atau gunakan Render CLI:
   ```bash
   render run --service rumah-makan-cita-rasa php artisan migrate --force
   ```

2. **Generate App Key (jika belum):**
   ```bash
   render run --service rumah-makan-cita-rasa php artisan key:generate
   ```

3. **Cache Configuration:**
   ```bash
   render run --service rumah-makan-cita-rasa php artisan config:cache
   render run --service rumah-makan-cita-rasa php artisan route:cache
   render run --service rumah-makan-cita-rasa php artisan view:cache
   ```

## Troubleshooting

### Build Gagal
- Pastikan semua file sudah di-commit
- Cek log build di Render.com dashboard
- Pastikan Dockerfile path benar

### 500 Error
- Cek environment variables sudah benar
- Cek APP_KEY sudah di-set
- Cek database connection
- Cek storage permissions

### Assets Tidak Load
- Pastikan `npm run build` berjalan saat build
- Cek folder `public/build/` ada di repository
- Atau pastikan build step di Dockerfile berjalan

## Catatan Penting

1. **Free Tier**: Render.com free tier akan sleep setelah 15 menit tidak aktif
2. **Database**: Gunakan Render PostgreSQL untuk production (free tier tersedia)
3. **Storage**: File upload akan hilang saat redeploy, gunakan S3 atau storage external
4. **Queue**: Jika menggunakan queue, setup Redis di Render.com

## Update Deployment

Setiap kali push ke repository, Render.com akan otomatis rebuild dan redeploy.

