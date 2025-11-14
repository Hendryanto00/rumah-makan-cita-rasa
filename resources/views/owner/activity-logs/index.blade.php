@extends('layouts.owner')

@section('title', 'Laporan Aktivitas Sistem')
@section('page-title', 'Laporan Aktivitas Sistem')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-orange-500 via-orange-600 to-red-500 rounded-2xl shadow-lg p-6 md:p-8 text-white">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold mb-2">Laporan Aktivitas Sistem</h1>
                <p class="text-orange-100">Pantau seluruh aktivitas penting di sistem (tambah, ubah, hapus data)</p>
            </div>
            <div class="flex items-center gap-3 bg-white/20 backdrop-blur rounded-xl px-4 py-3">
                    <i class="fas fa-history text-2xl"></i>
                    <div>
                        <p class="text-xs text-orange-100">Total Aktivitas</p>
                        <p class="text-lg font-bold">{{ number_format($totalLogs, 0, ',', '.') }}</p>
                    </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-white rounded-xl shadow-md border border-gray-100 p-5">
        <form method="GET" action="{{ route('owner.activity-logs.index') }}" id="filterForm" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                <div>
                    <label for="start_date" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-calendar-alt mr-2 text-orange-500"></i>Tanggal Mulai
                    </label>
                    <input type="date" 
                           id="start_date" 
                           name="start_date" 
                           value="{{ old('start_date', $startDate) }}"
                           class="w-full rounded-lg border-2 border-gray-200 shadow-sm focus:border-orange-500 focus:ring-2 focus:ring-orange-200 px-4 py-2.5 text-gray-700 transition"
                           max="{{ now()->format('Y-m-d') }}">
                </div>
                <div>
                    <label for="end_date" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-calendar-check mr-2 text-orange-500"></i>Tanggal Akhir
                    </label>
                    <input type="date" 
                           id="end_date" 
                           name="end_date" 
                           value="{{ old('end_date', $endDate) }}"
                           class="w-full rounded-lg border-2 border-gray-200 shadow-sm focus:border-orange-500 focus:ring-2 focus:ring-orange-200 px-4 py-2.5 text-gray-700 transition"
                           max="{{ now()->format('Y-m-d') }}">
                </div>
                <div>
                    <label for="action" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-tasks mr-2 text-orange-500"></i>Jenis Aksi
                    </label>
                    <select id="action" 
                            name="action" 
                            class="w-full rounded-lg border-2 border-gray-200 shadow-sm focus:border-orange-500 focus:ring-2 focus:ring-orange-200 px-4 py-2.5 text-gray-700 transition">
                        <option value="">Semua Aksi</option>
                        @foreach($availableActions as $act)
                            <option value="{{ $act }}" {{ $action == $act ? 'selected' : '' }}>{{ $act }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="target_table" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-database mr-2 text-orange-500"></i>Tabel Target
                    </label>
                    <select id="target_table" 
                            name="target_table" 
                            class="w-full rounded-lg border-2 border-gray-200 shadow-sm focus:border-orange-500 focus:ring-2 focus:ring-orange-200 px-4 py-2.5 text-gray-700 transition">
                        <option value="">Semua Tabel</option>
                        @foreach($availableTables as $table)
                            <option value="{{ $table }}" {{ $targetTable == $table ? 'selected' : '' }}>{{ $table }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="user_id" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-user-shield mr-2 text-orange-500"></i>Pengguna (Admin)
                    </label>
                    <select id="user_id" 
                            name="user_id" 
                            class="w-full rounded-lg border-2 border-gray-200 shadow-sm focus:border-orange-500 focus:ring-2 focus:ring-orange-200 px-4 py-2.5 text-gray-700 transition">
                        <option value="">Semua Pengguna</option>
                        @foreach($availableUsers as $user)
                            <option value="{{ $user->id }}" {{ (string) $userId === (string) $user->id ? 'selected' : '' }}>
                                {{ $user->name }} {{ $user->email ? '(' . $user->email . ')' : '' }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="flex gap-3">
                <button type="submit" class="px-8 py-2.5 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white rounded-lg font-semibold shadow-md hover:shadow-lg transition-all duration-200 flex items-center justify-center gap-2">
                    <i class="fas fa-filter"></i>
                    <span>Filter</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
        <!-- Top Actions -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-chart-bar text-orange-500"></i>
                Aktivitas Berdasarkan Aksi
            </h3>
            <div class="space-y-3">
                @forelse($logsByAction as $log)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                        <span class="text-sm font-medium text-gray-700">{{ $log->action }}</span>
                        <span class="px-3 py-1 bg-orange-100 text-orange-700 rounded-full text-sm font-semibold">
                            {{ number_format($log->count, 0, ',', '.') }}
                        </span>
                    </div>
                @empty
                    <p class="text-sm text-gray-500 text-center py-4">Tidak ada data</p>
                @endforelse
            </div>
        </div>

        <!-- Top Tables -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-table text-orange-500"></i>
                Aktivitas Berdasarkan Tabel
            </h3>
            <div class="space-y-3">
                @forelse($logsByTable as $log)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                        <span class="text-sm font-medium text-gray-700">{{ $log->target_table }}</span>
                        <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-semibold">
                            {{ number_format($log->count, 0, ',', '.') }}
                        </span>
                    </div>
                @empty
                    <p class="text-sm text-gray-500 text-center py-4">Tidak ada data</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Activity Logs Table -->
    <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                <i class="fas fa-list text-orange-500"></i>
                Daftar Aktivitas
            </h3>
        </div>
        
        <!-- Desktop/tablet table -->
        <div class="overflow-x-auto hidden md:block">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Waktu</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">User</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Aksi</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Tabel</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Deskripsi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($activityLogs as $log)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 font-medium">
                                    {{ $log->created_at->format('d M Y') }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ $log->created_at->format('H:i:s') }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-orange-100 flex items-center justify-center">
                                            <i class="fas fa-user text-orange-600"></i>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $log->user->name ?? 'System' }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            {{ $log->user->email ?? '-' }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $actionColors = [
                                        'Tambah' => 'bg-green-100 text-green-800',
                                        'Ubah' => 'bg-blue-100 text-blue-800',
                                        'Hapus' => 'bg-red-100 text-red-800',
                                        'Update' => 'bg-yellow-100 text-yellow-800',
                                    ];
                                    $colorClass = 'bg-gray-100 text-gray-800';
                                    foreach($actionColors as $key => $color) {
                                        if(stripos($log->action, $key) !== false) {
                                            $colorClass = $color;
                                            break;
                                        }
                                    }
                                @endphp
                                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $colorClass }}">
                                    {{ $log->action }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-lg text-xs font-medium">
                                    {{ $log->target_table }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900 max-w-md">
                                    {{ $log->description }}
                                </div>
                                @if($log->target_id)
                                    <div class="text-xs text-gray-500 mt-1">
                                        ID: {{ $log->target_id }}
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fas fa-inbox text-4xl text-gray-300 mb-4"></i>
                                    <p class="text-gray-500 text-lg font-medium">Tidak ada aktivitas ditemukan</p>
                                    <p class="text-gray-400 text-sm mt-2">Coba ubah filter tanggal atau kriteria pencarian</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile list -->
        <div class="md:hidden divide-y">
            @forelse($activityLogs as $log)
            <div class="p-4 flex items-start gap-3">
                <div class="flex-shrink-0">
                    <div class="h-10 w-10 rounded-full bg-orange-100 flex items-center justify-center">
                        <i class="fas fa-user text-orange-600"></i>
                    </div>
                </div>
                <div class="min-w-0 flex-1">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-semibold text-gray-900 truncate">{{ $log->user->name ?? 'System' }}</p>
                        <span class="ml-2 px-2 py-0.5 rounded-full text-[11px] font-semibold bg-gray-100 text-gray-700">{{ $log->target_table }}</span>
                    </div>
                    <p class="text-[11px] text-gray-500 mt-0.5">{{ $log->user->email ?? '-' }}</p>
                    <div class="mt-2 flex items-center gap-2">
                        @php
                            $actionColors = [
                                'Tambah' => 'bg-green-100 text-green-800',
                                'Ubah' => 'bg-blue-100 text-blue-800',
                                'Hapus' => 'bg-red-100 text-red-800',
                                'Update' => 'bg-yellow-100 text-yellow-800',
                            ];
                            $colorClass = 'bg-gray-100 text-gray-800';
                            foreach($actionColors as $key => $color) {
                                if(stripos($log->action, $key) !== false) { $colorClass = $color; break; }
                            }
                        @endphp
                        <span class="px-2 py-0.5 rounded-full text-[11px] font-semibold {{ $colorClass }}">{{ $log->action }}</span>
                        <span class="text-[11px] text-gray-500">{{ $log->created_at->format('d M Y H:i') }}</span>
                    </div>
                    <p class="text-sm text-gray-800 mt-2">{{ $log->description }}</p>
                </div>
            </div>
            @empty
            <div class="p-6 text-center text-sm text-gray-500">Tidak ada aktivitas ditemukan</div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($activityLogs->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                {{ $activityLogs->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</div>

@push('styles')
<style>
    /* Custom pagination styling */
    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 0.5rem;
    }
    
    .pagination a,
    .pagination span {
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.2s;
    }
    
    .pagination a {
        background-color: white;
        color: #f97316;
        border: 1px solid #e5e7eb;
    }
    
    .pagination a:hover {
        background-color: #f97316;
        color: white;
        border-color: #f97316;
    }
    
    .pagination span {
        background-color: #f97316;
        color: white;
        border: 1px solid #f97316;
    }
</style>
@endpush
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('filterForm');
    if (!form) return;
    const ids = ['start_date','end_date','action','target_table','user_id'];
    const elements = ids
        .map(id => document.getElementById(id))
        .filter(Boolean);

    // Auto submit on change
    elements.forEach(el => {
        el.addEventListener('change', () => {
            form.requestSubmit ? form.requestSubmit() : form.submit();
        });
    });

    // Submit on Enter for any input within form
    form.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            form.requestSubmit ? form.requestSubmit() : form.submit();
        }
    });
});
</script>
@endpush
@endsection

