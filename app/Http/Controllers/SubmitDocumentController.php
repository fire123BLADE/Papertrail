<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Document;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class SubmitDocumentController extends Controller
{
    public function showSubmitForm()
    {
        return view('submit-document');
    }

    public function submit(Request $request)
    {
        // Initial validation
        $validatedData = $request->validate([
            'recipient_email' => 'required|string',
            'document_description' => 'required|string|max:255',
            'file' => 'required|file|max:25000', // Max size in KB (25 MB)
            'department' => 'required|string|max:255',
            'message_body' => 'nullable|string'
        ]);

        // Split and trim the string of email addresses into an array
        $recipientEmails = array_map('trim', explode(',', $validatedData['recipient_email']));

        // Validate each email address
        foreach ($recipientEmails as $email) {
            $emailValidator = Validator::make(['email' => $email], ['email' => 'required|email']);
            if ($emailValidator->fails()) {
                Log::error('Invalid email address: ' . $email);
                return redirect()->back()->withErrors(['recipient_email' => 'One or more email addresses are invalid'])->withInput();
            }
        }

        // Store the uploaded file
        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();
        $filePath = $file->storeAs('public/documents', $fileName); // Store in public/documents folder
        $filePath = Storage::url($filePath);

        // Get the ID of the authenticated user
        $userID = session('user_id') ?? auth()->id();

        foreach ($recipientEmails as $recipientEmail) {
            Log::info('Processing email for recipient: ' . $recipientEmail);

            // Save document details into the database
            $document = new Document();
            $document->Subject = $validatedData['document_description'];
            $document->DocumentType = $validatedData['department'];
            $document->Date = now();
            $document->RecipientEmail = $recipientEmail;
            $document->UserID = $userID; 
            $document->FileName = $fileName;
            $document->save();

            // Generate approval and disapproval links
            $approvalLink = route('documents.approve', ['subject' => $document->Subject, 'email' => $recipientEmail]);
            $disapprovalLink = route('documents.disapprove', ['subject' => $document->Subject, 'email' => $recipientEmail]);


            // Send the email
            $subject = $validatedData['document_description'];
            $messageBody = $request->input('message_body', '');

            try {
                Mail::send('emails.document_approval', [
                    'document' => $document,
                    'approvalLink' => $approvalLink,
                    'disapprovalLink' => $disapprovalLink,
                    'messageBody' => $messageBody
                ], function ($message) use ($recipientEmail, $subject, $filePath) {
                    $message->to($recipientEmail)
                            ->subject($subject)
                            ->attach(public_path($filePath));
                });
                Log::info('Email sent to: ' . $recipientEmail);
            } catch (\Exception $e) {
                Log::error('Failed to send email to: ' . $recipientEmail . ' Error: ' . $e->getMessage());
            }
        }

        return redirect()->back()->with('success', 'Document submitted successfully!');
    }
}
