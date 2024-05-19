<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class RecordsController extends Controller
{
    public function showRecords()
    {
        $records = DB::table('user')
                    ->join('document', 'user.UserID', '=', 'document.UserID') // Adjust the foreign key as needed
                    ->select('user.UserID', 'document.Document_ID', 'document.Subject', 'document.RecipientEmail', 'document.Date')//, 'document.status')
                    ->get();

        return view('records', compact('records'));
    }
}

