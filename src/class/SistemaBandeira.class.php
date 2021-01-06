<?php

/**
 * Esta classe monta e exibe a bandeira nacional.
 */
class SistemaBandeira
{
    private $svg;
    private $comprimento;
    private $largura;
    private $dist_losango;
    private $raio_circulo;
    private $centro_arco_faixa;
    private $raio_arco_inf;
    private $raio_arco_sup;
    private $largura_faixa;
    private $altura_letra;
    private $tamanho_fonte_letra;
    private $tamanho_fonte_conjuncao;
    private $espaco_letra;
    private $espaco_palavra;
    private $grandezas_estrelas = array();
    
    function __construct($comprimento = '')
    {
        $this->svg = new GraficoVetorialEscalavel;
        $modulo = $this->ajustarModulo($comprimento);
        $this->gerarEscala($modulo);
    }
    
    /**
     * Ajusta o tamanho do módulo de acordo com o comprimento da bandeira.
     * 
     * @param int $comprimento
     * @return int $modulo
     */
    private function ajustarModulo($comprimento)
    {
        if (!empty($comprimento) and is_numeric($comprimento)) {
            $modulo = $comprimento / COMPRIMENTO_BANDEIRA;
        } else {
            $modulo = MODULO;
        }
        return $modulo;
    }
    
    /**
     * Converte as dimensões de acordo com o tamanho do módulo.
     * 
     * @param float $modulo
     * 
     */
    private function gerarEscala($modulo)
    {
        $this->comprimento = COMPRIMENTO_BANDEIRA * $modulo;
        $this->largura = LARGURA_BANDEIRA * $modulo;
        $this->dist_losango = DISTANCIA_LOSANGO * $modulo;
        $this->raio_circulo = RAIO_CIRCULO * $modulo;
        $this->centro_arco_faixa = CENTRO_ARCO_FAIXA * $modulo;
        $this->raio_arco_inf = RAIO_ARCO_INF * $modulo;
        $this->raio_arco_sup = RAIO_ARCO_SUP * $modulo;
        $this->largura_faixa = LARGURA_FAIXA * $modulo;
        $this->altura_letra = ALTURA_LETRA * $modulo;
        $this->altura_conjuncao = ALTURA_CONJUNCAO_E * $modulo;
        $this->tamanho_fonte_letra = $this->gerarTamanhoFonte(ALTURA_LETRA, $modulo, TAMANHO_FONTE_LETRA);
        $this->tamanho_fonte_conjuncao = $this->gerarTamanhoFonte(ALTURA_CONJUNCAO_E, $modulo, TAMANHO_FONTE_CONJUNCAO);
        $this->espaco_letra = $this->gerarEspacoFonte($this->tamanho_fonte_letra, ESPACO_LETRA, TAMANHO_FONTE_LETRA);
        $this->espaco_palavra = $this->gerarEspacoFonte($this->tamanho_fonte_letra, ESPACO_PALAVRA, TAMANHO_FONTE_LETRA);
        foreach (GRANDEZAS_ESTRELAS as $g => $m) {
            $this->grandezas_estrelas[$g] = $m * $modulo;
        }
    }
    
    /**
     * Calcula o tamanho da fonte da legenda.
     * 
     * @param int $altura
     * @param float $modulo
     * @param int $tamanho
     * @return int $tamanho
     */
    private function gerarTamanhoFonte($altura, $modulo, $tamanho)
    {
        return round(($altura * $modulo) * $tamanho / ($altura * MODULO));
    }
    
    /**
     * Calcula o espaço entre as letras.
     * 
     * @param int $tamanhoc
     * @param int $espaco
     * @param int $tamanho
     * @return int $espaco
     */
    private function gerarEspacoFonte($tamanhoc, $espaco, $tamanho)
    {
        return round($tamanhoc * $espaco / $tamanho);
    }
    
