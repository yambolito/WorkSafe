 <?php 
function buildNavList($navs) {
    $navList = '<ul>';
    
    foreach ($navs as $nav) {
        $navList .= "<li><a href='/worksafe/index.php?action=" . urlencode($nav['name']) .
        "' title='View our $nav[name] '>$nav[name]</a> </li>";
    }
    
    $navList .= '</ul>';
 
    return $navList;
}
?>