<?php

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php'); // Redirecionar para login caso não esteja logado
    exit();
}

// Incluir a conexão com o banco de dados
include_once('C:\xampp\htdocs\BLFazenda\conf\conexao.php');

// Consultar dados do usuário logado
$usuario_id = $_SESSION['usuario_id'];
$sql_usuario = "SELECT nome FROM usuarios WHERE id = $usuario_id";
$res_usuario = mysqli_query($conn, $sql_usuario);
$usuario = mysqli_fetch_assoc($res_usuario);
$nome_usuario = $usuario['nome']; // Pegando o nome do usuário
?>

<style>
    :root {
      --forest-green: #2D5A27;
      --leaf-green: #4A7856;
      --grass-light: #8FBC8F;
      --gradiente-azul: linear-gradient(135deg, #8FBC8F 7%, #4A7856, #2D5A27 95%);
    }

    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f5f5f5;
      margin: 0;
      padding: 0;
    }

    .navbar-custom {
      background-color: var(--forest-green);
      color: #fff;
    }

    .navbar-custom .navbar-brand,
    .navbar-custom .nav-link {
      color: #fff;
    }

    .sidebar {
      width: 220px;
      height: 100vh;
      position: fixed;
      top: 56px;
      left: 0;
      background: var(--gradiente-azul);
      padding-top: 1rem;
      color: #fff;
    }

    .sidebar a {
      color: #fff;
      display: block;
      padding: 0.8rem 1.2rem;
      text-decoration: none;
    }

    .sidebar a:hover {
      background-color: rgba(255, 255, 255, 0.1);
    }

    .content {
      margin-left: 220px;
      margin-top: 56px;
      padding: 2rem;
    }

    .card {
      border: none;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
      border-radius: 12px;
    }

    @media (max-width: 768px) {
      .sidebar {
        position: relative;
        width: 100%;
        height: auto;
        top: 0;
      }
      .content {
        margin-left: 0;
      }
    }
    .main-content {
    margin-left: 220px; /* Largura da sidebar */
    transition: all 0.3s ease;
}

@media (max-width: 768px) {
    .main-content {
        margin-left: 0; /* Remove a margem no mobile */
    }
}
</style>

<!-- Navbar Superior -->
<nav class="navbar navbar-expand-lg navbar-custom fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="#">🌿 FazendaDica</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuTopo">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="menuTopo">
      <ul class="navbar-nav mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="#">⚙️ Config</a></li>
        <li class="nav-item"><a class="nav-link text-danger" href="http://localhost/BLFazenda/login/exit.php">🚪 Sair</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- Sidebar -->
<div class="sidebar">
  <h4 class="mb-4"><?php echo $nome_usuario; ?></h2>
  <ul class="nav flex-column">
    <li class="nav-item mb-2"><a class="nav-link text-white" href="./index.php">📊 Dashboard</a></li>
    <li class="nav-item mb-2"><a class="nav-link text-white" href="produtos.php">🌾 Produtos</a></li>
    <li class="nav-item mb-2"><a class="nav-link text-white" href="vendas.php">💰 Vendas</a></li>
    <li class="nav-item mb-2"><a class="nav-link text-white" href="clientes.php">👥 Clientes</a></li>
    <li class="nav-item mb-2"><a class="nav-link text-white" href="fornecedores.php">🚚 Fornecedores</a></li>
    <li class="nav-item mb-2"><a class="nav-link text-white" href="parceiros.php">🤝 Parceiros</a></li>
    
    <!-- Exibir nome do usuário logado -->
    <li class="nav-item mb-2"><a class="nav-link text-white" href="usuario.php">👤usuários </a></li>
  </ul>
</div>
