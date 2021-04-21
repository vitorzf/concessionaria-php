<?php

    function post($nome = null){

        if(empty($nome)){
            return $_POST;
        }
        if(empty($_POST[$nome])){
            return null;
        }
        return $_POST[$nome];
    }

    function alterar_status_conta(){
        $id = post("id");
        $alterar_para = (post('status') == 'desativar' ? 0 : 1);

        $dados = ['ativo' => $alterar_para];

        $where = ["id" => $id];

        $result = $GLOBALS['database']->update('funcionario', $dados, $where);
        if ($result) {
            die(json_encode(['erro' => false]));
        }
        echo json_encode(['erro' => true]);
    }

    function alterar_tipo_conta(){
        $id = post("id");

        $cargo = (post("tipo") == "gerente" ? 1 : 0);

        $dados = ['gerente' => $cargo];

        $where = ["id" => $id];

        $result = $GLOBALS['database']->update('funcionario', $dados, $where);
        if($result){
            die(json_encode(['erro' => false]));
        }
        echo json_encode(['erro' => true]);
    }

    function lista_funcionarios(){
        
        $_id = $GLOBALS['session']->getSession("id");

        $filtro = "";
        if(!empty(post('filtro'))){
            $params = post('filtro');
            $params = (object) $params[0];
            $busca = "";

            switch ($params->tipo) {
                case 'nome':
                    $busca = "LIKE '%{$params->pesquisa}%";
                    break;
                case 'cpf':
                case 'rg':
                case 'telefone':
                    $busca = "= '{$params->pesquisa}";
                    break;
                
                default:
                    $busca = "= '{$params->pesquisa}";
                    break;
            }

            $filtro = "WHERE df.{$params->tipo} {$busca}'";
        }

        $sql = "SELECT  f.id as funcionario_id,
                        f.ativo,
                        f.gerente,
                        df.id as dados_id,
                        df.nome,
                        df.cpf,
                        df.rg,
                        df.telefone
                FROM funcionario f
                inner join dados_funcionario df on f.id_dados_funcionario = df.id
                {$filtro}
                AND f.id not in({$_id})
                order by df.nome asc
                ";

        $resultados = $GLOBALS['database']->retornaLista($sql);

        $html = "";

        if(empty($resultados)){
            $html = "<tr><td colspan=\"6\" class=\"text-center\">Nenhum funcionário encontrado</td></tr>";
            die(json_encode(['html' => $html]));
        }else{
            foreach($resultados as $resultado){

                $gerente = $GLOBALS['funcoes']->usuarioGerente();

                if($gerente){

                    $tipo = ($resultado->gerente == 1 ? 'vendedor' : 'gerente');
                    $status = ($resultado->ativo == 1 ? 'desativar' : 'ativar');
                    $titulo_status = ucfirst($status);

                    $botao = "<td class=\"text-center\">
                                <div class=\"btn-group\">
                                    <button class=\"btn btn-success btn-sm\">Opções</button>
                                    <button class=\"btn btn-success btn-sm dropdown-toggle dropdown-toggle-split\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
                                        <span class=\"sr-only\">Abrir Dropdown</span>
                                    </button>
                                    <div class=\"dropdown-menu dropdown-menu-right\">
                                        <a class=\"dropdown-item\" href=\"javascript:alterarTipoConta('{$resultado->funcionario_id}','{$tipo}')\">Alterar para {$tipo}</a>
                                        <div class=\"dropdown-divider\"></div>
                                        <a class=\"dropdown-item\" href=\"javascript:alterarStatusConta('{$status}','{$resultado->funcionario_id}')\">{$titulo_status} Conta</a>
                                    </div>
                                </div>
                            </td>";

                }else{

                    $botao = "";

                }
               

                if($resultado->ativo == "1"){
                    $situacao = "<span style=\"color:green;font-weight:bold;\">Ativo</span>";
                }else{
                    $situacao = "<span style=\"color:red;font-weight:bold;\">Inativado</span>";
                }

                $cor = ($resultado->gerente == 1 ? 'color: green;' : 'color: blue;');

                $nome = "<i class=\"fa fa-circle\" style=\"{$cor}\"></i> {$resultado->nome}";

                $html .= "  <tr>
                                <td>{$nome}</td>
                                <td class=\"text-center\">{$resultado->cpf}</td>
                                <td class=\"text-center\">{$resultado->rg}</td>
                                <td class=\"text-center\">{$resultado->telefone}</td>
                                <td class=\"text-center\">{$situacao}</td>
                                {$botao}
                            </tr>";
            }

            $html .= "<tr>
                <td colspan=\"6\" class=\"text-center\">
                    <i class=\"fa fa-circle\" style=\"color:green;\"></i> Gerente
                    <i class=\"fa fa-circle\" style=\"color:blue;\"></i> Vendedor 
                </td>
            </tr>";

            echo json_encode(['html' => $html]);
            
        }

    }

    function cadastrar_funcionario(){
        $nome = post('nome');
        $telefone = post('telefone');
        $cpf = post('cpf');
        $rg = post('rg');
        $email = post('email');
        $senha = md5(post('senha'));
        $tipo_usuario = post("tipo_usuario");

        $dados = [
            'nome' => $nome,
            'telefone' => $telefone,
            'cpf' => $cpf,
            'rg' => $rg
        ];

        $id = $GLOBALS['database']->insert("dados_funcionario",$dados, true);

        if(!empty($id)){
            $dados_funcionario = [
                'id_dados_funcionario' => $id,
                'email' => $email,
                'senha' => $senha,
                'gerente' => ($tipo_usuario == 'gerente' ? 1 : 0)
            ];

            $insert_funcionario = $GLOBALS['database']->insert('funcionario', $dados_funcionario);

            if($insert_funcionario){
                echo json_encode(['erro' => false]);
            }else{
                echo json_encode(['erro' => true, 'msg' => "Erro ao salvar funcionário!"]);
            }
        }else{
            echo json_encode(['erro' => true, 'msg' => "Erro ao salvar endereço!"]);
        }

    }

?>