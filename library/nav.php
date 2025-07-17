<?php

function getNavs(){
    $db = dataPrueba(); 
    $sql = 'SELECT name, navId FROM nav 
            ORDER BY 
                CASE 
                    WHEN name = "Home" THEN 0 
                    WHEN name = "Login" THEN 2 
                    ELSE 1 
                END, 
                name ASC'; 
    $stmt = $db->prepare($sql);
    $stmt->execute(); 
    $classnav = $stmt->fetchAll(); 
    $stmt->closeCursor(); 
    return $classnav;
}