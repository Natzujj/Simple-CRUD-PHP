<?php
/* Em PHP é utilizado o padrão Active Record para manipular os dados da tabela. Neste padrão
   ocê pode criar uma única classe que encapsula tanto a definição dos atributos e comportamentos 
   da entidade quanto a lógica para persistir esses dados no banco.
 */
    class Jogos {
        private $id;
        private $nome;

        // public function __construct($id, $nome){
        //     $this->id = $id;
        //     $this->nome = $nome;
        // }

        public function getId(){
            return $this->id;
        }
        public function setId($id){
            $this->id = $id;
        }
        public function getNome(){
            return $this->nome;
        }
        public function setNome($nome){
            $this->nome = $nome;
        }

        public function create(){
            $sql = new DbConnect();
            if($this->getId() == null){
                $result = $sql->select("INSERT INTO `jogo` (`nome`) VALUES (:NOME)", array(
                    ":NOME"=>$this->getNome()
                    ));
                    if(count($result) > 0){
                        $this->setId($result[0]["id"]);
                    }
            }
        }

        public function getAll(){
            $sql = new DbConnect();
            $results = $sql->select("SELECT * FROM jogo");
            return $results;
        }

        public function loadById($id){
            $sql = new DbConnect();
            $results = $sql->select("SELECT * FROM `jogo` WHERE id = :ID", array(
                ":ID"=>$id
            ));
                if(count($results) > 0){
                    $row = $results[0];
                    $this->setId($row["id"]);
                    $this->setNome($row["nome"]);
                }
        }

        public function update(){
            $sql = new DbConnect();
            $sql->select("UPDATE `jogo` SET `nome` = :NOME WHERE `id` = :ID", array(
                ":NOME"=>$this->getNome(),
                ":ID"=>$this->getId()
            ));
        }

        public function delete(){
            $sql = new DbConnect();
            $sql->executeQuery("DELETE FROM `jogo` WHERE `id` = :ID", array(
                ":ID"=>$this->getId()
            ));
        }

        public function __toString(){
            return json_encode(array(
                "idusuario"=>$this->getId(),
                "deslogin"=>$this->getNome()
            ));  
        }
    }
?>