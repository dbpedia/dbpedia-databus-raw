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
        <div>
            <h1><?=$docs['label']?></h1>
            <h3><a href="/">home</a><?php for ($i = 0; $i < count($pathEntries); $i++) { ?> /<a href="<?=$breadcrumbs[$i]?>/"><?=$pathEntries[$i]?></a> <?php } ?> </h3>
            <p><?=$docs['desc']?></p>
            <p>Databus URI: <a href="<?=$docs['databus-uri']?>/"><?=$docs['databus-uri']?></a></p>
        </div>
        <br />
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
                    <td><a href="/<?=$link['uri']?>"><?=$link['label']?></a></td>
                    <td><?=$link['time']?></td>
                    <td value="<?=$link['size']?>"><?=formatSize($link['size'])?></td>
                </tr>
                <?php } ?>
            </table>
        </div>
        <script src="/scripts.js"></script>
    </body>
</html>
