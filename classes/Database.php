<?php
    class Database{

        private $db = null;
        private $debug = false;

        public function __construct($debug = false){

            $this->debug = $debug;

            $this->db = new mysqli("sql10.freemysqlhosting.net", "sql10405941", "GLwHZDqbN7", "sql10405941", "3306");

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
                    if($this->debug){
                        $err = mysqli_error($this->db);
                        throw new Exception("Erro: {$err}", 1);
                    }else{
                        return false;
                    }
                    
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
                if (!mysqli_query($this->db, $sql)) {
                    if ($this->debug) {
                        $err = mysqli_error($this->db);
                        throw new Exception("Erro: {$err}", 1);
                    } else {
                        return false;
                    }
                } else {
                    $busca = mysqli_query($this->db, $sql);

                    $arr = mysqli_fetch_all($busca, MYSQLI_ASSOC);

                    $res = [];

                    foreach ($arr as $pos) {
                        $res[] = (object) $pos;
                    }

                    return $res;
                }
            }
        }

        public function delete($tabela = null, $where = null){
            if (empty($tabela)) {
                throw new Exception("Erro: Tabela não especificada", 1);
                exit();
            }

            $condition = "";

            if (!empty($where)) {

                $condition = "";

                foreach ($where as $key => $value) {

                    if (!empty($condition)) {
                        $condition .= " AND ";
                    }
                    $condition .= "{$key} = {$value}";
                }

                $condition = "WHERE {$condition}";
            }

            $sql = "DELETE FROM {$tabela} {$condition}";

            if ($this->db->query($sql) === TRUE) {

                return true;
            } else {
                if ($this->debug) {
                    $err = mysqli_error($this->db);
                    throw new Exception("Erro: {$err}", 1);
                } else {
                    return false;
                }
            }

        }

        public function update($tabela = null, $campos = null, $where = null){
            if (empty($tabela)) {
                throw new Exception("Erro: Tabela não especificada", 1);
                exit();
            }

            if (empty($campos)) {
                throw new Exception("Erro: Nenhum campo foi enviado para o Update", 1);
                exit();
            }

            if (!empty($campos[0])) {
                throw new Exception("Erro: Especifique o nome do campo que o valor deverá ser alterado na posição do array", 1);
                exit();
            }

            $set = "";

            foreach($campos as $key => $value){
                $set .= " {$key} = '{$value}',";
            }

            $set = rtrim($set, ",");
        
            $condition = "";

            if(!empty($where)){

                $condition = "";

                foreach($where as $key => $value){

                    if(!empty($condition)){
                        $condition .= " AND ";
                    }
                    $condition .= "{$key}='{$value}'";
                }

                $condition = "WHERE {$condition}";
            }

            $sql = "UPDATE {$tabela} SET {$set} {$condition}";

            if ($this->db->query($sql) === TRUE) {

                return true;
            } else {
                // if ($this->debug) {
                    $err = mysqli_error($this->db);
                    throw new Exception("Erro: {$err}", 1);
                // } else {
                //     return false;
                // }
            }

        }

        public function insert($tabela = null, $campos = null, $last_id = false){

            
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

                if($last_id){
                    return $this->db->insert_id;
                }

                return true;
            } else {
                if ($this->debug) {
                    $err = mysqli_error($this->db);
                    throw new Exception("Erro: {$err}", 1);
                } else {
                    return false;
                }
            }

        }

        public function executasql($sql){
            if ($this->db->query($sql) === TRUE) {
                return true;
            } else {
                if ($this->debug) {
                    $err = mysqli_error($this->db);
                    throw new Exception("Erro: {$err}", 1);
                } else {
                    return false;
                }
            }
        }

    }
?>