<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $head['title'] ?></title>
    <link rel="stylesheet" href="<?php echo $PATH ?>style.css">

    <?php
    foreach ($head['sctipts'] as $script) {
        echo "<script src='{$PATH}js/{$script}'></script>";
    }
    ?>
</head>