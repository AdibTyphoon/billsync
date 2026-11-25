<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BillerController extends Controller
{
    public function index() 
    {
        // 1. Tarik Master List dari Admin untuk form Dropdown
        $masterBillers = DB::table('billers')->get();

        // 2. Tarik langganan spesifik milik user yang login (User ID)
        $userBillers = DB::table('user_billers')
            ->join('billers', 'user_billers.biller_id', '=', 'billers.biller_id')
            ->where('user_billers.user_id', Auth::id())
            ->select('user_billers.id as pivot_id', 'billers.biller_name', 'billers.category', 'billers.sender_email', 'user_billers.status') 
            ->get();

        return view('monitored-billers', compact('userBillers', 'masterBillers'));
    }

    public function store(Request $request)
    {
        // Semak supaya tak langgan syarikat yang sama dua kali
        $exists = DB::table('user_billers')
            ->where('user_id', Auth::id())
            ->where('biller_id', $request->biller_id)
            ->exists();

        if ($exists) {
            return back()->with('error', 'You are already monitoring this biller.');
        }

        DB::table('user_billers')->insert([
            'user_id' => Auth::id(),
            'biller_id' => $request->biller_id,
            // 'status' => 'pending',
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // return back()->with('success', 'Biller successfully linked! Awaiting verification.');
        return back()->with('success', 'Biller successfully linked and active!');
    }

    public function destroy($id)
    {
        // Padam langganan user tanpa usik Master List Admin
        DB::table('user_billers')
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->delete();
            
        return back()->with('success', 'Biller monitoring successfully stopped!');
    }
}