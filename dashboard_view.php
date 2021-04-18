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
        <p class="opcao">Histórico de Vendas</p>
      </div>
      <div class="titulo-panel">
        Opções
        <i class="fa fa-chevron-right flecha"></i>
      </div>
      <div class="opcoes-panel" style="display:none;">
        <p class="opcao" id="mostra-mudar-senha">Mudar senha</p>
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
                <!-- <th class="text-center">Placa</th> -->
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
        lista clients
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
                    <input class="form-control" type="text" id="txtValorCarro">
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

<script>
  var model_funcionarios = '<?= $conf->base_url(); ?>request/model/funcionarios';
  var model_carros = '<?= $conf->base_url(); ?>request/model/carros';
  $(document).ready(function() {

    numerar();
    lista_carros();
    lista_tipos_carros();
    lista_funcionarios();

    filtro_tipo_carros();

    $('.opcoes-panel').click(function(e) {
      e.preventDefault();
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

    $('#btnModalCarro').click(function() {

      var id = $('#idCarro').val();
      var nome = $('#txtNomeCarro').val();
      var placa = $('#txtPlacaCarro').val();
      var modelo = $('#txtModeloCarro').val();
      var marca = $('#txtMarcaCarro').val();
      var cor = $('#txtCorCarro').val();
      var tipo = $('#cmbTipoCarro').val();
      var valor = $('#txtValorCarro').val();
      var estoque = $('#txtEstoqueCarro').val();

      if (nome.length == 0) {
        alert("Nome do veículo vazio");
        return;
      }
      if (placa.length > 7) {
        alert("Placa digitada incorretamente, digite sem o hífen");
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
        placa,
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
            return;
          } else {
            alert("Carro editado com sucesso!");
            return;
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

    var tipo = $('#cmbTipoPesquisaFuncionario').val();
    var pesquisa = $('#cmbTipoPesquisaCarro').val();
    var tipo_carro = $('#cmbFiltroTipoCarro').val();
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