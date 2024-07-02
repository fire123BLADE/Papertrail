<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
    body {
      background-color: #f0f2f5;
      background-image: url('submit1.svg');
      background-size: cover;
      background-repeat: no-repeat;
      height: 100vh;
    }

    .container {
      max-width: 500px;
      margin: 50px auto;
      padding: 20px 30px;
      border-radius: 8px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0);
      background-color: #dee2e6;
    }

    .form-group {
      margin-bottom: 20px;
    }

    label {
      font-weight: bold;
    }

    input[type="text"],
    input[type="file"],
    select {
      width: 100%;
      padding: 10px;
      border: 1px solid #ced4da;
      border-radius: 5px;
      transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    input[type="text"]:focus,
    input[type="file"]:focus,
    select:focus {
      border-color: #4d94ff;
      outline: 0;
      box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    input[type="submit"] {
      width: 100%;
      padding: 10px;
      border: none;
      border-radius: 5px;
      background-color: #007bff;
      color: #fff;
      cursor: pointer;
      transition: background-color 0.15s ease-in-out;
    }

    input[type="submit"]:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>
<div class="container">
        <div class="d-flex justify-content-between mb-3">
            <!-- Return button -->
            <a href="{{('/dashboard') }}" class="btn btn-secondary">Return to Dashboard</a>
            <div></div> <!-- Placeholder for spacing -->
        </div>
    <div class="container">
        <h2 class="mb-4">Upload Document</h2>
        <form action="{{ route('submitDocument') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="recipient_email">To:</label>
                <textarea id="recipient_email" name="recipient_email" class="form-control" placeholder="Recipient's email (comma-separated)"></textarea>
            </div>
            <div class="form-group">
                <label for="document_description">Subject:</label>
                <input type="text" id="document_description" name="document_description" class="form-control" placeholder="Enter subject">
            </div>
            <div class="form-group">
                <label for="file">Document:</label>
                <input type="file" id="file" name="file" class="form-control-file">
            </div>
            <div class="form-group">
            <label for="message_body">Message Body:</label>
            <textarea id="message_body" name="message_body" class="form-control" placeholder="Message body"></textarea>
            </div>
            <div class="form-group">
                <label for="department">Document Type:</label>
                <select id="department" name="department" class="form-control">
                    <option value="GM">Good Moral</option>
                    <option value="TOR">Transcript Of Records (TOR)</option>
                    <option value="COE">Certificate of Enrollment</option>
                    <option value="F1">Form 1</option>
                    <option value="Leave">File Leave</option>
                </select>
            </div>
        
            <input type="submit" class="btn btn-primary" value="Submit">
        </form>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Check if success message exists
            var successMessage = '{{ session("success") }}';
            if (successMessage) {
                // Create success message box
                var successBox = document.createElement('div');
                successBox.className = 'alert alert-success';
                successBox.textContent = successMessage;
                document.body.appendChild(successBox);
                
                // Automatically hide the success message after 3 seconds
                setTimeout(function () {
                    successBox.style.display = 'none';
                }, 3000);
            }
        });
    </script>
</body>
</html>