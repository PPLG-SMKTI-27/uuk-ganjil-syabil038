<!DOCTYPE html>
<html>
<head>
    <title>Login - Peminjaman Lab</title>
    <style>
        body { font-family: Arial; max-width: 400px; margin: 100px auto; padding: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input[type="text"], input[type="password"] { width: 100%; padding: 8px; }
        button { background: #007bff; color: white; padding: 10px 20px; border: none; cursor: pointer; }
        .error { color: red; margin-bottom: 15px; }
    </style>
</head>
<body>
    <h2>Login Peminjaman Lab</h2>
    
    <?php if (isset($error)): ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <form method="POST">
        <div class="form-group">
            <label>Username:</label>
            <input type="text" name="username" required>
        </div>
        
        <div class="form-group">
            <label>Password:</label>
            <input type="password" name="password" required>
        </div>
        
        <button type="submit">Login</button>
    </form>
</body>
</html>