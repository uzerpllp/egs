<?php
class Doku_Renderer {
    var $info = array(
        'cache' => TRUE, // may the rendered result cached?
    );


    function nocache() {
        $this->info['cache'] = FALSE;
    }
    
    function document_start() {}
    
    function document_end() {}
    
    function toc_open() {}
    
    function tocbranch_open($level) {}
    
    function tocitem_open($level, $empty = FALSE) {}
    
    function tocelement($level, $title) {}
    
    function tocitem_close($level) {}
    
    function tocbranch_close($level) {}
    
    function toc_close() {}
    
    function header($text, $level, $pos) {}
    
    function section_open($level) {}
    
    function section_close() {}
    
    function cdata($text) {}
    
    function p_open() {}
    
    function p_close() {}
    
    function linebreak() {}
    
    function hr() {}
    
    function strong_open() {}
    
    function strong_close() {}
    
    function emphasis_open() {}
    
    function emphasis_close() {}
    
    function underline_open() {}
    
    function underline_close() {}
    
    function monospace_open() {}
    
    function monospace_close() {}
    
    function subscript_open() {}
    
    function subscript_close() {}
    
    function superscript_open() {}
    
    function superscript_close() {}
    
    function deleted_open() {}
    
    function deleted_close() {}
    
    function footnote_open() {}
    
    function footnote_close() {}
    
    function listu_open() {}
    
    function listu_close() {}
    
    function listo_open() {}
    
    function listo_close() {}
    
    function listitem_open($level) {}
    
    function listitem_close() {}
    
    function listcontent_open($level) {}
    
    function listcontent_close() {}
    
    function unformatted($text) {}
    
    function php($text) {}
    
    function html($text) {}
    
    function preformatted($text) {}
    
    function file($text) {}
    
    function quote_open() {}
    
    function quote_close() {}
    
    function code($text, $lang = NULL) {}
    
    function acronym($acronym) {}
    
    function smiley($smiley) {}
    
    function wordblock($word) {}
    
    function entity($entity) {}
    
    // 640x480 ($x=640, $y=480)
    function multiplyentity($x, $y) {}
    
    function singlequoteopening() {}
    
    function singlequoteclosing() {}
    
    function doublequoteopening() {}
    
    function doublequoteclosing() {}
    
    // $link like 'SomePage'
    function camelcaselink($link) {}
    
    // $link like 'wiki:syntax', $title could be an array (media)
    function internallink($link, $title = NULL) {}
    
    // $link is full URL with scheme, $title could be an array (media)
    function externallink($link, $title = NULL) {}
    
    // $link is the original link - probably not much use
    // $wikiName is an indentifier for the wiki
    // $wikiUri is the URL fragment to append to some known URL
    function interwikilink($link, $title = NULL, $wikiName, $wikiUri) {}
    
    // Link to file on users OS, $title could be an array (media)
    function filelink($link, $title = NULL) {}
    
    // Link to a Windows share, , $title could be an array (media)
    function windowssharelink($link, $title = NULL) {}
    
    function email($address, $title = NULL) {}
    
    function internalmedialink (
        $src,$title=NULL,$align=NULL,$width=NULL,$height=NULL,$cache=NULL
        ) {}

    function externalmedialink(
        $src,$title=NULL,$align=NULL,$width=NULL,$height=NULL,$cache=NULL
        ) {}
        
    function table_open($maxcols = NULL, $numrows = NULL){}
    
    function table_close(){}
    
    function tablerow_open(){}
    
    function tablerow_close(){}
    
    function tableheader_open($colspan = 1, $align = NULL){}
    
    function tableheader_close(){}
    
    function tablecell_open($colspan = 1, $align = NULL){}
    
    function tablecell_close(){}

}


//Setup VIM: ex: et ts=4 enc=utf-8 :
