<?php
session_start();
foreach (glob("./classes/*.php") as $nome_arquivo) {
    require $nome_arquivo;
}

$conf = new Config();
$session = new Session();

$GLOBALS['database'] = new Database();
$GLOBALS['session'] = $session;

$path = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
$str = str_replace("http://", "", $conf->base_url());
$str = str_replace("//", "/", $str);

$p = explode("http://{$str}", $path);

if(!empty($p[1])){

    $z = explode("/", $p[1]);

    if($z[0] == "request"){
        
        $caminho = getcwd()."/{$z[1]}/{$z[2]}.php";
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

if(empty($nome_pagina)){
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
    <link rel="stylesheet" href="<?= $conf->base_url("assets/style.css") ?>">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <title><?= $nome_pagina ?></title>
</head>

<body>
    <?php
    require 'cabecalho.php';
    ?>

    <div class="container-fluid" style="padding-top:100px;">
        <?php
            require "{$arquivo}_view.php";
        ?>
    </div>

    <script>
        $(document).ready(function() {
            $('nav').addClass('black');

            $(".menu-icon").on("click", function() {
                $("nav ul").toggleClass("showing");
            });
        });

        $(window).on("scroll", function() {
            if ($(window).scrollTop()) {
                $('nav').addClass('black');
            } else {
                $('nav').removeClass('black');
            }
        })
    </script>
</body>

</html>