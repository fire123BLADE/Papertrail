<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Document;

class DocumentApproval extends Mailable
{
    use Queueable, SerializesModels;

    public $document;
    public $approvalLink;
    public $disapprovalLink;
    public $messageBody;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($document, $approvalLink, $disapprovalLink, $messageBody)
    {
        $this->document = $document;
        $this->approvalLink = $approvalLink;
        $this->disapprovalLink = $disapprovalLink;
        $this->messageBody = $messageBody;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // Check if the document is already approved or disapproved
        if ($this->document->status === 'approved' || $this->document->status === 'disapproved') {
            $this->approvalLink = null;
            $this->disapprovalLink = null;
        }

        return $this->view('emails.document_approval')
                    ->attach(public_path('storage/documents/' . $this->document->path)) // Assuming your document is stored in storage/app
                    ->with([
                        'approvalLink' => $this->approvalLink,
                        'disapprovalLink' => $this->disapprovalLink,
                        'messageBody' => $this->messageBody
                    ]);
    }
}
