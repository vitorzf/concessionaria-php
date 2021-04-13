<div class="wrapper">
    <header>
        <nav>
            <div class="menu-icon">
                <i class="fa fa-bars fa-2x"></i>
            </div>
            <div class="logo">
                Concessionária
            </div>
            <div class="menu">
                <ul>
                    <li><a href="<?= $conf->base_url() ?>">Home</a></li>
                    <?php
                    if (!$session->logado()) {
                        echo "<li><a href=\"javascript:modalLogin()\">Login/Cadastro</a></li>";
                    } else {
                        echo "<li><a href=\"{$conf->base_url("painel")}\">Painel</a></li>
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
                <h5 class="modal-title" id="tituloModalLoginCadastro">Login de colaboradores</h5>
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

        $('#txtUsuarioEmail').keypress(function(e) {
            if (e.which == 13) {
                $('#realizarLogin').click();
            }
        });

        $('#txtUsuarioSenha').keypress(function(e) {
            if (e.which == 13) {
                $('#realizarLogin').click();
            }
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

</script>