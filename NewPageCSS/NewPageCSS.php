<?php
if (!defined('MEDIAWIKI')) die();
/**
 * A parser hook to add per-page CSS to pages with the <css> tag
 *
 * @addtogroup Extensions
 *
 * @author Julian Porter <julian.porter@porternet.org> and Ævar Arnfjörð Bjarmason <avarab@gmail.com>
 * @copyright Copyright © 2010, Julian Porter; 2005, Ævar Arnfjörð Bjarmason
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgHooks['ParserFirstCallInit'][] = 'CSS_setup';
$wgExtensionCredits['parserhook'][] = array(
	'path' => __FILE__,
	'name' => 'New Page CSS',
	'url' => 'http://www.mediawiki.org/wiki/Extension:NewPageCSS',
	'description' => 'Parser hook to add per-page CSS using the <tt>&lt;css&gt;</tt> tag',
	'author' => array( 'Julian Porter', '&#x00C6;var Arnfj&#x00F6;r&#x00F0; Bjarmason' ),
);

function CSS_setup(&$parser)
{
  $parser->setHook("css","CSS_include");
  return true;
}

function CSS_include($content, $argv, $parser)
{
#  global $wgParser;
  $css = htmlspecialchars( trim( Sanitizer::checkCss( $content ) ) );
  $parser->mOutput->addHeadItem( <<<EOT
<style type="text/css">
/*<![CDATA[*/      
{$css}
/*]]>*/       
</style>
EOT
  );
  return '';
}
