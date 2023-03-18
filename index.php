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
        // CLICOU NO BOTAO CADASTRAR OU EDITAR
        if (!empty($_POST)) {
            //---------------- EDITAR ----------------
            if (isset($_GET["id_up"]) && !empty($_GET["id_up"])) {
                $id_update = strip_tags(htmlspecialchars($_GET["id_up"]));
                $nome = (string) strip_tags(htmlspecialchars(($_POST["nome"])));
                $telefone = (string)  strip_tags(htmlspecialchars(($_POST["telefone"]))); 
                $email = (string) strip_tags(htmlspecialchars(($_POST["email"]))); 
                // Verifica se os campos estao vazios
                if (!empty($nome) && !empty($telefone) && !empty($email)) {
                    //Ve se o usuario já está cadastrado
                    $p->atualizarDados($id_update, $nome, $telefone, $email);
                    header("location:index.php");
                } else {
                    echo "Preencha todos os campos";
                }
            }
            // -------------- CADASTRAR ----------------
            else {
                $nome = (string) strip_tags(htmlspecialchars(($_POST["nome"])));
                $telefone = (string)  strip_tags(htmlspecialchars(($_POST["telefone"]))); 
                $email = (string) strip_tags(htmlspecialchars(($_POST["email"]))); 

                // Verifica se os campos estao vazios
                if (!empty($nome) && !empty($telefone) && !empty($email)) {
                    //Ve se o usuario já está cadastrado
                    if (!$p->cadastrarPessoa($nome, $telefone, $email)) {
                        echo "Email já cadastrado";
                    }
                } else {
                    echo "Preencha todos os campos";
                }
            }
        }
        ?>

        <?php
        if (isset($_GET["id_up"])) {
            $id_update = addslashes($_GET["id_up"]);

            $res = $p->buscarDadosPessoa($id_update);
        }

        ?>
        <section id="esquerda">
            <form action="" method="POST">
                <h2>Cadastrar Pessoa</h2>
                <!-- Campo Nome-->
                <label for="nome">Nome</label>
                <input type="text" name="nome" id="nome" value="<?php if (isset($res)) {
                                                                    echo $res['nome'];
                                                                } ?>">

                <!-- Campo Telefone-->
                <label for="telefone">Telefone</label>
                <input type="text" name="telefone" id="telefone" value="<?php if (isset($res)) {
                                                                            echo $res['telefone'];
                                                                        } ?>">

                <!-- Campo Email-->
                <label for="email">Email</label>
                <input type="text" name="email" id="email" value="<?php if (isset($res)) {
                                                                        echo $res['email'];
                                                                    } ?>">

                <input type="submit" value="<?php if (isset($res)) {
                                                echo "atualizar";
                                            } else {
                                                echo "cadastrar";
                                            } ?>">

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
                            <a href="index.php?id_up=<?php echo $dados[$i]['id'] ?>">Editar</a>
                            <!-- passa via get o id a ser excluído ao clicar no botão excluir -->
                            <a href="index.php?id=<?php echo $dados[$i]['id']; ?>">Excluir</a>
                        </td>
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
//deleta o usuario quando clica no 
if (isset($_GET["id"])) {
    $id_pessoa = addslashes($_GET["id"]);
    $p->excluirPessoa($id_pessoa);
    //reinicia a página
    header("location:index.php");
}


?>