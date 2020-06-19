<?php
#############
# VARIABLES
#############

# $type   - One of: index, publisher, group, artifact, version
# $parent - The page parent
# $links  - An array of links. Each link has the following fields:
#               $label   - The link label
#               $uri     - The link uri
?>

<html>
    <head>
        <title>Index of <?=$parent?></title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <h1>Index of <?=$parent?></h1>
        <div>
            <a href="../">../</a>
        </div>
        <div>
            <table>
            <?php foreach ($links as &$link) { ?>
                <tr>
                    <td><a href="/<?=$link['uri']?>"><?=$link['label']?></a></td>
                </tr>
            <?php } ?>
            </table>
        </div>
    </body>
</html>
