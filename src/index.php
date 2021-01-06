<?php

/* to Hide All Errors: */
//error_reporting(0);
//ini_set('display_errors', 0);

/* to Show All Errors: */
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: image/svg+xml');
header('Content-Disposition: inline; filename="bandeira.svg"');

foreach (glob("class/*.class.php") as $classe) {
    require_once("./$classe");
}

ConfiguracaoAmbiente::defineConstantes();

$comprimento = filter_input(INPUT_GET, 'c', FILTER_VALIDATE_INT, array('options' => array('default' => 800, 'min_range' => 200, 'max_range' => 4000)));

$sistema = new SistemaBandeira($comprimento);
echo $sistema->exibeBandeira();
   
