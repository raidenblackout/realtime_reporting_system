<?php
function leftSidebar($title){
$content='<div class="collapse collapsible flex-column flex-shrink-0 bg-light left-sidebar" style="width: 4.5rem; position: fixed;" id="collapsible-left-sidebar">
    <span></span>
    <ul class="nav nav-pills nav-flush flex-column mb-auto text-center">
        <li class="nav-item" data-toggle="tooltip" data-placement="right" data-title="Home">
            <a href="/realtime_reporting_system/index.php" class="nav-link py-3 border-bottom {status-home}" aria-current="page" title="" role="tab" data-title="home" aria-controls="home" aria-selected="true">
                <i class="fa fa-home"></i>
            </a>
        </li>
        <li data-toggle="tooltip" data-placement="right" data-title="Explore">
            <a href="/realtime_reporting_system/explore.php" class="nav-link py-3 border-bottom {status-explore}" title=""  role="tab" data-title="explore" aria-controls="explore" aria-selected="false">
                <i class="fa fa-search" aria-hidden="true"></i>
            </a>
        </li>
        <li data-toggle="tooltip" data-placement="right" data-title="Bookmarks">
            <a href="/realtime_reporting_system/bookmarks.php" class="nav-link py-3 border-bottom {status-bookmarks}" title=""  role="tab" data-title="bookmarks" aria-controls="bookmarks" aria-selected="false">
            <i class="fa fa-bookmark"></i>
            </a>
        </li>
        <li data-toggle="tooltip" data-placement="right" data-title="Profile"  role="tab" aria-controls="profile" data-title="profile" aria-selected="false">
            <a href="#" class="nav-link py-3 border-bottom {status-profile}" title="" >
            <i class="fa fa-user"></i>
            </a>
        </li>
        <li data-toggle="tooltip" data-placement="right" data-title="Analytics"  role="tab" aria-controls="analytics"  data-title="analytics" aria-selected="false">
            <a href="#" class="nav-link py-3 border-bottom {status-analytics}" title="">
            <i class="fa fa-line-chart"></i>
            </a>
        </li>
    </ul>
    <div class="dropdown border-top">
        <a href="#" class="d-flex align-items-center justify-content-center p-3 link-dark text-decoration-none dropdown-toggle" id="dropdownUser3" data-toggle="dropdown" aria-expanded="false">
        <i class="fa fa-user"></i>
        </a>
        <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser3">
            <li><a class="dropdown-item" href="#">Settings</a></li>
            <li><a class="dropdown-item" href="#">Profile</a></li>
            <li>
                <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item" href="/realtime_reporting_system/modules/signout.php">Sign out</a></li>
        </ul>
    </div>
</div>';
    if($title == "explore"){
        $content = str_replace("{status-explore}", "active", $content);
        // $content = str_replace("{status-explore}", "", $content);
        $content = str_replace("{status-bookmarks}", "", $content);
        $content = str_replace("{status-profile}", "", $content);
        $content = str_replace("{status-analytics}", "", $content);
        $content = str_replace("{status-home}", "", $content);
    }elseif($title == "bookmarks"){
        $content = str_replace("{status-bookmarks}", "active", $content);
        $content = str_replace("{status-explore}", "", $content);
        // $content = str_replace("{status-bookmarks}", "", $content);
        $content = str_replace("{status-profile}", "", $content);
        $content = str_replace("{status-analytics}", "", $content);
        $content = str_replace("{status-home}", "", $content);
    }elseif($title == "profile"){
        $content = str_replace("{status-profile}", "active", $content);
        $content = str_replace("{status-explore}", "", $content);
        $content = str_replace("{status-bookmarks}", "", $content);
        // $content = str_replace("{status-profile}", "", $content);
        $content = str_replace("{status-analytics}", "", $content);
        $content = str_replace("{status-home}", "", $content);
    }elseif($title == "analytics"){
        $content = str_replace("{status-analytics}", "active", $content);
        $content = str_replace("{status-explore}", "", $content);
        $content = str_replace("{status-bookmarks}", "", $content);
        $content = str_replace("{status-profile}", "", $content);
        // $content = str_replace("{status-analytics}", "", $content);
        $content = str_replace("{status-home}", "", $content);
    }else if($title == "home"){
        $content = str_replace("{status-home}", "active", $content);
        $content = str_replace("{status-explore}", "", $content);
        $content = str_replace("{status-bookmarks}", "", $content);
        $content = str_replace("{status-profile}", "", $content);
        $content = str_replace("{status-analytics}", "", $content);
        // $content = str_replace("{status-home}", "", $content);
    }else{
        $content = str_replace("{status-explore}", "", $content);
        $content = str_replace("{status-bookmarks}", "", $content);
        $content = str_replace("{status-profile}", "", $content);
        $content = str_replace("{status-analytics}", "", $content);
        $content = str_replace("{status-home}", "", $content);
    }
    return $content;
}
?>