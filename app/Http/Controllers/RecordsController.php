<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class RecordsController extends Controller
{
    public function showRecords(Request $request)
    {
        // Initialize query
        $query = DB::table('user')
                   ->join('document', 'user.UserID', '=', 'document.UserID') // Adjust the foreign key as needed
                   ->select('user.UserID', 'document.Document_ID', 'document.Subject', 'document.RecipientEmail', 'document.Date'); // Add more columns if needed

        // Apply search filter
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('user.UserID', 'LIKE', "%{$search}%")
                  ->orWhere('document.RecipientEmail', 'LIKE', "%{$search}%");
            });
        }

        // Apply sorting
        $sortBy = $request->input('sort_by', 'Date');
        $sortOrder = $request->input('sort_order', 'asc');
        $query->orderBy($sortBy, $sortOrder);

        // Get the results
        $records = $query->get();

        return view('records', compact('records'));
    }
}
