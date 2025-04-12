<?php
//die(password_hash("123456", PASSWORD_DEFAULT)) ;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="../css/login.css">
  <link rel="stylesheet" href="../css/global.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>

<body>
  <div class="login-container">
    <h1>🌿 Bem-Vindo ao Sistema da Fazenda</h1>
    <form method="POST" action="login.php">
      <div class="input-group">
        <input type='text' name="usuario" placeholder="👤 Usuário ou Email" required>
      </div>

      <div class="input-group">
        <input type="password" name="senha" placeholder="🔒 Senha" required>
      </div>

      <button type="submit" class="login-btn">🚪 Acessar Painel</button>
    </form>
  </div>

</body>

</html>