    /**
     * Constrói a bandeira nacional.
     * 
     * @return string SVG
     */
    public function construir()
    {
        $this->svg->iniciar($this->comprimento, $this->largura, true, '1.1', '', true, '', '', '', '', '', 'display: block; margin: auto;');
        $this->svg->titulo(TITULO);
        $this->svg->descricao(DESCRICAO);
        
        $this->svg->retangulo(0, 0, $this->comprimento, $this->largura, '', '', array("fill" => COR_VERDE, "stroke-width" => 0));
        $this->svg->poligono($this->calcularPontosLosango($this->comprimento, $this->largura, $this->dist_losango), array("fill" => COR_AMARELA, "stroke-width" => 0));
        
        $cx = round($this->comprimento / 2);
        $cy = round($this->largura / 2);
        $this->svg->circulo($cx, $cy, $this->raio_circulo, array("fill" => COR_AZUL, "stroke-width" => 0));
        
        $caminho = $this->encontrarCaminhoFaixa();
        $this->svg->caminho($caminho, '', '', array("fill" => COR_BRANCA, "stroke-width" => 0));
        
        $caminho = $this->encontrarLinhaLegenda();
        $this->svg->caminho($caminho, 'faixa', '', '', '', '', '', true);
        $this->svg->definicao();
        
        $legenda = LEGENDA_ORDEM . ' ' . $this->svg->textoAjustado(LEGENDA_CONJUNCAO, '', '', '', '', '', '', '', array("font-size" => $this->tamanho_fonte_conjuncao)) . ' ' . LEGENDA_PROGRESSO;
        $texto = $this->svg->textoCaminho($legenda, '#faixa', '50%');
        $this->svg->texto($texto, '', '', '', '', '', '', '', array("font-family" => 'Verdana', "font-size" => $this->tamanho_fonte_letra, "font-weight" => 600, "word-spacing" => $this->espaco_palavra, "letter-spacing" => $this->espaco_letra, "fill" => COR_VERDE, "text-anchor" => 'middle'));
        
        foreach (ESTRELAS as $estrela) {
            $pontos = $this->calcularPontosEstrela($estrela);
            $this->svg->poligono($pontos, '', '', '', '', '', true);
        }
        $this->svg->grupo('', array("fill" => COR_BRANCA, "fill-rule" => 'nonzero', "stroke" => COR_BRANCA, "stroke-width" => 1));
        
        return $this->svg->obter();
    }
    
    /**
     * Monta o caminho da faixa branca.
     * 
     * @return string "Os dados para o elemento <path>"
     */
    private function encontrarCaminhoFaixa()
    {
        $xa = ($this->comprimento / 2) - $this->centro_arco_faixa;
        $ya = $this->largura;
        $ri = $this->raio_arco_inf;
        $rs = $this->raio_arco_sup;
        $xc = round($this->comprimento / 2);
        $yc = round($this->largura / 2);
        $rc = $this->raio_circulo;
        
        $pontosinf = $this->calcularPontosInterseccao($xa, $ya, $ri, $xc, $yc, $rc);
        $pontossup = $this->calcularPontosInterseccao($xa, $ya, $rs, $xc, $yc, $rc);
        
        $cax = round($pontosinf['P2']['x'], 5);
        $cay = round($pontosinf['P2']['y'], 5);
        $cbx = round($pontossup['P2']['x'], 5);
        $cby = round($pontossup['P2']['y'], 5);
        $ccx = round($pontossup['P1']['x'], 5);
        $ccy = round($pontossup['P1']['y'], 5);
        $cdx = round($pontosinf['P1']['x'], 5);
        $cdy = round($pontosinf['P1']['y'], 5);
        
        $caminho = (string) 'M ' . $cax . ' ' . $cay .
                            ' A ' . $rc . ' ' . $rc . ' 0 0 1 ' . $cbx . ' ' . $cby .
                            ' A ' . $rs . ' ' . $rs . ' 0 0 1 ' . $ccx . ' ' . $ccy .
                            ' A ' . $rc . ' ' . $rc . ' 0 0 1 ' . $cdx . ' ' . $cdy .
                            ' A ' . $ri . ' ' . $ri . ' 0 0 0 ' . $cax . ' ' . $cay . ' Z';
        
        return $caminho;
    }
    
    /**
     * Monta o caminho para as letras da legenda.
     * 
     * @return string "Os dados para o elemento <path>"
     */
    private function encontrarLinhaLegenda()
    {
        $xa = ($this->comprimento / 2) - $this->centro_arco_faixa;
        $ya = $this->largura;
        $ra = $this->raio_arco_inf + (($this->largura_faixa - $this->altura_letra) / 2);
        $xc = round($this->comprimento / 2);
        $yc = round($this->largura / 2);
        $rc = $this->raio_circulo;
        
        $pontos = $this->calcularPontosInterseccao($xa, $ya, $ra, $xc, $yc, $rc);
        
        $cax = round($pontos['P2']['x'], 5);
        $cay = round($pontos['P2']['y'], 5);
        $cbx = round($pontos['P1']['x'], 5);
        $cby = round($pontos['P1']['y'], 5);
        
        $caminho = (string) 'M ' . $cax . ' ' . $cay .
                            ' A ' . $ra . ' ' . $ra . ' 0 0 1 ' . $cbx . ' ' . $cby;
        
        return $caminho;
    }
    
