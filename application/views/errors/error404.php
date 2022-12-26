<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style404.css">
    <title>Page not Found</title>
</head>
<body>
    <div id="container">
        <div class="content">
            <h2>404</h2>
            <h4>Opps! Page not found</h4>
            <p>The page you are looking for doesn't exyt. You may have mistyped the address or the page may have moved</p>
            <a href="<?php echo base_url(); ?>home">Back to Home</a>
        </div>
    </div>

    <script type="text/javascript">
        let container = document.getElementById('container');
        window.onmousemove = function (e) {
            let x = -e.clientX/5,
            y = -e.clientY/5;

            container.style.backgroundPositionX = `${x}px`;
            container.style.backgroundPositionY = `${y}px`;
        }
    </script>
    
</body>
</html>