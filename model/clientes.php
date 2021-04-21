<?php

function post($nome = null)
{
    if (empty($nome)) {
        return $_POST;
    }
    if (empty($_POST[$nome])) {
        return null;
    }
    return $_POST[$nome];
}

function criar_cliente(){

    $nome = post("nome");
    $email = post("email");
    $rg = post("rg");
    $cpf = post("cpf");
    $telefone = post("telefone");
    $estado = post("estado");
    $rua = post("rua");
    $cidade = post("cidade");
    $numero = post("numero");
    $bairro = post("bairro");
    $cep = post("cep");

    $dados_endereco = [
        "rua" => $rua,
        "bairro" => $bairro,
        "cidade" => $cidade,
        "estado" => $estado,
        "numero" => $numero,
        "cep" => $cep
    ];

    $endereco_id = $GLOBALS['database']->insert("endereco", $dados_endereco, true);

    if(empty($endereco_id)){
        die(json_encode(['erro' => true, 'msg' => "Erro ao salvar endereço"]));
    }

    $dados_cliente = [
        "nome" => $nome,
        "email" => $email,
        "telefone" => $telefone,
        "RG" => $rg,
        "CPF" => $cpf,
        "endereco_id" => $endereco_id
    ];

    $dados_cliente_id = $GLOBALS['database']->insert("dados_cliente", $dados_cliente, true);

    if (empty($dados_cliente_id)) {
        die(json_encode(['erro' => true, 'msg' => "Erro ao dados do cliente"]));
    }

    $cliente = [
        "id_dados_cliente" => $dados_cliente_id    
    ];

    $resultado = $GLOBALS['database']->insert("cliente", $cliente);

    if(!$resultado){
        die(json_encode(['erro' => true]));
    }else{
        echo json_encode(['erro' => false]);
    }

}

function lista_clientes(){

    $filtro = "";

    if (!empty(post('filtro'))) {
        $params = post('filtro');
        $params = (object) $params[0];

        $pesquisa = mb_strtolower($params->pesquisa);

        switch ($params->tipo) {
            case 'nome':
            case 'email':
                $filtro = "WHERE lower(dc.{$params->tipo}) like '%{$pesquisa}%'";
                break;

            case 'rua':
            case 'bairro':
            case 'cidade':
            case 'estado':
                $filtro = "WHERE lower(e.{$params->tipo}) like '%{$pesquisa}%'";
                break;

            case 'cpf':
            case 'rg':
            case 'telefone':
                $filtro = "WHERE lower(dc.{$params->tipo}) = '{$pesquisa}'";
                break;
        }

        
    }

    if (!empty($filtro)) {
        $filtro .= " AND c.visivel = 1 ";
    } else {
        $filtro = " WHERE c.visivel = 1 ";
    }

    $sql = "SELECT 
                c.id,
                c.id_dados_cliente as dados_id,
                dc.nome,
                dc.email,
                dc.telefone,
                dc.RG rg,
                dc.CPF cpf,
                e.rua,
                e.bairro,
                e.cidade,
                e.estado,
                e.numero,
                e.cep
            FROM cliente c
            inner join dados_cliente dc on dc.id = c.id_dados_cliente
            inner join endereco e on e.id = dc.endereco_id
            {$filtro}";

    $resultados = $GLOBALS['database']->retornaLista($sql);

    $html = "";

    if (empty($resultados)) {
        $html = "<tr><td colspan=\"100\" class=\"text-center\">Nenhum cliente encontrado</td></tr>";
        die(json_encode(['html' => $html]));
    } else {
        foreach ($resultados as $resultado) {

            $gerente = $GLOBALS['funcoes']->usuarioGerente();

            if ($gerente) {

                $botao = "<td class=\"text-center\">
                                <div class=\"btn-group\">
                                    <button class=\"btn btn-success btn-sm\">Opções</button>
                                    <button class=\"btn btn-success btn-sm dropdown-toggle dropdown-toggle-split\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
                                        <span class=\"sr-only\">Abrir Dropdown</span>
                                    </button>
                                    <div class=\"dropdown-menu dropdown-menu-right\">
                                        <a class=\"dropdown-item\" href=\"javascript:alterar_cliente('{$resultado->id}')\">Alterar</a>
                                        <a class=\"dropdown-item\" href=\"javascript:excluir_cliente('{$resultado->id}')\">Excluir</a>
                                    </div>
                                </div>
                            </td>";
            } else {

                $botao = "";
            }

            $botao_endereco = "<a class=\"btn-endereco\" style=\"cursor:pointer\" rua=\"{$resultado->rua}\" bairro=\"{$resultado->bairro}\" cidade=\"{$resultado->cidade}\" estado=\"{$resultado->estado}\" numero=\"{$resultado->numero}\" cep=\"{$resultado->cep}\">Endereço</a>";

            $html .= "  <tr>
                                <td>{$resultado->nome}</td>
                                <td class=\"text-center\">{$resultado->email}</td>
                                <td class=\"text-center\">{$resultado->telefone}</td>
                                <td class=\"text-center\">{$resultado->rg}</td>
                                <td class=\"text-center\">{$resultado->cpf}</td>
                                <td class=\"text-center\">{$botao_endereco}</td>
                                {$botao}
                            </tr>";
        }

        echo json_encode(['html' => $html]);

    }
}

