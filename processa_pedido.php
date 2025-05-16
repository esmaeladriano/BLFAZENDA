<?php
session_start();
require_once './conf/conexao.php'; // conexão com banco

if (!isset($_POST['telefone'], $_POST['localidade'])) {
    die('Dados incompletos.');
}

$nome       = $_POST['nome'];
$email      = $_POST['email'];
$telefone   = $_POST['telefone'];
$localidade = $_POST['localidade'];
$total      = $_POST['total'];
$data       = date('Y-m-d H:i:s');

// Inserir o pedido
$stmt = $conn->prepare("INSERT INTO pedidos (nome, email, telefone, localidade, total, data) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssis", $nome, $email, $telefone, $localidade, $total, $data);
$stmt->execute();

$pedido_id = $stmt->insert_id;

// Inserir os itens do pedido
if (isset($_SESSION['carrinho']) && is_array($_SESSION['carrinho'])) {
    foreach ($_SESSION['carrinho'] as $item) {
        $nome_produto   = $item['nome'];
        $quantidade     = $item['quantidade'];
        $preco_unitario = $item['preco'];

        $stmt_item = $conn->prepare("INSERT INTO pedido_itens (pedido_id, nome_produto, quantidade, preco_unitario) VALUES (?, ?, ?, ?)");
        $stmt_item->bind_param("isid", $pedido_id, $nome_produto, $quantidade, $preco_unitario);
        $stmt_item->execute();
    }
}

// Limpar carrinho
unset($_SESSION['carrinho']);

?>

<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <title>Compra Finalizada</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container py-5 text-center">
    <h2 class="text-success">✅ Compra finalizada com sucesso!</h2>
    <p class="mt-3">Obrigado por comprar conosco, <strong><?= htmlspecialchars($nome) ?></strong>.</p>
    <p>Recebemos seu pedido e estamos a processá-lo.</p>
    <a href="index.php" class="btn btn-primary mt-4">Voltar à página inicial</a>
  </div>
</body>
</html>
