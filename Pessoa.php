<?php

class Pessoa
{
    private $pdo;

    //CONEXAO COM O BANCO
    public function __construct($dbname, $host, $user, $password)
    {
        try {
            $this->pdo = new PDO("mysql:dbname=" . $dbname . ";host=" . $host, $user, $password);
        } catch (PDOException $e) {
            echo "Erro com o banco de dados: " . $e->getMessage();
            exit();
        } catch (Exception $e) {
            echo "Erro: " . $e->getMessage();
            exit();
        }
    }

    //Busca os dados e coloca no campo direito da tela
    public function buscarDados()
    {
        //ORDER BY  id DESC ordena os id de maneira decrescente
        $res = array();
        $cmd = $this->pdo->query("SELECT * FROM pessoa ORDER BY nome");
        $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }

    public function cadastrarPessoa(string $nome, string $telefone, string $email)
    {
        //VE SE O EMAIL JÁ EXISTE NA DATABASE
        $cmd = $this->pdo->prepare("SELECT id FROM pessoa WHERE email = :e ");
        $cmd->bindValue(":e", $email);
        $cmd->execute();

        //se o email nao for encontrado ele registra a pessoa na database;
        if (!$cmd->rowCount() > 0) {
            //REGISTRA PESSOA
            $cmd = $this->pdo->prepare("INSERT INTO pessoa(nome, telefone, email)values(:n, :t, :e)");
            $cmd->bindValue(":n", $nome);
            $cmd->bindValue(":t", $telefone);
            $cmd->bindValue(":e", $email);
            $cmd->execute();
            return true;
        }
        //retorna falso caso o email não exista
        return false;
    }

    public function excluirPessoa($id)
    {
        $cmd = $this->pdo->prepare("DELETE  FROM pessoa WHERE id = :id");
        $cmd->bindValue(":id", $id);
        $cmd->execute();
    }

    public function buscarDadosPessoa($id)
    {
        $res  = array();

        $cmd = $this->pdo->prepare("SELECT * FROM pessoa WHERE id = :id");
        $cmd->bindValue(":id", $id);
        $cmd->execute();

        $res = $cmd->fetch(PDO::FETCH_ASSOC);

        return $res;
    }

    //Atualiza dados no banco
    public function atualizarDados($id, $nome, $telefone, $email)
    {
        $cmd = $this->pdo->prepare("UPDATE pessoa SET nome = :n, telefone = :t, email = :e WHERE id = :id");
        $cmd->bindValue(":n", $nome);
        $cmd->bindValue(":t", $telefone);
        $cmd->bindValue(":e", $email);
        $cmd->bindValue(":id", $id);
        $cmd->execute();
    }
}
