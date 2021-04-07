<?php
    class Session{

        public function __construct()
        {
            
        }

        public function setSessionArray($campos = [])
        {
            if (empty($campos)) {
                throw new Exception("Erro: Nenhum campo foi enviado para setar a sessão", 1);
                exit();
            }

            if (!empty($campos[0])) {
                throw new Exception("Erro: Especifique o nome do campo que o valor deverá ser inserido na posição do array", 1);
                exit();
            }

            foreach ($campos as $field => $value) {

                $_SESSION[$field] = $value;
            
            }

            return true;

        }

        public function setSession($campo, $valor){
            $_SESSION[$campo] = $valor;

            return true;
        }

        public function getSession($campo = null){
            if(empty($campo)){
                return $_SESSION;
            }
                
            return $_SESSION[$campo];
        }

        public function logado(){
            
            if(!empty($_SESSION['email'])){
                return true;
            }

            return false;
        }

        public function destroy(){
            session_unset();
        }

}
