<?php

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
