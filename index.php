<?php
require_once("Pessoa.php");
//conecta com a database
$p = new Pessoa("CRUDPDO", "localhost", "usuario", "");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Cadastrar Pessoa</title>
</head>

<body>
    <div class="main-container">
        <?php 
            // Ve se o formulário foi enviado
            if(!empty($_POST)){
                $nome = (string) addslashes($_POST["nome"]);
                $telefone = (string) addslashes($_POST["telefone"]);
                $email = (string) addslashes($_POST["email"]);

                // Verifica se os campos estao vazios
                if(!empty($nome) && !empty($telefone) && !empty($email)){
                    //Ve se o usuario já está cadastrado
                    if(!$p -> cadastrarPessoa($nome, $telefone, $email)){
                        echo "Email já cadastrado";
                    }
                }   
                else{
                    echo "Preencha todos os campos";
                }
            }
        ?>
        <section id="esquerda">
            <form action="" method="POST">
                <h2>Cadastrar Pessoa</h2>
                <!-- Campo Nome-->
                <label for="nome">Nome</label>
                <input type="text" name="nome" id="nome">

                <!-- Campo Telefone-->
                <label for="telefone">Telefone</label>
                <input type="text" name="telefone" id="telefone">

                <!-- Campo Email-->
                <label for="email">Email</label>
                <input type="text" name="email" id="email">

                <input type="submit" value="cadastrar">

            </form>
        </section>
        <section id="direita">
            <table>
                <tr id="titulo">
                    <td>Nome</td>
                    <td>Telefone</td>
                    <td colspan="2">Email</td>
                </tr>
                <?php
                $dados = $p->buscarDados();
                // mostra os registros na tabela de contatos caso exista pessoas cadastradas
                if (count($dados) > 0) {
                    for ($i = 0; $i <  count($dados); $i++) {
                        echo "<tr>";
                        foreach ($dados[$i] as $key => $value) {
                            if ($key !== "id") {
                                echo "<td>" . $value . "</td>";
                            }
                        }
                        ?> <td>
                            <a href="">Editar</a>
                            <!-- passa via get o id a ser excluído ao clicar no botão excluir -->
                            <a href="index.php?id=<?php echo $dados[$i]['id']; ?>">Excluir</a></td>
                             <?php
                        echo "</tr>";
                    }
                }
                //banco vazio
                else {
                    echo "Ainda não há pessoas cadastradas";
                }
                ?>

            </table>
        </section>
    </div>

</body>

</html>

<?php 
if(isset($_GET["id"])){
    $id_pessoa = addslashes($_GET["id"]);
    $p -> excluirPessoa($id_pessoa);
    //reinicia a página
    header("location:index.php");
}


?>