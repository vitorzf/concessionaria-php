<?php

    function cadastrarUsuario(){
        $usuario = post("usuario");
        $email = post("email");
        $senha = post("senha");

        $dados = [
            "nome" => $usuario,
            "email" => $email,
            "senha" => md5($senha),
            "cargo_id" => 2
        ];

        $insert = $GLOBALS['database']->insert("usuarios", $dados);

        if($insert){
            $result = ['erro' => false];
        }else{
            $result = ['erro' => true];
        }

        echo json_encode($result);
    }

    function realizarLogin(){

        $credencial = post('emailuser');
        $senha = md5(post('senha'));

        if(filter_var($credencial, FILTER_VALIDATE_EMAIL)){
            $sql = "SELECT * FROM funcionario WHERE email = '{$credencial}' and senha = '{$senha}'";
        }else{
            die(json_encode(['erro' => true]));
        }

        $response = (array) $GLOBALS['database']->retornaLinha($sql);

        if(!empty($response)){
            $set_sessao = $GLOBALS['session']->setSessionArray($response);
            if($set_sessao){
                die(json_encode(['erro' => false]));
            }
            echo json_encode(['erro' => true]);
        }else{
            echo json_encode(['erro' => true]);
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
        return $_POST[$nome];
    }
?>