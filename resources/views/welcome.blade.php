<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #8B0000 0%, #C41E3A 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .welcome-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            padding: 40px;
            max-width: 500px;
            text-align: center;
        }
        .welcome-container h1 {
            color: #8B0000;
            margin-bottom: 20px;
        }
        .welcome-container p {
            color: #666;
            margin-bottom: 30px;
        }
        .btn-custom {
            background: linear-gradient(135deg, #8B0000 0%, #C41E3A 100%);
            border: none;
            color: white;
            padding: 12px 30px;
            border-radius: 5px;
            text-decoration: none;
            margin: 10px;
            display: inline-block;
            transition: all 0.3s;
        }
        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(139, 0, 0, 0.3);
            color: white;
        }
    </style>
</head>
<body>
    <div class="welcome-container">
        <h1><i class="fas fa-feather"></i> Blog Dashboard</h1>
        <p>Welcome! The application is ready to use.</p>
        <a href="/" class="btn-custom">View Website</a>
        <a href="/admin/login" class="btn-custom">Admin Login</a>
    </div>
</body>
</html>
