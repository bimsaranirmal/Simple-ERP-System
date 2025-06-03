<!-- filepath: c:\my\htdocs\codeerp\application\views\register.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #908A8AFF;
            padding: 20px;
        }
        .container {
            max-width: 350px;           
            margin: auto;
            background-color: #EADFDFFF;
            padding: 50px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .input {
            width: 350px;
            margin: 5px 0 5px 0;
            height: 50px;
            border: none;
            border-radius: 5px;
            background-color: #B7ADADFF;
        }
        .button {
            width: 350px;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .signin-link {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <form method="POST" action="<?php echo base_url('register'); ?>">
        <div class="container">
            <h1>Register</h1>
            <input type="text" id="name" name="name" class="input" placeholder="    Enter your name" required><br><br>
            <input type="email" id="email" name="email" class="input" placeholder="    Enter your email" required><br><br>
            <input type="password" id="password" name="password" class="input" placeholder="    Enter your password" required><br><br>
            <button type="submit" class="button">Register</button>
            <div class="signin-link">
                Already registered? <a href="<?php echo base_url('login'); ?>">Sign In</a>
            </div>
        </div>
    </form>
</body>
</html>