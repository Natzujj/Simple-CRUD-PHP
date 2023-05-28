<?php
    require_once('persistence/DbConnect.php');
    require_once('persistence/jogos.php');

    $jogos = new Jogos();
    $jogosObj= $jogos->getAll();

     // Verificar se o formulário foi enviado
     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Verificar se é uma ação de criar
        if (isset($_POST['criar'])) {
            $nome = $_POST['nome'];
            // Criar o novo registro
            $novoJogo = new Jogos();
            $novoJogo->setNome($nome);
            $novoJogo->create();
            // Redirecionar para evitar o reenvio do formulário
            header('Location: index.php');
            exit();
        }
        // Verificar se é uma ação de editar
        if (isset($_POST['editarRegistro'])) {
            $id = $_POST['id'];
            $nome = $_POST['nome'];
            // Atualizar o registro
            $jogo = new Jogos();
            $jogo->loadById($id);
            $jogo->setNome($nome);
            $jogo->update($nome);
            // Redirecionar para evitar o reenvio do formulário
            header('Location: index.php');
            exit();
        }

        // Verificar se é uma ação de excluir
        if (isset($_POST['excluir'])) {
            $id = $_POST['id'];
            // Excluir o registro
            $jogo = new Jogos();
            $jogo->loadById($id);
            $jogo->delete();
            // Redirecionar para evitar o reenvio do formulário
            header('Location: index.php');
            exit();
        }

            // Carregar os dados do jogo selecionado, se o ID estiver definido
        if (isset($_POST['editar'])) {
            $id = $_POST['id'];
            $jogo = new Jogos();
            $jogo->loadById($id);
            $id = $jogo->getId();
            $nome = $jogo->getNome();
        }
    }

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD com PHP</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <!-- Formulário para criar ou atualizar um registro -->
        <h2>Novo Registro de Jogo</h2>
        <form method="post" action="index.php">
            <input type="hidden" name="id" value="<?php echo isset($id) ? $id : ''; ?>">
            <div class="row">
                <div class="col-sm-8">
                    <div class="mb-3">
                        <!-- <label for="nome" class="form-label">Nome:</label> -->
                        <input type="text" placeholder="Digite o nome do jogo:" name="nome" id="nome" required class="form-control" value="<?php echo isset($nome) ? $nome : ''; ?>">
                    </div>
                </div>
                <div class="col-sm-4">
                    <?php if (isset($id)): ?>
                        <button type="submit" name="editarRegistro" class="btn btn-primary">Atualizar</button>
                    <?php else: ?>
                        <button type="submit" name="criar" class="btn btn-success">Criar</button>
                    <?php endif; ?>
                </div>
            </div>
        </form>

        <!-- Tabela para exibir os registros -->
        <h2>Jogos</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($jogosObj as $jogo): ?>
                    <tr>
                        <td><?php echo $jogo['id']; ?></td>
                        <td><?php echo $jogo['nome']; ?></td>
                        <td>
                            <form method="post" action="index.php" style="display: inline;">
                                <input type="hidden" name="id" value="<?php echo $jogo['id']; ?>">
                                <button type="submit" name="excluir" class="btn btn-danger">Excluir</button>
                            </form>
                            <form method="post" action="index.php" style="display: inline;">
                                <input type="hidden" name="id" value="<?php echo $jogo['id']; ?>">
                                <button type="submit" name="editar" class="btn btn-primary btn-editar">Editar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
</body>
</html>

<style>
        .container {
            margin-top: 50px;
        }
        .btn-editar {
            margin-right: 5px;
        }
    </style>