<?php
require_once 'C:\xampp\htdocs\BLFazenda\login\verifica_acesso.php';
permitirAcesso('admin');

// Conectar ao banco de dados
include_once 'C:\xampp\htdocs\BLFazenda\conf\conexao.php';

// Consultar a quantidade de produtos
$sql_produtos = "SELECT COUNT(*) AS total FROM produtos";
$res_produtos = mysqli_query($conn, $sql_produtos);
$row_produtos = mysqli_fetch_assoc($res_produtos);

// Consultar a quantidade de vendas
$sql_vendas = "SELECT COUNT(*) AS total FROM vendas";
$res_vendas = mysqli_query($conn, $sql_vendas);
$row_vendas = mysqli_fetch_assoc($res_vendas);

// Consultar a quantidade de clientes
$sql_clientes = "SELECT COUNT(*) AS total FROM clientes";
$res_clientes = mysqli_query($conn, $sql_clientes);
$row_clientes = mysqli_fetch_assoc($res_clientes);

// Consultar a quantidade de fornecedores
$sql_fornecedores = "SELECT COUNT(*) AS total FROM fornecedores";
$res_fornecedores = mysqli_query($conn, $sql_fornecedores);
$row_fornecedores = mysqli_fetch_assoc($res_fornecedores);

?>
<!DOCTYPE html>
<html lang="pt-pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Painel Administrativo - Fazenda</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php
  include_once 'navbar.php'; ?>

<div class="content">
  <h2>📊 Painel de Controle</h2>
  <div class="row mt-4">
  <!-- PRODUTOS -->
  <div class="col-md-3 mb-3">
    <a href="produtos.php" class="text-decoration-none">
      <div class="card p-4 text-white" style="background-color: var(--leaf-green); border-left: 6px solid var(--forest-green); border-radius: 15px;">
        <h5>🌾 Produtos</h5>
        <h2><?php echo $row_produtos['total']; ?></h2>
        <span>Ver detalhes</span>
      </div>
    </a>
  </div>

  <!-- VENDAS -->
  <div class="col-md-3 mb-3">
    <a href="vendas.php" class="text-decoration-none">
      <div class="card p-4 text-white" style="background-color: var(--forest-green); border-left: 6px solid #ffffff50; border-radius: 15px;">
        <h5>💰 Vendas</h5>
        <h2><?php echo $row_vendas['total']; ?></h2>
        <span>Ver detalhes</span>
      </div>
    </a>
  </div>

  <!-- CLIENTES -->
  <div class="col-md-3 mb-3">
    <a href="clientes.php" class="text-decoration-none">
      <div class="card p-4 text-white" style="background-color: #4A7856; border-left: 6px solid #8FBC8F; border-radius: 15px;">
        <h5>👥 Clientes</h5>
        <h2><?php echo $row_clientes['total']; ?></h2>
        <span>Ver detalhes</span>
      </div>
    </a>
  </div>

  <!-- FORNECEDORES -->
  <div class="col-md-3 mb-3">
    <a href="fornecedores.php" class="text-decoration-none">
      <div class="card p-4 text-white" style="background-color: #6b8e23; border-left: 6px solid #2D5A27; border-radius: 15px;">
        <h5>🚚 Fornecedores</h5>
        <h2><?php echo $row_fornecedores['total']; ?></h2>
        <span>Ver detalhes</span>
      </div>
    </a>
  </div>
</div>

  <!-- GRÁFICOS -->
  <div class="row mt-5">
    <div class="col-md-8 mb-4">
      <div class="card p-4">
        <h5 class="mb-3">📈 Vendas nos Últimos 7 Dias</h5>
        <canvas id="vendasSemanaChart" height="120"></canvas>
      </div>
    </div>
    <div class="col-md-4 mb-4">
      <div class="card p-4">
        <h5 class="mb-3">🛒 Tipo de Venda</h5>
        <canvas id="tipoVendaChart" height="180"></canvas>
      </div>
    </div>
  </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  // Gráfico de Linhas - Vendas Semanais
  const vendasSemanaCtx = document.getElementById('vendasSemanaChart').getContext('2d');
  new Chart(vendasSemanaCtx, {
    type: 'line',
    data: {
      labels: ['Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'],
      datasets: [{
        label: 'Vendas (R$)',
        data: [150, 200, 170, 250, 220, 300, 280],
        backgroundColor: 'rgba(77, 145, 102, 0.2)',
        borderColor: 'var(--forest-green)',
        borderWidth: 3,
        fill: true,
        tension: 0.4,
        pointBackgroundColor: 'var(--leaf-green)'
      }]
    },
    options: {
      scales: {
        y: { beginAtZero: true }
      }
    }
  });

  // Gráfico de Pizza - Tipo de Venda
  const tipoVendaCtx = document.getElementById('tipoVendaChart').getContext('2d');
  new Chart(tipoVendaCtx, {
    type: 'doughnut',
    data: {
      labels: ['Retalho', 'Grosso'],
      datasets: [{
        data: [60, 40],
        backgroundColor: ['#4A7856', '#2D5A27'],
        borderColor: '#fff',
        borderWidth: 2
      }]
    },
    options: {
      plugins: {
        legend: {
          position: 'bottom'
        }
      }
    }
  });
</script>

</body>
</html>
