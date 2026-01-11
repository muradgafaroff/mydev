
<!DOCTYPE html>
<html lang="az">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ödəniş Et - Kapitalbank</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .payment-container {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 420px;
        }
        
        .payment-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .payment-header h1 {
            color: #1e3c72;
            font-size: 28px;
            margin-bottom: 10px;
        }
        
        .payment-header p {
            color: #666;
            font-size: 14px;
        }
        
        .error-message {
            background: #fee2e2;
            border: 1px solid #ef4444;
            color: #dc2626;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        
        .form-group {
            margin-bottom: 24px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #374151;
            font-size: 14px;
        }
        
        .form-group input {
            width: 100%;
            padding: 16px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 18px;
            transition: border-color 0.3s;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: #1e3c72;
        }
        
        .pay-button {
            width: 100%;
            padding: 18px;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        
        .pay-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(30, 60, 114, 0.3);
        }
        
        .security-note {
            text-align: center;
            margin-top: 24px;
            color: #6b7280;
            font-size: 12px;
        }

        .bank-logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .bank-logo img {
            height: 40px;
        }
    </style>
</head>
<body>
    <div class="payment-container">
        <div class="bank-logo">
            <img src="https://www.kapitalbank.az/assets/images/logo.svg" alt="Kapitalbank">
        </div>

        <div class="payment-header">
            <h1>💳 Ödəniş Et</h1>
            <p>Təhlükəsiz ödəniş sistemi</p>
        </div>

        @if(session('error'))
            <div class="error-message">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('payment.pay') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label for="amount">Ödəniş məbləği (AZN)</label>
                <input 
                    type="number" 
                    id="amount" 
                    name="amount" 
                    step="0.01" 
                    min="0.1"
                    max="10000"
                    placeholder="0.00"
                    required
                    autofocus
                >
            </div>

            <button type="submit" class="pay-button">
                🔒 Ödənişə keç
            </button>
        </form>

        <p class="security-note">
            🔐 Ödənişiniz Kapitalbank tərəfindən qorunur
        </p>
    </div>
</body>
</html>
