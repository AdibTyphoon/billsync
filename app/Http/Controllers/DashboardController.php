<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bill; 
use Carbon\Carbon; // Tambah fungsi masa/tarikh

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Tarik senarai bil
        $bills = Bill::with('biller')->orderBy('created_at', 'desc')->get();

        // 2. Kira Jumlah Keseluruhan (Belum Dibayar)
        $totalOutstanding = Bill::where('payment_status', 'unpaid')->sum('amount');

        // 3. FUNGSI BARU: Kira Jumlah Dibayar Bulan Ini
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        
        // TUKAR KAT SINI: Kita guna 'created_at' sebab 'due_date' Apple tu jatuh pada bulan depan (November)
        $totalPaidThisMonth = Bill::where('payment_status', 'paid')
                                  ->whereMonth('created_at', $currentMonth)
                                  ->whereYear('created_at', $currentYear)
                                  ->sum('amount');

        // 4. Sediakan Data Untuk Pie Chart (Analitik)
        $unpaidBills = Bill::with('biller')->where('payment_status', 'unpaid')->get();
        $chartLabels = [];
        $chartValues = [];
        
        $grouped = $unpaidBills->groupBy('biller_id');
        foreach ($grouped as $billerId => $group) {
            $chartLabels[] = $group->first()->biller->biller_name ?? 'Unknown';
            $chartValues[] = $group->sum('amount');
        }

        // Hantar semua data ke Blade
        return view('dashboard', compact('bills', 'totalOutstanding', 'totalPaidThisMonth', 'chartLabels', 'chartValues'));
    }

    public function monitoredBillers()
    {
        $billers = \App\Models\Biller::all();
        return view('monitored-billers', compact('billers'));
    }

    public function adminPortal()
    {
        // if (auth()->user()->role !== 'admin') {
        //     abort(403, 'ACCESS DENIED. You are not an administrator.');
        // }
        return view('admin-portal');
    }
}