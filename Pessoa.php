<?php 

class Pessoa {
    private $pdo;

    //CONEXAO COM O BANCO
    public function __construct($dbname, $host, $user, $password)
    {
        try{
            $this->pdo = new PDO("mysql:dbname=" . $dbname . ";host=" . $host, $user, $password);    

        }
        catch(PDOException $e){
            echo "Erro com o banco de dados: " . $e-> getMessage();
            exit();
        } 
        catch (Exception $e) {
            echo "Erro: " . $e-> getMessage();
            exit();

        }

    }

   
}

?>