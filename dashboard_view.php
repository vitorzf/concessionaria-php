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
        <p class="opcao">Listagem de Carros</p>
        <p class="opcao">Listagem de Carros</p>
        <p class="opcao">Listagem de Carros</p>
        <p class="opcao">Listagem de Carros</p>
      </div>
      <div class="titulo-panel">
        Clientes
        <i class="fa fa-chevron-right flecha"></i>
      </div>
      <div class="opcoes-panel" style="display:none;">
        <p class="opcao">Listagem de Carros</p>
        <p class="opcao">Listagem de Carros</p>
        <p class="opcao">Listagem de Carros</p>
        <p class="opcao">Listagem de Carros</p>
      </div>
      <div class="titulo-panel">
        Funcionários
        <i class="fa fa-chevron-right flecha"></i>
      </div>
      <div class="opcoes-panel" style="display:none;">
        <p class="opcao" id="mostra-lista-funcionarios">Listagem de Funcionários</p>
      </div>
      <div class="titulo-panel">
        Vendas
        <i class="fa fa-chevron-right flecha"></i>
      </div>
      <div class="opcoes-panel" style="display:none;">
        <p class="opcao">Listagem de Carros</p>
        <p class="opcao">Listagem de Carros</p>
        <p class="opcao">Listagem de Carros</p>
        <p class="opcao">Listagem de Carros</p>
      </div>
    </div>
    <div class="col-xs-11 col-sm-11 col-md-9 col-lg-9 offset-xs-1 offset-sm-1 offset-md-0 offset-lg-0 telas">
      <div id="bem-vindo" class="text-center pad-5">
        <h4>Bem-vindo ao Dashboard da Concessionária topzera</h4>
        <p>Selecione ao lado a operação que deseja realizar.</p>
      </div>
      <!-- A partir daqui começa as telas separadas -->

      <!-- Carros -->

      <!-- Clientes -->

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
  $(document).ready(function() {

    numerar();
    lista_funcionarios();

    $('.opcoes-panel').click(function(e) {
      e.preventDefault();
    });

    $('.opcao').click(function() {
      var id = "#" + $(this).attr('id').slice(7);
      $('#bem-vindo').hide();
      $('.telas').find(".mostra").each(function() {
        $(this).removeClass("mostra").addClass("naoMostra");
      });

      $(id).show();

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

  function criar_funcionario() {
    $('#tituloModalFuncionario').html("Cadastrar Funcionário");
    $('#modalFuncionario').modal("show");
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
</script>