<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Announcement</title>
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
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
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
    select,
    textarea {
      width: 100%;
      padding: 10px;
      border: 1px solid #ced4da;
      border-radius: 5px;
      transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    input[type="text"]:focus,
    input[type="file"]:focus,
    select:focus,
    textarea:focus {
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

    #backButton {
      display: inline-block;
      margin-bottom: 20px;
      padding: 10px 20px;
      background-color: #6c757d;
      color: white;
      text-align: center;
      text-decoration: none;
      font-size: 16px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    #backButton:hover {
      background-color: #5a6268;
    }
  </style>
</head>
<body>
  <div class="container">
    <button id="backButton" onclick="goBack()">Back</button>
    <h2 class="mb-4">Admin Announcement</h2>
    <form action="{{ route('submitAnnouncement') }}" method="POST">
      @csrf
      <div class="form-group">
        <label for="announcement_title">Title:</label>
        <input type="text" id="announcement_title" name="announcement_title" class="form-control" placeholder="Announcement Title" required>
      </div>
      <div class="form-group">
        <label for="announcement_message">Message:</label>
        <textarea id="announcement_message" name="announcement_message" class="form-control" rows="5" placeholder="Announcement Message" required></textarea>
      </div>
      <div class="form-group">
        <label for="recipient_email">Recipient Email(s):</label>
        <input type="text" id="recipient_email" name="recipient_email" class="form-control" placeholder="Recipient Email(s), separated by commas" required>
      </div>
      <input type="submit" value="Send Announcement">
    </form>
  </div>

  <script>
    function goBack() {
      window.history.back();
    }
  </script>
</body>
</html>
