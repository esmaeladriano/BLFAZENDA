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
    <div class="register-link" style="margin-top: 20px; text-align: center;">
      <span>Não tem login?</span>
      <a href="../cadastro/" style="color:rgb(255, 255, 255); text-decoration: underline;">Cadastre-se aqui</a>
    </div>
  </div>

</body>

</html>