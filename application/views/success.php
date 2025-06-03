<!-- filepath: c:\my\htdocs\codeerp\application\views\success.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Success</title>
    <script>
        // Display an alert and redirect to login.php
        alert('Registration successful! Redirecting to login page...');
        window.location.href = '<?php echo base_url("login.php"); ?>';
    </script>
</head>
<body>
    <h1>Registration Successful!</h1>
    <p>If you are not redirected, <a href="<?php echo base_url('login.php'); ?>">click here</a>.</p>
</body>
</html>