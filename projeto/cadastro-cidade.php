<?php
session_start();
if (!isset($_SESSION['logado'])) {
    header('Location: login.php');
}
//abrir conexão com o banco de dados
$conexao = require('database/config.php');
$cidades = null;

if (isset($_GET['id'])) {
    
    $id = $_GET["id"];

    $sql = "SELECT * FROM cidades WHERE id = :id";
    $stmt = $conexao->prepare($sql);
    $stmt->bindValue(':id',$id);

    $stmt->execute(); //Executa o SQL com os parâmetros passados acima
    $retorno = $stmt->fetch(PDO::FETCH_ASSOC); //armazena na variavel retorno, os dados obtidos da consulta
    if ($retorno) {
        $cidades = $retorno;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Cidades</title>

    <?php include('componentes/js.php') ?>
   
</head>
<body>
    
    <?php include('menu.php') ?>

    <div class="container">
        <div class="row">
            <div class="col-sm-12">

                    <form method="post" action="action/actions.php?tipo=cidades">

                        <input type="hidden" class="form-control" name="id" 
                        value="<?php echo ($cidades != null ? $cidades['id'] : '') ?>">

                        <div class="row mb-2 mt-2">
                            <div class="col-sm-9 col-md-8 mb-2">
                                <label>Nome da Cidade</label>
                                <input type="text" class="form-control" 
                                name="cidade" placeholder="NomeCidade"
                                value="<?php echo ($cidades != null ? $cidades['cidade']:'') ?>">
                            </div>

                            <div class="col-sm-3 col-md-4 mb-2">
                                <label>Sigla do Estado</label>
                                <input type="text" class="form-control" 
                                name="sigla_estado" placeholder="SiglaEstado"
                                value="<?php echo ($cidades != null ? $cidades['sigla_estado']:'') ?>">
                            </div>
                        </div>
                        <input class="btn btn-warning mb-2" value="Limpar" type="reset">
                        <button class="btn btn-primary mb-2 ms-2" type="submit">Salvar</button>
                    </form>

                    <button class="btn btn-secondary" onclick="confirmar_logout()">SAIR</button>
            </div>
        </div>
    </div>    

</body>
</html>
