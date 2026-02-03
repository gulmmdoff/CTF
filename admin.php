<?php
// ==== AUTH CHECK ====
if (!isset($_COOKIE['auth'])) {
    header("Location: index.php");
    exit;
}

$data = unserialize($_COOKIE['auth']);

if (!($data['username'] == "snowden" && $data['password'] == "Super&ecret")) {
    header("Location: index.php");
    exit;
}

// Logout
if (isset($_GET['logout'])) {
    setcookie("auth", "", time() - 3600);
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Admin Panel </title>
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
            padding: 20px;
            color: #b8c5d6;
        }

        /* Background Animation */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            z-index: -1;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Header */
        .header {
            background: rgba(15, 52, 96, 0.4);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(0, 255, 136, 0.3);
            border-radius: 8px;
            padding: 25px 35px;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }

        .header-left h1 {
            font-size: 24px;
            font-weight: 300;
            letter-spacing: 4px;
            color: #00ff88;
            margin-bottom: 5px;
        }

        .header-left p {
            font-size: 13px;
            color: #6c7a89;
        }

        .header-left p span {
            color: #00ff88;
            font-weight: 600;
        }

        .logout-btn {
            padding: 10px 25px;
            background: rgba(255, 0, 85, 0.2);
            border: 1px solid #ff0055;
            border-radius: 4px;
            color: #ff0055;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            text-transform: uppercase;
        }

        .logout-btn:hover {
            background: #ff0055;
            color: #0a0e1a;
            box-shadow: 0 4px 15px rgba(255, 0, 85, 0.4);
        }

        /* Dashboard Grid */
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: rgba(15, 52, 96, 0.4);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(0, 255, 136, 0.3);
            border-radius: 8px;
            padding: 25px;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            border-color: #00ff88;
            box-shadow: 0 4px 20px rgba(0, 255, 136, 0.2);
        }

        .stat-card h3 {
            font-size: 12px;
            color: #6c7a89;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 10px;
        }

        .stat-card .value {
            font-size: 28px;
            color: #00ff88;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .stat-card .label {
            font-size: 11px;
            color: #6c7a89;
        }

        /* Main Panel */
        .main-panel {
            background: rgba(15, 52, 96, 0.4);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(0, 255, 136, 0.3);
            border-radius: 8px;
            padding: 35px;
            margin-bottom: 30px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }

        .panel-header {
            border-bottom: 1px solid rgba(0, 255, 136, 0.2);
            padding-bottom: 15px;
            margin-bottom: 25px;
        }

        .panel-header h2 {
            font-size: 18px;
            font-weight: 300;
            letter-spacing: 3px;
            color: #00ff88;
            text-transform: uppercase;
        }

        .panel-header p {
            font-size: 12px;
            color: #6c7a89;
            margin-top: 5px;
        }

        /* Form Styling */
        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 12px;
            color: #b8c5d6;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .input-wrapper {
            display: flex;
            gap: 10px;
        }

        input[type="text"] {
            flex: 1;
            padding: 14px 18px;
            background: rgba(10, 14, 26, 0.6);
            border: 1px solid rgba(0, 255, 136, 0.3);
            border-radius: 4px;
            color: #b8c5d6;
            font-size: 14px;
            font-family: 'Courier New', monospace;
            transition: all 0.3s ease;
        }

        input[type="text"]:focus {
            outline: none;
            border-color: #00ff88;
            box-shadow: 0 0 15px rgba(0, 255, 136, 0.2);
            background: rgba(10, 14, 26, 0.8);
        }

        input::placeholder {
            color: rgba(184, 197, 214, 0.3);
        }

        button[type="submit"] {
            padding: 14px 35px;
            background: #00ff88;
            border: none;
            border-radius: 4px;
            color: #0a0e1a;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 2px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
        }

        button[type="submit"]:hover {
            background: #00dd77;
            box-shadow: 0 4px 20px rgba(0, 255, 136, 0.4);
            transform: translateY(-2px);
        }

        /* Output Section */
        .output-section {
            margin-top: 25px;
        }

        .output-section h3 {
            font-size: 12px;
            color: #6c7a89;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 12px;
        }

        pre {
            background: rgba(10, 14, 26, 0.8);
            border: 1px solid rgba(0, 255, 136, 0.2);
            border-radius: 4px;
            padding: 20px;
            color: #00ff88;
            font-family: 'Courier New', monospace;
            font-size: 13px;
            line-height: 1.6;
            overflow-x: auto;
            min-height: 150px;
        }

        pre:empty::before {
            content: 'Output will appear here...';
            color: #6c7a89;
            font-style: italic;
        }

        /* Info Panel */
        .info-panel {
            background: rgba(15, 52, 96, 0.4);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(0, 255, 136, 0.3);
            border-radius: 8px;
            padding: 25px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }

        .info-panel h3 {
            font-size: 14px;
            color: #00ff88;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 15px;
        }

        .info-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid rgba(0, 255, 136, 0.1);
            font-size: 13px;
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-label {
            color: #6c7a89;
        }

        .info-value {
            color: #b8c5d6;
            font-family: 'Courier New', monospace;
        }

        /* Warning Badge */
        .warning-badge {
            display: inline-block;
            background: rgba(255, 165, 0, 0.2);
            border: 1px solid #ffa500;
            color: #ffa500;
            padding: 4px 12px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 1px;
            margin-left: 10px;
            text-transform: uppercase;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="header-left">
                <h1>ADMIN CONTROL PANEL</h1>
                <p>Logged in as: <span>snowden</span></p>
            </div>
            <a href="?logout=1" class="logout-btn">Logout</a>
        </div>

        <!-- Dashboard Stats -->
        <div class="dashboard-grid">
            <div class="stat-card">
                <h3>System Status</h3>
                <div class="value">ONLINE</div>
                <div class="label">All systems operational</div>
            </div>
            <div class="stat-card">
                <h3>Active Sessions</h3>
                <div class="value">1</div>
                <div class="label">Current user sessions</div>
            </div>
            <div class="stat-card">
                <h3>Server Load</h3>
                <div class="value">24%</div>
                <div class="label">CPU utilization</div>
            </div>
            <div class="stat-card">
                <h3>Uptime</h3>
                <div class="value">99.9%</div>
                <div class="label">Last 30 days</div>
            </div>
        </div>

        <!-- Network Diagnostic Tool -->
        <div class="main-panel">
            <div class="panel-header">
                <h2>Network Diagnostic Tool <span class="warning-badge">Beta</span></h2>
                <p>Execute network diagnostics and connectivity tests</p>
            </div>

            <form method="GET">
                <div class="form-group">
                    <label>Target Host / IP Address:</label>
                    <div class="input-wrapper">
                        <input type="text" name="host" placeholder="127.0.0.1 or example.com" value="<?php echo isset($_GET['host']) ? htmlspecialchars($_GET['host']) : ''; ?>">
                        <button type="submit">Execute Ping</button>
                    </div>
                </div>
            </form>

            <?php if (isset($_GET['host'])): ?>
            <div class="output-section">
                <h3>Command Output:</h3>
                <pre><?php
                    $host = $_GET['host'];
                    
                    //Command Injection 
                    $cmd = "ping -n 4 " . $host;
                    
                    system($cmd);
                ?></pre>
            </div>
            <?php endif; ?>
        </div>

        <!-- System Information -->
        <div class="info-panel">
            <h3>System Information</h3>
            <div class="info-item">
                <span class="info-label">Server OS:</span>
                <span class="info-value">Ubuntu Server </span>
            </div>
            <div class="info-item">
                <span class="info-label">PHP Version:</span>
                <span class="info-value"><?php echo phpversion(); ?></span>
            </div>
           
            <div class="info-item">
                <span class="info-label">Last Login:</span>
                <span class="info-value"><?php echo date('Y-m-d H:i:s'); ?></span>
            </div>
        </div>
    </div>
</body>
</html>