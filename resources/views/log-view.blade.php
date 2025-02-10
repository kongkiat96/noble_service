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
            background-color: #f0f2f5;
            color: #212529;
        }
        .log-container {
            height: 75vh;
            overflow-y: auto;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        pre {
            background-color: #1e1e1e;
            color: #d4d4d4;
            padding: 20px;
            border-radius: 8px;
            font-family: 'Consolas', 'Monaco', monospace;
            font-size: 0.9rem;
            line-height: 1.6;
            margin: 0;
            white-space: pre-wrap;
            word-wrap: break-word;
        }
        pre::-webkit-scrollbar {
            width: 8px;
        }
        pre::-webkit-scrollbar-track {
            background: #2d2d2d;
        }
        pre::-webkit-scrollbar-thumb {
            background: #666;
            border-radius: 4px;
        }
        .header {
            background-color: #fff;
            padding: 1.5rem;
            border-bottom: 1px solid #e0e4e8;
            position: sticky;
            top: 0;
            z-index: 1000;
            border-radius: 12px 12px 0 0;
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
            border-radius: 8px;
            border: 1px solid #ced4da;
            padding: 0.5rem 1rem;
        }
        .btn-primary {
            background-color: #0d6efd;
            border: none;
            border-radius: 8px;
            padding: 0.5rem 1.25rem;
            font-weight: 500;
        }
        .log-line {
            padding: 4px 0;
            border-bottom: 1px solid #2d2d2d;
        }
        .log-error { color: #ff8080; }
        .log-warning { color: #ffd700; }
        .log-info { color: #87ceeb; }
        .log-success { color: #98c379; }
        .log-debug { color: #b19cd9; }
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
            const logContent = $('#log-contents');
            let content = logContent.html();
            
            // Add color highlighting
            content = content.replace(/ERROR|CRITICAL|ALERT|EMERGENCY/gi, '<span class="log-error">$&</span>');
            content = content.replace(/WARNING/gi, '<span class="log-warning">$&</span>');
            content = content.replace(/INFO/gi, '<span class="log-info">$&</span>');
            content = content.replace(/SUCCESS/gi, '<span class="log-success">$&</span>');
            content = content.replace(/DEBUG/gi, '<span class="log-debug">$&</span>');
            
            // Add line breaks and spacing
            content = content.split('\n').map(line => 
                `<div class="log-line">${line}</div>`
            ).join('');
            
            logContent.html(content);
        });
    </script>
</body>
</html>