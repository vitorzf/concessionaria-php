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

function lista_tipos_carros()
{

    $filtro = "";

    if (!empty(post('pesquisa'))) {
        $pesquisa = post('pesquisa');

        $filtro = " WHERE t.nome LIKE '%{$pesquisa}%' ";
    }

    if(empty($filtro)){
        $filtro = " WHERE t.visivel = 1";
    }else{
        $filtro .= " AND t.visivel = 1";
    }

    $sql = "SELECT * 
            from tipo_carro t
            {$filtro}
            order by t.nome asc";

    $resultados = $GLOBALS['database']->retornaLista($sql);

    $html = "";

    if (empty($resultados)) {
        $html = "<tr><td colspan=\"6\" class=\"text-center\">Nenhum tipo de carro encontrado</td></tr>";
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
                                        <a class=\"dropdown-item\" href=\"javascript:alterar_tipo_carro('{$resultado->id}')\">Alterar</a>
                                        <a class=\"dropdown-item\" href=\"javascript:excluir_tipo_carro('{$resultado->id}')\">Excluir</a>
                                    </div>
                                </div>
                            </td>";
            } else {

                $botao = "";
            }

            $html .= "  <tr>
                                <td>{$resultado->nome}</td>
                                {$botao}
                            </tr>";
        }

        echo json_encode(['html' => $html]);
    }
}

function filtro_tipo_carros(){

    $sql = "SELECT id, nome FROM tipo_carro where visivel = 1 order by nome asc";

    $resultados = $GLOBALS['database']->retornaLista($sql);


    if(!$resultados){
        die(json_encode(['erro' => true]));
    }

    $html = "";

    foreach($resultados as $resultado){
        $html .= "<option value=\"{$resultado->id}\">{$resultado->nome}</option>";
    }

    if(empty($html)){
        $html = "<option value=\"default\">Nenhuma opção encontrada</option>";
    }else{
        $html = "<option value=\"default\">Tipo de Carro</option>" . $html;
    }

    echo json_encode(['erro' => false, 'html' => $html]);
}

function criar_alterar_carro(){
    $id = post("id");
    $nome = post("nome");
    // $placa = post("placa");
    $modelo = post("modelo");
    $marca = post("marca");
    $cor = post("cor");
    $tipo = post("tipo");
    $valor = (float) post("valor");
    $estoque = (int) post("estoque");
    $fotos = post("fotos");
    
    $arr_fotos = [];
    if(!empty($fotos)){
        foreach($fotos as $foto){
            $arr_fotos[] = ["url" => $foto];
        }
    }

    $dados = [
        'nome' => $nome,
        // 'placa' => $placa,
        'modelo' => $modelo,
        'marca' => $marca,
        'cor' => $cor,
        'tipo_id' => $tipo,
        'valor' => $valor,
        'estoque' => $estoque,
        'fotos' => json_encode($arr_fotos, JSON_UNESCAPED_UNICODE)
    ];

    if(empty($id)){
        
        $result = $GLOBALS['database']->insert("carro", $dados);

        if ($result) {
            die(json_encode(['erro' => false]));
        }

        echo json_encode(['erro' => true]);
    }else{

        $dados_carro = dados_carro($id);
        
        if($dados_carro->estoque != $dados['estoque']){
            registrar_movimentacao_estoque($id, $dados_carro->estoque, $dados['estoque']);
        }

        $result = $GLOBALS['database']->update('carro', $dados, ["id" => $id]);

        if ($result) {
            die(json_encode(['erro' => false]));
        }

        echo json_encode(['erro' => true]);

    }

}

function registrar_movimentacao_estoque($carro, $estoque_anterior, $novo_estoque){

    $id = $GLOBALS['session']->getSession("id");

    $dados = [
        'estoque_anterior' => $estoque_anterior,
        'novo_estoque' => $novo_estoque,
        'carro_id' => $carro,
        'gerente_id' => $id
    ];

    $GLOBALS['database']->insert("movimentacao_estoque", $dados);

    return true;

}

function dados_carro($id){

    $sql = "SELECT * FROM carro WHERE id = '{$id}'";

    $resultado = $GLOBALS['database']->retornaLinha($sql);

    if (!$resultado) {
        die(json_encode(['erro' => true]));
    }

    return $resultado;

}

