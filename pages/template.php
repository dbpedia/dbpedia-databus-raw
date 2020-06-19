<?php
#############
# VARIABLES
#############

# $pathLength  - Length of the path, can be used to adjust template path depth to depth
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
