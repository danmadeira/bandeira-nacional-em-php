<?php

/**
 * Uma classe para construir os elementos gráficos do SVG versão 1.1, na gramática XML.
 * Cada função retorna um elemento SVG, container ou gráfico, com os respectivos atributos.
 * 
 * @author Daniel Madeira <dmadeira@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GNU General Public License version 3
 * @version v2.1.1
 */
class GraficoVetorialEscalavel
{
    
    private $grafico;
    private $grupo = '';
    private $definicao = '';
    
    public function iniciar($width = 1366, $height = 768, $namespace = true, $version = '1.1', $lang = '', $xlink = false, $viewbox = '', $preserveaspectratio = '', $presentation = '', $id = '', $class = '', $style = '')
    {
        $this->grafico = $this->svg11($width, $height, $namespace, $version, $lang, $xlink, $viewbox, $preserveaspectratio, $presentation, $id, $class, $style);
    }
    
    // doctype = "false | true | S | H"
    // xml = "false | true"
    // standalone = "no | yes"
    // encoding = "UTF-8 | UTF-16 | ISO-8859-1 | ISO-2022-JP | Shift_JIS | EUC-JP"
    public function obter($doctype = false, $xml = false, $standalone = 'no', $encoding = 'UTF-8')
    {
        if(empty($this->grafico)) {
            $this->iniciar();
        }
        if ($doctype !== false) {
            $d = $this->dtd($doctype);
        } else {
            $d = '';
        }
        if ($xml) {
            $x = $this->xml10($standalone, $encoding);
        } else {
            $x = '';
        }
        
        return $x . $d . $this->grafico . $this->svgFim();
    }
    
    private function obterGrupo()
    {
        $grupo = $this->grupo;
        $this->grupo = '';
        return $grupo;
    }
    
    private function obterDefinicao()
    {
        $definicao = $this->definicao;
        $this->definicao = '';
        return $definicao;
    }
    
    // standalone = "no | yes"
    // encoding = "UTF-8 | UTF-16 | ISO-8859-1 | ISO-2022-JP | Shift_JIS | EUC-JP"
    private function xml10($standalone = 'no', $encoding = 'UTF-8')
    {
        if (!empty($standalone)) {
            $standalone = ' standalone="' . $standalone . '"';
        }
        if (!empty($encoding)) {
            $encoding = ' encoding="' . $encoding . '"';
        }
        
        return '<?xml version="1.0"' . $encoding . $standalone . '?>' . PHP_EOL;
    }
    
    private function dtd($doctype)
    {
        if ($doctype === 'S' or $doctype === true) {
            $dtd = '<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">';
        } elseif ($doctype === 'H') {
            $dtd = '<!DOCTYPE html>';
        } else {
            $dtd = '';
        }
        return $dtd . PHP_EOL;
    }
    
    // x = "<coordinate>"
    // y = "<coordinate>"
    // width = "<length>"
    // height = "<length>"
    // viewBox = "<min-x> <min-y> <width> <height>"
    // preserveAspectRatio="none | xMinYMin | xMidYMin | xMaxYMin
    //                           | xMinYMid | xMidYMid | xMaxYMid
    //                           | xMinYMax | xMidYMax | xMaxYMax
    //                      meet | slice"
    // version = "<number>"
    // baseProfile = profile-name
    // contentScriptType = "content-type"
    // contentStyleType = "content-type" 
    // zoomAndPan = "disable | magnify"
    private function svg11($width = 1366, $height = 768, $namespace = true, $version = '1.1', $lang = '', $xlink = false, $viewbox = '', $preserveaspectratio = '', $presentation = '', $id = '', $class = '', $style = '')
    {
        if ($namespace) {
            $ns = ' xmlns="http://www.w3.org/2000/svg"';
        } else {
            $ns = '';
        }
        if (!empty($version)) {
            $ver = ' version="' . $version . '"';
        } else {
            $ver = '';
        }
        if (!empty($lang)) {
            $lang = ' xml:lang="' . $lang . '"';
        } else {
            $lang = '';
        }
        if ($xlink) {
            $link = ' xmlns:xlink="http://www.w3.org/1999/xlink"';
        } else {
            $link = '';
        }
        if (!empty($viewbox)) {
            $viewbox = ' viewBox="' . $viewbox . '"';
        }
        if (!empty($preserveaspectratio)) {
            $preserveaspectratio = ' preserveAspectRatio="' . $preserveaspectratio . '"';
        }
        if (!empty($id)) {
            $id = ' id="' . $id . '"';
        }
        if (!empty($class)) {
            $class = ' class="' . $class . '"';
        }
        if (!empty($style)) {
            $style = ' style="' . $style . '"';
        }
        $attributes = $this->obterAtributosApresentacao($presentation);
        
        return '<svg' . $ns . $ver . $lang . $link . $id . $attributes . $class . $style . ' width="' . $width . '" height="' . $height . '"' . $viewbox . $preserveaspectratio . '>' . PHP_EOL;
    }
    
    private function svgFim()
    {
        return '</svg>';
    }
    
    public function titulo($content)
    {
        $this->grafico .= '<title>' . $content . '</title>' . PHP_EOL;
    }
    
    public function descricao($content)
    {
        $this->grafico .= '<desc>' . $content . '</desc>' . PHP_EOL;
    }
    
    public function definicao($presentation = '', $class = '', $style = '', $transform = '')
    {
        if (!empty($class)) {
            $class = ' class="' . $class . '"';
        }
        if (!empty($style)) {
            $style = ' style="' . $style . '"';
        }
        if (!empty($transform)) {
            $transform = ' transform="' . $transform . '"';
        }
        $attributes = $this->obterAtributosApresentacao($presentation);
        
        $this->grafico .= '<defs' . $attributes . $class . $style . $transform . '>' . PHP_EOL . $this->obterDefinicao() . '</defs>' . PHP_EOL;
    }
    
