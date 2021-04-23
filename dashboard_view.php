<?php
if (!$session->logado()) {

  $url = $GLOBALS['config']->base_url();

  echo '<script type="text/javascript">';
  echo 'window.location.href="' . $url . '";';
  echo '</script>';
  echo '<noscript>';
  echo '<meta http-equiv="refresh" content="0;url=' . $url . '" />';
  echo '</noscript>';
  exit;
}
?>

<style>
  .titulo-panel {
    /* background-color: #012f85; */
    background-color: black;
    color: white;
    padding: 10px;
    text-align: center;
    border-bottom: 2px solid #012f85;
    transition-duration: 0.2s;

  }

  .flecha {
    float: right;
    padding-top: 6px;

  }

  .ativo {
    background-color: #012f85;
    transition-duration: 0.2s;
  }

  .opcoes-panel {
    border-right: 2px solid #012f85;
  }

  .opcoes-panel:last-child {
    border-bottom: 2px solid #012f85
  }

  .opcao {
    text-align: center;
    cursor: pointer;
    margin-bottom: 0px;
  }

  .opcao:hover {
    background-color: #7392cc;
    color: #ffffff;
  }

  .pad-5 {
    padding-top: 5px;
  }

  .naoMostra {
    display: none;
  }

  .mostra {
    display: block;
  }

  a {
    text-decoration: none !important;
  }

  .venda-cancelada {
    background-color: #ce1616;
    color: white;
  }

  .venda-cancelada td a {
    color: #c494f9;
  }
</style>

