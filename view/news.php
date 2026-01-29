<?php
class ViewNews {

    public static function NewsByCategory($arr) {
        foreach($arr as $value) {
            //если есть видео показываем - показываем его
            if (!empty($value['video'])) {
                echo '<video width="250" controls>';
                echo '<source src="'.$value['video'].'" type="video/mp4">';
                echo '</video><br>';
                //иначе показываем картинку
            } elseif (!empty($value['picture'])) {
                echo '<img src="data:image/jpeg;base64,'.base64_encode( $value['picture'] ).'"width=250><br>';
            }
            
            echo "<h2>".$value['title']."</h2>";
            Controller::CommentsCount($value['id']);
            echo "<a href='news?id=".$value['id']."'>Edasi</a><br>";
        }
    }

    public static function AllNews($arr) {
        foreach($arr as $value) {
            echo "<li>".$value['title'];
            Controller::CommentsCount($value['id']);
            echo "<a href='news?id=".$value['id']."'>Edasi</a></li><br>";
        }
    }

    public static function ReadNews($n) {
        echo "<h2>".$n['title']."</h2>";
        Controller::CommentsCountWithAncor($n['id']);
        echo '<br>';
        
        //Видео
        if (!empty($n['video'])) {
            echo '<video width="400" controls>';
            echo '<source src="'.$n['video'].'" type="video/mp4">';
            echo '</video><br>';
            //Картинка
        } elseif (!empty($n['picture'])) {
            echo '<img src="data:image/jpeg;base64,'.base64_encode( $n['picture'] ).'" width=300><br>';
        }

        echo "<p>".$n['text']."</p>";

    }

}//end class

?>