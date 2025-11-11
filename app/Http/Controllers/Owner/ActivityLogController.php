<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ActivityLog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ActivityLogController extends Controller
{
    /**
     * Laporan Aktivitas Sistem (Owner)
     * Owner dapat membaca log seluruh aktivitas penting di sistem (update data, tambah, hapus) sepanjang waktu tertentu.
     */
    public function index(Request $request)
    {
        // Default filter: 30 hari terakhir
        $startDate = $request->input('start_date', now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->format('Y-m-d'));
        $action = $request->input('action', '');
        $targetTable = $request->input('target_table', '');
        $userId = $request->input('user_id', '');
        
        try {
            $start = Carbon::parse($startDate);
            $end = Carbon::parse($endDate);
        } catch (\Exception $e) {
            $startDate = now()->subDays(30)->format('Y-m-d');
            $endDate = now()->format('Y-m-d');
            $start = Carbon::parse($startDate);
            $end = Carbon::parse($endDate);
        }
        
        // Validasi: end_date harus >= start_date
        if ($end->lt($start)) {
            $end = $start->copy();
            $endDate = $end->format('Y-m-d');
        }
        
        // Query activity logs dengan filter
        $query = ActivityLog::with('user')
            ->whereBetween('created_at', [
                $start->startOfDay(),
                $end->endOfDay()
            ]);
        
        // Filter by action
        if ($action) {
            $query->where('action', 'like', '%' . $action . '%');
        }
        
        // Filter by target table
        if ($targetTable) {
            $query->where('target_table', $targetTable);
        }
        
        // Filter by user
        if ($userId) {
            $query->where('user_id', $userId);
        }
        
        // Get unique actions and tables for filter dropdowns
        $availableActions = ActivityLog::select('action')
            ->distinct()
            ->orderBy('action')
            ->pluck('action')
            ->toArray();
        
        $availableTables = ActivityLog::select('target_table')
            ->distinct()
            ->orderBy('target_table')
            ->pluck('target_table')
            ->toArray();
        
        $availableUsers = User::whereHas('role', function ($query) {
                $query->where('name', 'admin');
            })
            ->orderBy('name')
            ->get(['id', 'name', 'email']);
        
        // Paginate results
        $activityLogs = $query->latest('created_at')->paginate(50);
        
        // Statistics
        $totalLogs = ActivityLog::whereBetween('created_at', [
            $start->startOfDay(),
            $end->endOfDay()
        ])->count();
        
        $logsByAction = ActivityLog::select('action', DB::raw('count(*) as count'))
            ->whereBetween('created_at', [
                $start->startOfDay(),
                $end->endOfDay()
            ])
            ->groupBy('action')
            ->orderBy('count', 'desc')
            ->get();
        
        $logsByTable = ActivityLog::select('target_table', DB::raw('count(*) as count'))
            ->whereBetween('created_at', [
                $start->startOfDay(),
                $end->endOfDay()
            ])
            ->groupBy('target_table')
            ->orderBy('count', 'desc')
            ->get();
        
        return view('owner.activity-logs.index', compact(
            'activityLogs',
            'startDate',
            'endDate',
            'action',
            'targetTable',
            'userId',
            'availableActions',
            'availableTables',
            'availableUsers',
            'totalLogs',
            'logsByAction',
            'logsByTable'
        ));
    }

    /**
     * Download Activity Logs as PDF
     */
    public function downloadPdf(Request $request)
    {
        $startDate = $request->input('start_date', now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->format('Y-m-d'));
        $action = $request->input('action', '');
        $targetTable = $request->input('target_table', '');
        $userId = $request->input('user_id', '');

        try {
            $start = Carbon::parse($startDate);
            $end = Carbon::parse($endDate);
        } catch (\Exception $e) {
            $startDate = now()->subDays(30)->format('Y-m-d');
            $endDate = now()->format('Y-m-d');
            $start = Carbon::parse($startDate);
            $end = Carbon::parse($endDate);
        }
        if ($end->lt($start)) {
            $end = $start->copy();
            $endDate = $end->format('Y-m-d');
        }

        $query = ActivityLog::with('user')
            ->whereBetween('created_at', [$start->startOfDay(), $end->endOfDay()]);
        if ($action) $query->where('action', 'like', '%' . $action . '%');
        if ($targetTable) $query->where('target_table', $targetTable);
        if ($userId) $query->where('user_id', $userId);

        $activityLogs = $query->latest('created_at')->get();

        if ($activityLogs->count() === 0) {
            return redirect()->route('owner.activity-logs.index', [
                'start_date' => $startDate,
                'end_date' => $endDate,
                'action' => $action,
                'target_table' => $targetTable,
                'user_id' => $userId
            ])->with('error', 'Tidak ada data aktivitas untuk filter tersebut.');
        }

        $pdf = Pdf::loadView('owner.activity-logs.pdf', compact(
            'activityLogs','startDate','endDate','action','targetTable'
        ))->setPaper('a4', 'portrait');

        $filename = 'laporan-aktivitas-' . $start->format('Ymd') . '-' . $end->format('Ymd') . '.pdf';
        return $pdf->download($filename);
    }
}

