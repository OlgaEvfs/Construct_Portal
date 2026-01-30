<?php

echo "<li class='submenuunit'><a href='all'>ALL</a></li>";
foreach($arr as $value) {
    echo "<li class='submenuunit'>"
       . "<a href='category?id=" . $value['id'] . "'>" . $value['name'] . "</a>"
       . "</li>";
}

?>