<div class="container-fluid" style="padding-left:0px; margin-top:-10px;">
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
      <div class="titulo-panel">
        Carros
        <i class="fa fa-chevron-right flecha"></i>
      </div>
      <div class="opcoes-panel" style="display:none;">
        <p class="opcao" id="mostra-lista-carros">Lista de Carros</p>
        <p class="opcao" id="mostra-lista-tipos-carros">Lista de tipos de carros</p>
      </div>
      <div class="titulo-panel">
        Clientes
        <i class="fa fa-chevron-right flecha"></i>
      </div>
      <div class="opcoes-panel" style="display:none;">
        <p class="opcao" id="mostra-lista-clientes">Lista de Clientes</p>
      </div>
      <div class="titulo-panel">
        Funcionários
        <i class="fa fa-chevron-right flecha"></i>
      </div>
      <div class="opcoes-panel" style="display:none;">
        <p class="opcao" id="mostra-lista-funcionarios">Lista de Funcionários</p>
      </div>
      <div class="titulo-panel">
        Vendas
        <i class="fa fa-chevron-right flecha"></i>
      </div>
      <div class="opcoes-panel" style="display:none;">
        <p class="opcao" id="mostra-historico-vendas">Histórico de Vendas</p>
      </div>
      <div class="titulo-panel">
        Opções da sua conta
        <i class="fa fa-chevron-right flecha"></i>
      </div>
      <div class="opcoes-panel" style="display:none;">
        <p class="opcao" id="mostra-mudar-senha">Mudar senha</p>
        <p class="opcao" id="mostra-mudar-info">Mudar Informações</p>
      </div>
    </div>
    <div class="col-xs-11 col-sm-11 col-md-9 col-lg-9 offset-xs-1 offset-sm-1 offset-md-0 offset-lg-0 telas">
      <div id="bem-vindo" class="text-center pad-5">
        <h4>Bem-vindo ao Dashboard da Concessionária VIVC</h4>
        <p>Selecione ao lado a operação que deseja realizar.</p>
      </div>
      <!-- A partir daqui começa as telas separadas -->

      <!-- Carros -->

      <div id="lista-carros" class="naoMostra pad-5">
        <div class="row">
          <div class="container-fluid tools">
            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                <div class="form-group">
                  <label></label>
                  <input type="text" id="txtBuscaCarro" class="form-control" placeholder="Digite a Pesquisa">
                </div>
              </div>
              <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                <div class="form-group">
                  <label></label>
                  <select class="form-control" id="cmbTipoPesquisaCarro">
                    <option selected value="default">Sem filtro</option>
                    <option value="nome">Nome</option>
                    <option value="modelo">Modelo</option>
                    <option value="cor">Cor</option>
                    <!-- <option value="placa">Placa</option> -->
                  </select>
                </div>
              </div>

              <?php
              if ($GLOBALS['funcoes']->usuarioGerente()) {
              ?>
                <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                  <div class="form-group">
                    <label></label>
                    <select class="form-control" id="cmbFiltroTipoCarro">

                    </select>
                  </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2">
                  <a href="javascript:lista_carros()">
                    <button class="btn btn-primary btn-block" style="margin-top:24px;">
                      <i class="fa fa-search"></i>
                      Buscar
                    </button>
                  </a>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2">
                  <a href="javascript:criar_carro()">
                    <button class="btn btn-success btn-block" style="margin-top:24px;">
                      <i class="fa fa-plus"></i>
                      Criar
                    </button>
                  </a>
                </div>
              <?php
              } else {
              ?>
                <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                  <div class="form-group">
                    <label></label>
                    <select class="form-control" id="cmbFiltroTipoCarro">
                    </select>
                  </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                  <a href="javascript:lista_carros()">
                    <button class="btn btn-primary btn-block" style="margin-top:24px;">
                      <i class="fa fa-search"></i>
                      Buscar
                    </button>
                  </a>
                </div>
              <?php
              }
              ?>
            </div>
          </div>
          <table class="table table-hover" id="lista-de-carros">
            <thead>
              <tr>
                <th>Nome</th>
                <th class="text-center">Modelo</th>
                <th class="text-center">Tipo</th>
                <th class="text-center">Cor</th>
                <th class="text-center">Preço</th>
                <th class="text-center">Estoque</th>
                <?php
                if ($GLOBALS['funcoes']->usuarioGerente()) {
                  echo "<th class=\"text-center\">Opções</th>";
                }
                ?>
              </tr>
            </thead>
            <tbody>

            </tbody>
          </table>
        </div>
      </div>

      <div id="lista-tipos-carros" class="naoMostra pad-5">
        <div class="row">
          <div class="container-fluid tools">
            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-6 col-lg-8">
                <div class="form-group">
                  <label></label>
                  <input type="text" id="txtBuscaTipoCarro" class="form-control" placeholder="Digite a Pesquisa">
                </div>
              </div>
              <?php
              if ($GLOBALS['funcoes']->usuarioGerente()) {
              ?>
                <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2">
                  <a href="javascript:lista_tipos_carros()">
                    <button class="btn btn-primary btn-block" style="margin-top:24px;">
                      <i class="fa fa-search"></i>
                      Buscar
                    </button>
                  </a>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2">
                  <a href="javascript:criar_tipo_carro()">
                    <button class="btn btn-success btn-block" style="margin-top:24px;">
                      <i class="fa fa-plus"></i>
                      Criar
                    </button>
                  </a>
                </div>
              <?php
              } else {
              ?>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                  <a href="javascript:lista_tipos_carros()">
                    <button class="btn btn-primary btn-block" style="margin-top:24px;">
                      <i class="fa fa-search"></i>
                      Buscar
                    </button>
                  </a>
                </div>
              <?php
              }
              ?>
            </div>
          </div>
          <table class="table table-hover" id="lista-de-tipos-de-carros">
            <thead>
              <tr>
                <th>Nome</th>
                <?php
                if ($GLOBALS['funcoes']->usuarioGerente()) {
                  echo "<th class=\"text-center\">Opções</th>";
                }
                ?>
              </tr>
            </thead>
            <tbody>

            </tbody>
          </table>
        </div>
      </div>

      <!-- Clientes -->
      <div id="lista-clientes" class="naoMostra pad-5">
        <div class="row">
          <div class="container-fluid tools">
            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-3 col-lg-5">
                <div class="form-group">
                  <label></label>
                  <input type="text" id="txtBuscaCliente" class="form-control" placeholder="Digite a Pesquisa">
                </div>
              </div>
              <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                <div class="form-group">
                  <label></label>
                  <select class="form-control" id="cmbTipoPesquisaCliente">
                    <option selected value="default">Sem filtro</option>
                    <option value="nome">Nome</option>
                    <option value="email">Email</option>
                    <option value="cpf">CPF</option>
                    <option value="rg">RG</option>
                    <option value="telefone">Telefone</option>
                    <option value="rua">Rua</option>
                    <option value="bairro">Bairro</option>
                    <option value="cidade">Cidade</option>
                    <option value="estado">Estado</option>
                  </select>
                </div>
              </div>
              <?php
              if ($GLOBALS['funcoes']->usuarioGerente()) {
              ?>
                <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2">
                  <a href="javascript:lista_clientes()">
                    <button class="btn btn-primary btn-block" style="margin-top:24px;">
                      <i class="fa fa-search"></i>
                      Buscar
                    </button>
                  </a>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2">
                  <a href="javascript:criar_cliente()">
                    <button class="btn btn-success btn-block" style="margin-top:24px;">
                      <i class="fa fa-plus"></i>
                      Criar
                    </button>
                  </a>
                </div>
              <?php
              } else {
              ?>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                  <a href="javascript:lista_clientes()">
                    <button class="btn btn-primary btn-block" style="margin-top:24px;">
                      <i class="fa fa-search"></i>
                      Buscar
                    </button>
                  </a>
                </div>
              <?php
              }
              ?>
            </div>
          </div>
          <table class="table table-hover" id="lista-de-clientes">
            <thead>
              <tr>
                <th>Nome</th>
                <th class="text-center">Email</th>
                <th class="text-center">CPF</th>
                <th class="text-center">RG</th>
                <th class="text-center">Telefone</th>
                <th class="text-center">Endereço</th>
                <?php
                if ($GLOBALS['funcoes']->usuarioGerente()) {
                  echo "<th class=\"text-center\">Opções</th>";
                }
                ?>
              </tr>
            </thead>
            <tbody>

            </tbody>
          </table>
        </div>
      </div>

      <!-- Funcionarios -->

      <div id="lista-funcionarios" class="naoMostra pad-5">
        <div class="row">
          <div class="container-fluid tools">
            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-3 col-lg-5">
                <div class="form-group">
                  <label></label>
                  <input type="text" id="txtBuscaFuncionario" class="form-control" placeholder="Digite a Pesquisa">
                </div>
              </div>
              <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                <div class="form-group">
                  <label></label>
                  <select class="form-control" id="cmbTipoPesquisaFuncionario">
                    <option selected value="default">Sem filtro</option>
                    <option value="nome">Nome</option>
                    <option value="cpf">CPF</option>
                    <option value="rg">RG</option>
                    <option value="telefone">Telefone</option>
                  </select>
                </div>
              </div>
              <?php
              if ($GLOBALS['funcoes']->usuarioGerente()) {
              ?>
                <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2">
                  <a href="javascript:lista_funcionarios()">
                    <button class="btn btn-primary btn-block" style="margin-top:24px;">
                      <i class="fa fa-search"></i>
                      Buscar
                    </button>
                  </a>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2">
                  <a href="javascript:criar_funcionario()">
                    <button class="btn btn-success btn-block" style="margin-top:24px;">
                      <i class="fa fa-plus"></i>
                      Criar
                    </button>
                  </a>
                </div>
              <?php
              } else {
              ?>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                  <a href="javascript:lista_funcionarios()">
                    <button class="btn btn-primary btn-block" style="margin-top:24px;">
                      <i class="fa fa-search"></i>
                      Buscar
                    </button>
                  </a>
                </div>
              <?php
              }
              ?>
            </div>
          </div>
          <table class="table table-hover" id="lista-de-funcionarios">
            <thead>
              <tr>
                <th>Nome</th>
                <th class="text-center">CPF</th>
                <th class="text-center">RG</th>
                <th class="text-center">Telefone</th>
                <th class="text-center">Situação</th>
                <?php
                if ($GLOBALS['funcoes']->usuarioGerente()) {
                  echo "<th class=\"text-center\">Opções</th>";
                }
                ?>
              </tr>
            </thead>
            <tbody>

            </tbody>
          </table>
        </div>
      </div>

      <!-- Vendas -->

      <div id="historico-vendas" class="naoMostra pad-5">
        <div class="row">
          <div class="container-fluid tools">
            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                  <label>Pesquisa</label>
                  <input type="text" id="txtBuscaVenda" class="form-control" placeholder="Digite a Pesquisa">
                </div>
              </div>
              <div class="col-xs-12 col-sm-12 col-md-4 col-lg-2">
                <div class="form-group">
                  <label>Tipo de Filtro</label>
                  <select class="form-control" id="cmbTipoPesquisaVenda">
                    <option selected value="default">Sem filtro</option>
                    <option value="cliente">Nome Cliente</option>
                    <option value="carro">Nome Carro</option>
                    <option value="funcionario">Nome Funcionário</option>
                  </select>
                </div>
              </div>
              <div class="col-xs-12 col-sm-12 col-md-4 col-lg-2">
                <div class="form-group">
                  <label>Status</label>
                  <select class="form-control" id="cmbPesquisaStatusVenda">
                    <option selected value="default">Sem filtro</option>
                    <option value="normal">Venda Realizada</option>
                    <option value="cancelada">Venda Cancelada</option>
                  </select>
                </div>
              </div>
              <?php
              if ($GLOBALS['funcoes']->usuarioGerente()) {
              ?>
                <div class="col-xs-6 col-sm-6 col-md-12 col-lg-2">
                  <a href="javascript:lista_vendas()">
                    <button class="btn btn-primary btn-block" style="margin-top:32px;">
                      <i class="fa fa-search"></i>
                      Buscar
                    </button>
                  </a>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-12 col-lg-2">
                  <a href="javascript:criar_venda()">
                    <button class="btn btn-success btn-block" style="margin-top:32px;">
                      <i class="fa fa-plus"></i>
                      Criar
                    </button>
                  </a>
                </div>
              <?php
              } else {
              ?>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                  <a href="javascript:lista_vendas()">
                    <button class="btn btn-primary btn-block" style="margin-top:32px;">
                      <i class="fa fa-search"></i>
                      Buscar
                    </button>
                  </a>
                </div>
              <?php
              }
              ?>
            </div>
          </div>
          <table class="table table-hover" id="lista-de-vendas">
            <thead>
              <tr>
                <th>Carro</th>
                <th class="text-center">Cliente</th>
                <th class="text-center">Vendedor</th>
                <th class="text-center">Valor</th>
                <th class="text-center">Detalhes da venda</th>
                <?php
                if ($GLOBALS['funcoes']->usuarioGerente()) {
                  echo "<th class=\"text-center\">Opções</th>";
                }
                ?>
              </tr>
            </thead>
            <tbody>

            </tbody>
          </table>
        </div>
      </div>

      <div id="mudar-senha" class="naoMostra pad-5">
        <div class="form-group">
          <label>Senha Atual</label>
          <input type="password" id="txtSenhaAtual" class="form-control" placeholder="Senha Atual">
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <div class="form-group">
              <label>Nova senha</label>
              <input type="password" id="txtNovaSenha1" class="form-control" placeholder="Senha">
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <div class="form-group">
              <label>Repita a nova senha</label>
              <input type="password" id="txtNovaSenha2" class="form-control" placeholder="Senha">
            </div>
          </div>
        </div>
        <div class="text-center">
          <button id="btnAlterarSenha" class="btn btn-success">Alterar Senha</button>
        </div>
      </div>

      <div id="mudar-info" class="naoMostra pad-5">
        <div class="form-group">
          <label>Nome</label>
          <input type="text" id="txtNomeInfo" class="form-control" placeholder="Nome">
        </div>
        <div class="form-group">
          <label>Telefone</label>
          <input type="text" id="txtTelefoneInfo" class="form-control" placeholder="Telefone">
        </div>
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <div class="form-group">
              <label>RG</label>
              <input type="text" id="txtRGInfo" class="form-control" placeholder="RG">
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <div class="form-group">
              <label>CPF</label>
              <input type="text" id="txtCPFInfo" class="form-control" placeholder="CPF">
            </div>
          </div>
        </div>
        <div class="text-center">
          <button id="btnAlterarInfo" class="btn btn-success">Salvar Alterações</button>
        </div>
      </div>

    </div>
  </div>
