<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\Document;
use App\Models\Archive;

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
    
    

    public function showArchive()
    {
        $archivedDocuments = Archive::all();
        $records = Document::all();

        $groupedRecords = $records->groupBy(function ($item) {  
            return $item->Subject . '|' . $item->Date;
        });
    
        return view('archive', compact('groupedRecords'));
        return view('archive', compact('archivedDocuments'));
    }
    
    public function archiveDocuments()
    {
    // Find documents to archive based on new conditions
    $documentsToArchive = Document::where(function ($query) {
        // Condition 1: Records with the same 'Subject', 'Date' that all have "approved" status
        $query->whereExists(function ($subQuery) {
            $subQuery->from('document as d2')
                     ->whereRaw('document.Subject = d2.Subject')
                     ->whereRaw('document.Date = d2.Date')
                     ->where('d2.status', '=', 'approved');
        })
        ->whereNotExists(function ($subQuery) {
            $subQuery->from('document as d3')
                     ->whereRaw('document.Subject = d3.Subject')
                     ->whereRaw('document.Date = d3.Date')
                     ->where('d3.status', '<>', 'approved');
        });

        // Condition 2: Records with NULL status for 15 days or more
        $query->orWhere(function ($subQuery) {
            $subQuery->whereNull('status')
                     ->whereRaw('DATEDIFF(NOW(), Date) > 15');
        });

        // Condition 3: Records with the same 'Subject', 'Date' but with 1 or more "disapproved" status
        $query->orWhereExists(function ($subQuery) {
            $subQuery->from('document as d4')
                     ->whereRaw('document.Subject = d4.Subject')
                     ->whereRaw('document.Date = d4.Date')
                     ->where('d4.status', '=', 'disapproved');
        });
    })->get();

    // Archive each eligible document
    foreach ($documentsToArchive as $document) {
        // Create an archive entry
        Archive::create([
            'Document_ID' => $document->Document_ID,
            'Subject' => $document->Subject,
            'RecipientEmail' => $document->RecipientEmail,
            'DateModified' => now(), // Assuming you want to timestamp the archive action
            'DocumentType' => $document->DocumentType // Adjust based on your document types
        ]);
    }

    // Optionally, return a response or redirect
    return response()->json(['success' => true, 'message' => 'Documents archived successfully']);
}
    public function dashboard()
    {
    $recentDocuments = Document::orderBy('Date', 'desc')->take(3)->get();
    
    // Other data you may want to pass to the view
    $totalDocuments = Document::count();
    $pendingDocuments = Document::where ('status')->count();
    $approvedDocuments = Document::where('status', 'approved')->count();
    $archivedDocuments = Archive::count(); // Count of archived documents

    return view('dash', [
        'recentDocuments' => $recentDocuments,
        'totalDocuments' => $totalDocuments,
        'pendingDocuments' => $pendingDocuments,
        'approvedDocuments' => $approvedDocuments,
        'archivedDocuments' => $archivedDocuments,
        // Other variables you need to pass to the view
    ]);
    }

}