    public function ligacao($namespace = true, $href = '', $rel = '', $media = '', $type = '')
    {
        if ($namespace) {
            $ns = ' xmlns="http://www.w3.org/1999/xhtml"';
        } else {
            $ns = '';
        }
        if (!empty($href)) {
            $href = ' href="' . $href . '"';
        }
        if (!empty($rel)) {
            $rel = ' rel="' . $rel . '"';
        }
        if (!empty($media)) {
            $media = ' media="' . $media . '"';
        }
        if (!empty($type)) {
            $type = ' type="' . $type . '"';
        }
        $this->grafico .= '<link' . $ns . $href . $rel . $media . $type . ' />' . PHP_EOL;
    }
    
    public function script($href = '', $content = '')
    {
        if (!empty($href)) {
            $href = ' xlink:href="' . $href . '" />';
            $content = '';
        } elseif (!empty ($content)) {
            $href = '>';
            $content = '<![CDATA[' . PHP_EOL . $content . PHP_EOL . ']]></script>';
        }
        $this->grafico .= '<script' . $href . $content . PHP_EOL;
    }
    
    public function grupo($id = '', $presentation = '', $class = '', $style = '', $transform = '')
    {
        if (!empty($id)) {
            $id = ' id="' . $id . '"';
        }
        if (!empty($class)) {
            $class = ' class="' . $class . '"';
        }
        if (!empty($style)) {
            $style = ' style="' . $style . '"';
        }
        if (!empty($transform)) {
            $transform = ' transform="' . $transform . '"';
        }
        $attributes = $this->obterAtributosApresentacao($presentation);
        
        $this->grafico .= '<g' . $id . $attributes . $class . $style . $transform . '>' . PHP_EOL . $this->obterGrupo() . '</g>' . PHP_EOL;
    }
    
    // viewBox = "<min-x> <min-y> <width> <height>"
    // preserveAspectRatio="none | xMinYMin | xMidYMin | xMaxYMin
    //                           | xMinYMid | xMidYMid | xMaxYMid
    //                           | xMinYMax | xMidYMax | xMaxYMax
    //                      meet | slice"
    public function simbolo($content, $id = '', $presentation = '', $class = '', $style = '', $preserveaspectratio = '', $viewbox = '')
    {
        if (!empty($id)) {
            $id = ' id="' . $id . '"';
        }
        if (!empty($class)) {
            $class = ' class="' . $class . '"';
        }
        if (!empty($style)) {
            $style = ' style="' . $style . '"';
        }
        if (!empty($preserveaspectratio)) {
            $preserveaspectratio = ' preserveAspectRatio="' . $preserveaspectratio . '"';
        }
        if (!empty($viewbox)) {
            $viewbox = ' viewBox="' . $viewbox . '"';
        }
        $attributes = $this->obterAtributosApresentacao($presentation);
        
        $this->grafico .= '<symbol' . $id . $attributes . $class . $style . $preserveaspectratio . $viewbox . '>' . PHP_EOL . $content . PHP_EOL . '</symbol>' . PHP_EOL;
    }
    
    // x = "<coordinate>"
    // y = "<coordinate>"
    // width = "<length>"
    // height = "<length>"
    // xlink:href = "<iri>"
    public function uso($xlinkhref, $x = '', $y = '', $width = '', $height = '', $presentation = '', $class = '', $style = '', $transform = '')
    {
        if (!empty($x) or is_numeric($x)) {
            $x = ' x="' . $x . '"';
        }
        if (!empty($y) or is_numeric($y)) {
            $y = ' y="' . $y . '"';
        }
        if (!empty($width)) {
            $width = ' width="' . $width . '"';
        }
        if (!empty($height)) {
            $height = ' height="' . $height . '"';
        }
        if (!empty($class)) {
            $class = ' class="' . $class . '"';
        }
        if (!empty($style)) {
            $style = ' style="' . $style . '"';
        }
        if (!empty($transform)) {
            $transform = ' transform="' . $transform . '"';
        }
        $attributes = $this->obterAtributosApresentacao($presentation);
        
        $this->grafico .= '<use xlink:href="' . $xlinkhref . '"' . $x . $y . $width . $height . $attributes . $class . $style . $transform . ' />' . PHP_EOL;
    }
    
    // d = "path data"
    // pathLength = "<number>"
    public function caminho($d, $id = '', $pathlength = '', $presentation = '', $class = '', $style = '', $transform = '', $defs = false)
    {
        if (!empty($id)) {
            $id = ' id="' . $id . '"';
        }
        if (!empty($pathlength)) {
            $pathlength = ' pathLength="' . $pathlength . '"';
        }
        if (!empty($class)) {
            $class = ' class="' . $class . '"';
        }
        if (!empty($style)) {
            $style = ' style="' . $style . '"';
        }
        if (!empty($transform)) {
            $transform = ' transform="' . $transform . '"';
        }
        $attributes = $this->obterAtributosApresentacao($presentation);
        
        $caminho = '<path' . $id . ' d="' . $d . '"' . $pathlength . $attributes . $class . $style . $transform . ' />' . PHP_EOL;
        
        if ($defs) {
            $this->definicao .= $caminho;
        } else {
            $this->grafico .= $caminho;
        }
    }
    
