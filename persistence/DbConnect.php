<?php    

    class dbConnect extends PDO {
        private $connect;


        public function __construct() {          
            $host = 'localhost';
            $nomeBanco = 'teste';
            $usuario = 'root';
            $senha = 'root';

            try{
                $this->connect = new PDO("mysql:host=$host;dbname=$nomeBanco", $usuario); 
                $this->connect-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $e){
                echo 'Erro na conexão com o banco de dados: ' .$e->getMessage();
            }                    
        }

        private function setParam($statement, $key, $value){
            $statement->bindParam($key, $value);
            return $statement;
        }

        private function setParams($statement, $parameters = array()){
            foreach($parameters as $key => $value){
                $this->setParam($statement, $key, $value);
            }
        }

        public function executeQuery($query, $params = array()){
            $statement = $this->connect->prepare($query);
            $this->setParams($statement, $params);
            $statement->execute();
            return $statement;
        }

        public function select($query, $params = array()){
            $statement = $this->executeQuery($query, $params);
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }
    }

?>