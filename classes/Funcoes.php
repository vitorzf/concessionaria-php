<?php
    class Funcoes{

        public function __construct()
        {
        
        }

        public function nomeLogin(){

            $id = $GLOBALS['session']->getSession("id_dados_funcionario");

            if(!empty($id)){
                $result = $GLOBALS['database']->retornaLinha("SELECT nome FROM dados_funcionario d WHERE d.id = {$id}");

                return $result->nome;
            }

            return null;
            
        }

        public function usuarioGerente(){
            $response = $GLOBALS['session']->getSession('gerente');
        
            if($response){
                return true;
            }

            return false;
        }

    }
