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

function detalhes_pedido(){

    $id = post("id");

    $sql = "SELECT 
                v.id,
                v.total_venda as valor,
                v.status,
                v.quantidade,
                v.forma_pagto,
                v.data,
                v.observacoes,

                dc.nome as nome_cliente,
                dc.email,
                dc.telefone,

                e.*,

                df.nome as nome_vendedor,
                dg.nome as nome_gerente,

                tc.nome as tipo,

                c.nome as nome_carro,
                c.modelo,
                c.cor,
                c.marca,
                c.fotos
            
            FROM vendas v
            inner join carro c on c.id = v.carro_id
            inner join tipo_carro tc on c.tipo_id = tc.id
            inner join cliente cl on cl.id = v.cliente_id
            inner join dados_cliente dc on dc.id = cl.id_dados_cliente
            inner join funcionario on funcionario.id = v.funcionario_id
            inner join dados_funcionario df on df.id = funcionario.id_dados_funcionario
            inner join funcionario as gerente on gerente.id = v.gerente_id
            inner join dados_funcionario dg on dg.id = gerente.id_dados_funcionario
            inner join endereco e on e.id = dc.endereco_id
            where v.id = '{$id}'";

    $venda = $GLOBALS['database']->retornaLinha($sql);

    if(!$venda){
        die(json_encode(['erro' => true]));
    }

    if(empty($venda)){
        die(json_encode(['erro' => true]));
    }

    $li_carrossel = "";
    $div_fotos = "";

    $fotos = json_decode($venda->fotos);
    foreach($fotos as $pos => $foto){
        $active = "";
        $class_active = "";
        if($pos == 0){
            $active = "class=\"active\"";
            $class_active = "active";
        }
        $li_carrossel .= "<li data-target=\"#carouselExampleIndicators\" data-slide-to=\"{$pos}\" {$active}></li>";

        

        $div_fotos .= "<div class=\"carousel-item {$class_active}\">
                        <img src=\"{$foto->url}\" class=\"d-block w-100\">
                    </div>";
    }

    $hide_carrossel = "";

    if(empty($div_fotos)){
        $hide_carrossel = " style=\"display:none;\" ";
    }

    $valor_venda = number_format($venda->valor, 2, ",", ".");
    $valor_total = $venda->valor * $venda->quantidade;
    $valor_total = number_format($valor_total, 2, ",", ".");

    $data = date("d/m/Y H:i:s", strtotime($venda->data));

    $forma_pagto = "";

    switch ($venda->forma_pagto) {
        case 'avista':
            $forma_pagto = "à Vista";
            break;
        case 'credito':
            $forma_pagto = "Crédito";
            break;
        case 'debito':
            $forma_pagto = "Débito";
            break;
        case 'boleto':
            $forma_pagto = "Boleto";
            break;
        
        default:
            $forma_pagto = "Não especificada";
            break;
    }

    $status_venda = "";

    switch ($venda->status) {
        case 1:
            $status_venda = "<span style=\"color:green; font-weight:bold;\">Venda realizada</span>";
            break;
        
        default:
            $status_venda = "<span style=\"color:red; font-weight:bold;\">Venda cancelada</span>";
            break;
    }

    $html = "<div class=\"row\">
          <div class=\"col-xs-12 col-sm-12 col-md-6 col-lg-6\">
            <p class=\"titulo-detalhes text-center\">Detalhes do carro</p>
            <div class=\"container-fluid\">
              <div id=\"carouselExampleIndicators\" class=\"carousel slide\" data-ride=\"carousel\" {$hide_carrossel}>
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
              <span class=\"font-bold\">Nome: </span>{$venda->nome_carro}<br />
              <span class=\"font-bold\">Modelo: </span>{$venda->modelo}<br />
              <span class=\"font-bold\">Cor: </span>{$venda->cor}<br />
              <span class=\"font-bold\">Marca: </span>{$venda->marca}<br />
            </div>
          </div>
          <div class=\"col-xs-12 col-sm-12 col-md-6 col-lg-6\">
            <p class=\"titulo-detalhes text-center\">Detalhes da venda</p>
            <span class=\"font-bold\">Status:</span> {$status_venda}<br />
            <span class=\"font-bold\">Gerente da venda:</span> {$venda->nome_gerente}<br />
            <span class=\"font-bold\">Vendedor:</span> {$venda->nome_vendedor}<br />
            <span class=\"font-bold\">Quantidade:</span> {$venda->quantidade}<br />
            <span class=\"font-bold\">Valor:</span> {$valor_venda}<br />
            <span class=\"font-bold\">Valor Total:</span> {$valor_total}<br />
            <span class=\"font-bold\">Forma de Pagamento:</span> {$forma_pagto}<br />
            <span class=\"font-bold\">Data da Venda:</span> {$data}<br />
            <span class=\"font-bold\">Observações:</span> {$venda->observacoes}<br />
          </div>
        </div>
        <div class=\"row\">
            <div class=\"col-xs-12 col-sm-12 col-md-6 col-lg-6\"></div>
            <div class=\"col-xs-12 col-sm-12 col-md-6 col-lg-6\">
                <p class=\"titulo-detalhes text-center\">Dados do comprador</p>
                <span class=\"font-bold\">Nome:</span> {$venda->nome_cliente}<br />
                <span class=\"font-bold\">Email:</span> {$venda->email}}<br />
                <span class=\"font-bold\">Telefone:</span> {$venda->telefone}}<br />
                <span class=\"font-bold\">Cidade:</span> {$venda->cidade} - {$venda->estado}<br />
                <span class=\"font-bold\">Bairro:</span> {$venda->bairro}<br />
                <span class=\"font-bold\">Rua:</span> {$venda->rua} <span class=\"font-bold\">N°</span>{$venda->numero}<br />
                <span class=\"font-bold\">CEP:</span> {$venda->cep}<br />
            </div>
        </div>";

    echo json_encode(['erro'=> false, 'html' => $html]);

}