    // <color> = white = rgb(255,255,255) = rgb(100%,100%,100%) = #fff = #ffffff
    // <color> = black blue brown coral cyan gold grey green indigo lavender lime
    //           magenta maroon navy olive orange orchid tomato pink purple red
    //           salmon silver violet white yellow
    // text-anchor = "start | middle | end | inherit"
    // fill = "<paint>"
    // fill-rule = "nonzero | evenodd | inherit"
    // fill-opacity = "<opacity-value> | inherit"
    // stroke = "<paint>"
    // stroke-width = "<percentage> | <length> | inherit"
    // stroke-linecap = "butt | round | square | inherit"
    // stroke-linejoin = "miter | round | bevel | inherit"
    // stroke-miterlimit = "<miterlimit> | inherit"
    // stroke-dasharray = "none | <dasharray> | inherit"
    // stroke-dashoffset = "<percentage> | <length> | inherit"
    // stroke-opacity = "<opacity-value> | inherit"
    // stop-opacity = "<opacity-value> | inherit"
    // opacity = "<opacity-value> | inherit>
    // color = "<color> | inherit"
    // stop-color = "currentColor | <color> <icccolor> | inherit"
    // font-family = "<family-name>"
    // font-style = "normal | italic | oblique | inherit"
    // font-variant = "normal | small-caps | inherit"
    // font-weight = "normal | bold | bolder | lighter | 100 | 200 | 300 | 400 | 500 | 600 | 700 | 800 | 900 | inherit"
    // font-stretch = "normal | wider | narrower | ultra-condensed | extra-condensed | condensed | semi-condensed | semi-expanded | expanded | extra-expanded | ultra-expanded | inherit"
    // font-size = "<absolute-size> | <relative-size> | <length> | <percentage> | inherit"
    // font-size-adjust = "<number> | none | inherit"
    // font = "[ [ <'font-style'> || <'font-variant'> || <'font-weight'> ]? <'font-size'> [ / <'line-height'> ]? <'font-family'> ] | caption | icon | menu | message-box | small-caption | status-bar | inherit"
    // kerning = "auto | <length> | inherit"
    // letter-spacing = "normal | <length> | inherit"
    // word-spacing = "normal | <length> | inherit"
    // text-decoration = "none | [ underline || overline || line-through || blink ] | inherit"
    private function obterAtributosApresentacao($presentation)
    {
        $attributes = '';
        if (!empty($presentation) and is_array($presentation)) {
            if (array_key_exists("text-anchor", $presentation)) {
                $attributes .= ' text-anchor="' . $presentation["text-anchor"] . '"';
            }
            if (array_key_exists("fill", $presentation)) {
                $attributes .= ' fill="' . $presentation["fill"] . '"';
            }
            if (array_key_exists("fill-rule", $presentation)) {
                $attributes .= ' fill-rule="' . $presentation["fill-rule"] . '"';
            }
            if (array_key_exists("fill-opacity", $presentation)) {
                $attributes .= ' fill-opacity="' . $presentation["fill-opacity"] . '"';
            }
            if (array_key_exists("stroke", $presentation)) {
                $attributes .= ' stroke="' . $presentation["stroke"] . '"';
            }
            if (array_key_exists("stroke-width", $presentation)) {
                $attributes .= ' stroke-width="' . $presentation["stroke-width"] . '"';
            }
            if (array_key_exists("stroke-linecap", $presentation)) {
                $attributes .= ' stroke-linecap="' . $presentation["stroke-linecap"] . '"';
            }
            if (array_key_exists("stroke-linejoin", $presentation)) {
                $attributes .= ' stroke-linejoin="' . $presentation["stroke-linejoin"] . '"';
            }
            if (array_key_exists("stroke-miterlimit", $presentation)) {
                $attributes .= ' stroke-miterlimit="' . $presentation["stroke-miterlimit"] . '"';
            }
            if (array_key_exists("stroke-dasharray", $presentation)) {
                $attributes .= ' stroke-dasharray="' . $presentation["stroke-dasharray"] . '"';
            }
            if (array_key_exists("stroke-dashoffset", $presentation)) {
                $attributes .= ' stroke-dashoffset="' . $presentation["stroke-dashoffset"] . '"';
            }
            if (array_key_exists("stroke-opacity", $presentation)) {
                $attributes .= ' stroke-opacity="' . $presentation["stroke-opacity"] . '"';
            }
            if (array_key_exists("stop-opacity", $presentation)) {
                $attributes .= ' stop-opacity="' . $presentation["stop-opacity"] . '"';
            }
            if (array_key_exists("opacity", $presentation)) {
                $attributes .= ' opacity="' . $presentation["opacity"] . '"';
            }
            if (array_key_exists("stop-color", $presentation)) {
                $attributes .= ' stop-color="' . $presentation["stop-color"] . '"';
            }
            if (array_key_exists("color", $presentation)) {
                $attributes .= ' color="' . $presentation["color"] . '"';
            }
            if (array_key_exists("font-family", $presentation)) {
                $attributes .= ' font-family="' . $presentation["font-family"] . '"';
            }
            if (array_key_exists("font-style", $presentation)) {
                $attributes .= ' font-style="' . $presentation["font-style"] . '"';
            }
            if (array_key_exists("font-variant", $presentation)) {
                $attributes .= ' font-variant="' . $presentation["font-variant"] . '"';
            }
            if (array_key_exists("font-weight", $presentation)) {
                $attributes .= ' font-weight="' . $presentation["font-weight"] . '"';
            }
            if (array_key_exists("font-stretch", $presentation)) {
                $attributes .= ' font-stretch="' . $presentation["font-stretch"] . '"';
            }
            if (array_key_exists("font-size", $presentation)) {
                $attributes .= ' font-size="' . $presentation["font-size"] . '"';
            }
            if (array_key_exists("font-size-adjust", $presentation)) {
                $attributes .= ' font-size-adjust="' . $presentation["font-size-adjust"] . '"';
            }
            if (array_key_exists("font", $presentation)) {
                $attributes .= ' font="' . $presentation["font"] . '"';
            }
            if (array_key_exists("kerning", $presentation)) {
                $attributes .= ' kerning="' . $presentation["kerning"] . '"';
            }
            if (array_key_exists("letter-spacing", $presentation)) {
                $attributes .= ' letter-spacing="' . $presentation["letter-spacing"] . '"';
            }
            if (array_key_exists("word-spacing", $presentation)) {
                $attributes .= ' word-spacing="' . $presentation["word-spacing"] . '"';
            }
            if (array_key_exists("text-decoration", $presentation)) {
                $attributes .= ' text-decoration="' . $presentation["text-decoration"] . '"';
            }
        }
        
        return $attributes;
    }
    
