<?php
    class Database{

        private $db = null;

        public function __construct(){

            $this->db = new mysqli("localhost", "root", "", "projetoconcessionaria");

            if($this->db->connect_errno){
                throw new Exception("Erro ao conectar no banco de dados:\n {$this->db->connect_error}", 1);
                exit();
            }

        }

        /**
        * retornaLinha
        *
        * @param  string $sql - String com sql para retornar
        * @return object Retorna uma linha com o resultado do sql
        */
        public function retornaLinha($sql = null)
        {

            if (!empty($sql)) {
                if (!mysqli_query($this->db, $sql)) {
                    $err = mysqli_error($this->db);
                    throw new Exception("Erro: {$err}", 1);
                } else {
                    $busca = mysqli_query($this->db, $sql);

                    return mysqli_fetch_object($busca);
                }
            }
        }


        /**
        * retornaLista
        *
        * @param  mixed $sql
        * @return string Resultado em forma de array
        */
        public function retornaLista($sql = null)
        {

            if (!empty($sql)) {
                if (!mysqli_query($this->conexao, $sql)) {
                    $err = mysqli_error($this->conexao);
                    throw new Exception("Erro: {$err}", 1);
                } else {
                    $busca = mysqli_query($this->conexao, $sql);

                    $arr = mysqli_fetch_all($busca, MYSQLI_ASSOC);

                    $res = [];

                    foreach ($arr as $pos) {
                        $res[] = (object) $pos;
                    }

                    return $res;
                }
            }
        }

        public function insert($tabela = null, $campos = null){
            if(empty($tabela)){
                throw new Exception("Erro: Tabela não especificada", 1);
                exit();
            }

            if(empty($campos)){
                throw new Exception("Erro: Nenhum campo foi enviado para o Insert", 1);
                exit();
            }

            if(!empty($campos[0])){
                throw new Exception("Erro: Especifique o nome do campo que o valor deverá ser inserido na posição do array", 1);
                exit();
            }

            $_campos = [];
            $_valores = [];

            foreach($campos as $field => $value){
                $_campos[] = $field;
                $_valores[] = (empty($value) ? null : $value);
            }

            $_campos = implode(", ", $_campos);
            $_valores = implode("','", $_valores);

            $sql = "INSERT INTO {$tabela}({$_campos}) VALUES ('{$_valores}')";
            
            if ($this->db->query($sql) === TRUE) {
                return true;
            } else {
                throw new Exception("Erro: {$this->db->error}", 1);
                exit();
            }

        }

        public function executasql($sql){
            if ($this->db->query($sql) === TRUE) {
                return true;
            } else {
                throw new Exception("Erro: {$this->db->error}", 1);
                exit();
            }
        }

    }
?>