<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\Document; // Import the Document model

class SubmitDocumentController extends Controller
{
    public function showSubmitForm()
    {
        return view('submit-document');
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

        //$userId = Auth::id(); // Get the ID of the authenticated user
        $userID = session('user_id');
        
        // Save document details into the database
        $document = new Document();
        $document->Subject = $validatedData['document_description'];
        $document->DocumentType = $validatedData['department'];
        $document->Date = now(); // Current date
        $document->RecipientEmail = $validatedData['recipient_email'];
        $document->UserID = $userID; // Assign the user ID
        $document->save();

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