</div>


<div class="modal" tabindex="-1" id="modalTipoCarro">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tituloModalTipoCarro"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <div class="row">
            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div>
            <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
              <div class="form-group">
                <input type="hidden" id="idTipoCarro">
                <label for="txtNomeTipoCarro">Nome</label>
                <input class="form-control" type="text" id="txtNomeTipoCarro">
              </div>
            </div>
            <div class="text-center" style="width:100%;">
              <button id="btnModalTipoCarro" class="btn btn-success" data-loading-text="Aguarde...">
                Criar
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
  .titulo-detalhes {
    padding-left: 15px;
    font-size: 20px;
    color: #4b68d2;
    text-decoration: overline;
  }

  .font-bold {
    font-weight: bold !important;
  }

  .modal-dialog {
    overflow-y: initial !important
  }

  .modal-body {
    height: 80vh;
    overflow-y: auto;
  }
</style>

<div class="modal" tabindex="-1" id="modalDetalhesPedido">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detalhes da venda</h5>
        <button type="button" id="fecharModalDetalhesPedido" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="divDetalhesPedido"></div>
      </div>
    </div>
  </div>
</div>

<div class="modal" tabindex="-1" id="modalEndereco">
  <div class="modal-dialog modal-xs">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Endereço</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="height:auto;">
        <div class="container-fluid">
          <div class="row">
            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div>
            <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10" id="enderecoCliente">

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal" tabindex="-1" id="modalCarro">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tituloModalCarro"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <div class="row">
            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div>
            <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
              <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                  <div class="form-group">
                    <input type="hidden" id="idCarro">
                    <label for="txtNomeCarro">Nome</label>
                    <input class="form-control" type="text" id="txtNomeCarro">
                  </div>
                </div>
                <!-- <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                  <div class="form-group">
                    <label for="txtPlacaCarro">Placa</label>
                    <input class="form-control" type="text" id="txtPlacaCarro">
                  </div>
                </div> -->
              </div>
              <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
                  <div class="form-group">
                    <label for="txtModeloCarro">Modelo</label>
                    <input class="form-control" type="text" id="txtModeloCarro">
                  </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                  <div class="form-group">
                    <label for="txtMarcaCarro">Marca</label>
                    <input class="form-control" type="text" id="txtMarcaCarro">
                  </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                  <div class="form-group">
                    <label for="txtCorCarro">Cor</label>
                    <input class="form-control" type="text" id="txtCorCarro">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                  <div class="form-group">
                    <label for="cmbTipoCarro">Tipo de Carro</label>
                    <select class="form-control" id="cmbTipoCarro">
                    </select>
                  </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                  <div class="form-group">
                    <label for="txtValorCarro">Valor</label>
                    <input class="form-control" data-prefix="R$ " data-thousands="." data-decimal="," type="text" id="txtValorCarro">
                  </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                  <div class="form-group">
                    <label for="txtEstoqueCarro">Estoque</label>
                    <input class="form-control" type="int" id="txtEstoqueCarro">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                  <div class="form-group">
                    <label for="txtFotoCarro1">Foto 1</label>
                    <input class="form-control" type="int" id="txtFotoCarro1">
                  </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                  <div class="form-group">
                    <label for="txtFotoCarro2">Foto 2</label>
                    <input class="form-control" type="int" id="txtFotoCarro2">
                  </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                  <div class="form-group">
                    <label for="txtFotoCarro3">Foto 3</label>
                    <input class="form-control" type="int" id="txtFotoCarro3">
                  </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                  <div class="form-group">
                    <label for="txtFotoCarro4">Foto 4</label>
                    <input class="form-control" type="int" id="txtFotoCarro4">
                  </div>
                </div>
              </div>
            </div>
            <div class="text-center" style="width:100%;">
              <button id="btnModalCarro" class="btn btn-success" data-loading-text="Aguarde...">
                Criar
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal" tabindex="-1" id="modalFuncionario">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tituloModalFuncionario"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <div class="row">
            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div>
            <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
              <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                  <div class="form-group">
                    <label for="txtNomeFuncionario">Nome</label>
                    <input class="form-control" type="text" id="txtNomeFuncionario">
                  </div>
                  <div class="form-group">
                    <label for="txtTelefone">Telefone</label>
                    <input class="form-control" type="text" id="txtTelefone">
                  </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                  <div class="form-group">
                    <label for="txtCPFFuncionario">CPF</label>
                    <input class="form-control" type="text" id="txtCPFFuncionario">
                  </div>
                  <div class="form-group">
                    <label for="txtRGFuncionario">RG</label>
                    <input class="form-control" type="text" id="txtRGFuncionario">
                  </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                  <div class="form-group">
                    <label for="txtEmailFuncionario">Email</label>
                    <input class="form-control" type="email" id="txtEmailFuncionario">
                  </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                  <div class="form-group">
                    <label for="txtSenhaFuncionario">Senha</label>
                    <input class="form-control" type="password" id="txtSenhaFuncionario">
                  </div>
                </div>
                <?php if ($GLOBALS['funcoes']->usuarioGerente()) {

                ?>
                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group">
                      <label for="cmbTipoUsuario">Tipo usuário</label>
                      <select class="form-control" id="cmbTipoUsuario">
                        <option selected value="vendedor">Vendedor</option>
                        <option value="gerente">Gerente</option>
                      </select>
                    </div>
                  </div>
                <?php
                }
                ?>
              </div>
            </div>
            <div class="text-center" style="width:100%;">
              <button id="btnModalFuncionario" class="btn btn-success" data-loading-text="Aguarde...">
                Criar
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal" tabindex="-1" id="modalCliente">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tituloModalCliente"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
              <div class="form-group">
                <input class="form-control" type="hidden" id="idCliente">
                <label for="txtNomeCliente">Nome</label>
                <input class="form-control" type="text" id="txtNomeCliente">
              </div>
              <div class="form-group">
                <label for="txtEmailCliente">Email</label>
                <input class="form-control" type="email" id="txtEmailCliente">
              </div>
              <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                  <div class="form-group">
                    <label for="txtRGCliente">RG</label>
                    <input class="form-control" type="text" id="txtRGCliente">
                  </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                  <div class="form-group">
                    <label for="txtCPFCliente">CPF</label>
                    <input class="form-control" type="text" id="txtCPFCliente">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="txtTelefoneCliente">Telefone</label>
                <input class="form-control" type="text" id="txtTelefoneCliente">
              </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
              <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-7">
                  <div class="form-group">
                    <label for="txtCidadeCliente">Cidade</label>
                    <input class="form-control" type="text" id="txtCidadeCliente">
                  </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                  <div class="form-group">
                    <label for="cmbEstadoCliente">Estado</label>
                    <div class="form-group">
                      <select id="cmbEstadoCliente" class="form-control">
                        <option value="default" selected>Estado</option>
                        <option value="AC">Acre</option>
                        <option value="AL">Alagoas</option>
                        <option value="AP">Amapá</option>
                        <option value="AM">Amazonas</option>
                        <option value="BA">Bahia</option>
                        <option value="CE">Ceará</option>
                        <option value="DF">Distrito Federal</option>
                        <option value="ES">Espírito Santo</option>
                        <option value="GO">Goiás</option>
                        <option value="MA">Maranhão</option>
                        <option value="MT">Mato Grosso</option>
                        <option value="MS">Mato Grosso do Sul</option>
                        <option value="MG">Minas Gerais</option>
                        <option value="PA">Pará</option>
                        <option value="PB">Paraíba</option>
                        <option value="PR">Paraná</option>
                        <option value="PE">Pernambuco</option>
                        <option value="PI">Piauí</option>
                        <option value="RJ">Rio de Janeiro</option>
                        <option value="RN">Rio Grande do Norte</option>
                        <option value="RS">Rio Grande do Sul</option>
                        <option value="RO">Rondônia</option>
                        <option value="RR">Roraima</option>
                        <option value="SC">Santa Catarina</option>
                        <option value="SP">São Paulo</option>
                        <option value="SE">Sergipe</option>
                        <option value="TO">Tocantins</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-8">
                  <div class="form-group">
                    <label for="txtRuaCliente">Rua</label>
                    <input class="form-control" type="text" id="txtRuaCliente">
                  </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                  <div class="form-group">
                    <label for="txtNumeroCliente">Numero</label>
                    <input class="form-control" type="text" id="txtNumeroCliente">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="txtBairroCliente">Bairro</label>
                <input class="form-control" type="email" id="txtBairroCliente">
              </div>
              <div class="form-group">
                <label for="txtCEPCliente">CEP</label>
                <input class="form-control" type="email" id="txtCEPCliente">
              </div>
            </div>
          </div>
        </div>
        <div class="text-center" style="width:100%;">
          <button id="btnModalCliente" class="btn btn-success" data-loading-text="Aguarde...">
            Criar
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal" tabindex="-1" id="modalVenda">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tituloModalVenda"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
              <div class="form-group">
                <label for="cmbFuncionarioVenda">Funcionario que realizou a Venda</label>
                <select class="form-control" id="cmbFuncionarioVenda">
                </select>
              </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
              <div class="form-group">
                <label for="cmbClienteVenda">Cliente</label>
                <select class="form-control" id="cmbClienteVenda">
                </select>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="cmbCarroVenda">Carro vendido</label>
            <select class="form-control" id="cmbCarroVenda">
            </select>
          </div>
          <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
              <div class="form-group">
                <label for="txtValorVenda">Valor da Venda</label>
                <input class="form-control" type="text" id="txtValorVenda" disabled>
              </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
              <div class="form-group">
                <label for="txtQuantidadeVenda">Quantidade</label>
                <input class="form-control" type="number" id="txtQuantidadeVenda" value="0">
              </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
              <div class="form-group">
                <label for="cmbFormaPagtoVenda">Forma de Pagamento</label>
                <select class="form-control" id="cmbFormaPagtoVenda">
                  <option value="default">Escolha</option>
                  <option value="avista">à Vista</option>
                  <option value="credito">Cartão de Crédito</option>
                  <option value="debito">Cartão de Débito</option>
                  <option value="boleto">Boleto Bancário</option>
                </select>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="txtComentarioVenda">Observações sobre a venda</label>
            <textarea id="txtComentarioVenda" style="resize:none; width:100%; height: 100px;"></textarea>
          </div>
        </div>
        <div class="text-center" style="width:100%;">
          <button id="btnModalVenda" class="btn btn-success" data-loading-text="Aguarde...">
            Criar
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  var model_funcionarios = '<?= $conf->base_url(); ?>request/model/funcionarios';
  var model_carros = '<?= $conf->base_url(); ?>request/model/carros';
  var model_clientes = '<?= $conf->base_url(); ?>request/model/clientes';
  var model_vendas = '<?= $conf->base_url(); ?>request/model/vendas';
  var model_usuarios = '<?= $conf->base_url(); ?>request/model/usuarios';

  $(document).ready(function() {

    numerar();
    lista_carros();
    lista_tipos_carros();
    lista_funcionarios();
    lista_clientes();
    lista_vendas();

    filtro_tipo_carros();

    buscar_info_funcionario();

    $('#txtValorCarro').maskMoney();
    $('#txtValorVenda').maskMoney();

    $('.opcoes-panel').click(function(e) {
      e.preventDefault();
    });

    $(document).on("change", "#cmbCarroVenda", function() {

      var selecionado = $(this).val();

      if (selecionado == 'default') {
        $('#txtValorVenda').val("").attr('disabled', true);
        return;
      }
      var preco = $('option:selected', this).attr('preco');

      $('#txtValorVenda').val(preco).attr('disabled', false).focus().blur();

    })

    $(document).on("click", '.btn-endereco', function() {

      var estado = $(this).attr("estado");
      var cidade = $(this).attr("cidade");
      var bairro = $(this).attr("bairro");
      var rua = $(this).attr("rua");
      var numero = $(this).attr("numero");
      var cep = $(this).attr("cep");

      var texto = `<strong>Cidade:</strong> ${cidade} - ${estado} <br><strong>Bairro:</strong> ${bairro} <br><strong>Rua:</strong> ${rua} <strong>N° </strong>${numero} - <strong><br>CEP:</strong> ${cep}`;

      $('#enderecoCliente').html(texto);
      $('#modalEndereco').modal('show');
    });

    $('.opcao').click(function() {
      var id = "#" + $(this).attr('id').slice(7);
      $('#bem-vindo').hide();
      $('.telas').find(".mostra").each(function() {
        $(this).removeClass("mostra").addClass("naoMostra");
      });

      $(id).removeClass("naoMostra").addClass("mostra");

    });

    $('#btnModalTipoCarro').click(function() {
      var id = $('#idTipoCarro').val();
      var nome = $('#txtNomeTipoCarro').val();

      if (nome.length < 2) {
        alert("O nome digitado é muito curto");
        return;
      }

      $.post(`${model_carros}/cadastrar_alterar_tipo_carro`, {
        id,
        nome
      }, function(data) {

        if (data.erro) {
          if (typeof data.msg !== 'undefined') {
            alert(data.msg);
          } else {
            if (id.length == 0) {
              alert("Erro ao cadastrar tipo de carro!");
            } else {
              alert("Erro ao alterar tipo de carro!");
            }
          }
          return;
        } else {

          if (id.length == 0) {
            alert("Tipo de carro cadastrado com sucesso!");
          } else {
            alert("Tipo de carro alterado com sucesso!");
          }

          $('#modalTipoCarro').modal('hide');

          $('#idTipoCarro').val("");
          $('#txtNomeTipoCarro').val("");
          lista_tipos_carros();

        }

      }, 'json')

    });

    $('#btnModalCliente').click(function() {

      var id = $('#idCliente').val();
      var nome = $('#txtNomeCliente').val();
      var email = $('#txtEmailCliente').val();
      var rg = $('#txtRGCliente').val();
      var cpf = $('#txtCPFCliente').val();
      var telefone = $('#txtTelefoneCliente').val();

      var rua = $('#txtRuaCliente').val();
      var numero = $('#txtNumeroCliente').val();
      var cidade = $('#txtCidadeCliente').val();
      var estado = $('#cmbEstadoCliente').val();
      var bairro = $('#txtBairroCliente').val();
      var cep = $('#txtCEPCliente').val();

      if (nome.length == 0) {
        alert("Nome do cliente vazio");
        return;
      }

      if (cidade.length == 0) {
        alert("Cidade do cliente vazia");
        return;
      }

      if (email.length == 0) {
        alert("Email do cliente vazio");
        return;
      }

      if (rg.length == 0) {
        alert("RG vazio");
        return;
      }

      if (cpf.length == 0) {
        alert("CPF vazio");
        return;
      }

      if (rua.length == 0) {
        alert("Rua do cliente vazia");
        return;
      }

      if (estado == "default") {
        alert("Estado do cliente não selecionado");
        return;
      }
      if (numero.length == 0) {
        alert("Numero do cliente vazio");
        return;
      }
      if (bairro.length == 0) {
        alert("Bairro do cliente vazio");
        return;
      }
      if (cep.length == 0) {
        alert("Cep do cliente vazio");
        return;
      }

      var url = "";

      if (id.length == 0) {
        url = `${model_clientes}/criar_cliente`;
      } else {
        url = `${model_clientes}/alterar_cliente`;
      }

      $.post(url, {
        id,
        nome,
        email,
        rg,
        cpf,
        telefone,
        estado,
        cidade,
        rua,
        numero,
        bairro,
        cep
      }, function(data) {

        if (data.erro) {
          if (typeof data.msg !== 'undefined') {
            alert(data.msg);
          } else {
            if (id.length == 0) {
              alert("Erro ao cadastrar Cliente!");
              return;
            } else {
              alert("Erro ao editar Cliente!");
              return;
            }

          }
          return;
        } else {

          if (id.length == 0) {
            alert("Cliente cadastrado com sucesso!");
          } else {
            alert("Cliente editado com sucesso!");
          }

          $('#idCliente').val("");
          $('#txtNomeCliente').val("");
          $('#txtEmailCliente').val("");
          $('#txtRGCliente').val("");
          $('#txtCPFCliente').val("");
          $('#txtTelefoneCliente').val("");
          $('#cmbEstadoCliente').val("default");
          $('#txtCidadeCliente').val("");
          $('#txtRuaCliente').val("");
          $('#txtNumeroCliente').val("");
          $('#txtBairroCliente').val("");
          $('#txtCEPCliente').val("");
          $('#modalCliente').modal("hide");
          lista_clientes();
        }

      }, 'json')

    });

    $('#btnModalVenda').click(function() {

      var vendedor = $("#cmbFuncionarioVenda").val();
      var cliente = $("#cmbClienteVenda").val();
      var carro = $("#cmbCarroVenda").val();
      var valor = $("#txtValorVenda").maskMoney("unmasked")[0];
      var qtde = $("#txtQuantidadeVenda").val();
      var obs = $("#txtComentarioVenda").val();

      qtde = parseInt(qtde);
      var forma_pagto = $("#cmbFormaPagtoVenda").val();

      if (vendedor == "default") {
        alert("Vendedor não selecionado!");
        return;
      }

      if (cliente == "default") {
        alert("Cliente não selecionado!");
        return;
      }

      if (carro == "default") {
        alert("Carro não selecionado!");
        return;
      }

      if (valor <= 0) {
        alert("Valor de venda não permitido!");
        return;
      }

      if (qtde <= 0) {
        alert("Quantidade de venda não é valida!");
        return;
      }

      if (forma_pagto == "default") {
        alert("Forma de pagamento não selecionada!");
        return;
      }

      $.post(`${model_vendas}/salvar_venda`, {
        vendedor,
        cliente,
        carro,
        valor,
        qtde,
        forma_pagto,
        obs
      }, function(data) {

        if (data.erro) {
          if (typeof data.msg !== 'undefined') {
            alert(data.msg);
          } else {
            alert("Erro ao salvar venda!");

          }
          return;
        } else {

          alert("Venda realizada com sucesso!")

          $("#cmbFuncionarioVenda").val("default");
          $("#cmbClienteVenda").val("default");
          $("#cmbCarroVenda").val("default");
          $("#txtValorVenda").val("").attr('disabled', true);
          $("#txtQuantidadeVenda").val("0");
          $("#cmbFormaPagtoVenda").val("default");
          $("#txtComentarioVenda").val("");

          $('#modalVenda').modal("hide");
          lista_vendas();
        }

      }, 'json')

    });

    $('#btnAlterarSenha').click(function() {

      var senhaAtual = $('#txtSenhaAtual').val();
      var novaSenha1 = $('#txtNovaSenha1').val();
      var novaSenha2 = $('#txtNovaSenha2').val();

      if (novaSenha1 != novaSenha2) {
        alert("As senhas digitadas não são iguais");
        return;
      }

      $.post(`${model_usuarios}/alterar_senha`, {
        senhaAtual,
        novaSenha1
      }, function(data) {

        if (data.erro) {
          if (typeof data.msg !== 'undefined') {
            alert(data.msg);
          } else {
            alert("Erro ao alterar senha!");
          }
          return;
        } else {

          alert("Senha alterada com sucesso!");

          $('#txtSenhaAtual').val("");
          $('#txtNovaSenha1').val("");
          $('#txtNovaSenha2').val("");

        }

      }, 'json')
    })

    $('#btnModalCarro').click(function() {

      var id = $('#idCarro').val();
      var nome = $('#txtNomeCarro').val();
      var modelo = $('#txtModeloCarro').val();
      var marca = $('#txtMarcaCarro').val();
      var cor = $('#txtCorCarro').val();
      var tipo = $('#cmbTipoCarro').val();
      var valor = $('#txtValorCarro').maskMoney('unmasked')[0];

      var estoque = $('#txtEstoqueCarro').val();

      if (nome.length == 0) {
        alert("Nome do veículo vazio");
        return;
      }

      if (modelo.length == 0) {
        alert("Modelo do veículo vazio");
        return;
      }
      if (marca.length == 0) {
        alert("Marca do veículo vazia");
        return;
      }
      if (cor.length == 0) {
        alert("Cor do veículo vazia");
        return;
      }
      if (tipo == "default") {
        alert("Escolha o tipo do veículo");
        return;
      }
      if (valor.length == 0) {
        alert("Digite o valor do veículo (somente numeros)");
        return;
      }
      if (estoque.length == 0) {
        alert("Estoque do veículo não digitado");
        return;
      }

      var fotos = [];

      var foto1 = $('#txtFotoCarro1').val();
      var foto2 = $('#txtFotoCarro2').val();
      var foto3 = $('#txtFotoCarro3').val();
      var foto4 = $('#txtFotoCarro4').val();

      if (foto1.length != 0) {
        fotos.push(foto1);
      }

      if (foto2.length != 0) {
        fotos.push(foto2);
      }

      if (foto3.length != 0) {
        fotos.push(foto3);
      }

      if (foto4.length != 0) {
        fotos.push(foto4);
      }

      $.post(`${model_carros}/criar_alterar_carro`, {
        id,
        nome,
        modelo,
        marca,
        cor,
        tipo,
        valor,
        estoque,
        fotos
      }, function(data) {

        if (data.erro) {
          if (typeof data.msg !== 'undefined') {
            alert(data.msg);
          } else {
            if (id.length == 0) {
              alert("Erro ao cadastrar carro!");
              return;
            } else {
              alert("Erro ao editar carro!");
              return;
            }

          }
          return;
        } else {

          if (id.length == 0) {
            alert("Carro cadastrado com sucesso!");
          } else {
            alert("Carro editado com sucesso!");
          }

          $('#idCarro').val("");
          $('#txtNomeCarro').val("");
          // $('#txtPlacaCarro').val("");
          $('#txtModeloCarro').val("");
          $('#txtMarcaCarro').val("");
          $('#txtCorCarro').val("");
          $('#cmbTipoCarro').val("");
          $('#txtValorCarro').val("");
          $('#txtEstoqueCarro').val("");
          $('#txtFotoCarro1').val("");
          $('#txtFotoCarro2').val("");
          $('#txtFotoCarro3').val("");
          $('#txtFotoCarro4').val("");
          $('#modalCarro').modal("hide");
          lista_carros();
        }

      }, 'json')

    });

    $('#btnAlterarInfo').click(function() {
      var nome = $("#txtNomeInfo").val();
      var telefone = $("#txtTelefoneInfo").val();
      var rg = $("#txtRGInfo").val();
      var cpf = $("#txtCPFInfo").val();

      if (nome.length < 2) {
        alert("O nome digitado é muito curto");
        return;
      }
      if (telefone.length < 10) {
        alert("O telefone digitado esta incorreto");
        return;
      }
      if (cpf.length != 11) {
        alert("O CPF foi digitado incorretamente, somente números");
        return;
      }

      if (rg.length < 7) {
        alert("RG digitado incorretamente");
        return;
      }
      $.post(`${model_usuarios}/alterar_dados_funcionario`, {
        nome,
        telefone,
        cpf,
        rg
      }, function(data) {

        if (data.erro) {
          if (typeof data.msg !== 'undefined') {
            alert(data.msg);
          } else {
            alert("Erro ao alterar seus dados!");
          }
          return;
        } else {

          alert("Dados alterados com sucesso!");

        }

      }, 'json')

    });

    $('#btnModalFuncionario').click(function() {
      var nome = $('#txtNomeFuncionario').val();
      var telefone = $('#txtTelefone').val();
      var cpf = $('#txtCPFFuncionario').val();
      var rg = $('#txtRGFuncionario').val();
      var email = $('#txtEmailFuncionario').val();
      var senha = $('#txtSenhaFuncionario').val();
      var tipo_usuario = $('#cmbTipoUsuario').val();

      if (nome.length < 2) {
        alert("O nome digitado é muito curto");
        return;
      }
      if (telefone.length < 10) {
        alert("O telefone digitado esta incorreto");
        return;
      }
      if (cpf.length != 11) {
        alert("O CPF foi digitado incorretamente, somente números");
        return;
      }

      if (rg.length < 7) {
        alert("RG digitado incorretamente");
        return;
      }
      if (nome.email == 0) {
        alert("Email não digitado");
        return;
      }
      if (senha.email == 0) {
        alert("Senha não digitada");
        return;
      }

      $.post(`${model_funcionarios}/cadastrar_funcionario`, {
        nome,
        telefone,
        cpf,
        rg,
        email,
        senha,
        tipo_usuario
      }, function(data) {

        if (data.erro) {
          if (typeof data.msg !== 'undefined') {
            alert(data.msg);
          } else {
            alert("Erro ao cadastrar funcionario!");
          }
          return;
        } else {

          alert("Funcionário cadastrado com sucesso!");
          $('#modalFuncionario').modal('hide');

          limpar_campos_funcionario();
          $('#cmbTipoPesquisaFuncionario').val("default");
          $('#txtBuscaFuncionario').val("");
          lista_funcionarios();

        }

      }, 'json')

    })

    $('.titulo-panel').click(function() {

      var opcao = ".opcao-" + $(this).attr("titulo");

      if ($(this).hasClass("ativo")) {
        $(this).find('.fa-chevron-down').each(function() {
          $(this).removeClass('fa-chevron-down').addClass("fa-chevron-right");
        });

        $(this).removeClass("ativo");
        $(opcao).fadeOut();

      } else {

        $(this).find('.fa-chevron-right').each(function() {
          $(this).removeClass('fa-chevron-right').addClass("fa-chevron-down");
        });

        $(this).addClass("ativo");

        $(opcao).fadeIn();
      }
    });

  });

  function alterarStatusConta(status, id) {
    $.post(`${model_funcionarios}/alterar_status_conta`, {
      status,
      id
    }, function(data) {

      if (data.erro) {
        if (typeof data.msg !== 'undefined') {
          alert(data.msg);
        } else {
          alert("Erro ao desativar conta!");
        }
        return;
      } else {

        lista_funcionarios();

      }

    }, 'json')
  }

  function cmb_vendedores(set = "") {
    $.post(`${model_vendas}/lista_vendedores`, {}, function(data) {

      if (data.erro) {
        if (typeof data.msg !== 'undefined') {
          alert(data.msg);
        } else {
          alert("Erro ao listar vendedores!");
        }
        return;
      } else {

        $('#cmbFuncionarioVenda').html(data.html);

        if (set.length != 0) {
          $('#cmbFuncionarioVenda').val(set);
        }

      }

    }, 'json')
  }

  function cmb_clientes(set = "") {
    $.post(`${model_vendas}/lista_clientes`, {}, function(data) {

      if (data.erro) {
        if (typeof data.msg !== 'undefined') {
          alert(data.msg);
        } else {
          alert("Erro ao listar clientes!");
        }
        return;
      } else {

        $('#cmbClienteVenda').html(data.html);

        if (set.length != 0) {
          $('#cmbClienteVenda').val(set);
        }

      }

    }, 'json')
  }

  function cmb_carros(set = "") {
    $.post(`${model_vendas}/lista_carros`, {}, function(data) {

      if (data.erro) {
        if (typeof data.msg !== 'undefined') {
          alert(data.msg);
        } else {
          alert("Erro ao listar carros!");
        }
        return;
      } else {

        $('#cmbCarroVenda').html(data.html);

        if (set.length != 0) {
          $('#cmbCarroVenda').val(set);
        }

      }

    }, 'json')
  }

  function alterar_status_venda(id, status) {

    if (confirm("Deseja altera a venda para cancelada?")) {
      $.post(`${model_vendas}/alterar_status_venda`, {
        id,
        status
      }, function(data) {

        if (data.erro) {
          if (typeof data.msg !== 'undefined') {
            alert(data.msg);
          } else {
            alert("Erro ao alterar status da venda!");
          }
          return;
        } else {

          alert("Status alterado com sucesso!");
          lista_vendas();

        }

      }, 'json')
    }
  }

  function criar_venda() {

    cmb_vendedores();
    cmb_clientes();
    cmb_carros();
    $("#cmbCarroVenda").val("default");
    $('#txtValorVenda').val("").attr('disabled', true);

    $('#tituloModalVenda').html("Cadastrar nova Venda");
    $('#btnModalVenda').html("Finalizar Venda");
    $('#modalVenda').modal("show");
  }

  function lista_vendas() {
    var busca = $('#txtBuscaVenda').val();
    var tipo = $('#cmbTipoPesquisaVenda').val();
    var status = $('#cmbPesquisaStatusVenda').val();

    if (busca.length == 0 && tipo != "default") {
      alert("Termo de busca não digitado");
      return;
    }

    $.post(`${model_vendas}/lista_vendas`, {
      busca,
      tipo,
      status
    }, function(data) {

      if (data.erro) {
        if (typeof data.msg !== 'undefined') {
          alert(data.msg);
        } else {
          alert("Erro ao alterar listar vendas!");
        }
        return;
      } else {

        $('#lista-de-vendas > tbody').html(data.html);

      }

    }, 'json')

  }

  function mostrar_detalhes_pedido(id) {
    $.post(`${model_vendas}/detalhes_pedido`, {
      id
    }, function(data) {


      if (data.erro) {
        if (typeof data.msg !== 'undefined') {
          alert(data.msg);
        } else {
          alert("Erro ao alterar tipo de conta!");
        }
        return;
      } else {

        $('#divDetalhesPedido').html(data.html);

        $('#modalDetalhesPedido').modal('show');
      }

    }, 'json')
  }

  function alterarTipoConta(id, tipo) {
    $.post(`${model_funcionarios}/alterar_tipo_conta`, {
      id,
      tipo
    }, function(data) {

      if (data.erro) {
        if (typeof data.msg !== 'undefined') {
          alert(data.msg);
        } else {
          alert("Erro ao alterar tipo de conta!");
        }
        return;
      } else {

        lista_funcionarios();

      }

    }, 'json')
  }

  function buscar_tipos_de_carros(set = '') {

    $.post(`${model_carros}/filtro_tipo_carros`, {}, function(data) {

      if (data.erro) {
        if (typeof data.msg !== 'undefined') {
          alert(data.msg);
        } else {
          alert("Erro ao buscar filtro de tipos de carros!");
        }
        return;
      } else {

        $('#cmbTipoCarro').html(data.html);

        if (set.length != 0) {
          $('#cmbTipoCarro').val(set);
        }

      }

    }, 'json')
  }

  function buscar_info_funcionario() {
    $.post(`${model_usuarios}/buscar_info_funcionario`, {}, function(data) {

      if (data.erro) {
        if (typeof data.msg !== 'undefined') {
          alert(data.msg);
        } else {
          alert("Erro ao buscar dados do funcionario!");
        }
        return;
      } else {

        $('#txtNomeInfo').val(data.nome);
        $('#txtTelefoneInfo').val(data.telefone);
        $('#txtRGInfo').val(data.rg);
        $('#txtCPFInfo').val(data.cpf);
        // btnAlterarInfo

      }

    }, 'json')
  }

  function filtro_tipo_carros() {

    $.post(`${model_carros}/filtro_tipo_carros`, {}, function(data) {

      if (data.erro) {
        if (typeof data.msg !== 'undefined') {
          alert(data.msg);
        } else {
          alert("Erro ao buscar filtro de tipos de carros!");
        }
        return;
      } else {

        $('#cmbFiltroTipoCarro').html(data.html);

      }

    }, 'json')
  }

  function numerar() {
    var cnt = 1;
    $('.titulo-panel').each(function() {
      $(this).attr("titulo", cnt);
      cnt++;
    });

    cnt = 1

    $(".opcoes-panel").each(function() {
      $(this).addClass("opcao-" + cnt);
      cnt++;
    });
  }

  function criar_carro() {
    buscar_tipos_de_carros();
    $('#tituloModalCarro').html("Cadastrar Carro");
    $('#modalCarro').modal("show");
  }

  function criar_cliente() {
    $('#tituloModalCliente').html("Cadastrar cliente");
    $('#modalCliente').modal("show");
  }

  function criar_funcionario() {
    $('#tituloModalFuncionario').html("Cadastrar Funcionário");
    $('#modalFuncionario').modal("show");
  }

  function alterar_tipo_carro(id) {
    $.post(`${model_carros}/buscar_tipo_carro`, {
      id
    }, function(data) {

      if (data.erro) {
        if (typeof data.msg !== 'undefined') {
          alert(data.msg);
        } else {
          alert("Erro ao buscar tipo de carro!");
        }
        return;
      } else {

        $('#idTipoCarro').val(id);
        $('#txtNomeTipoCarro').val(data.nome);
        $('#tituloModalTipoCarro').html("Alterar tipo de Carro");
        $('#btnModalTipoCarro').html("Alterar");
        $('#modalTipoCarro').modal("show");

      }

    }, 'json')


  }

  function excluir_tipo_carro(id) {

    if (!confirm("Deseja deletar o tipo de carro?")) {
      return;
    }

    $.post(`${model_carros}/excluir_tipo_carro`, {
      id
    }, function(data) {

      if (data.erro) {
        if (typeof data.msg !== 'undefined') {
          alert(data.msg);
        } else {
          alert("Erro ao excluir tipo de carro!");
        }
        return;
      } else {

        lista_tipos_carros();

      }

    }, 'json')
  }

  function criar_tipo_carro() {

    $('#idTipoCarro').val("");
    $('#txtNomeTipoCarro').val("");
    $('#tituloModalTipoCarro').html("Cadastrar tipo de Carro");
    $('#btnModalTipoCarro').html("Criar");
    $('#modalTipoCarro').modal("show");
  }

  function limpar_campos_funcionario() {
    $('#txtNomeFuncionario').val("");
    $('#txtTelefone').val("");
    $('#txtCPFFuncionario').val("");
    $('#txtRGFuncionario').val("");
    $('#txtEmailFuncionario').val("");
    $('#txtSenhaFuncionario').val("");
    $('#cmbTipoUsuario').val("vendedor");
  }

  function lista_funcionarios() {

    var tipo = $('#cmbTipoPesquisaFuncionario').val();
    var pesquisa = $('#txtBuscaFuncionario').val();
    var filtro = [];

    if (tipo != null) {
      if (tipo != "default") {
        if (pesquisa.length == 0) {
          alert("Pesquisa não digitada!");
          return;
        }

        filtro.push({
          'tipo': tipo,
          'pesquisa': pesquisa
        });

      }
    }

    $.post(`${model_funcionarios}/lista_funcionarios`, {
      filtro
    }, function(data) {

      if (data.erro) {
        if (typeof data.msg !== 'undefined') {
          alert(data.msg);
        } else {
          alert("Erro ao listar funcionarios!");
        }
        return;
      } else {

        $('#lista-de-funcionarios > tbody').html(data.html);

      }

    }, 'json')
  }

  function alterar_carro(id) {

    $.post(`${model_carros}/buscar_dados_carro`, {
      id
    }, function(data) {

      if (data.erro) {
        if (typeof data.msg !== 'undefined') {
          alert(data.msg);
        } else {
          alert("Erro ao buscar dados do carro!");
        }
        return;
      } else {

        var dados = data.dados;
        buscar_tipos_de_carros(dados.tipo_id);
        $('#idCarro').val(id);
        $('#txtNomeCarro').val(dados.nome);
        // $('#txtPlacaCarro').val(dados.placa);
        $('#txtModeloCarro').val(dados.modelo);
        $('#txtMarcaCarro').val(dados.marca);
        $('#txtCorCarro').val(dados.cor);
        // $('#cmbTipoCarro').val(dados.tipo_id);
        $('#txtValorCarro').val(dados.valor);
        $('#txtEstoqueCarro').val(dados.estoque);
        $('#txtFotoCarro1').val(dados.foto1);
        $('#txtFotoCarro2').val(dados.foto2);
        $('#txtFotoCarro3').val(dados.foto3);
        $('#txtFotoCarro4').val(dados.foto4);
        $('#tituloModalCarro').html("Alterar tipo de Carro");
        $('#btnModalCarro').html("Alterar");
        $('#modalCarro').modal("show");
        $('#txtValorCarro').focus().blur();

      }

    }, 'json')
  }

  function alterar_cliente(id) {

    $.post(`${model_clientes}/buscar_dados_cliente`, {
      id
    }, function(data) {

      if (data.erro) {
        if (typeof data.msg !== 'undefined') {
          alert(data.msg);
        } else {
          alert("Erro ao buscar dados do carro!");
        }
        return;
      } else {

        var dados = data.dados;

        $('#idCliente').val(dados.id);
        $('#txtNomeCliente').val(dados.nome);
        $('#txtEmailCliente').val(dados.email);
        $('#cmbEstadoCliente').val(dados.estado);
        $('#txtRGCliente').val(dados.rg);
        $('#txtCPFCliente').val(dados.cpf);
        $('#txtTelefoneCliente').val(dados.telefone);
        $('#txtCidadeCliente').val(dados.cidade);
        $('#txtRuaCliente').val(dados.rua);
        $('#txtNumeroCliente').val(dados.numero);
        $('#txtBairroCliente').val(dados.bairro);
        $('#txtCEPCliente').val(dados.cep);

        $('#tituloModalCliente').html("Alterar tipo de Carro");
        $('#btnModalCliente').html("Alterar");
        $('#modalCliente').modal("show");

      }

    }, 'json')
  }

  function excluir_carro(id) {
    if (!confirm("Deseja deletar o carro?")) {
      return;
    }

    $.post(`${model_carros}/excluir_carro`, {
      id
    }, function(data) {

      if (data.erro) {
        if (typeof data.msg !== 'undefined') {
          alert(data.msg);
        } else {
          alert("Erro ao excluir o carro!");
        }
        return;
      } else {

        lista_carros();

      }

    }, 'json')
  }

  function lista_carros() {

    var tipo = $('#cmbTipoPesquisaCarro').val();
    var pesquisa = $('#txtBuscaCarro').val();
    var tipo_carro = $('#cmbFiltroTipoCarro').val();
    var filtro = [];

    if (tipo_carro == "default") {
      tipo_carro = null;
    }

    if (tipo != null) {
      if (tipo != "default") {
        if (pesquisa.length == 0) {
          alert("Pesquisa não digitada!");
          return;
        }

        filtro.push({
          'tipo': tipo,
          'pesquisa': pesquisa
        });

      }
    }

    $.post(`${model_carros}/lista_carros`, {
      filtro,
      tipo_carro
    }, function(data) {

      if (data.erro) {
        if (typeof data.msg !== 'undefined') {
          alert(data.msg);
        } else {
          alert("Erro ao listar carros!");
        }
        return;
      } else {

        $('#lista-de-carros > tbody').html(data.html);

      }

    }, 'json')
  }

  function lista_clientes() {

    var tipo = $('#cmbTipoPesquisaCliente').val();
    var pesquisa = $('#txtBuscaCliente').val();
    var filtro = [];

    if (tipo != null) {
      if (tipo != "default") {
        if (pesquisa.length == 0) {
          alert("Pesquisa não digitada!");
          return;
        }

        filtro.push({
          'tipo': tipo,
          'pesquisa': pesquisa
        });
      }
    }

    $.post(`${model_clientes}/lista_clientes`, {
      filtro
    }, function(data) {

      if (data.erro) {
        if (typeof data.msg !== 'undefined') {
          alert(data.msg);
        } else {
          alert("Erro ao listar clientes!");
        }
        return;
      } else {

        $('#lista-de-clientes > tbody').html(data.html);

      }

    }, 'json')
  }


  function lista_tipos_carros() {

    var pesquisa = $('#txtBuscaTipoCarro').val();

    $.post(`${model_carros}/lista_tipos_carros`, {
      pesquisa
    }, function(data) {

      if (data.erro) {
        if (typeof data.msg !== 'undefined') {
          alert(data.msg);
        } else {
          alert("Erro ao listar tipos de carro!");
        }
        return;
      } else {

        $('#lista-de-tipos-de-carros > tbody').html(data.html);

      }

    }, 'json')
  }
</script>
