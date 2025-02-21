<?php

defined('BASEPATH') OR exit('No direct script access allowed');


function random_ticket($lenght = 8)
{
    $characters = 'ABCDEFGHIJKLMNPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < 2; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }


    $characters = '0123456789';
    $charactersLength = strlen($characters);
    $randomNum = '';
    for ($i = 0; $i < $lenght; $i++) {
        $randomNum .= $characters[rand(0, $charactersLength - 1)];
    }

    return $randomString . $randomNum;
}




function isHTML($str) {
	return preg_match("/\/[a-z]*>/i", $str) != 0;
}


function cc_array_formatter($string) {
    $cc_array = [];
    if($string == "") return $cc_array;

    $recipients = explode(',', $string);

    foreach ($recipients as $recipient) {
        $recipient = trim($recipient);
        if (filter_var($recipient, FILTER_VALIDATE_EMAIL)) {
            array_push($cc_array, $recipient);
        }
    }

    return $cc_array;
}







/* Allowed HTML elements */
$html_elements = array('a', 'abbr', 'acronym', 'address', 'area', 'b', 'basefont', 'bdo', 'big', 'blockquote', 'br', 'caption', 'center', 'cite', 'code', 'col', 'colgroup', 'dd', 'del', 'dfn', 'dir', 'div', 'dl', 'dt', 'em', 'fieldset', 'font', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'hr', 'i', 'ins', 'label', 'legend', 'li', 'map', 'menu', 'ol', 'p', 'pre', 'q', 's', 'samp', 'small', 'span', 'strike', 'strong', 'sub', 'sup', 'table', 'tbody', 'td', 'tfoot', 'th', 'thead', 'title', 'tr', 'tt', 'u', 'ul', 'var', 'img');

/* Allowed HTML attributes */
$html_attribs = array('name', 'class', 'title', 'alt', 'width', 'height', 'align', 'nowrap', 'col', 'row', 'id', 'rowspan', 'colspan', 'cellspacing', 'cellpadding', 'valign', 'bgcolor', 'color', 'border', 'bordercolorlight', 'bordercolordark', 'face', 'marginwidth', 'marginheight', 'axis', 'border', 'abbr', 'char', 'charoff', 'clear', 'compact', 'coords', 'vspace', 'hspace', 'cellborder', 'size', 'lang', 'dir', 'src');

/* Check CSS style */
function wash_style($style, $config, &$full) {
  global $css_attribs, $css_values, $href_re;
  $s = '';

  foreach(explode(';', $style) as $declaration) {
    if(preg_match('/^\s*([a-z\-]+)\s*:\s*(.*)\s*$/i', $declaration, $match)) {
      $cssid = $match[1];
      $str = $match[2];
      $value = '';
      while(sizeof($str) > 0 &&
	    preg_match('/^(url\(\s*[\'"]?([^\'"\)]*)[\'"]?\s*\)'./*1,2*/
		       '|rgb\(\s*[0-9]+\s*,\s*[0-9]+\s*,\s*[0-9]+\s*\)'.
		       '|-?[0-9.]+\s*(em|ex|px|cm|mm|in|pt|pc|deg|rad|grad|ms|s|hz|khz|%)?'.
		       '|#[0-9a-f]{3,6}|[a-z0-9\-]+'.
		       ')\s*/i', $str, $match)) {
	if($match[2]) {
	  //Use parse_url
	  if(preg_match('/^(http|https|ftp):.*$/i', $match[2], $url)) {
	    if($config['allow_remote'])
	      $value .= ' url(\''.htmlspecialchars($url[0], ENT_QUOTES).'\')';
	    else
	      $full = false;
	  } else if(preg_match('/^cid:(.*)$/i', $match[2], $cid))
	    $value .= ' url(\''.htmlspecialchars($config['cid_map']['cid:'.$cid[1]], ENT_QUOTES) . '\')';
	} else if($match[0] != 'url' && $match[0] != 'rbg')//whitelist ?
	  $value .= ' ' . $match[0];
	$str = substr($str, strlen($match[0]));
      }
      if($value)
	$s .= ($s?' ':'') . $cssid . ':' . $value . ';';
    }
  }
  return $s;
}

/* Take a node and return allowed attributes and check values */
function wash_attribs($node, $config, &$full) {
  global $html_attribs;
  $t = '';
  $washed;

  foreach($node->attributes as $key => $plop) {
    $key = strtolower($key);
    $value = $node->getAttribute($key);
    if((in_array($key, $html_attribs)) ||
       ($key == 'href' && preg_match('/^(http|https|ftp|mailto):.*/i', $value)))
      $t .= ' ' . $key . '="' . htmlspecialchars($value, ENT_QUOTES) . '"';
    else if($key == 'style' && ($style = wash_style($value, $config, $full)))
      $t .= ' style="' . $style . '"';
    else if($key == 'src' && strtolower($node->tagName) == 'img') { //check tagName anyway
      if(preg_match('/^(http|https|ftp):.*/i', $value)) {
	if($config['allow_remote'])
	  $t .= ' ' . $key . '="' . htmlspecialchars($value, ENT_QUOTES) . '"';
	else
	  $full = false;
      }	else if(preg_match('/^cid:(.*)$/i', $value, $cid))
	$t .= ' ' . $key . '="' . htmlspecialchars($config['cid_map']['cid:'.$cid[1]], ENT_QUOTES) . '"';
    } else
      $washed .= ($washed?' ':'') . $key . '=' . htmlspecialchars($value, ENT_QUOTES);
  }
  return $t . ($washed?' x-washed="'.$washed.'"':'');
}

/* The main loop that recurse on a node tree.
 * It output only allowed tags with allowed attributes
 * and allowed inline styles */
function dumpHtml($node, $config, &$full) {
  global $html_elements, $html_attribs;

  if(!$node->hasChildNodes())
    return '';

  $node = $node->firstChild;
  $dump = '';

  do {
    switch($node->nodeType) {
    case XML_ELEMENT_NODE://Check element
      $tagName = strtolower($node->tagName);
      if(in_array($tagName, $html_elements)) {
	$content = dumpHtml($node, $config, $full);
	$dump .= '<' . $tagName . wash_attribs($node, $config, $full) .
	  ($content?">$content</$tagName>":' />');
      } else if($tagName == 'html' || $tagName == 'body') {
	$dump .= dumpHtml($node, $config, $full);//Just ignored
      } else
	$dump .= '<!-- ' . htmlspecialchars($tagName, ENT_QUOTES) . ' not allowed -->';
      break;
    case XML_TEXT_NODE:
      $dump .= htmlspecialchars($node->nodeValue);
      break;
    case XML_HTML_DOCUMENT_NODE:
      $dump .= dumpHtml($node, $config, $full);
      break;
    case XML_DOCUMENT_TYPE_NODE: break;
    default:
    }
  } while($node = $node->nextSibling);

  return $dump;
}

/* Main function, give it untrusted HTML, tell it if you allow loading
 * remote images and give it a map to convert "cid:" urls. */
function washtml($html, $config=array(), &$full=true) {
  if(!isset($config['allow_remote'])) $config['allow_remote']=true;
  if(!isset($config['cid_map'])) $config['cid_map']=array();
  //Charset seems to be ignored (probably if defined in the HTML document)
  $node = new DOMDocument('1.0'); // , $config['charset']);
  $full = true;

  $html = @mb_convert_encoding($html, 'HTML-ENTITIES', "auto");
  @$node->loadHTML($html);
  return dumpHtml($node, $config, $full);
}
