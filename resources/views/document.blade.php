<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document Details</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
<div class="container mt-5">
    <h2>Document Details</h2>
    <div class="card">
        <div class="card-body">
            <p><strong>Document ID:</strong> {{ $document->Document_ID }}</p>
            <p><strong>Subject:</strong> {{ $document->Subject }}</p>
            <p><strong>Recipient Email:</strong> {{ $document->RecipientEmail }}</p>
            <p><strong>Date:</strong> {{ $document->Date }}</p>
            <p><strong>Document File: </strong>{{ $document->FileName }}</p>
            <div id="iframe-container">
                <iframe id="document-iframe" src="{{ $fileUrl }}" style="border: none; width: 100%; height: 600px;"></iframe>
            </div>
            <div class="mt-3">
                <button class="btn btn-success" onclick="handleApprove({{ $document->Document_ID }})">Approve</button>
                <button class="btn btn-danger" onclick="handleDisapprove({{ $document->Document_ID }})">Disapprove</button>
            </div>
        </div>
    </div>
    <a href="{{ route('records') }}" class="btn btn-secondary mt-3">Back to Records</a>
</div>
<script>
     function handleApprove(documentId) {
        updateDocumentStatus(documentId, 'approve');
    }

    function handleDisapprove(documentId) {
        updateDocumentStatus(documentId, 'disapprove');
    }

    function updateDocumentStatus(documentId, action) {
        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch(`/documents/${documentId}/status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ action: action })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(`Document ${action}d successfully`);
                // Optionally redirect back to the records page or update UI
                window.location.href = '{{ route('records') }}';
            } else {
                alert('Failed to update document status');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while updating document status');
        });
    }

    window.addEventListener("DOMContentLoaded", function() {
        var iframe = document.getElementById('document-iframe');
        var iframeContainer = document.getElementById('iframe-container');
        
        // Check if iframe element is not null
        if (iframe) {
            iframe.addEventListener('load', function() {
                var iframeDocument = iframe.contentDocument || iframe.contentWindow.document;
                var iframeWidth = iframeDocument.body.scrollWidth || iframeDocument.documentElement.scrollWidth;
                var iframeHeight = iframeDocument.body.scrollHeight || iframeDocument.documentElement.scrollHeight;

                iframe.style.width = iframeWidth + 'px';
                iframe.style.height = iframeHeight + 'px';
                iframeContainer.style.overflow = 'auto'; // Enable scrolling if the document is larger than the iframe
            });
        }
    });
</script>
</body>
</html>
