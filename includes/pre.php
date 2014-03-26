<?php

function site_header($title) {
	$xmlstring = '<?xml version="1.0" encoding="iso-8859-1"?>';
	$header = <<<HEAD
$xmlstring
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>${title}</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="Content-Style-Type" content="text/css" />
	<link rel="stylesheet" href="/shared/pe.css" type="text/css" />
	<link rel="stylesheet" href="/shared/lightwindow.css" type="text/css" media="screen" />
<style type="text/css">td img {display: block;}</style>
<script language="JavaScript" type="text/javascript" src="/shared/pe.js" />
<script type="text/javascript" src="/shared/prototype.js"></script>
<script type="text/javascript" src="/shared/scriptaculous.js?load=effects"></script>
<script type="text/javascript" src="/shared/lightwindow.js"></script>
</head>
<body bgcolor="#ffffff">
HEAD;
	
	echo $header;
}

function site_footer() {
	echo '<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
	</script>
	<script type="text/javascript">
	_uacct = "UA-1017041-1";
	urchinTracker();
	</script></body></html>';
}

# Function MakeCheckBoxes #####################################################
function MakeCheckBoxes($Name,$PromptsAndValues,$Selected) {
   $ArrayCount = count($PromptsAndValues);
   for($Index=0;$Index<$ArrayCount;$Index++) {
     $String .= "<label class=\"checklabel\" for=\"$Name";
     $String .= ($ArrayCount>1) ? "[$Index]" : "";
     $String .= "\">";
     $String .= $PromptsAndValues[$Index];
     $String .= "</label>";

     $String .=<<<STRING
     <input class="checkbox" type="checkbox" name="$Name
STRING;
     $String .= ($ArrayCount>1) ? "[$Index]" : "";
     $String .= '"';
     $String .= "id=\"$Name";
     $String .= ($ArrayCount>1) ? "[$Index]" : "";
     $String .= '"';
     $String .= "\n    value=\"$PromptsAndValues[$Index]\"";
     $String .= ($Selected[$Index]) ? " checked>" : ">";
     $String .= "\n<br/>";
   } # End of for ($Index=0;$Index<count($PromptsAndValues);$Index++)
   return chop($String);
} # End of function MakeCheckBoxes ############################################

?>
