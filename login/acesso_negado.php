<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <title>🚫 Acesso Negado</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', sans-serif;
    }

    body {
      height: 100vh;
      background: linear-gradient(135deg, #163315, #265a21);
      display: flex;
      justify-content: center;
      align-items: center;
      color: white;
    }

    .container {
      background: #2D5A27;
      padding: 40px;
      border-radius: 20px;
      box-shadow: 0 0 20px rgba(0,0,0,0.4);
      text-align: center;
      max-width: 400px;
    }

    .container img {
      width: 100px;
      margin-bottom: 20px;
    }

    h1 {
      font-size: 2em;
      margin-bottom: 10px;
    }

    p {
      margin-bottom: 30px;
      font-size: 1.1em;
    }

    .btn {
      padding: 12px 20px;
      background-color: #ffffff;
      color: #2D5A27;
      text-decoration: none;
      border-radius: 8px;
      font-weight: bold;
      transition: 0.3s;
    }

    .btn:hover {
      background-color: #2D5A27;
      color: white;
      border: 1px solid white;
    }
  </style>
</head>
<body>
  <div class="container">
    <img src="https://www.svgrepo.com/show/21045/access-denied.svg" alt="Acesso Negado">
    <h1>🚫 Acesso Negado</h1>
    <p>Você não tem permissão para acessar esta página.</p>
    <a href="exit.php" class="btn">🔐 Terminar Sessão</a>
  </div>
</body>
</html>
