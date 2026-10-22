<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        // Tarik semua senarai syarikat dari Master List
        $billers = DB::table('billers')->get();
        
        // Tarik senarai langganan user yang berstatus 'pending'
        $pendingSubscriptions = DB::table('user_billers')
            ->join('users', 'user_billers.user_id', '=', 'users.user_id')
            ->join('billers', 'user_billers.biller_id', '=', 'billers.biller_id')
            ->select('user_billers.id as sub_id', 'users.name as user_name', 'billers.biller_name', 'user_billers.created_at')
            ->where('user_billers.status', 'pending')
            ->get();
            
        // Hantar data ke fail admin-portal.blade.php
        return view('admin-portal', compact('billers', 'pendingSubscriptions')); 
    }

    public function store(Request $request)
    {
        // Masukkan rekod syarikat baru ke dalam database utama
        DB::table('billers')->insert([
            'biller_name' => $request->biller_name,
            'sender_email' => $request->email,
            'category' => $request->category,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return back()->with('success', 'New master biller successfully added to the system!');
    }

    // Fungsi untuk Kemaskini (Update) Biller & Regex
    public function update(Request $request, $id)
    {
        DB::table('billers')->where('biller_id', $id)->update([
            'biller_name' => $request->biller_name,
            'sender_email' => $request->email,
            'category' => $request->category,
            'amount_regex' => $request->amount_regex,
            'date_regex' => $request->date_regex,
            'updated_at' => now()
        ]);

        return back()->with('success', 'Biller configuration and Regex rules updated successfully!');
    }

    // Fungsi untuk Padam (Delete) Biller
    public function destroy($id)
    {
        // 1. Padam langganan user (pivot) dulu supaya tak sangkut error Foreign Key
        DB::table('user_billers')->where('biller_id', $id)->delete();
        
        // 2. Baru padam syarikat dari Master List
        DB::table('billers')->where('biller_id', $id)->delete();
            
        return back()->with('success', 'Master Biller successfully deleted!');
    }

    // Luluskan langganan (Tukar pending jadi active)
    public function approve($id)
    {
        DB::table('user_billers')->where('id', $id)->update([
            'status' => 'active',
            'updated_at' => now()
        ]);
        return back()->with('success', 'User subscription officially approved!');
    }

    // Tolak langganan (Padam rekod dari user_billers)
    public function reject($id)
    {
        DB::table('user_billers')->where('id', $id)->delete();
        return back()->with('success', 'User subscription rejected and removed.');
    }
}