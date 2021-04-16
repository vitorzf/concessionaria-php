<?php

    function realizarLogin(){

        $credencial = post('emailuser');
        $senha = md5(post('senha'));

        if(filter_var($credencial, FILTER_VALIDATE_EMAIL)){
            $sql = "SELECT id, id_dados_funcionario, email, ativo, gerente FROM funcionario WHERE email = '{$credencial}' and senha = '{$senha}'";
        }else{
            die(json_encode(['erro' => true]));
        }

        $response = (array) $GLOBALS['database']->retornaLinha($sql);

        if(!empty($response)){

            if ($response['ativo'] == 0) {
                die(json_encode(['erro' => true, 'msg' => 'Usuario desativado']));
            }

            $set_sessao = $GLOBALS['session']->setSessionArray($response);
            if($set_sessao){
                die(json_encode(['erro' => false]));
            }
            echo json_encode(['erro' => true]);
        }else{
            echo json_encode(['erro' => true]);
        }

    }

    function atualizarLogin(){

        $id = $GLOBALS['session']->getSession('id');
        
        if(!empty($id)){
            $sql = "SELECT ativo, gerente FROM funcionario WHERE id = {$id}";

            $response = $GLOBALS['database']->retornaLinha($sql);
            
            if($response->ativo == "0"){
                $GLOBALS['session']->destroy();
                header("Location:" .$GLOBALS['config']->base_url());
            }

            $GLOBALS['session']->setSession("ativo", (int) $response->ativo);
            $GLOBALS['session']->setSession("gerente", (int) $response->gerente);

        }

    }

    function sair(){
        $GLOBALS['session']->destroy();
        echo json_encode(['error'=> false]);
    }

    function post($nome = null){
        if(empty($nome)){
            return $_POST;
        }
        if(empty($_POST[$nome])){
            return null;
        }
        return $_POST[$nome];
    }
?>