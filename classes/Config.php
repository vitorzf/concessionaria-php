<?php
    class Config{

        public $base_url;

        public function __construct()
        {
            $url = "http://" . $_SERVER['SERVER_NAME'] . dirname($_SERVER['PHP_SELF']);

            $exp = explode("index.php", $url);

            $url_atual = $exp[0];
            $this->base_url = rtrim($url_atual, "/");
        }

        public function base_url($params = null){
            $url = "http://" . $_SERVER['SERVER_NAME'] . dirname($_SERVER['PHP_SELF']);

            $exp = explode("index.php", $url);

            $url_atual = $exp[0];

            if (mb_strpos($url_atual, $this->base_url) !== false) {
                
                return "{$this->base_url}/{$params}";
            } else {
                throw new Exception("Error: Base url no arquivo index.php incorreta", 1);
                die();
            }
        }
    }
?>