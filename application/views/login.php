<!-- filepath: c:\my\htdocs\codeerp\application\views\login.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #908A8AFF;
            padding: 20px;
        }
        .container {
            max-width: 300px;
            margin: auto;
            background-color: #fff;
            padding: 50px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .input {
            width: 280px;
            height: 20px;
            margin: 10px 0;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f2f2f2;
        }
        button {
            width: 100%;
            height: 40px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .signin-link {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <form method="POST" action="<?php echo base_url('login'); ?>">
        <div class="container">
            <h1>Login</h1>
            <input type="email" name="email" class="input" placeholder="Enter your email" required>
            <input type="password" name="password" class="input" placeholder="Enter your password" required>
            <button type="submit">Login</button>
            <div class="signin-link">
                Don't have an account? <a href="<?php echo base_url('register'); ?>">Sign Up</a>
            </div>
        </div>
    </form>
</body>
</html>