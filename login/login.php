
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
            $_SESSION['email'] = $row['email'];

            // Redireciona para o painel correto
            if ($row['role'] === 'admin') {
                header("Location: http://localhost/BLFazenda/painel/admin/");
            } elseif ($row['role'] === 'funcionario') {
                header("Location: painel_funcionario.php");
            } else {

                header("Location: http://localhost/BLFazenda/");
            }
            exit();
        } else {
            $_SESSION['login_error'] = "❌ Senha incorreta.";
            header("Location: index.php");
            exit();
        }
        } else {
        $_SESSION['login_error'] = "❌ Usuário não encontrado.";
        header("Location: index.php");
        exit();
    }
}
?>
