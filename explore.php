<?php
//check if the user is logged in
require_once 'modules/checkAuthentication.php';

?>

<html>

<head>
    <title>Explore - Realtime Reporting System</title>
    <meta name="title" content="explore">
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
    echo leftSidebar("explore");
    ?>
    <?php
    require_once 'components/rightSidebar.php';
    ?>
    <?php
    include 'components/navbar.php';
    ?>
    <div class="wrapper">
        <div class="container w-70">
            <div id="gap" style="height: 5rem"></div>
            <div class="top-categories">
                <div class="dropdown">
                <a class="btn bg-color-main dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-expanded="false">
                    Categories
                </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                       <?php
                        require_once 'modules/dependencyImporter.php';
                        $categories = getCategories();
                        foreach ($categories as $category) {
                            echo '<a class="dropdown-item" href="explore.php?category=' . $category['c_name'] . '">' . $category['c_name'] . '</a>';
                        }
                        ?>
                    </div>
                </div>
            </div>
            <?php
            require "components/ExploreView.php";
            ?>
        </div>
    </div>

    <script src="static/js/videoplayer.js"></script>
</body>

</html>