<?php
// This is a template for a PHP scraper on Morph (https://morph.io)
// including some code snippets below that you should find helpful

date_default_timezone_set('America/Santiago');

require 'scraperwiki.php';
require 'scraperwiki/simple_html_dom.php';

$mes = 1;
$dia = 1;
$valor = array();

// Init
for( $mes = 1; $mes <= 12; $mes++ ){
    for( $dia = 1; $dia <= 31; $dia++){
        $valor[$mes][$dia] = null;
    }
}

// // Read in a page
$html = scraperwiki::scrape("http://www.sii.cl/pagina/valores/uf/uf2014.htm");
//
// // Find something on the page using css selectors
$dom = new simple_html_dom();
$dom->load($html);

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

var_dump( $valor );
//
// // Write out to the sqlite database using scraperwiki library
// scraperwiki::save_sqlite(array('name'), array('name' => 'susan', 'occupation' => 'software developer'));
//
// // An arbitrary query against the database
// scraperwiki::select("* from data where 'name'='peter'")

// You don't have to do things with the ScraperWiki library. You can use whatever is installed
// on Morph for PHP (See https://github.com/openaustralia/morph-docker-php) and all that matters
// is that your final data is written to an Sqlite database called data.sqlite in the current working directory which
// has at least a table called data.
?>
