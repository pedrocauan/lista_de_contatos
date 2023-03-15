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

    public function buscarDados(){
        //ORDER BY  id DESC ordena os id de maneira decrescente
        $res = array();
        $cmd = $this -> pdo -> query("SELECT * FROM pessoa ORDER BY nome");
        $res = $cmd-> fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }
   
}

?>