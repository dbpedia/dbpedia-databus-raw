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
        <link rel="stylesheet" href="/style.css">
    </head>
    <body>
        <h1>Index of <?=$parent?></h1>
        <div>
            <h2><?=$docs['label']?></h2>
            <p>Databus URI: <a href="/<?=$docs['databus-uri']?>/"><?=$docs['databus-uri']?></a></p>
            <p><?=$docs['desc']?></p>
        </div>

        <div>
            <a href="../">../</a>
        </div>
        <div>
            <table style="width:100%">
                <tr>
                    <th>Link</th>
                    <th>Time</th>
                    <th>Size</th>
                </tr>
                <?php foreach ($links as &$link) { ?>
                <tr>
                    <td><a href="/<?=$link['uri']?>/"><?=$link['label']?></a></td>
                    <td><?=$link['time']?></td>
                    <td><?=$link['size']?></td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </body>
</html>