function alterar_cliente(){

    $id = post("id");
    $nome = post("nome");
    $email = post("email");
    $rg = post("rg");
    $cpf = post("cpf");
    $telefone = post("telefone");
    $estado = post("estado");
    $rua = post("rua");
    $cidade = post("cidade");
    $numero = post("numero");
    $bairro = post("bairro");
    $cep = post("cep");

    $busca_dados_cliente = $GLOBALS['database']->retornaLinha("SELECT * FROM cliente where id = '{$id}'");

    if (!$busca_dados_cliente) {
        die(json_encode(['erro' => true, 'msg' => "Erro ao buscar dados do cliente"]));
    }

    $dados_cliente = [
        "nome" => $nome,
        "email" => $email,
        "telefone" => $telefone,
        "RG" => $rg,
        "CPF" => $cpf,
        "data_alteracao" => date("Y-m-d H:i:s")
    ];

    $result = $GLOBALS['database']->update("dados_cliente", $dados_cliente, ["id" => $busca_dados_cliente->id_dados_cliente]);

    if(!$result){
        die(json_encode(['erro' => true]));
    }

    $busca_dados_endereco = $GLOBALS['database']->retornaLinha("SELECT endereco_id FROM dados_cliente where id = '{$busca_dados_cliente->id_dados_cliente}'");

    if (!$busca_dados_endereco) {
        die(json_encode(['erro' => true, 'msg' => "Erro ao buscar dados de endereço do cliente"]));
    }

    $dados_endereco = [
        "rua" => $rua,
        "bairro" => $bairro,
        "cidade" => $cidade,
        "estado" => $estado,
        "numero" => $numero,
        "cep" => $cep
    ];

    $result = $GLOBALS['database']->update("endereco", $dados_endereco, ["id" => $busca_dados_endereco->endereco_id]);

    if (!$result) {
        die(json_encode(['erro' => true, 'msg' => "Erro ao dados do cliente"]));
    }else{
        echo json_encode(['erro' => false]);
    }

    // if (!$resultado) {
    //     die(json_encode(['erro' => true]));
    // } else {
    //     echo json_encode(['erro' => false]);
    // }

}

function buscar_dados_cliente()
{
    $id = post("id");

    $sql = "SELECT 
                c.id,
                c.id_dados_cliente as dados_id,
                dc.nome,
                dc.email,
                dc.telefone,
                dc.RG rg,
                dc.CPF cpf,
                e.rua,
                e.bairro,
                e.cidade,
                e.estado,
                e.numero,
                e.cep
            FROM cliente c
            inner join dados_cliente dc on dc.id = c.id_dados_cliente
            inner join endereco e on e.id = dc.endereco_id
            WHERE c.id = '{$id}'";

    $resultado = $GLOBALS['database']->retornaLinha($sql);

    if (!$resultado) {
        die(json_encode(['erro' => true]));
    }

    echo json_encode(['erro' => false, 'dados' => $resultado]);
}

?>