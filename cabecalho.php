<?php

$nome = $funcoes->nomeLogin();
if (!empty($nome)) {

    $GLOBALS['session']->setSession("nome", $nome);
}

?>

<style>
    .logo {
        text-decoration: none !important;
        color: white;
        font-size: 20px;
        text-align: center;
        transition-duration: 0.5s;
    }

    .logo:hover {
        color: white;
        font-size: 26px;
        margin-left: 36px;
        transition-duration: 0.5s;
        -webkit-animation: glow 1s ease-in-out infinite alternate;
        -moz-animation: glow 1s ease-in-out infinite alternate;
        animation: glow 1s ease-in-out infinite alternate;
    }

    @-webkit-keyframes glow {
        from {
            text-shadow: 0 0 10px #fff, 0 0 20px #fff, 0 0 30px #e60073, 0 0 40px #e60073, 0 0 50px #e60073, 0 0 60px #e60073, 0 0 70px #e60073;
        }

        to {
            text-shadow: 0 0 20px #fff, 0 0 30px #ff4da6, 0 0 40px #ff4da6, 0 0 50px #ff4da6, 0 0 60px #ff4da6, 0 0 70px #ff4da6, 0 0 80px #ff4da6;
        }
    }
</style>

<div class="wrapper">
    <header>
        <nav class="black">
            <div class="menu-icon">
                <i class="fa fa-bars fa-2x"></i>
            </div>
            <div>
                <a class="logo" href="<?= $GLOBALS['config']->base_url(); ?>">
                    <i>VIVC</i>
                </a>
            </div>
            <div class="menu">
                <ul>
                    <li><a href="<?= $conf->base_url() ?>">Home</a></li>
                    <?php
                    if (!$session->logado()) {
                        echo "<li><a href=\"javascript:modalLogin()\">Login colaborador</a></li>";
                    } else {

                        $exp = explode(" ", $nome);


                        echo "<li><a href=\"javascript:void()\">Bem-vindo(a) {$exp[0]}</a></li>
                              <li><a href=\"{$conf->base_url("dashboard")}\">Painel</a></li>
                              <li><a href=\"javascript:logoff()\">Sair</a></li>";
                    }
                    ?>
                </ul>
            </div>
        </nav>
    </header>
</div>

<div class="modal" tabindex="-1" id="modalLogin">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Login de colaboradores</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xs-10 col-sm-10 col-md-8 col-lg-8 offset-xs-1 offset-sm-1 offset-md-2 offset-lg-2">
                            <div class="form-group">
                                <label for="txtUsuarioEmail">Email</label>
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

        atualizarLogin();

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
                    if (typeof data.msg !== 'undefined') {
                        alert(data.msg);
                    } else {
                        alert("Erro ao realizar login!");

                    }
                    return;
                } else {
                    location.reload();
                }

            }, 'json')
        })
    });

    function atualizarLogin() {
        $.post(`${model_usuarios}/atualizarLogin`, {}, function() {})
    }

    function limparCampos() {
        $('#txtUsuarioEmail').val("");
        $('#txtUsuarioSenha').val("");
    }

    function modalLogin() {
        limparCampos();
        $('#divLogin').show();
        $('#modalLogin').modal("show");

    }

    function logoff() {
        $.post(`${model_usuarios}/sair`, {}, function() {
            window.location.replace("<?= $conf->base_url() ?>");
        }, 'json')
    }
</script>