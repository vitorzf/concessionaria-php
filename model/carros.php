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

    if(empty($resultados)){

      return "<option value=\"default\">Nenhuma opção encontrada</option>";
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

function detalhes_carro()
{

    $id = post("id");

    $sql = "SELECT

                c.nome as nome_carro,
                c.modelo,
                c.cor,
                c.marca,
                c.fotos,
                c.valor,
                tc.nome as tipo_carro

            FROM carro c
            inner join tipo_carro tc on tc.id = c.tipo_id
            where c.id = '{$id}'";

    $detalhes = $GLOBALS['database']->retornaLinha($sql);

    if (!$detalhes) {
        die(json_encode(['erro' => true]));
    }

    if (empty($detalhes)) {
        die(json_encode(['erro' => true]));
    }

    $li_carrossel = "";
    $div_fotos = "";

    $fotos = json_decode($detalhes->fotos);
    foreach ($fotos as $pos => $foto) {
        $active = "";
        $class_active = "";
        if ($pos == 0) {
            $active = "class=\"active\"";
            $class_active = "active";
        }
        $li_carrossel .= "<li data-target=\"#carouselExampleIndicators\" data-slide-to=\"{$pos}\" {$active}></li>";



        $div_fotos .= "<div class=\"carousel-item {$class_active}\">
                        <img src=\"{$foto->url}\" class=\"d-block w-100\">
                    </div>";
    }

    $hide_carrossel = "";

    if (empty($div_fotos)) {
        $hide_carrossel = " style=\"display:none;\" ";
    }

    $valor_carro = number_format($detalhes->valor, 2, ",", ".");

    $html = "<div class=\"row\">
          <div class=\"col-xs-12 col-sm-12 col-md-6 col-lg-6\" {$hide_carrossel}>
            <p class=\"titulo-detalhes text-center\">Fotos do carro</p>
            <div class=\"container-fluid\">
              <div id=\"carouselExampleIndicators\" class=\"carousel slide\" data-ride=\"carousel\">
                <ol class=\"carousel-indicators\">
                  {$li_carrossel}
                </ol>
                <div class=\"carousel-inner\">
                  {$div_fotos}
                </div>
                <a class=\"carousel-control-prev\" href=\"#carouselExampleIndicators\" role=\"button\" data-slide=\"prev\">
                  <span class=\"carousel-control-prev-icon\" aria-hidden=\"true\"></span>
                  <span class=\"sr-only\">Previous</span>
                </a>
                <a class=\"carousel-control-next\" href=\"#carouselExampleIndicators\" role=\"button\" data-slide=\"next\">
                  <span class=\"carousel-control-next-icon\" aria-hidden=\"true\"></span>
                  <span class=\"sr-only\">Next</span>
                </a>
              </div>

            </div>
          </div>
          <div class=\"col-xs-12 col-sm-12 col-md-6 col-lg-6\">
            <p class=\"titulo-detalhes text-center\">Detalhes do carro</p>
            <span class=\"font-bold\">Nome: </span>{$detalhes->nome_carro}<br />
              <span class=\"font-bold\">Modelo: </span>{$detalhes->modelo} - {$detalhes->tipo_carro}<br />
              <span class=\"font-bold\">Cor: </span>{$detalhes->cor}<br />
              <span class=\"font-bold\">Marca: </span>{$detalhes->marca}<br />
              <span class=\"font-bold\">Valor: </span>{$valor_carro}<br />
          </div>
        </div>";

    echo json_encode(['erro' => false, 'html' => $html]);
}

function alterar_status_venda()
{

    $id = post("id");
    $status = post("status");

    $alterar_para = "";

    switch ($status) {
        case 'cancelar':
            $alterar_para = "0";
            break;
        case 'reverter':
            $alterar_para = "1";
            break;
    }

    $dados = [
        'status' => $alterar_para
    ];

    $retorno = $GLOBALS['database']->update("vendas", $dados, ['id' => $id]);

    if (!$retorno) {
        die(json_encode(['erro' => true]));
    }

    echo json_encode(['erro' => false]);
}

function lista_carros_home(){

    $filtro = "";

    $pesquisa = post("pesquisa");

    if(!empty($pesquisa)){
        $filtro = "WHERE c.nome like '%{$pesquisa}%'
                    or c.modelo like '%{$pesquisa}%'
                    or c.cor like '%{$pesquisa}%'
                    or c.marca like '%{$pesquisa}%'
                    or tc.nome like '%{$pesquisa}%'";
    }

    $sql = "SELECT c.id, c.nome, c.modelo, c.valor, c.cor, c.estoque, c.marca, c.fotos, tc.nome as tipo
         from carro c inner join tipo_carro tc on tc.id = c.tipo_id {$filtro}";

    $carros = $GLOBALS['database']->retornaLista($sql);

    $html = "";

    if(empty($carros)){
        die(json_encode(['erro' => false, 'html' => "<div class=\"text-center\">Nenhum carro encontrado</div>"]));
    }
    foreach($carros as $carro){

        $fotos = json_decode($carro->fotos);

        $foto_principal = $fotos[0]->url;

        $valor = number_format($carro->valor, 2, ",", ".");
        $nome_carro = "{$carro->nome} {$carro->modelo}";

        $html .= "
        <div class=\"col-sm-6 col-md-4 col-lg-4 py-2\">
            <div class=\"card h-100 \">
                <div class=\"card-body\">
                    <img style=\"height: 270px; width: 100%; object-fit: cover; object-position: center;\" src=\"$foto_principal\">
                    <h3 style=\"margin-top:15px;\" class=\"card-title text-center\">{$nome_carro}</h3>
                    <div class=\"row\">
                        <div class=\"col-xs-12 col-sm-12 col-md-8 col-lg-8 text-center\">
                            <p class=\"card-text\" style=\"font-size:20px;\"><sup>R$</sup> {$valor}</p>
                        </div>
                        <div class=\"col-xs-12 col-sm-12 col-md-4 col-lg-4 text-center\">
                            <a href=\"javascript:detalhes_carro('{$carro->id}');\" class=\"btn btn-outline-primary\">Detalhes</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>";
    }


    echo json_encode(['erro' => false, 'html' => $html]);

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

            $valor = number_format($resultado->valor,2,",",".");

            $html .= "  <tr>
                                <td>{$resultado->nome}</td>
                                <td class=\"text-center\">{$resultado->modelo}</td>
                                <td class=\"text-center\">{$resultado->tipo_carro}</td>
                                <td class=\"text-center\">{$resultado->cor}</td>
                                <td class=\"text-center\">R$ {$valor}</td>
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