function lista_carros()
{

    $filtro = "";

    if(!empty(post('filtro'))){
        $params = post('filtro');
        $params = (object) $params[0];

        $pesquisa = strtolower($params->pesquisa);

        $filtro = "WHERE lower(c.{$params->tipo}) like '%{$pesquisa}%'";
    }
    
    $tipo = post("tipo_carro");

    if(!empty($tipo)){
        if (empty($filtro)) {
            $filtro .= " AND c.tipo_id = '{$tipo}' ";
        } else {
            $filtro = " WHERE c.tipo_id = '{$tipo}' ";
        }
    }
    
    if (!empty($filtro)) {
        $filtro .= " AND c.visivel = 1 ";
    } else {
        $filtro = " WHERE c.visivel = 1 ";
    }
    
    $sql = "SELECT c.*,
            tc.nome as tipo_carro
            from carro c
            inner join tipo_carro tc on tc.id = c.tipo_id
            {$filtro}
            order by c.nome asc";

    $resultados = $GLOBALS['database']->retornaLista($sql);
    
    $html = "";

    if (empty($resultados)) {
        $html = "<tr><td colspan=\"6\" class=\"text-center\">Nenhum tipo de carro encontrado</td></tr>";
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
                                        <a class=\"dropdown-item\" href=\"javascript:alterar_carro('{$resultado->id}')\">Alterar</a>
                                        <a class=\"dropdown-item\" href=\"javascript:excluir_carro('{$resultado->id}')\">Excluir</a>
                                    </div>
                                </div>
                            </td>";
            } else {

                $botao = "";
            }

            $html .= "  <tr>
                                <td>{$resultado->nome}</td>
                                <td class=\"text-center\">{$resultado->modelo}</td>
                                <td class=\"text-center\">{$resultado->tipo_carro}</td>
                                <td class=\"text-center\">{$resultado->cor}</td>
                                <td class=\"text-center\">{$resultado->estoque}</td>
                                {$botao}
                            </tr>";
        }

        echo json_encode(['html' => $html]);
    }
}

function cadastrar_alterar_tipo_carro(){
    $id = post("id");
    $nome = post("nome");

    $dados = [
        "nome" => $nome
    ];

    if(empty($id)){
        $result = $GLOBALS['database']->insert('tipo_carro', $dados);

        if($result){
            die(json_encode(['erro' => false]));
        }

        echo json_encode(['erro' => true]);
    }else{

        $result = $GLOBALS['database']->update('tipo_carro', $dados, ["id" => $id]);

        if($result){
            die(json_encode(['erro' => false]));
        }

        echo json_encode(['erro' => true]);
    }
}

function buscar_tipo_carro(){
    $id = post("id");

    $sql = "SELECT nome FROM tipo_carro WHERE id = '{$id}'";

    $result = $GLOBALS['database']->retornaLinha($sql);

    if ($result) {
        die(json_encode(['erro' => false, 'nome' => $result->nome]));
    }

    echo json_encode(['erro' => true]);
}

function excluir_tipo_carro(){
    $id = post("id");

    $dados = [
        'visivel' => 0    
    ];

    $result = $GLOBALS['database']->update('tipo_carro', $dados, ["id" => $id]);

    if ($result) {
        die(json_encode(['erro' => false]));
    }

    echo json_encode(['erro' => true]);
}

function buscar_dados_carro(){
    $id = post("id");

    $sql = "SELECT * FROM carro WHERE id = '{$id}'";

    $resultado = $GLOBALS['database']->retornaLinha($sql);

    if (!$resultado) {
        die(json_encode(['erro' => true]));
    }

    unset($resultado->visivel);

    $fotos = json_decode($resultado->fotos);

    $resultado->foto1 = (!empty($fotos[0]->url) ? $fotos[0]->url : '');
    $resultado->foto2 = (!empty($fotos[1]->url) ? $fotos[1]->url : '');
    $resultado->foto3 = (!empty($fotos[2]->url) ? $fotos[2]->url : '');
    $resultado->foto4 = (!empty($fotos[3]->url) ? $fotos[3]->url : '');

    unset($resultado->fotos);

    echo json_encode(['erro' => false, 'dados' => $resultado]);
}

function excluir_carro(){
    $id = post("id");

    $dados = [
        'visivel' => 0    
    ];

    $result = $GLOBALS['database']->update('carro', $dados, ["id" => $id]);

    if ($result) {
        die(json_encode(['erro' => false]));
    }

    echo json_encode(['erro' => true]);
}

?>