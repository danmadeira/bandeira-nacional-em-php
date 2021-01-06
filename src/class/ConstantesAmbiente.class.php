<?php

/**
 * Esta classe contém valores para configuração da bandeira nacional.
 */
class ConfiguracaoAmbiente
{
    
    /**
     * A configuração será constante.
     */
    public static function defineConstantes()
    {
        define('TITULO', 'Bandeira Nacional');
        define('DESCRICAO', 'Desenho da bandeira do Brasil regulamentado pela Lei n° 5.700, de 1° de setembro de 1971, incluindo a alteração dada pela Lei n° 8.421, de 11 de maio de 1992. As cores seguem a paleta prioritária de cores do sistema de identidade visual do Ministério da Defesa, que consta no Manual de Identidade Visual do Ministério da Defesa, na edição de janeiro de 2015.');
        define('MODULO', 100);
        define('LARGURA_BANDEIRA', 14);
        define('COMPRIMENTO_BANDEIRA', 20);
        define('DISTANCIA_LOSANGO', 1.7);
        define('RAIO_CIRCULO', 3.5);
        define('CENTRO_ARCO_FAIXA', 2);
        define('RAIO_ARCO_INF', 8);
        define('RAIO_ARCO_SUP', 8.5);
        define('LARGURA_FAIXA', 0.5);
        define('ALTURA_LETRA', 0.33);
        define('LARGURA_LETRA', 0.30);
        define('ALTURA_CONJUNCAO_E', 0.30);
        define('LARGURA_CONJUNCAO_E', 0.25);
        define('TAMANHO_FONTE_LETRA', 45);
        define('TAMANHO_FONTE_CONJUNCAO', 41);
        define('ESPACO_LETRA', 4);
        define('ESPACO_PALAVRA', 8);
        define('GRANDEZAS_ESTRELAS', array(1 => 0.30,
                                           2 => 0.25,
                                           3 => 0.20,
                                           4 => 0.14,
                                           5 => 0.10));
        define('COR_VERDE', 'rgb(0,112,36)');
        define('COR_AMARELA', 'rgb(247,198,0)');
        define('COR_AZUL', 'rgb(33,42,116)');
        define('COR_BRANCA', 'rgb(255,255,255)');
        define('LEGENDA_ORDEM', 'ORDEM');
        define('LEGENDA_CONJUNCAO', 'E');
        define('LEGENDA_PROGRESSO', 'PROGRESSO');
        define('ESTRELAS', array(array("UF" => 'PA', "G" => 1, "X" =>  2.97, "Y" => -3.03),
                                 array("UF" => 'AM', "G" => 1, "X" => -8.15, "Y" => -1.80),
                                 array("UF" => 'MS', "G" => 2, "X" => -3.70, "Y" =>  0.30),
                                 array("UF" => 'AC', "G" => 3, "X" =>  2.62, "Y" => -0.56),
                                 array("UF" => 'MT', "G" => 1, "X" => -7.34, "Y" =>  2.40),
                                 array("UF" => 'AP', "G" => 2, "X" => -8.46, "Y" =>  3.27),
                                 array("UF" => 'RO', "G" => 4, "X" => -6.37, "Y" =>  1.75),
                                 array("UF" => 'RR', "G" => 2, "X" => -5.21, "Y" =>  3.34),
                                 array("UF" => 'TO', "G" => 3, "X" => -5.48, "Y" =>  4.38),
                                 array("UF" => 'GO', "G" => 1, "X" => -4.00, "Y" =>  5.40),
                                 array("UF" => 'BA', "G" => 2, "X" => -0.02, "Y" =>  1.55),
                                 array("UF" => 'MG', "G" => 3, "X" => -0.98, "Y" =>  2.59),
                                 array("UF" => 'ES', "G" => 4, "X" => -0.43, "Y" =>  3.16),
                                 array("UF" => 'SP', "G" => 1, "X" =>  0.00, "Y" =>  4.53),
                                 array("UF" => 'RJ', "G" => 2, "X" =>  1.11, "Y" =>  2.47),
                                 array("UF" => 'PI', "G" => 1, "X" =>  7.00, "Y" =>  3.43),
                                 array("UF" => 'MA', "G" => 3, "X" =>  8.41, "Y" =>  3.51),
                                 array("UF" => 'CE', "G" => 2, "X" =>  7.38, "Y" =>  4.43),
                                 array("UF" => 'RN', "G" => 2, "X" =>  6.79, "Y" =>  5.18),
                                 array("UF" => 'PB', "G" => 3, "X" =>  5.97, "Y" =>  5.67),
                                 array("UF" => 'PE', "G" => 3, "X" =>  5.00, "Y" =>  5.61),
                                 array("UF" => 'AL', "G" => 2, "X" =>  5.00, "Y" =>  6.57),
                                 array("UF" => 'SE', "G" => 3, "X" =>  5.01, "Y" =>  7.49),
                                 array("UF" => 'SC', "G" => 3, "X" =>  3.84, "Y" =>  5.79),
                                 array("UF" => 'RS', "G" => 2, "X" =>  2.97, "Y" =>  6.77),
                                 array("UF" => 'PR', "G" => 3, "X" =>  2.17, "Y" =>  5.55),
                                 array("UF" => 'DF', "G" => 5, "X" =>  0.02, "Y" =>  7.75)));
    }
    
}

