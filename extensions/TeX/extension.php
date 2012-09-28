<?php

$wgExtensionFunctions[] = 'wfWikiTeX';
$wgExtensionCredits['parserhook'][] = array(
  'name'	=> 'WikiTeX',
  'author'	=> 'Matthias Bock',
  'url'		=> 'http://www.mediawiki.org/wiki/Extension:WikiTeX',
  'description'	=> 'render TeX in a MediaWiki',
);


/*
 * Setup WikiTeX extension.
 * Sets a parser hook for <tex></tex>.
 */
function wfWikiTeX() {
	new WikiTeX();
}


class WikiTeX {
     /*
     * Construct the extension and install it as a parser hook.
     */
    public function __construct() {
        global $wgParser;
        $wgParser->setHook('tex', array(&$this, 'hook'));
    }
 
    /*
     * The hook function. Handles <tex></tex>.
     * Receives the content and <tex> tag arguments.
     */
    public function hook($content, $argv, $parser) {

        // parse arguments
        $params = '';
        foreach ($argv as $key => $val) {
#            if ($key == 'sep')
#               do something;
        }

	$ret = $parser->parse("<source lang=latex>$content</source>",
	                      $parser->mTitle,
	                      $parser->mOptions,
	                      false,
	                      false);
#	<object style="border:1px; width:100%;" src="/Advokado/extensions/TeX/pdflatex.php?tex='.urlencode($content).'&.pdf" type="application/pdf"/>

	$insert = '<form id=wikitex name=wikitex method=POST action="/Advokado/extensions/TeX/pdflatex.php">
<input name=tex type=hidden value="'.$content.'"/>
<img src="/Advokado/extensions/TeX/PDF.png" style="border:none; cursor:pointer; width:32px; position:absolute; right:20px;" onclick="document.forms[\'wikitex\'].submit();"/>
</form>';
	$wikiText = str_replace('<pre class="de1">', $insert.'<pre class="de1">', $ret->getText());
 
        return $wikiText;
    }

}

