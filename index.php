<?php

require_once './library/conections.php';
require_once './library/nav.php';
require_once './models/main-model.php';
require_once './models/personal_mode.php';

$navs = getNavs();
$navList = buildNavList($navs);

//var_dump($navs);
//exit;
//echo $navList;
//exit;

$action = isset($_GET['action']) ? $_GET['action'] : 'home';

switch ($action) {
    case 'stadistics':
        include './views/statistics.php';
        break;
    case 'Add Personal':
        include './views/addPerson.php';
        break;
    case 'Search':
        include './views/search.php';
        break;
    case 'Login':
        include './views/login.php';
        break;
    default:
        include './views/home.php';
        break;
}



?>