    // x = "<list-of-coordinates>"
    // y = "<list-of-coordinates>"
    // dx = "<list-of-lengths>"
    // dy = "<list-of-lengths>"
    // rotate = "<list-of-numbers>"
    // textLength = "<length>"
    // lengthAdjust = "spacing | spacingAndGlyphs"
    public function texto($content, $x = '', $y = '', $dx = '', $dy = '', $rotate = '', $textlength = '', $lengthadjust = '', $presentation = '', $id = '', $class = '', $style = '', $transform = '')
    {
        if (!empty($x) or is_numeric($x)) {
            $x = ' x="' . $x . '"';
        }
        if (!empty($y) or is_numeric($y)) {
            $y = ' y="' . $y . '"';
        }
        if (!empty($dx) or is_numeric($dx)) {
            $dx = ' dx="' . $dx . '"';
        }
        if (!empty($dy) or is_numeric($dy)) {
            $dy = ' dy="' . $dy . '"';
        }
        if (!empty($rotate)) {
            $rotate = ' rotate="' . $rotate . '"';
        }
        if (!empty($textlength)) {
            $textlength = ' textLength="' . $textlength . '"';
        }
        if (!empty($lengthadjust)) {
            $lengthadjust = ' lengthAdjust="' . $lengthadjust . '"';
        }
        if (!empty($id)) {
            $id = ' id="' . $id . '"';
        }
        if (!empty($class)) {
            $class = ' class="' . $class . '"';
        }
        if (!empty($style)) {
            $style = ' style="' . $style . '"';
        }
        if (!empty($transform)) {
            $transform = ' transform="' . $transform . '"';
        }
        $attributes = $this->obterAtributosApresentacao($presentation);
        
        $this->grafico .= '<text' . $x . $y . $dx . $dy . $rotate . $textlength . $lengthadjust . $attributes . $id . $class . $style . $transform . '>' . PHP_EOL . $content . PHP_EOL . '</text>' . PHP_EOL;
    }
    
    // x = "<list-of-coordinates>"
    // y = "<list-of-coordinates>"
    // dx = "<list-of-lengths>"
    // dy = "<list-of-lengths>"
    // rotate = "<list-of-numbers>"
    // textLength = "<length>"
    // lengthAdjust = "spacing|spacingAndGlyphs"
    public function textoAjustado($content, $x = '', $y = '', $dx = '', $dy = '', $rotate = '', $textlength = '', $lengthadjust = '', $presentation = '', $id = '', $class = '', $style = '')
    {
        if (!empty($x) or is_numeric($x)) {
            $x = ' x="' . $x . '"';
        }
        if (!empty($y) or is_numeric($y)) {
            $y = ' y="' . $y . '"';
        }
        if (!empty($dx) or is_numeric($dx)) {
            $dx = ' dx="' . $dx . '"';
        }
        if (!empty($dy) or is_numeric($dy)) {
            $dy = ' dy="' . $dy . '"';
        }
        if (!empty($rotate)) {
            $rotate = ' rotate="' . $rotate . '"';
        }
        if (!empty($textlength)) {
            $textlength = ' textLength="' . $textlength . '"';
        }
        if (!empty($lengthadjust)) {
            $lengthadjust = ' lengthAdjust="' . $lengthadjust . '"';
        }
        if (!empty($id)) {
            $id = ' id="' . $id . '"';
        }
        if (!empty($class)) {
            $class = ' class="' . $class . '"';
        }
        if (!empty($style)) {
            $style = ' style="' . $style . '"';
        }
        $attributes = $this->obterAtributosApresentacao($presentation);
        
        return '<tspan' . $x . $y . $dx . $dy . $rotate . $textlength . $lengthadjust . $attributes . $id . $class . $style . '>' . $content . '</tspan>';
    }
    
    // xlink:href = "<iri>"
    public function textoReferencia($xlinkhref = '', $presentation = '', $id = '', $class = '', $style = '')
    {
        if (!empty($xlinkhref)) {
            $xlinkhref = ' xlink:href="' . $xlinkhref . '"';
        }
        if (!empty($id)) {
            $id = ' id="' . $id . '"';
        }
        if (!empty($class)) {
            $class = ' class="' . $class . '"';
        }
        if (!empty($style)) {
            $style = ' style="' . $style . '"';
        }
        $attributes = $this->obterAtributosApresentacao($presentation);
        
        return '<tref' . $xlinkhref . $attributes . $id . $class . $style . ' />' . PHP_EOL;
    }
    
    // xlink:href = "<iri>"
    // startOffset = "<length>"
    // method = "align | stretch"
    // spacing = "auto | exact"
    public function textoCaminho($content, $xlinkhref = '', $startoffset = '', $method = '', $spacing = '', $presentation = '', $id = '', $class = '', $style = '')
    {
        if (!empty($xlinkhref)) {
            $xlinkhref = ' xlink:href="' . $xlinkhref . '"';
        }
        if (!empty($startoffset)) {
            $startoffset = ' startOffset="' . $startoffset . '"';
        }
        if (!empty($method)) {
            $method = ' method="' . $method . '"';
        }
        if (!empty($spacing)) {
            $spacing = ' spacing="' . $spacing . '"';
        }
        if (!empty($id)) {
            $id = ' id="' . $id . '"';
        }
        if (!empty($class)) {
            $class = ' class="' . $class . '"';
        }
        if (!empty($style)) {
            $style = ' style="' . $style . '"';
        }
        $attributes = $this->obterAtributosApresentacao($presentation);
        
        return '<textPath' . $xlinkhref . $startoffset . $method . $spacing . $attributes . $id . $class . $style . '>' . $content . '</textPath>';
    }
    
    // horiz-origin-x = "<number>"
    // horiz-origin-y = "<number>"
    // horiz-adv-x = "<number>"
    // vert-origin-x = "<number>"
    // vert-origin-y = "<number>"
    // vert-adv-y = "<number>"
    public function fonte($content, $id = '', $horizoriginx = '', $horizoriginy = '', $horizadvx = '', $vertoriginx = '', $vertoriginy = '', $vertadvy = '', $presentation = '', $class = '', $style = '')
    {
        if (!empty($id)) {
            $id = ' id="' . $id . '"';
        }
        if (!empty($horizoriginx)) {
            $horizoriginx = ' horiz-origin-x="' . $horizoriginx . '"';
        }
        if (!empty($horizoriginy)) {
            $horizoriginy = ' horiz-origin-y="' . $horizoriginy . '"';
        }
        if (!empty($horizadvx)) {
            $horizadvx = ' horiz-adv-x="' . $horizadvx . '"';
        }
        if (!empty($vertoriginx)) {
            $vertoriginx = ' vert-origin-x="' . $vertoriginx . '"';
        }
        if (!empty($vertoriginy)) {
            $vertoriginy = ' vert-origin-y="' . $vertoriginy . '"';
        }
        if (!empty($vertadvy)) {
            $vertadvy = ' vert-adv-y="' . $vertadvy . '"';
        }
        if (!empty($class)) {
            $class = ' class="' . $class . '"';
        }
        if (!empty($style)) {
            $style = ' style="' . $style . '"';
        }
        $attributes = $this->obterAtributosApresentacao($presentation);
        
        $this->grafico .= '<font' . $id . $horizoriginx . $horizoriginy . $horizadvx . $vertoriginx . $vertoriginy . $vertadvy . $attributes . $class . $style . '>' . PHP_EOL . $content . PHP_EOL . '</font>' . PHP_EOL;
    }
    
