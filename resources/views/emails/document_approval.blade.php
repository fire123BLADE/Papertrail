<!DOCTYPE html>
<html>
<head>
    <title>Document Approval</title>
</head>
<body>
    <h2>Document Approval Request</h2>
    <p>Dear recipient,</p>

    <p>{{ $messageBody }}</p>

    @if ($approvalLink)
        <p><a href="{{ $approvalLink }}">Approve Document</a></p>
    @endif

    @if ($disapprovalLink)
        <p><a href="{{ $disapprovalLink }}">Disapprove Document</a></p>
    @endif

    @if ($document->status === 'approved')
        <p>This document has been approved.</p>
    @elseif ($document->status === 'disapproved')
        <p>This document has been disapproved.</p>
    @endif
</body>
</html>
