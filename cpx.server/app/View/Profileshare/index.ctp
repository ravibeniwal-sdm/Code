
 <!DOCTYPE html>
    <html>
        <head>
            <meta property="og:title" content="<?php echo $detaildata['name']; ?>" />
            
            <meta property="og:image" content="<?php echo $detaildata['img']; ?>" />
            <!-- etc. -->
        </head>
        <body>
            <p><?php echo $detaildata['name']; ?></p>
            <img src="<?php echo $detaildata['img']; ?>">
        </body>
    </html>