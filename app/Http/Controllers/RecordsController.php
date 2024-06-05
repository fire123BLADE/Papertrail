<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\Document;

class RecordsController extends Controller
{
    public function showRecords(Request $request)
    {
        // Initialize query
        $query = DB::table('user')
                   ->join('document', 'user.UserID', '=', 'document.UserID')
                   ->select(
                       'user.UserID',
                       'document.Document_ID',
                       'document.Subject',
                       'document.RecipientEmail',
                       'document.Date',
                       'document.FileName',
                       'document.status'
                   );

        // Apply search filter
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('user.UserID', 'LIKE', "%{$search}%")
                  ->orWhere('document.Document_ID', 'LIKE', "%{$search}%");
            });
        }

        // Apply sorting
        $sortBy = $request->input('sort_by', 'Date');
        $sortOrder = $request->input('sort_order', 'asc');
        $query->orderBy($sortBy, $sortOrder);

        $records = $query->get();

        foreach ($records as $record) {
            $document = Document::find($record->Document_ID);
            $record->fileUrl = Storage::url('documents/' . $record->FileName);
        }

        // Group records by subject and date
        $groupedRecords = $records->groupBy(function ($item) {
            return $item->Subject . '|' . $item->Date;
        });

        return view('records', compact('groupedRecords'));
    }

    public function view($filename)
    {
        $document = Document::where('FileName', $filename)->firstOrFail();
        $fileUrl = Storage::url('documents/' . $document->FileName);

        return view('document', compact('document', 'fileUrl'));
    }

    public function updateStatus(Request $request, $documentId) {
        $document = Document::where('Document_ID', $documentId)->first();
    
        if (!$document) {
            return response()->json(['success' => false, 'message' => 'Document not found'], 404);
        }
    
        $action = $request->input('action');
        if ($action === 'approve') {
            $document->status = 'approved';
        } elseif ($action === 'disapprove') {
            $document->status = 'disapproved';
        } else {
            return response()->json(['success' => false, 'message' => 'Invalid action'], 400);
        }
    
        $document->save();
    
        return response()->json(['success' => true, 'message' => 'Document status updated']);
    }
    


}
