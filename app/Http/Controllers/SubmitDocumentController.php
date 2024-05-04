<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SubmitDocumentController extends Controller
{


    public function showSubmitForm()
    {
        return view('submit_document');
        
    }

    public function submit(Request $request)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'recipient_email' => 'required|email',
            'document_description' => 'required',
            'file' => 'required|file|max:25000', // Max size in KB (25 MB)
            'department' => 'required'
        ]);

        // Store the uploaded file
        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();
        $file->storeAs('documents', $fileName); // Store in storage/app/documents folder

        // Send the email
        $recipientEmail = $validatedData['recipient_email'];
        $subject = $validatedData['document_description'];
        $department = $validatedData['department'];
        $messageBody = $request->input('message_body');

        Mail::raw($messageBody, function ($message) use ($recipientEmail, $subject, $department, $fileName) {
            $message->to($recipientEmail)
                    ->subject($subject)
                    ->attach(storage_path('app/documents/'.$fileName));
        });

        return redirect()->back()->with('success', 'Document submitted successfully!');
    }
}