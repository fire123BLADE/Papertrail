<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Announcement;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class AnnouncementController extends Controller
{
    public function showSubmitForm()
    {
        return view('announce');
    }

    public function submit(Request $request)
    {
        // Validate announcement data
        $validatedData = $request->validate([
            'announcement_title' => 'required|string|max:255',
            'announcement_message' => 'required|string',
            'recipient_email' => 'required|string'
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

        // Loop through recipients
        foreach ($recipientEmails as $recipientEmail) {
            // Send email
            $subject = $validatedData['announcement_title'];
            $messageBody = $validatedData['announcement_message'];

            try {
                Mail::raw($messageBody, function ($message) use ($recipientEmail, $subject) {
                    $message->to($recipientEmail)
                            ->subject($subject);
                });
                Log::info('Email sent to: ' . $recipientEmail);
            } catch (\Exception $e) {
                Log::error('Failed to send email to: ' . $recipientEmail . ' Error: ' . $e->getMessage());
            }
        }

        return redirect()->back()->with('success', 'Announcement sent successfully!');
    }
}
