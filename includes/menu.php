<?php
    $pList       = array("l", "s", "cb", "cp");
    $classesList = array("Licence", "Site", "Cb", "Compte");
    $titlesList  = array("Licences", "Sites Web", "Cartes Bancaires", "Comptes Bancaires");
    
    echo('<ul id="menu">');
    
    for ($i = 0; $i <= 3; $i++)
    {
        echo ('<li><a '.(($p != $pList[$i]) ? "href=\"?p=$pList[$i]\" " : "").'id="'.$classesList[$i].'" title="'.$titlesList[$i].'"><span class="nodisplay">'.$titlesList[$i].'</span></a></li>');
    }
    
    echo("</ul>");
?>