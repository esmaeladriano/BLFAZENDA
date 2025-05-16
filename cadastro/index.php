<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Cadastro de Usuário</title>
    <link rel="stylesheet" href="../css/login.css">
    <link rel="stylesheet" href="../css/global.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body class="bg-light">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg">
                    <div class="card-body">
                        <h3 class="card-title text-center mb-4">Cadastro de Usuário</h3>

                        <!-- Mensagens de alerta -->
                        <?php if (isset($_GET['status'])): ?>
                            <?php if ($_GET['status'] === 'sucesso'): ?>
                                <div class="alert alert-success">✅ Usuário cadastrado com sucesso!
                                    <h2>Cadastro realizado com sucesso!</h2>
                                    <p>Você será redirecionado para a página de login em 5 segundos.</p>
                                    <p>Se não for redirecionado, clique <a href="../login/">aqui</a>.</p>
                                </div>
                                <meta http-equiv='refresh' content='5;url=../login/'>

                            <?php elseif ($_GET['status'] === 'email_duplicado'): ?>
                                <div class="alert alert-warning">⚠️ Este email já está cadastrado.</div>
                            <?php else: ?>
                                <div class="alert alert-danger">❌ Erro ao cadastrar. Tente novamente.</div>
                            <?php endif; ?>
                        <?php endif; ?>

                        <form action="processa_cadastro.php" method="post">
                            <div class="mb-3">
                                <label for="nome" class="form-label">Nome:</label>
                                <input type="text" id="nome" name="nome" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email:</label>
                                <input type="email" id="email" name="email" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="senha" class="form-label">Senha:</label>
                                <input type="password" id="senha" name="senha" class="form-control" required>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Cadastrar</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>