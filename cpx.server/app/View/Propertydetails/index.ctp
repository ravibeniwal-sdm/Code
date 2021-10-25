
 <!DOCTYPE html>
    <html>
        <head>
            <meta property="og:title" content="<?php echo $detaildata['name']; ?>" />
            <meta property="og:description" content="<?php echo $detaildata['type']; ?>" />
            <meta property="og:image" content="<?php echo $detaildata['img']; ?>" />
            <!-- etc. -->
        </head>
        <body>
            <p><?php echo $detaildata['type']; ?></p>
            <img src="<?php echo $detaildata['img']; ?>">
        </body>
    </html>