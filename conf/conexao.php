
<?php
$host = "localhost"; // ou IP do servidor
$usuario = "root";   // seu usuário do MySQL
$senha = "";         // sua senha do MySQL
$banco = "fazenda";  // nome do banco de dados

$conn = mysqli_connect($host, $usuario, $senha, $banco);

if (!$conn) {
    die("Erro na conexão com o banco de dados: " . mysqli_connect_error());
}

// Opcional: define charset para evitar problemas com acentos
mysqli_set_charset($conn, "utf8");

// Você pode descomentar a linha abaixo para testes
// echo "Conectado com sucesso!";
?>