    // font-family = "<string>"
    // font-style = "all | [ normal | italic | oblique] [, [normal | italic | oblique]]*"
    // font-variant = "[normal | small-caps] [,[normal | small-caps]]*"
    // font-weight = "all | [normal | bold | 100 | 200 | 300 | 400 | 500 | 600 | 700 | 800 | 900] [, [normal | bold | 100 | 200 | 300 | 400 | 500 | 600 | 700 | 800 | 900]]*"
    // font-stretch = "all | [ normal | ultra-condensed | extra-condensed | condensed | semi-condensed | semi-expanded | expanded | extra-expanded | ultra-expanded] [, [ normal | ultra-condensed | extra-condensed | condensed | semi-condensed | semi-expanded | expanded | extra-expanded | ultra-expanded] ]*"
    // font-size = "<string>"
    // unicode-range = "<urange> [, <urange>]*"
    // units-per-em = "<number>"
    // panose-1 = "[<integer>]{10}"
    // stemv = "<number>"
    // stemh = "<number>"
    // slope = "<number>"
    // cap-height = "<number>"
    // x-height = "<number>"
    // accent-height = "<number>"
    // ascent = "<number>"
    // descent = "<number>"
    // widths = "<string>"
    // bbox = "<string>"
    // ideographic = "<number>"
    // alphabetic = "<number>"
    // mathematical = "<number>"
    // hanging = "<number>"
    // v-ideographic = "<number>"
    // v-alphabetic = "<number>"
    // v-mathematical = "<number>"
    // v-hanging = "<number>"
    // underline-position = "<number>"
    // underline-thickness = "<number>"
    // strikethrough-position = "<number>"
    // strikethrough-thickness = "<number>"
    // overline-position = "<number>"
    // overline-thickness = "<number>"
    private function obterAtributosFonteFace($a)
    {
        $attributes = '';
        if (!empty($a) and is_array($a)) {
            if (array_key_exists("font-family", $a)) {
                $attributes .= ' font-family="' . $a["font-family"] . '"';
            }
            if (array_key_exists("font-style", $a)) {
                $attributes .= ' font-style="' . $a["font-style"] . '"';
            }
            if (array_key_exists("font-variant", $a)) {
                $attributes .= ' font-variant="' . $a["font-variant"] . '"';
            }
            if (array_key_exists("font-weight", $a)) {
                $attributes .= ' font-weight="' . $a["font-weight"] . '"';
            }
            if (array_key_exists("font-stretch", $a)) {
                $attributes .= ' font-stretch="' . $a["font-stretch"] . '"';
            }
            if (array_key_exists("font-size", $a)) {
                $attributes .= ' font-size="' . $a["font-size"] . '"';
            }
            if (array_key_exists("unicode-range", $a)) {
                $attributes .= ' unicode-range="' . $a["unicode-range"] . '"';
            }
            if (array_key_exists("units-per-em", $a)) {
                $attributes .= ' units-per-em="' . $a["units-per-em"] . '"';
            }
            if (array_key_exists("panose-1", $a)) {
                $attributes .= ' panose-1="' . $a["panose-1"] . '"';
            }
            if (array_key_exists("stemv", $a)) {
                $attributes .= ' stemv="' . $a["stemv"] . '"';
            }
            if (array_key_exists("stemh", $a)) {
                $attributes .= ' stemh="' . $a["stemh"] . '"';
            }
            if (array_key_exists("slope", $a)) {
                $attributes .= ' slope="' . $a["slope"] . '"';
            }
            if (array_key_exists("cap-height", $a)) {
                $attributes .= ' cap-height="' . $a["cap-height"] . '"';
            }
            if (array_key_exists("x-height", $a)) {
                $attributes .= ' x-height="' . $a["x-height"] . '"';
            }
            if (array_key_exists("accent-height", $a)) {
                $attributes .= ' accent-height="' . $a["accent-height"] . '"';
            }
            if (array_key_exists("ascent", $a)) {
                $attributes .= ' ascent="' . $a["ascent"] . '"';
            }
            if (array_key_exists("descent", $a)) {
                $attributes .= ' descent="' . $a["descent"] . '"';
            }
            if (array_key_exists("widths", $a)) {
                $attributes .= ' widths="' . $a["widths"] . '"';
            }
            if (array_key_exists("bbox", $a)) {
                $attributes .= ' bbox="' . $a["bbox"] . '"';
            }
            if (array_key_exists("ideographic", $a)) {
                $attributes .= ' ideographic="' . $a["ideographic"] . '"';
            }
            if (array_key_exists("alphabetic", $a)) {
                $attributes .= ' alphabetic="' . $a["alphabetic"] . '"';
            }
            if (array_key_exists("mathematical", $a)) {
                $attributes .= ' mathematical="' . $a["mathematical"] . '"';
            }
            if (array_key_exists("hanging", $a)) {
                $attributes .= ' hanging="' . $a["hanging"] . '"';
            }
            if (array_key_exists("v-ideographic", $a)) {
                $attributes .= ' v-ideographic="' . $a["v-ideographic"] . '"';
            }
            if (array_key_exists("v-alphabetic", $a)) {
                $attributes .= ' v-alphabetic="' . $a["v-alphabetic"] . '"';
            }
            if (array_key_exists("v-mathematical", $a)) {
                $attributes .= ' v-mathematical="' . $a["v-mathematical"] . '"';
            }
            if (array_key_exists("v-hanging", $a)) {
                $attributes .= ' v-hanging="' . $a["v-hanging"] . '"';
            }
            if (array_key_exists("underline-position", $a)) {
                $attributes .= ' underline-position="' . $a["underline-position"] . '"';
            }
            if (array_key_exists("underline-thickness", $a)) {
                $attributes .= ' underline-thickness="' . $a["underline-thickness"] . '"';
            }
            if (array_key_exists("strikethrough-position", $a)) {
                $attributes .= ' strikethrough-position="' . $a["strikethrough-position"] . '"';
            }
            if (array_key_exists("strikethrough-thickness", $a)) {
                $attributes .= ' strikethrough-thickness="' . $a["strikethrough-thickness"] . '"';
            }
            if (array_key_exists("overline-position", $a)) {
                $attributes .= ' overline-position="' . $a["overline-position"] . '"';
            }
            if (array_key_exists("overline-thickness", $a)) {
                $attributes .= ' overline-thickness="' . $a["overline-thickness"] . '"';
            }
        }
        
        return $attributes;
    }
    
