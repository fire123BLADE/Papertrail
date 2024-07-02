<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;

class DocumentController extends Controller 
{
    public function approve(Request $request)
    {
        $subject = $request->query('subject');
        $email = $request->query('email');

        // Find the document based on subject and RecipientEmail
        $document = Document::where('Subject', $subject)
                            ->where('RecipientEmail', $email)
                            ->firstOrFail();

        // Check if the document is already approved
        if ($document->status === 'approved') {
            return view('approval_status', ['status' => 'Already approved']);
        }

        // Update document status only if it's not already approved
        if ($document->status !== 'disapproved') {
            $document->status = 'approved';
            $document->save();
        }

        return view('approval_status', ['status' => 'approved']);
    }

    public function disapprove(Request $request)
    {
        $subject = $request->query('subject');
        $email = $request->query('email');

        // Find the document based on subject and RecipientEmail
        $document = Document::where('Subject', $subject)
                            ->where('RecipientEmail', $email)
                            ->firstOrFail();

        // Check if the document is already disapproved
        if ($document->status === 'disapproved') {
            return view('approval_status', ['status' => 'Already disapproved']);
        }

        // Update document status only if it's not already disapproved
        if ($document->status !== 'approved') {
            $document->status = 'disapproved';
            $document->save();
        }

        return view('approval_status', ['status' => 'disapproved']);
    }
}
