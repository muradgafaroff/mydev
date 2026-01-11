<!DOCTYPE html>
<html lang="az">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ödəniş Uğursuz</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #eb3349 0%, #f45c43 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .container {
            background: white;
            padding: 50px 40px;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
            text-align: center;
            max-width: 420px;
        }
        
        .icon {
            font-size: 80px;
            margin-bottom: 20px;
        }
        
        h1 {
            color: #eb3349;
            font-size: 28px;
            margin-bottom: 12px;
        }
        
        .message {
            color: #6b7280;
            font-size: 16px;
            margin-bottom: 24px;
        }
        
        .buttons {
            display: flex;
            gap: 12px;
            justify-content: center;
        }
        
        .btn {
            padding: 14px 28px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
        }
        
        .btn-secondary {
            background: #f3f4f6;
            color: #374151;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="icon">❌</div>
        <h1>Ödəniş Uğursuz</h1>
        <p class="message">{{ $message }}</p>
        
        <div class="buttons">
            <a href="/checkout" class="btn btn-primary">Yenidən cəhd et</a>
            <a href="/" class="btn btn-secondary">Ana səhifə</a>
        </div>
    </div>
</body>
</html>