    /**
     * Calcula as coordenadas dos pontos de intersecção entre duas circunferências.
     * 
     * @param int $xa
     * @param int $ya
     * @param int $ra
     * @param int $xc
     * @param int $yc
     * @param int $rc
     * @return array ['P1' => array ['x' => float, 'y' => float], 'P2' => array ['x' => float, 'y' => float]]
     */
    private function calcularPontosInterseccao($xa, $ya, $ra, $xc, $yc, $rc)
    {
        $pontos = array();
        $distancia = sqrt(pow($xc - $xa, 2) + pow($yc - $ya, 2));
        $area = sqrt(($distancia + $ra + $rc) * ($distancia + $ra - $rc) * ($distancia - $ra + $rc) * (0 - $distancia + $ra + $rc)) / 4;
        
        $xi1 = ($xa + $xc) / 2 + (($xc - $xa) * (pow($ra, 2) - pow($rc, 2)) / (2 * pow($distancia, 2))) + (2 * (($ya - $yc) / pow($distancia, 2)) * $area);
        $yi1 = ($ya + $yc) / 2 + (($yc - $ya) * (pow($ra, 2) - pow($rc, 2)) / (2 * pow($distancia, 2))) - (2 * (($xa - $xc) / pow($distancia, 2)) * $area);
        $xi2 = ($xa + $xc) / 2 + (($xc - $xa) * (pow($ra, 2) - pow($rc, 2)) / (2 * pow($distancia, 2))) - (2 * (($ya - $yc) / pow($distancia, 2)) * $area);
        $yi2 = ($ya + $yc) / 2 + (($yc - $ya) * (pow($ra, 2) - pow($rc, 2)) / (2 * pow($distancia, 2))) + (2 * (($xa - $xc) / pow($distancia, 2)) * $area);
        
        $pontos['P1'] = array('x' => $xi1, 'y' => $yi1);
        $pontos['P2'] = array('x' => $xi2, 'y' => $yi2);
        
        return $pontos;
    }
    
    /**
     * Calcula e monta as coordenadas dos vértices do losango.
     * 
     * @param int $comprimento
     * @param int $largura
     * @param int $distancia
     * @return string "Os pontos para o elemento <polygon>"
     */
    private function calcularPontosLosango($comprimento, $largura, $distancia)
    {
        $xesquerda = $distancia;
        $yesquerda = round($largura / 2);
        $xcima = round($comprimento / 2);
        $ycima = $distancia;
        $xdireita = round($comprimento - $distancia);
        $ydireita = round($largura / 2);
        $xbaixo = round($comprimento / 2);
        $ybaixo = round($largura - $distancia);
        
        return (string) $xesquerda . ',' . $yesquerda . ' ' . $xcima . ',' . $ycima . ' ' .
                        $xdireita . ',' . $ydireita . ' ' . $xbaixo . ',' . $ybaixo;
    }
    
    /**
     * Calcula e monta as coordenadas dos cinco vértices da estrela.
     * 
     * @param array $estrela ['UF' => string, 'G' => int, 'X' => float, 'Y' => float]
     * @return string "Os pontos para o elemento <polygon>"
     */
    private function calcularPontosEstrela($estrela)
    {
        $larguraquadricula = $this->raio_circulo / 10;
        $r = $this->grandezas_estrelas[$estrela['G']] / 2;
        $cx = $estrela['X'] * $larguraquadricula + ($this->comprimento / 2);
        $cy = $estrela['Y'] * $larguraquadricula + ($this->largura / 2);
        
        $xa = round(($r * cos(deg2rad(270)) + $cx), 5);
        $ya = round(($r * sin(deg2rad(270)) + $cy), 5);
        $xb = round(($r * cos(deg2rad(126)) + $cx), 5);
        $yb = round(($r * sin(deg2rad(126)) + $cy), 5);
        $xc = round(($r * cos(deg2rad(342)) + $cx), 5);
        $yc = round(($r * sin(deg2rad(342)) + $cy), 5);
        $xd = round(($r * cos(deg2rad(198)) + $cx), 5);
        $yd = round(($r * sin(deg2rad(198)) + $cy), 5);
        $xe = round(($r * cos(deg2rad( 54)) + $cx), 5);
        $ye = round(($r * sin(deg2rad( 54)) + $cy), 5);
        
        return (string) $xa . ',' . $ya . ' ' .
                        $xb . ',' . $yb . ' ' .
                        $xc . ',' . $yc . ' ' .
                        $xd . ',' . $yd . ' ' .
                        $xe . ',' . $ye;
    }
    
    /**
     * Invoca a construção.
     *
     * @return string SVG
     */
    public function exibeBandeira()
    {
        return $this->construir();
    }
    
}

