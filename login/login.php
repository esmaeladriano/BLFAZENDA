
<?php
session_start();
include_once 'C:\xampp\htdocs\BLFazenda\conf\conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM usuarios WHERE email = ? OR senha = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $usuario, $usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();
   

    if ($resultado->num_rows === 1) {
        $row = $resultado->fetch_assoc();
  
        if (password_verify($senha, $row['senha'])) {
            $_SESSION['usuario_id'] = $row['id'];
            $_SESSION['nome'] = $row['nome'];
            $_SESSION['nivel'] = $row['role'];

            // Redireciona para o painel correto
            if ($row['role'] === 'admin') {
                header("Location: http://localhost/BLFazenda/painel/admin/");
            } elseif ($row['role'] === 'funcionario') {
                header("Location: painel_funcionario.php");
            } else {

                header("Location: painel_usuario.php");
            }
            exit();
        } else {
            echo "❌ Senha incorreta.";
        }
    } else {
        echo "❌ Usuário não encontrado.";
    }
}
?>