function alterar_status_venda(){

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

    if(!$retorno){
        die(json_encode(['erro' => true]));
    }  

    echo json_encode(['erro' => false]);

}

function lista_vendas()
{
    $busca = post("busca");
    $tipo = post("tipo");
    $status = post("status");

    $filtro = "";

    if(!empty($busca)){

        $tabela = "";
        switch ($tipo) {
            case 'cliente':
                $tabela = "dc";
                break;

            case 'carro':
                $tabela = "c";
                break;

            case 'funcionario':
                $tabela = "df";
                break;

        }

        $texto = strtolower($busca);

        $filtro = " WHERE lower({$tabela}.nome) like '%{$texto}%'";

    }

    if($status != 'default'){
        $filtro_status = "";
        switch ($status) {
            case 'normal':
                $filtro_status = "'1'";
                break;
            case 'cancelada':
                $filtro_status = "'0'";
                break;
        }
        if(empty($filtro)){
            $filtro = " WHERE v.status = {$filtro_status}";
        }else{
            $filtro .= " AND v.status = {$filtro_status}";
        }
    }

    $sql = "SELECT 
                v.id,
                v.total_venda as valor,
                v.status,
                dc.nome as nome_cliente,
                df.nome as nome_vendedor,
                tc.nome as tipo,
                c.nome as nome_carro,
                c.modelo,
                c.cor,
                c.marca
            
            FROM vendas v
            inner join carro c on c.id = v.carro_id
            inner join tipo_carro tc on c.tipo_id = tc.id
            inner join cliente cl on cl.id = v.cliente_id
            inner join dados_cliente dc on dc.id = cl.id_dados_cliente
            inner join funcionario on funcionario.id = v.funcionario_id
            inner join dados_funcionario df on df.id = funcionario.id_dados_funcionario
            inner join funcionario as gerente on gerente.id = v.gerente_id
            inner join dados_funcionario dg on dg.id = gerente.id_dados_funcionario
            {$filtro}";

    $resultados = $GLOBALS['database']->retornaLista($sql);

    $html = "";

    if (empty($resultados)) {
        $html = "<tr><td colspan=\"100\" class=\"text-center\">Nenhuma venda encontrada</td></tr>";
        die(json_encode(['html' => $html]));
    } else {
        foreach ($resultados as $resultado) {

            $gerente = $GLOBALS['funcoes']->usuarioGerente();

            if ($gerente) {

                $texto = ($resultado->status == 1 ? "cancelar" : "reverter");
                $textoup = ucfirst($texto);

                $botao = "<td class=\"text-center\">
                                <div class=\"btn-group\">
                                    <button class=\"btn btn-success btn-sm\">Opções</button>
                                    <button class=\"btn btn-success btn-sm dropdown-toggle dropdown-toggle-split\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
                                        <span class=\"sr-only\">Abrir Dropdown</span>
                                    </button>
                                    <div class=\"dropdown-menu dropdown-menu-right\">
                                        <a class=\"dropdown-item\" href=\"javascript:alterar_status_venda('{$resultado->id}', '{$texto}')\">{$textoup} pedido</a>
                                    </div>
                                </div>
                            </td>";
            } else {

                $botao = "";
            }

            $carro = "{$resultado->marca} {$resultado->nome_carro} {$resultado->modelo} {$resultado->cor} - {$resultado->tipo}";

            $valor = number_format($resultado->valor, 2, ",", ".");

            $botao_dados_pedido = "<a style=\"cursor:pointer\" href=\"javascript:mostrar_detalhes_pedido('{$resultado->id}');\" >Visualizar Pedido</a>";

            $venda_cancelada = "";
            if($resultado->status == 0){
                $venda_cancelada = "class=\"venda-cancelada\"";
            }

            $html .= "  <tr {$venda_cancelada}>
                                <td>{$carro}</td>
                                <td class=\"text-center\">{$resultado->nome_cliente}</td>
                                <td class=\"text-center\">{$resultado->nome_vendedor}</td>
                                <td class=\"text-center\">R$ {$valor}</td>
                                <td class=\"text-center\">{$botao_dados_pedido}</td>
                                {$botao}
                                
                            </tr>";
        }
    }

    echo json_encode(['html' => $html]);

}

