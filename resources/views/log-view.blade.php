<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Logs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', system-ui, sans-serif;
            background-color: #f8f9fa;
            color: #212529;
        }
        .log-container {
            height: 75vh;
            overflow-y: auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        pre {
            background-color: #1a1d21;
            color: #e9ecef;
            padding: 20px;
            border-radius: 6px;
            font-family: 'Consolas', monospace;
            font-size: 0.9rem;
            line-height: 1.5;
            margin: 0;
            white-space: pre-wrap;
            word-wrap: break-word;
        }
        .header {
            background-color: #fff;
            padding: 1rem;
            border-bottom: 1px solid #dee2e6;
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .date-badge {
            background-color: #e9ecef;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 500;
            color: #495057;
        }
        .search-box {
            max-width: 300px;
        }
    </style>
</head>
<body>
    <div class="container-fluid py-4">
        <div class="header mb-3 d-flex justify-content-between align-items-center">
            <h4 class="mb-0">{{ $title }}</h4>
            <span class="date-badge">{{ $date  }}</span>
        </div>
        
        <div class="row mb-3">
            <div class="col-md-4">
                <form action="{{ url('/view-log') }}/{{ $url }}" method="GET" class="d-flex">
                    <input type="date" name="date" class="form-control search-box" required>
                    <button type="submit" class="btn btn-primary ml-2">Search</button>
                </form>
            </div>
        </div>

        <div class="log-container">
            <pre id="log-contents">{{ $logs }}</pre>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#searchLogs').on('input', function() {
                const searchText = $(this).val().toLowerCase();
                const logContent = $('#log-contents').text();
                const lines = logContent.split('\n');
                
                const filteredLines = lines.filter(line => 
                    line.toLowerCase().includes(searchText)
                );
                
                $('#log-contents').text(filteredLines.join('\n'));
            });
        });
    </script>
</body>
</html>