CREATE TABLE clientes (
id INT AUTO_INCREMENT PRIMARY KEY,
nome VARCHAR(100),
email VARCHAR(100),
telefone VARCHAR(15)
);

<?php
// Conexão com o banco de dados
$servername = "localhost";$username = "root";
$password = "";$dbname = "crud_example";

// Criando a conexão
$conn = new mysqli($servername, $username,$password, $dbname);

// Verificando se houve erro na conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);


// Função para criar um cliente
if (isset(_POST['acao']) && _POST['acao'] == 'criar')
$nome = _POST['nome'];
$email = _POST['email'];
$telefone = _POST['telefone'];
$sql = "INSERT INTO clientes (nome, email, telefone) VALUES ('$nome', '$email', '4telefone')";
    if ($conn->query($sql) === TRUE) 
        echo "Novo cliente criado com sucesso!";
     else 
        echo "Erro: " .$sql . "<br>" . $conn->error;
    

// Função para ler todos os clientes
if (isset(_POST['acao']) && _POST['acao'] == 'ler')
$sql = "SELECT * FROM clientes";
    $result =$conn->query($sql);
    $clientes = [];
    while ($row =$result->fetch_assoc()) {
        $clientes[] =$row;
    }
    echo json_encode($clientes);


// Função para atualizar um cliente
if (isset(_POST['acao']) && _POST['acao'] == 'atualizar')
{
    $id = _POST['id'];
    $nome = _POST['nome'];
    $email = _POST['email'];
    $telefone = _POST['telefone'];
    $sql = "UPDATE clientes SET nome='nome', email='email', telefone='telefone' WHERE id=id";
    if ($conn->query(sql) === TRUE) {
        echo "Cliente atualizado com sucesso!";
    } else {
        echo "Erro: " . $sql . "<br>" .$conn->error;
    }
}

// Função para excluir um cliente
if (isset(_POST['acao']) && _POST['acao'] == 'excluir') {
    $id =_POST['id'];

    $sql = "DELETE FROM clientes WHERE id=id";
    if ($conn->query($sql) === TRUE) {
 echo "Cliente excluído com sucesso!";
    } else {
        echo "Erro: " . $sql . "<br>" .$conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD com PHP, jQuery, AJAX</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        button {
            padding: 8px 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>

    <h2>CRUD com PHP, jQuery, AJAX</h2>

    <!-- Formulário de adicionar/editar cliente -->
    <div>
        <h3>Adicionar Cliente</h3>
        <form id="form-cliente">
            <input type="hidden" id="cliente-id" name="id">
            <input type="text" id="nome" name="nome" placeholder="Nome" required>
            <input type="email" id="email" name="email" placeholder="E-mail" required>
            <input type="text" id="telefone" name="telefone" placeholder="Telefone" required>
            <button type="submit">Salvar Cliente</button>
        </form>
    </div>

    <h3>Clientes Cadastrados</h3>
    <table id="tabela-clientes">
        <thead>
            <tr>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Telefone</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        let id = 0;
        // Função para carregar os clientes na tabela
        function carregarClientes() {
            $.ajax({
                url: '',
                method: 'POST',
                data: { acao: 'ler' },
                dataType: 'json',
                success: function (data) {
                    let tabela = ('#tabela-clientes tbody');
                    tabela.empty(); // Limpa a tabela
                    data.forEach(function (cliente) {
                        tabela.append(`
                            <tr>
                                <td>{cliente.nome}</td>
                                <td>${cliente.email}</td>
                                <td>{cliente.telefone}</td>
                                <td>
                                    <button class="editar" data-id="cliente.id">Editar</button>
                                    <button class="excluir" data-id="{cliente.id}">Excluir</button>
                                </td>
                            </tr>
                        `);
                    });
                }
            }
            )
        };


        // Carregar clientes ao carregar a página
        (document).ready(function () {
            carregarClientes();

            // Enviar o formulário de cliente('#form-cliente').submit(function(e) {
            e.preventDefault();
            id = ('#cliente-id').val();
            let nome = ('#nome').val();
            let email = ('#email').val();
            let telefone = ('#telefone').val();

            let acao = id ? 'atualizar' : 'criar';

            $.ajax({
                url: '',
                method: 'POST',
                data: '',
                acao: acao,
                id: id,
                nome: nome,
                email: email,
                telefone: telefone,
                success: function (response) {
                    alert(response);
                    carregarClientes(); ('#form-cliente')[0].reset();
                    ('#cliente-id').val('');
                }
            });

            // Editar cliente(document).on('click', '.editar', function() {
            let id = (this).data('id');
            $.ajax({
                url: '',
                method: 'POST',
                data: { acao: 'ler' },
                dataType: 'json',
                success: function (data) {
                    let cliente = data.find(cliente => cliente.id == id);
                    if (cliente) {
                        ('#cliente-id').val(cliente.id); ('#nome').val(cliente.nome);
                        ('#email').val(cliente.email); ('#telefone').val(cliente.telefone);
                    }
                }
            });
        });

        // Excluir cliente
        (document).on('click', '.excluir', function () {
            if (confirm('Tem certeza que deseja excluir?'))
                id = (this).data('id');
            $.ajax({
                url: '',
                method: 'POST',
                data: { acao: 'excluir', id: id },
                success: function (response) {
                    alert(response);
                }
            });
        });



    </script>
</body>

</html>