    public function fonteface($sources, $id = '', $a = '')
    {
        if (!empty($id)) {
            $id = ' id="' . $id . '"';
        }
        $attributes = $this->obterAtributosFonteFace($a);
        
        $src = '';
        foreach ($sources as $source) {
            $element = '';
            if (array_key_exists("xlink:href", $source)) {
                $element .= '<font-face-uri xlink:href="' . $source["xlink:href"] . '" />';
            }
            if (array_key_exists("name", $source)) {
                $element .= '<font-face-name name="' . $source["name"] . '" />';
            }
            $src .= '<font-face-src id="' . $source["id"] . '">' . $element . '</font-face-src>' . PHP_EOL;
        }
        
        $this->grafico .= '<font-face' . $id . $attributes . '>' . PHP_EOL . $src . '</font-face>' . PHP_EOL;
    }
    
    // unicode = "<string>"
    // glyph-name = "<name> [, <name> ]* "
    // d = "path data"
    // orientation = "h | v"
    // arabic-form = "initial | medial | terminal | isolated"
    // lang = "%LanguageCodes;"
    // horiz-adv-x = "<number>"
    // vert-origin-x = "<number>"
    // vert-origin-y = "<number>"
    // vert-adv-y = "<number>"
    public function glifo($content, $id = '', $unicode = '', $glyphname = '', $d = '', $orientation = '', $arabicform = '', $lang = '', $horizadvx = '', $vertoriginx = '', $vertoriginy = '', $vertadvy = '', $presentation = '', $class = '', $style = '')
    {
        if (!empty($id)) {
            $id = ' id="' . $id . '"';
        }
        if (!empty($unicode)) {
            $unicode = ' unicode="' . $unicode . '"';
        }
        if (!empty($glyphname)) {
            $glyphname = ' glyph-name="' . $glyphname . '"';
        }
        if (!empty($d)) {
            $d = ' d="' . $d . '"';
        }
        if (!empty($orientation)) {
            $orientation = ' orientation="' . $orientation . '"';
        }
        if (!empty($arabicform)) {
            $arabicform = ' arabic-form="' . $arabicform . '"';
        }
        if (!empty($lang)) {
            $lang = ' lang="' . $lang . '"';
        }
        if (!empty($horizadvx)) {
            $horizadvx = ' horiz-adv-x="' . $horizadvx . '"';
        }
        if (!empty($vertoriginx)) {
            $vertoriginx = ' vert-origin-x="' . $vertoriginx . '"';
        }
        if (!empty($vertoriginy)) {
            $vertoriginy = ' vert-origin-y="' . $vertoriginy . '"';
        }
        if (!empty($vertadvy)) {
            $vertadvy = ' vert-adv-y="' . $vertadvy . '"';
        }
        if (!empty($class)) {
            $class = ' class="' . $class . '"';
        }
        if (!empty($style)) {
            $style = ' style="' . $style . '"';
        }
        $attributes = $this->obterAtributosApresentacao($presentation);
        
        $this->grafico .= '<glyph' . $id . $unicode . $glyphname . $d . $orientation . $arabicform . $lang . $horizadvx . $vertoriginx . $vertoriginy . $vertadvy . $attributes . $class . $style . '>' . PHP_EOL . $content . PHP_EOL . '</glyph>' . PHP_EOL;
    }
    
    // x = "<coordinate>"
    // y = "<coordinate>"
    // width = "<length>"
    // height = "<length>"
    // rx = "<length>"
    // ry = "<length>"
    public function retangulo($x = '', $y = '', $width = '', $height = '', $rx = '', $ry = '', $presentation = '', $id = '', $class = '', $style = '', $transform = '')
    {
        if (!empty($x) or is_numeric($x)) {
            $x = ' x="' . $x . '"';
        }
        if (!empty($y) or is_numeric($y)) {
            $y = ' y="' . $y . '"';
        }
        if (!empty($width)) {
            $width = ' width="' . $width . '"';
        }
        if (!empty($height)) {
            $height = ' height="' . $height . '"';
        }
        if (!empty($rx) or is_numeric($rx)) {
            $rx = ' rx="' . $rx . '"';
        }
        if (!empty($ry) or is_numeric($ry)) {
            $ry = ' ry="' . $ry . '"';
        }
        if (!empty($id)) {
            $id = ' id="' . $id . '"';
        }
        if (!empty($class)) {
            $class = ' class="' . $class . '"';
        }
        if (!empty($style)) {
            $style = ' style="' . $style . '"';
        }
        if (!empty($transform)) {
            $transform = ' transform="' . $transform . '"';
        }
        $attributes = $this->obterAtributosApresentacao($presentation);
        
        $this->grafico .= '<rect' . $x . $y . $width . $height . $rx . $ry . $attributes . $id . $class . $style . $transform . ' />' . PHP_EOL;
    }
    
