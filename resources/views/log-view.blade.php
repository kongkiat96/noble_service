<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Logs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.6/dist/sweetalert2.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .log-container {
            max-height: 100%;
            overflow-y: scroll;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 8px;
            border: 1px solid #ddd;
        }
        pre {
            background-color: #343a40;
            color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            white-space: pre-wrap;
            word-wrap: break-word;
        }
        .log-filter {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>View Logs {{ $year }}/{{ $month }}/{{ $day }}</h2>

       <hr>

        <div class="log-container">
            <pre id="log-contents">{{ $logs }}</pre>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
</body>
</html>
