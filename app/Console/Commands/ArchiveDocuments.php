<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Document;
use App\Models\Archive;
use Illuminate\Support\Facades\Log;

class ArchiveDocuments extends Command
{
    protected $signature = 'documents:archive';

    protected $description = 'Archive documents based on specified conditions';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {// Find documents to archive based on new conditions
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
        // Check if the document is already archived
        $existingArchive = Archive::where('Document_ID', $document->Document_ID)->first();

        if (!$existingArchive) {
            // Create an archive entry if it doesn't exist
            Archive::create([
                'Document_ID' => $document->Document_ID,
                'Subject' => $document->Subject,
                'RecipientEmail' => $document->RecipientEmail,
                'DateModified' => now(), // Assuming you want to timestamp the archive action
                'DocumentType' => $document->DocumentType, // Adjust based on your document types
                'status' => $document->status // Include the status in the archive
            ]);
        }
    }
}

}