    // cx = "<coordinate>"
    // cy = "<coordinate>"
    // r = "<length>"
    public function circulo($cx = '', $cy = '', $r = '', $presentation = '', $id = '', $class = '', $style = '', $transform = '')
    {
        if (!empty($cx) or is_numeric($cx)) {
            $cx = ' cx="' . $cx . '"';
        }
        if (!empty($cy) or is_numeric($cy)) {
            $cy = ' cy="' . $cy . '"';
        }
        if (!empty($r) or is_numeric($r)) {
            $r = ' r="' . $r . '"';
        }
        if (!empty($id)) {
            $id = ' id="' . $id . '"';
        }
        if (!empty($class)) {
            $class = ' class="' . $class . '"';
        }
        if (!empty($style)) {
            $style = ' style="' . $style . '"';
        }
        if (!empty($transform)) {
            $transform = ' transform="' . $transform . '"';
        }
        $attributes = $this->obterAtributosApresentacao($presentation);
        
        $this->grafico .= '<circle' . $cx . $cy . $r . $attributes . $id . $class . $style . $transform . ' />' . PHP_EOL;
    }
    
    // cx = "<coordinate>"
    // cy = "<coordinate>"
    // rx = "<length>"
    // ry = "<length>"
    public function elipse($cx = '', $cy = '', $rx = '', $ry = '', $presentation = '', $id = '', $class = '', $style = '', $transform = '')
    {
        if (!empty($cx) or is_numeric($cx)) {
            $cx = ' cx="' . $cx . '"';
        }
        if (!empty($cy) or is_numeric($cy)) {
            $cy = ' cy="' . $cy . '"';
        }
        if (!empty($rx) or is_numeric($rx)) {
            $rx = ' rx="' . $rx . '"';
        }
        if (!empty($ry) or is_numeric($ry)) {
            $ry = ' ry="' . $ry . '"';
        }
        if (!empty($id)) {
            $id = ' id="' . $id . '"';
        }
        if (!empty($class)) {
            $class = ' class="' . $class . '"';
        }
        if (!empty($style)) {
            $style = ' style="' . $style . '"';
        }
        if (!empty($transform)) {
            $transform = ' transform="' . $transform . '"';
        }
        $attributes = $this->obterAtributosApresentacao($presentation);
        
        $this->grafico .= '<ellipse' . $cx . $cy . $rx . $ry . $attributes . $id . $class . $style . $transform . ' />' . PHP_EOL;
    }
    
    // x1 = "<coordinate>"
    // y1 = "<coordinate>"
    // x2 = "<coordinate>"
    // y2 = "<coordinate>"
    public function linha($x1 = '', $y1 = '', $x2 = '', $y2 = '', $presentation = '', $id = '', $class = '', $style = '', $transform = '')
    {
        if (!empty($x1) or is_numeric($x1)) {
            $x1 = ' x1="' . $x1 . '"';
        }
        if (!empty($y1) or is_numeric($y1)) {
            $y1 = ' y1="' . $y1 . '"';
        }
        if (!empty($x2) or is_numeric($x2)) {
            $x2 = ' x2="' . $x2 . '"';
        }
        if (!empty($y2) or is_numeric($y2)) {
            $y2 = ' y2="' . $y2 . '"';
        }
        if (!empty($id)) {
            $id = ' id="' . $id . '"';
        }
        if (!empty($class)) {
            $class = ' class="' . $class . '"';
        }
        if (!empty($style)) {
            $style = ' style="' . $style . '"';
        }
        if (!empty($transform)) {
            $transform = ' transform="' . $transform . '"';
        }
        $attributes = $this->obterAtributosApresentacao($presentation);
        
        $this->grafico .= '<line' . $x1 . $y1 . $x2 . $y2 . $attributes . $id . $class . $style . $transform . ' />' . PHP_EOL;
    }
    
    // points = "<list-of-points>"
    public function polilinha($points, $presentation = '', $id = '', $class = '', $style = '', $transform = '')
    {
        if (!empty($id)) {
            $id = ' id="' . $id . '"';
        }
        if (!empty($class)) {
            $class = ' class="' . $class . '"';
        }
        if (!empty($style)) {
            $style = ' style="' . $style . '"';
        }
        if (!empty($transform)) {
            $transform = ' transform="' . $transform . '"';
        }
        $attributes = $this->obterAtributosApresentacao($presentation);
        
        $this->grafico .= '<polyline points="' . $points . '"' . $attributes . $id . $class . $style . $transform . ' />' . PHP_EOL;
    }
    
    // points = "<list-of-points>"
    public function poligono($points, $presentation = '', $id = '', $class = '', $style = '', $transform = '', $agroup = false)
    {
        if (!empty($id)) {
            $id = ' id="' . $id . '"';
        }
        if (!empty($class)) {
            $class = ' class="' . $class . '"';
        }
        if (!empty($style)) {
            $style = ' style="' . $style . '"';
        }
        if (!empty($transform)) {
            $transform = ' transform="' . $transform . '"';
        }
        $attributes = $this->obterAtributosApresentacao($presentation);
        
        $poligono = '<polygon points="' . $points . '"' . $attributes . $id . $class . $style . $transform . ' />' . PHP_EOL;
        
        if ($agroup) {
            $this->grupo .= $poligono;
        } else {
            $this->grafico .= $poligono;
        }
    }
    
    // x = "<coordinate>"
    // y = "<coordinate>"
    // width = "<length>"
    // height = "<length>"
    // xlink:href = "<iri>"
    // preserveAspectRatio= none | xMinYMin | xMidYMin | xMaxYMin
    //                           | xMinYMid | xMidYMid (the default) | xMaxYMid
    //                           | xMinYMax | xMidYMax | xMaxYMax
    //                      meet | slice
    public function imagem($xlinkhref, $x = '', $y = '', $width = '', $height = '', $preserveaspectratio = '', $presentation = '', $class = '', $style = '', $transform = '')
    {
        if (!empty($x) or is_numeric($x)) {
            $x = ' x="' . $x . '"';
        }
        if (!empty($y) or is_numeric($y)) {
            $y = ' y="' . $y . '"';
        }
        if (!empty($width)) {
            $width = ' width="' . $width . '"';
        }
        if (!empty($height)) {
            $height = ' height="' . $height . '"';
        }
        if (!empty($preserveaspectratio)) {
            $preserveaspectratio = ' preserveAspectRatio="' . $preserveaspectratio . '"';
        }
        if (!empty($class)) {
            $class = ' class="' . $class . '"';
        }
        if (!empty($style)) {
            $style = ' style="' . $style . '"';
        }
        if (!empty($transform)) {
            $transform = ' transform="' . $transform . '"';
        }
        $attributes = $this->obterAtributosApresentacao($presentation);
        
        $this->grafico .= '<image' . $x . $y . $width . $height . '" xlink:href="' . $xlinkhref . '"' . $preserveaspectratio . $attributes . $class . $style . $transform . '></image>' . PHP_EOL;
    }
    
