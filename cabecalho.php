<div class="wrapper">
    <header>
        <nav>
            <div class="menu-icon">
                <i class="fa fa-bars fa-2x"></i>
            </div>
            <div class="logo">
                TOPZERA
            </div>
            <div class="menu">
                <ul>
                    <li><a href="<?= $conf->base_url() ?>">Home</a></li>
                    <?php
                    if (!$session->logado()) {
                        echo "<li><a href=\"javascript:modalLogin()\">Login/Cadastro</a></li>";
                    } else {
                        echo "<li><a href=\"{$conf->base_url("minhaconta")}\">Minha Conta</a></li>
                              <li><a href=\"javascript:logoff()\">Sair</a></li>";
                    }
                    ?>
                </ul>
            </div>
        </nav>
    </header>
</div>

<div class="modal" tabindex="-1" id="modalLoginCadastro">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tituloModalLoginCadastro">Login</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid" id="divLogin">
                    <div class="row">
                        <div class="col-xs-10 col-sm-10 col-md-8 col-lg-8 offset-xs-1 offset-sm-1 offset-md-2 offset-lg-2">
                            <div class="form-group">
                                <label for="txtUsuarioEmail">Usuário ou Email</label>
                                <input class="form-control" type="text" id="txtUsuarioEmail">
                            </div>
                            <div class="form-group">
                                <label for="txtUsuarioSenha">Senha</label>
                                <input class="form-control" type="password" id="txtUsuarioSenha">
                            </div>
                        </div>
                        <div class="text-center" style="width:100%;">
                            <button id="realizarLogin" class="btn btn-success" data-loading-text="Validando...">
                                Entrar
                            </button>
                            <p style="margin-top:15px; font-size:14px;">
                                Não tem uma conta? <a href="javascript:criarConta()">Clique aqui!</a>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="container-fluid" id="divCadastro" style="display:none;">
                    <div class="row">
                        <div class="col-xs-10 col-sm-10 col-md-8 col-lg-8 offset-xs-1 offset-sm-1 offset-md-2 offset-lg-2">
                            <div class="form-group">
                                <label for="txtUsuarioCadastro">Nome de usuário</label>
                                <input class="form-control" type="text" id="txtUsuarioCadastro">
                            </div>
                            <div class="form-group">
                                <label for="txtEmailCadastro">Email</label>
                                <input class="form-control" type="email" id="txtEmailCadastro">
                            </div>
                            <div class="form-group">
                                <label for="txtSenhaCadastro">Senha</label>
                                <input class="form-control" type="password" id="txtSenhaCadastro">
                            </div>
                            <div class="form-group">
                                <label for="txtSenhaRepCadastro">Repita a senha</label>
                                <input class="form-control" type="password" id="txtSenhaRepCadastro">
                            </div>
                        </div>
                        <div class="text-center" style="width:100%;">
                            <button id="finalizarCadastro" class="btn btn-success" data-loading-text="Aguarde...">
                                Finalizar Cadastro
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    var model_usuarios = '<?= $conf->base_url(); ?>request/model/usuarios';

    $(document).ready(function() {
        $(document).on("click", "#finalizarCadastro", function() {

            var usuario = $('#txtUsuarioCadastro').val();
            var email = $('#txtEmailCadastro').val();
            var senha = $('#txtSenhaCadastro').val();
            var senha2 = $('#txtSenhaRepCadastro').val();

            if (senha != senha2) {
                alert("As senhas devem ser identicas");
                return;
            }

            if (usuario.length < 4) {
                alert("O nome de usuário deve ter no mínimo 5 caracteres");
                return;
            }

            $.post(`${model_usuarios}/cadastrarUsuario`, {
                usuario,
                email,
                senha
            }, function(data) {
                if (data.erro) {
                    alert("Erro ao realizar cadastro!");
                    return;
                } else {
                    alert("Cadastro realizado com sucesso!");
                    voltarLogin();
                }

            }, 'json')

        });

        $(document).on("click", "#realizarLogin", function() {
            var emailuser = $('#txtUsuarioEmail').val();
            if (emailuser.length == 0) {
                alert("Email ou nome de usuário devem ser informados!");
                return;
            }
            var senha = $('#txtUsuarioSenha').val();
            if (senha.length == 0) {
                alert("Senha não informada!");
                return;
            }

            $.post(`${model_usuarios}/realizarLogin`, {
                emailuser,
                senha
            }, function(data) {
                if (data.erro) {
                    alert("Erro ao realizar login!");
                    return;
                } else {
                    location.reload();
                }

            }, 'json')
        })
    });

    function limparCampos() {
        $('#txtUsuarioEmail').val("");
        $('#txtUsuarioSenha').val("");
        $('#txtUsuarioCadastro').val("");
        $('#txtEmailCadastro').val("");
        $('#txtSenhaCadastro').val("");
        $('#txtSenhaRepCadastro').val("");
    }

    function voltarLogin() {
        limparCampos();
        $('#tituloModalLoginCadastro').html("Login");
        $('#divCadastro').hide();
        $('#divLogin').show();
    }

    function modalLogin() {
        limparCampos();
        $('#tituloModalLoginCadastro').html("Login");
        $('#divCadastro').hide();
        $('#divLogin').show();
        $('#modalLoginCadastro').modal("show");

    }

    function logoff() {
        $.post(`${model_usuarios}/sair`, {}, function() {
            window.location.replace("<?= $conf->base_url() ?>");
        }, 'json')
    }

    function criarConta() {
        limparCampos();
        $('#tituloModalLoginCadastro').html("<a href=\"javascript:voltarLogin()\"><i class=\"fa fa-chevron-left\"></i> Voltar</a>");
        $('#divLogin').hide();
        $('#divCadastro').show();


    }
</script>