function salvar_venda(){

    $carro = post("carro");
    $qtde = (int) post("qtde");
    $cliente = post("cliente");
    $vendedor = post("vendedor");
    $valor = post("valor");
    $forma_pagto = post("forma_pagto");
    $observacoes = post("obs");

    $dados_carro = $GLOBALS['database']->retornaLinha("SELECT estoque from carro where id = '{$carro}'");

    $estoque_atual = (int) $dados_carro->estoque;

    if($estoque_atual < $qtde){
        die(json_encode(['erro' => true, 'msg' => "Estoque insuficiente para realizar a venda. Estoque atual: {$estoque_atual}"]));
    }

    $gerente = $GLOBALS['session']->getSession("id");

    $venda = [
        "cliente_id" => $cliente,
        "carro_id" => $carro,
        "gerente_id" => $gerente,
        "funcionario_id" => $vendedor,
        "total_venda" => $valor,
        "quantidade" => $qtde,
        "forma_pagto" => $forma_pagto,
        "observacoes" => $observacoes
    ];

    $result = $GLOBALS['database']->insert("vendas", $venda);

    if(!$result){
        die(json_encode(['erro' => true, 'msg' => "Erro ao realizar venda!"]));
    }else{
        $novo_estoque = $estoque_atual - $qtde;

        $dados = [
            'estoque' => $novo_estoque
        ];

        $GLOBALS['database']->update("carro", $dados, ["id" => $carro]);
        
        registrar_movimentacao_estoque($carro, $estoque_atual, $novo_estoque);

        echo json_encode(['erro' => false]);
    }

}

function registrar_movimentacao_estoque($carro, $estoque_anterior, $novo_estoque)
{

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

function lista_clientes(){

    $sql = "SELECT c.id,
                   dc.nome
            FROM cliente c
            inner join dados_cliente dc on dc.id = c.id_dados_cliente
            where c.visivel = 1";

    $clientes = $GLOBALS['database']->retornaLista($sql);

    if(!$clientes){
        die(json_encode(['erro' => true]));
    }

    if(empty($clientes)){

        $html = "<option value=\"default\">Nenhum cliente encontrado</option>";

        echo json_encode(['erro' => false, 'html' => $html]);
    }

    $html = "<option value=\"default\">Selecione o Cliente</option>";

    foreach($clientes as $cliente){
        $html .= "<option value=\"{$cliente->id}\">{$cliente->nome}</option>";
    }

    echo json_encode(['erro'=> false, 'html' => $html]);

}

function lista_carros(){
    $sql = "SELECT c.id,
                    c.nome,
                    c.modelo,
                    c.valor,
                    c.marca,
                    c.cor,
                    tc.nome as tipo
            FROM carro c
            inner join tipo_carro tc on tc.id = c.tipo_id
            ";

    $carros = $GLOBALS['database']->retornaLista($sql);

    if (!$carros) {
        die(json_encode(['erro' => true]));
    }

    if (empty($carros)) {

        $html = "<option value=\"default\">Nenhum carro encontrado</option>";

        echo json_encode(['erro' => false, 'html' => $html]);
    }

    $html = "<option value=\"default\">Selecione o carro</option>";

    foreach ($carros as $carro) {

        $nome = "{$carro->marca} {$carro->nome} {$carro->modelo} {$carro->cor} - {$carro->tipo}";
        $html .= "<option preco=\"{$carro->valor}\" value=\"{$carro->id}\">{$nome}</option>";
    }

    echo json_encode(['erro' => false, 'html' => $html]);
}

function lista_vendedores(){

    $sql = "SELECT  f.id as funcionario_id,
                        df.nome
                FROM funcionario f
                inner join dados_funcionario df on f.id_dados_funcionario = df.id
                WHERE f.gerente = 0
                and f.ativo = 1
                order by df.nome asc
                ";

    $vendedores = $GLOBALS['database']->retornaLista($sql);

    if(!$vendedores){
        die(json_encode(['erro' => true]));
    }

    if(empty($vendedores)){

        $html = "<option value=\"default\">Nenhum vendedor encontrado</option>";

        echo json_encode(['erro' => false, 'html' => $html]);
    }

    $html = "<option value=\"default\">Selecione o Vendedor</option>";

    foreach($vendedores as $vendedor){
        $html .= "<option value=\"{$vendedor->funcionario_id}\">{$vendedor->nome}</option>";
    }

    echo json_encode(['erro'=> false, 'html' => $html]);
}

?>