<?php

$adminName = "snowden";
$adminPassword = "Super&ecret";

// LOGIN CHECK 
if (isset($_COOKIE['auth'])) {
    $data = unserialize($_COOKIE['auth']);

    if ($data['username'] == $adminName && $data['password'] == $adminPassword) {
        header("Location: admin.php");
        exit;
    }
}

// ==== LOGIN FORM ====
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $cookieData = [
        "username" => $username,
        "password" => $password
    ];

    setcookie("auth", serialize($cookieData));
    header("Location: index.php");
    exit;
}
?>


<!--
snowden 
-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Panel</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #0a0e1a;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            position: relative;
        }

        
        .bg-animation {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            overflow: hidden;
        }

        .polygon {
            position: absolute;
            opacity: 0.15;
        }

        .polygon-1 {
            width: 0;
            height: 0;
            border-left: 150px solid transparent;
            border-right: 150px solid transparent;
            border-bottom: 260px solid #00ff88;
            top: 10%;
            right: 15%;
            animation: float 8s ease-in-out infinite;
        }

        .polygon-2 {
            width: 0;
            height: 0;
            border-left: 100px solid transparent;
            border-right: 100px solid transparent;
            border-bottom: 173px solid #00ff88;
            bottom: 20%;
            left: 10%;
            animation: float 10s ease-in-out infinite reverse;
        }

        .polygon-3 {
            width: 0;
            height: 0;
            border-left: 80px solid transparent;
            border-right: 80px solid transparent;
            border-bottom: 138px solid #00ff88;
            top: 60%;
            right: 25%;
            animation: float 7s ease-in-out infinite;
        }

        .polygon-4 {
            width: 0;
            height: 0;
            border-left: 120px solid transparent;
            border-right: 120px solid transparent;
            border-bottom: 207px solid #00ff88;
            bottom: 10%;
            right: 5%;
            animation: float 9s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0) rotate(0deg);
            }
            50% {
                transform: translateY(-30px) rotate(5deg);
            }
        }

        
        .network-line {
            position: absolute;
            height: 1px;
            background: linear-gradient(90deg, transparent, #00ff88, transparent);
            opacity: 0.3;
            animation: lineMove 4s linear infinite;
        }

        .line-1 {
            width: 40%;
            top: 20%;
            left: 10%;
            transform: rotate(45deg);
        }

        .line-2 {
            width: 50%;
            top: 60%;
            right: 5%;
            transform: rotate(-30deg);
            animation-delay: 1s;
        }

        .line-3 {
            width: 35%;
            bottom: 15%;
            left: 20%;
            transform: rotate(20deg);
            animation-delay: 2s;
        }

        @keyframes lineMove {
            0% {
                opacity: 0.1;
            }
            50% {
                opacity: 0.4;
            }
            100% {
                opacity: 0.1;
            }
        }

        /* Dots */
        .dot {
            position: absolute;
            width: 8px;
            height: 8px;
            background: #00ff88;
            border-radius: 50%;
            opacity: 0.6;
            animation: pulse 3s ease-in-out infinite;
        }

        .dot-1 { top: 15%; right: 20%; animation-delay: 0s; }
        .dot-2 { top: 25%; left: 15%; animation-delay: 0.5s; }
        .dot-3 { bottom: 30%; right: 10%; animation-delay: 1s; }
        .dot-4 { bottom: 20%; left: 25%; animation-delay: 1.5s; }
        .dot-5 { top: 50%; right: 35%; animation-delay: 2s; }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
                opacity: 0.6;
            }
            50% {
                transform: scale(1.5);
                opacity: 1;
            }
        }

        /* Login Container */
        .container {
            background: rgba(15, 52, 96, 0.4);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(0, 255, 136, 0.3);
            border-radius: 12px;
            padding: 50px 45px;
            width: 90%;
            max-width: 450px;
            box-shadow: 
                0 8px 32px rgba(0, 0, 0, 0.4),
                inset 0 0 60px rgba(0, 255, 136, 0.05);
            position: relative;
            z-index: 10;
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
        }

        .header h2 {
            font-size: 26px;
            font-weight: 300;
            letter-spacing: 6px;
            color: #b8c5d6;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
            background: rgba(10, 14, 26, 0.6);
            border: 1px solid rgba(0, 255, 136, 0.3);
            border-radius: 4px;
            transition: all 0.3s ease;
        }

        .input-wrapper:focus-within {
            border-color: #00ff88;
            box-shadow: 0 0 20px rgba(0, 255, 136, 0.2);
            background: rgba(10, 14, 26, 0.8);
        }

        .input-icon {
            padding: 0 15px;
            color: #00ff88;
            font-size: 18px;
            display: flex;
            align-items: center;
        }

        .input-icon svg {
            width: 20px;
            height: 20px;
            fill: #00ff88;
        }

        input[type="text"],
        input[type="password"] {
            flex: 1;
            padding: 16px 15px 16px 0;
            background: transparent;
            border: none;
            color: #b8c5d6;
            font-size: 15px;
            outline: none;
        }

        input::placeholder {
            color: rgba(184, 197, 214, 0.4);
            font-size: 14px;
        }

        button {
            width: 100%;
            padding: 16px;
            background: #00ff88;
            border: none;
            border-radius: 4px;
            color: #0a0e1a;
            font-size: 15px;
            font-weight: 600;
            letter-spacing: 3px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            margin-top: 10px;
        }

        button:hover {
            background: #00dd77;
            box-shadow: 0 6px 25px rgba(0, 255, 136, 0.4);
            transform: translateY(-2px);
        }

        button:active {
            transform: translateY(0);
        }

        .hint-section {
            margin-top: 35px;
            padding-top: 25px;
            border-top: 1px solid rgba(0, 255, 136, 0.2);
        }

        .hint-item {
            font-size: 11px;
            color: #6c7a89;
            margin-bottom: 6px;
            padding-left: 12px;
            position: relative;
            line-height: 1.6;
        }

        .hint-item::before {
            content: '•';
            position: absolute;
            left: 0;
            color: #00ff88;
        }
    </style>
</head>
<body>
    <div class="bg-animation">
        <div class="polygon polygon-1"></div>
        <div class="polygon polygon-2"></div>
        <div class="polygon polygon-3"></div>
        <div class="polygon polygon-4"></div>
        
        <div class="network-line line-1"></div>
        <div class="network-line line-2"></div>
        <div class="network-line line-3"></div>
        
        <div class="dot dot-1"></div>
        <div class="dot dot-2"></div>
        <div class="dot dot-3"></div>
        <div class="dot dot-4"></div>
        <div class="dot dot-5"></div>
    </div>
    
    <div class="container">
        <div class="header">
            <h2>MEMBER LOGIN</h2>
        </div>

        <form method="POST">
            <div class="form-group">
                <div class="input-wrapper">
                    <div class="input-icon">
                        <svg viewBox="0 0 24 24">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                        </svg>
                    </div>
                    <input type="text" name="username" placeholder="Username" required>
                </div>
            </div>
            
            <div class="form-group">
                <div class="input-wrapper">
                    <div class="input-icon">
                        <svg viewBox="0 0 24 24">
                            <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/>
                        </svg>
                    </div>
                    <input type="password" name="password" placeholder="Password" required>
                </div>
            </div>
            
            <button type="submit">LOGIN</button>
        </form>

        
    </div>
</body>
</html>