<?php
// This is a template for a PHP scraper on Morph (https://morph.io)
// including some code snippets below that you should find helpful

date_default_timezone_set('America/Santiago');

require 'scraperwiki.php';
require 'simple_html_dom.php';

$year = 1994;

for( $year = 2010; $year <= 2014; $year++):
    $html = scraperwiki::scrape("http://www.sii.cl/pagina/valores/uf/uf". $year .".htm");
    
    $dom = new simple_html_dom();
    $dom->load($html);
    
    $mes = 1;
    $dia = 1;
    $valor = array();
    
    // Init
    for( $mes = 1; $mes <= 12; $mes++ ){
        for( $dia = 1; $dia <= 31; $dia++){
            $valor[$mes][$dia] = null;
        }
    }
    
    $mes = 1;
    $dia = 1;
    
    foreach( $dom->find('#contenido table tbody tr') as $fila ){
    
        for( $mes = 0; $mes <= 12; $mes++ ){
            if( 'td' == $fila->children($mes)->tag ){
                $val = str_replace('&nbsp;', '', $fila->children($mes)->plaintext );
                $valor[ $mes ][ $dia ] = trim( $val );
            }
        }
        
        $dia++; 
    }
    
    
    $i = 1;
    
    foreach( $valor as $m => $valores ){
        foreach( $valores as $d => $v ){
            if( null != $v ){
                $d = $d-1;
                
                $llave = sprintf('%s-%s-%s', $year, $m, $d);
                $valor = str_replace(array('.', ','), array('', '.'), $v);
                $valor = floatval( $valor );
                
                scraperwiki::save_sqlite( array('date'),
                                          array('date' => $llave, 'year' => $year, 'month' => $m, 'day' => $d, 'value' => $valor ) );
                
                printf("%s => %s \n", $llave, $valor);
            }
        }
        echo "\n ## ## ## ## ## ##\n";
    }
    
endfor;
