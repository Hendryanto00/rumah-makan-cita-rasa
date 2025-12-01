<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Menambahkan data dummy untuk periode Agustus 2025 - Januari 2026
     */
    public function run(): void
    {
        $this->command->info('Memulai generate dummy data untuk 6 bulan terakhir...');

        // Ambil atau buat user role
        $userRole = Role::where('name', 'user')->first();
        
        if (!$userRole) {
            $this->command->error('Role "user" tidak ditemukan! Jalankan RoleSeeder terlebih dahulu.');
            return;
        }

        // Ambil user yang sudah ada atau buat user dummy baru
        $existingUsers = User::where('role_id', $userRole->id)->get();
        
        // Buat beberapa user dummy tambahan jika belum ada banyak
        $dummyUserNames = ['Budi Santoso', 'Siti Nurhaliza', 'Ahmad Fauzi', 'Rina Wati', 'Dedi Kurniawan', 
                          'Maya Sari', 'Joko Widodo', 'Ratna Dewi', 'Andi Pratama', 'Lina Kusuma'];
        
        foreach ($dummyUserNames as $name) {
            if ($existingUsers->where('name', $name)->isEmpty()) {
                $email = strtolower(str_replace(' ', '.', $name)) . '@example.com';
                $user = User::firstOrCreate(
                    ['email' => $email],
                    [
                        'name' => $name,
                        'password' => Hash::make('password123'),
                        'role_id' => $userRole->id,
                        'phone' => '08' . rand(100000000, 999999999),
                        'address' => 'Jl. ' . $name . ' No. ' . rand(1, 100),
                        'email_verified_at' => Carbon::now(),
                    ]
                );
                $existingUsers->push($user);
            }
        }
        
        $users = $existingUsers;
        
        if ($users->isEmpty()) {
            $this->command->error('Tidak ada user untuk membuat pesanan!');
            return;
        }
        
        // Get all active menus
        $menus = Menu::where('is_active', true)->get();
        
        if ($menus->isEmpty()) {
            $this->command->error('Tidak ada menu aktif! Jalankan MenuSeeder terlebih dahulu.');
            return;
        }

        // Define date range: August 2025 to January 2026
        $startDate = Carbon::create(2025, 8, 1)->startOfMonth();
        $endDate = Carbon::create(2026, 1, 31)->endOfMonth();

        $totalOrders = 0;
        $totalRevenue = 0;

        // Generate orders for each month
        $currentDate = $startDate->copy();
        
        while ($currentDate->lte($endDate)) {
            // Different activity levels per month
            $daysInMonth = $currentDate->daysInMonth;
            $monthNumber = $currentDate->month;
            
            // Generate orders per day (more on weekends, less on weekdays)
            for ($day = 1; $day <= $daysInMonth; $day++) {
                $date = $currentDate->copy()->day($day);
                $dayOfWeek = $date->dayOfWeek; // 0 = Sunday, 6 = Saturday
                
                // Weekend lebih ramai
                $isWeekend = $dayOfWeek == 0 || $dayOfWeek == 6;
                $baseOrders = $isWeekend ? rand(8, 15) : rand(3, 8);
                
                // Variasi berdasarkan bulan (lebih ramai di akhir bulan/tahun)
                if ($monthNumber >= 11 || $monthNumber == 1) { // November, December, January
                    $baseOrders = (int)($baseOrders * 1.3);
                } elseif ($monthNumber == 8) { // Agustus agak sepi
                    $baseOrders = (int)($baseOrders * 0.8);
                }
                
                // Generate orders for this day
                for ($orderNum = 0; $orderNum < $baseOrders; $orderNum++) {
                    // Random time throughout the day (more during lunch and dinner)
                    $hour = rand(10, 21);
                    if ($hour >= 11 && $hour <= 14) { // Lunch time
                        $minute = rand(0, 59);
                    } elseif ($hour >= 17 && $hour <= 20) { // Dinner time
                        $minute = rand(0, 59);
                    } else {
                        $minute = rand(0, 59);
                    }
                    
                    $orderDate = $date->copy()->setTime($hour, $minute, rand(0, 59));
                    
                    // Random user
                    $user = $users->random();
                    
                    // Random menu items (1-5 items per order)
                    $numItems = rand(1, 5);
                    $selectedMenus = $menus->random(min($numItems, $menus->count()));
                    
                    // Calculate total amount
                    $totalAmount = 0;
                    $orderDetails = [];
                    
                    foreach ($selectedMenus as $menu) {
                        $quantity = rand(1, 3);
                        $price = $menu->price;
                        $subtotal = $quantity * $price;
                        $totalAmount += $subtotal;
                        
                        $orderDetails[] = [
                            'menu_id' => $menu->id,
                            'quantity' => $quantity,
                            'price' => $price,
                            'subtotal' => $subtotal,
                        ];
                    }
                    
                    // Create order
                    $order = Order::create([
                        'user_id' => $user->id,
                        'order_date' => $orderDate,
                        'status' => $this->getRandomStatus($orderDate),
                        'total_amount' => $totalAmount,
                        'created_at' => $orderDate,
                        'updated_at' => $orderDate,
                    ]);
                    
                    // Create order details
                    foreach ($orderDetails as $detail) {
                        OrderDetail::create([
                            'order_id' => $order->id,
                            'menu_id' => $detail['menu_id'],
                            'quantity' => $detail['quantity'],
                            'price' => $detail['price'],
                            'subtotal' => $detail['subtotal'],
                            'created_at' => $orderDate,
                            'updated_at' => $orderDate,
                        ]);
                    }
                    
                    // Create payment (most orders are successful)
                    $paymentStatus = rand(1, 100) <= 85 ? 'sukses' : (rand(1, 2) == 1 ? 'pending' : 'gagal');
                    $paymentMethod = ['midtrans', 'tunai', 'transfer'][rand(0, 2)];
                    
                    $paidAt = null;
                    if ($paymentStatus === 'sukses') {
                        // Paid within 30 minutes to 2 days after order (most within 2 hours)
                        $hoursToAdd = rand(1, 100) <= 70 ? rand(1, 2) : rand(3, 48);
                        $paidAt = $orderDate->copy()->addHours($hoursToAdd);
                    }
                    
                    Payment::create([
                        'order_id' => $order->id,
                        'payment_method' => $paymentMethod,
                        'payment_status' => $paymentStatus,
                        'transaction_id' => $paymentStatus === 'sukses' ? 'TXN-' . strtoupper(uniqid()) : null,
                        'amount' => $totalAmount,
                        'paid_at' => $paidAt,
                        'created_at' => $orderDate,
                        'updated_at' => $paidAt ?? $orderDate,
                    ]);
                    
                    $totalOrders++;
                    if ($paymentStatus === 'sukses' && $paidAt) {
                        $totalRevenue += $totalAmount;
                    }
                }
            }
            
            $this->command->info("Data untuk {$currentDate->format('F Y')} selesai.");
            
            // Move to next month
            $currentDate->addMonth();
        }

        $this->command->info("✅ Dummy data berhasil dibuat!");
        $this->command->info("   Total Pesanan: " . number_format($totalOrders, 0, ',', '.'));
        $this->command->info("   Total Pendapatan: Rp " . number_format($totalRevenue, 0, ',', '.'));
        $this->command->info("   Periode: {$startDate->format('d M Y')} - {$endDate->format('d M Y')}");
    }

    /**
     * Get random order status
     * Most orders are completed (selesai) for demo purposes
     * Valid status: 'pending', 'diproses', 'selesai', 'batal'
     */
    private function getRandomStatus($orderDate)
    {
        // For demo data, most orders should be completed
        $rand = rand(1, 100);
        
        if ($rand <= 75) {
            return 'selesai'; // 75% completed
        } elseif ($rand <= 90) {
            return 'diproses'; // 15% in process
        } elseif ($rand <= 95) {
            return 'pending'; // 5% pending
        } else {
            return 'batal'; // 5% cancelled
        }
    }
}

