<?php
//check if the user is logged in
require_once 'modules/checkAuthentication.php';

?>
<html>

<head>
    <title>Bookmarks - Realtime Reporting System</title>
    <meta name="title" content="bookmarks">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="static/stylesheets/reset.css" rel="stylesheet" type="text/css">
    <link href="static/stylesheets/style.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" type="image/x-icon" href="static/images/favicon.png">
    <?php
    include 'modules/bootstrapdependencies.php';
    ?>
    <script src="static/js/script.js"></script>
    <script src="https://cdn.plyr.io/3.6.12/plyr.polyfilled.js"></script>
    <link rel="stylesheet" href="https://cdn.plyr.io/3.6.12/plyr.css" />
    
</head>

<body>
<?php
    require 'components/leftSidebar.php';
    echo leftSidebar("bookmarks");
    ?>
    <?php
    include 'components/navbar.php';
    ?>
    <div class="wrapper justify-content-center">
        <div class="container w-70">
        <div id="gap" style="height: 5rem"></div>
            <?php
            require "components/BookMarksView.php";
            ?>
        </div>
    </div>
    <script src="static/js/videoplayer.js"></script>
</body>

</html>