    // $stops = array(array("offset" => '50%', "stop-color" => 'red', "stop-opacity" => '1'));
    // x1 = "<coordinate>"
    // y1 = "<coordinate>"
    // x2 = "<coordinate>"
    // y2 = "<coordinate>"
    // gradientUnits = "userSpaceOnUse | objectBoundingBox"
    // gradientTransform = "<transform-list>"
    // spreadMethod = "pad | reflect | repeat"
    // xlink:href = "<iri>"
    public function gradienteLinear($stops, $id = '', $x1 = '', $y1 = '', $x2 = '', $y2 = '', $gradientunits = '', $gradienttransform = '', $spreadmethod = '', $xlinkhref = '', $presentation = '', $class = '', $style = '')
    {
        if (!empty($id)) {
            $id = ' id="' . $id . '"';
        }
        if (!empty($x1) or is_numeric($x1)) {
            $x1 = ' x1="' . $x1 . '"';
        }
        if (!empty($y1) or is_numeric($y1)) {
            $y1 = ' y1="' . $y1 . '"';
        }
        if (!empty($x2) or is_numeric($x2)) {
            $x2 = ' x2="' . $x2 . '"';
        }
        if (!empty($y2) or is_numeric($y2)) {
            $y2 = ' y2="' . $y2 . '"';
        }
        if (!empty($gradientunits)) {
            $gradientunits = ' gradientUnits="' . $gradientunits . '"';
        }
        if (!empty($gradienttransform)) {
            $gradienttransform = ' gradientTransform="' . $gradienttransform . '"';
        }
        if (!empty($spreadmethod)) {
            $spreadmethod = ' spreadMethod="' . $spreadmethod . '"';
        }
        if (!empty($xlinkhref)) {
            $xlinkhref = ' xlink:href = "' . $xlinkhref . '"';
        }
        if (!empty($class)) {
            $class = ' class="' . $class . '"';
        }
        if (!empty($style)) {
            $style = ' style="' . $style . '"';
        }
        $attributes = $this->obterAtributosApresentacao($presentation);
        
        $paradas = '';
        foreach ($stops as $stop) {
            $paradas .= '<stop offset="' . $stop["offset"] . '" stop-color="' . $stop["stop-color"] . '" stop-opacity="' . $stop["stop-opacity"] . '" />';
        }
        
        $this->grafico .= '<linearGradient' . $id . $x1 . $y1 . $x2 . $y2 . $gradientunits . $gradienttransform . $spreadmethod . $xlinkhref . $attributes . $class . $style . '>' . $paradas . '</linearGradient>' . PHP_EOL;
    }
    
    // $stops = array(array("offset" => '50%', "stop-color" => 'red', "stop-opacity" => '1'));
    // cx = "<coordinate>"
    // cy = "<coordinate>"
    // r = "<length>"
    // fx = "<coordinate>"
    // fy = "<coordinate>"
    // gradientUnits = "userSpaceOnUse | objectBoundingBox"
    // gradientTransform = "<transform-list>"
    // spreadMethod = "pad | reflect | repeat"
    // xlink:href = "<iri>"
    public function gradienteRadial($stops, $id = '', $cx = '', $cy = '', $r = '', $fx = '', $fy = '', $gradientunits = '', $gradienttransform = '', $spreadmethod = '', $xlinkhref = '', $presentation = '', $class = '', $style = '')
    {
        if (!empty($id)) {
            $id = ' id="' . $id . '"';
        }
        if (!empty($cx) or is_numeric($cx)) {
            $cx = ' cx="' . $cx . '"';
        }
        if (!empty($cy) or is_numeric($cy)) {
            $cy = ' cy="' . $cy . '"';
        }
        if (!empty($r) or is_numeric($r)) {
            $r = ' r="' . $r . '"';
        }
        if (!empty($fx) or is_numeric($fx)) {
            $fx = ' fx="' . $fx . '"';
        }
        if (!empty($fy) or is_numeric($fy)) {
            $fy = ' fy="' . $fy . '"';
        }
        if (!empty($gradientunits)) {
            $gradientunits = ' gradientUnits="' . $gradientunits . '"';
        }
        if (!empty($gradienttransform)) {
            $gradienttransform = ' gradientTransform="' . $gradienttransform . '"';
        }
        if (!empty($spreadmethod)) {
            $spreadmethod = ' spreadMethod="' . $spreadmethod . '"';
        }
        if (!empty($xlinkhref)) {
            $xlinkhref = ' xlink:href = "' . $xlinkhref . '"';
        }
        if (!empty($class)) {
            $class = ' class="' . $class . '"';
        }
        if (!empty($style)) {
            $style = ' style="' . $style . '"';
        }
        $attributes = $this->obterAtributosApresentacao($presentation);
        
        $paradas = '';
        foreach ($stops as $stop) {
            $paradas .= '<stop offset="' . $stop["offset"] . '" stop-color="' . $stop["stop-color"] . '" stop-opacity="' . $stop["stop-opacity"] . '" />';
        }
        
        $this->grafico .= '<radialGradient' . $id . $cx . $cy . $r . $fx . $fy . $gradientunits . $gradienttransform . $spreadmethod . $xlinkhref . $attributes . $class . $style . '>' . $paradas . '</radialGradient>' . PHP_EOL;
    }
    
}

