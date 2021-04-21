<?php
session_start();
foreach (glob("./classes/*.php") as $nome_arquivo) {
    require $nome_arquivo;
}

$conf = new Config();
$session = new Session();
$funcoes = new Funcoes();

$GLOBALS['database'] = new Database();
$GLOBALS['session'] = $session;
$GLOBALS['funcoes'] = $funcoes;
$GLOBALS['config'] = $conf;

$path = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
$str = str_replace("http://", "", $conf->base_url());
$str = str_replace("//", "/", $str);

$p = explode("http://{$str}", $path);

if (!empty($p[1])) {

    $z = explode("/", $p[1]);

    if ($z[0] == "request") {

        $caminho = getcwd() . "/{$z[1]}/{$z[2]}.php";
        require $caminho;

        $z[3]();
        die();
    }
}


$link = strtolower($_SERVER['REQUEST_URI']);

$params = explode("/", $link);

$arquivo = $params[2];
$complemento = "";

if (!empty($params[3])) {

    $comp = ucfirst($params[3]);

    $complemento = " - {$comp}";
}

$nome_pagina = ucfirst($arquivo) . $complemento;

if (empty($nome_pagina)) {
    $arquivo = "home";
    $nome_pagina = "Home";
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>

    <title><?= $nome_pagina ?></title>
</head>

<body>

    <style>
        body {
            font-family: "Helvetica Neue", sans-serif;
            font-weight: lighter;
            margin: 0;
            padding: 0;
            width: 100%;
        }

        header {
            width: 100%;
            /* height: 100vh; */
            /* background: url() no-repeat 50% 50%; */
            /* background-size: cover; */
        }

        .content {
            width: 94%;
            margin: 4em auto;
            font-size: 20px;
            line-height: 30px;
            text-align: justify;
        }

        .logo {
            line-height: 60px;
            position: fixed;
            float: left;
            margin: 16px 46px;
            color: #fff;
            font-weight: bold;
            font-size: 20px;
            letter-spacing: 2px;
        }

        nav {
            position: fixed;
            width: 100%;
            line-height: 60px;
            z-index: 1000;
        }

        nav ul {
            line-height: 60px;
            list-style: none;
            background: rgba(0, 0, 0, 0);
            overflow: hidden;
            color: #fff;
            padding: 0;
            text-align: right;
            margin: 0;
            padding-right: 40px;
            transition: 1s;
        }

        nav.black ul {
            background: #000;
        }

        nav ul li {
            display: inline-block;
            padding: 16px 40px;
            ;
        }

        nav ul li a {
            text-decoration: none;
            color: #fff;
            font-size: 16px;
        }

        nav ul li a:hover {
            text-decoration: none;
            color: #fff;
        }

        .menu-icon {
            line-height: 60px;
            width: 100%;
            background: #000;
            text-align: right;
            box-sizing: border-box;
            padding: 15px 24px;
            cursor: pointer;
            color: #fff;
            display: none;
        }

        @media(max-width: 786px) {

            .logo {
                position: fixed;
                top: 0;
                margin-top: 16px;
            }

            nav ul {
                max-height: 0px;
                background: #000;
            }

            nav.black ul {
                background: #000;
            }

            .showing {
                max-height: 34em;
            }

            nav ul li {
                box-sizing: border-box;
                width: 100%;
                padding: 24px;
                text-align: center;
            }

            .menu-icon {
                display: block;
            }

        }
    </style>
    <div id="tudo">
        <?php
        require 'cabecalho.php';
        ?>

        <div id="conteudo" style="padding-top:100px;">
            <?php
            require "{$arquivo}_view.php";
            ?>
        </div>

        <?php
        require 'rodape.php';
        ?>
    </div>
    <script>
        $(document).ready(function() {

            $(".menu-icon").on("click", function() {
                $("nav ul").toggleClass("showing");
            });
        });
    </script>
</body>

</html>