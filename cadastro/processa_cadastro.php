<?php
// Conexão com o banco de dados (ajuste os dados conforme necessário)
include_once '../conf/conexao.php';


// Dados do formulário
$nome = trim($_POST['nome']);
$email = trim($_POST['email']);
$senha = $_POST['senha'];

$senhaHash = password_hash($senha, PASSWORD_DEFAULT);
$role = 'usuario';
$data_criacao = date('Y-m-d H:i:s');

// Verifica se o email já existe
$check = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
$check->bind_param("s", $email);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    $check->close();
    $conn->close();
    header("Location: index.php?status=email_duplicado");
    exit();
}
$check->close();

// Cadastro
$stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha, role, data_criacao) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $nome, $email, $senhaHash, $role, $data_criacao);

if ($stmt->execute()) {
    header("Location: index.php?status=sucesso");
} else {
    header("Location: index.php?status=erro");
}

$stmt->close();
$conn->close();
?>
