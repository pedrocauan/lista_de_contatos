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
        <section id="esquerda">
            <form action="">
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
                // mostra os registros na tabela de contatos
                if (count($dados) > 0) {
                    for ($i = 0; $i <  count($dados); $i++) {
                        echo "<tr>";
                        foreach ($dados[$i] as $key => $value) {
                            if ($key !== "id") {
                                echo "<td>" . $value . "</td>";
                            }
                        }
                        ?> <td><a href="">Editar</a><a href="">Excluir</a></td> <?php
                        echo "</tr>";
                    }
                
               
                }
                ?>

            </table>
        </section>
    </div>

</body>

</html>