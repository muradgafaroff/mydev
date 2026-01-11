<!DOCTYPE html>
<html lang="az">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ödəniş Uğurlu</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
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
            color: #11998e;
            font-size: 28px;
            margin-bottom: 12px;
        }
        
        .message {
            color: #6b7280;
            font-size: 16px;
            margin-bottom: 24px;
        }
        
        .order-info {
            background: #f3f4f6;
            padding: 16px;
            border-radius: 12px;
            margin-bottom: 24px;
        }
        
        .btn {
            display: inline-block;
            padding: 14px 32px;
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            color: white;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(17, 153, 142, 0.3);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="icon">✅</div>
        <h1>Ödəniş Uğurlu!</h1>
        <p class="message">{{ $message }}</p>
        
        @if($order_id)
            <div class="order-info">
                <p>Sifariş ID: <strong>{{ $order_id }}</strong></p>
            </div>
        @endif
        
        <a href="/" class="btn">Ana səhifəyə qayıt</a>
    </div>
</body>
</html>