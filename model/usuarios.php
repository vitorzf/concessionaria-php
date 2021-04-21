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

    function alterar_dados_funcionario(){
        $id = $GLOBALS['session']->getSession("id_dados_funcionario");  
        $dados = [
            'nome' => post("nome"),
            'telefone' => post('telefone'),
            'RG' => post("rg"),
            'CPF' => post('cpf')
        ];

        $alterar_dados = $GLOBALS['database']->update("dados_funcionario", $dados, ['id' => $id]);

        if (!$alterar_dados) {
            die(json_encode(['erro' => true]));
        }

        echo json_encode(['erro' => false]);
    }

    function buscar_info_funcionario(){
        $id = $GLOBALS['session']->getSession("id_dados_funcionario");
    

        $dados = $GLOBALS['database']->retornaLinha("SELECT nome, CPF as cpf, RG as rg, telefone from dados_funcionario where id = '{$id}'");
        
        if(empty($dados)){
            die(json_encode(['erro' => true, 'msg' => "Dados do usuario não encontrado"]));
        }else{
            echo json_encode(['erro' => false, 'nome' => $dados->nome, 'rg' => $dados->rg, 'cpf' => $dados->cpf, 'telefone' => $dados->telefone]);
        }
    }

    function alterar_senha(){
        $senha_atual = md5(post("senhaAtual"));
        $novaSenha = md5(post("novaSenha1"));

        $id = $GLOBALS['session']->getSession("id");

        $verifica_senha = $GLOBALS['database']->retornaLinha("SELECT * from funcionario where id = '{$id}' and senha = '{$senha_atual}'");

        if(empty($verifica_senha)){
            die(json_encode(['erro' => true, 'msg' => "A senha atual está incorreta"]));
        }

        $dados = [
            "senha" => $novaSenha
        ];

        $alterar_senha = $GLOBALS['database']->update("funcionario", $dados, ['id' => $id]);

        if(!$alterar_senha){
            die(json_encode(['erro' => true]));
        }

        echo json_encode(['erro' => false]);
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