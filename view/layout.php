<!DOCTYPE html>
<html>
    <head>
        <title>Construct Portal</title>
                <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
                integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
                crossorigin="anonymous">
                <link rel="stylesheet" type="text/css" href="style.css">
        <link href="https://fonts.googleapis.com/css?family=Noto+Serif" rel="stylesheet">
        <meta charset="utf-8">

    </head>
    <body>
        <nav class="one">
            <ul class="topmenu">
                <li><a href="#">Категории<i class="fa fa-angle-down"></i></a>
                    <ul class="submenu">
                        <?php
                            Controller::AllCategory();
                        ?>
                    </ul>
                </li>
                <li><a href="iwww">Инфо</a></li>
                <li><a href="./">Главная</a></li>
                <li><a href="registerForm">Зарегестрироваться</a></li>
                <div class="pull-right">
                    <li>
                        <form action="search">
                            <input type="text" name="otsi">
                            <input type="submit" value="Otsi">
                        </form>
                    </li>
                </div>
            </ul>
        </nav>
        
        <section>
            <div class="divBox">
                <?php
                if(isset($content)){
                    echo $content;
                }
                else {
                    echo '<h1>Content is gone!</h1>';
                }
                ?>
            </div>
        </section>

        <hr>
        <p style="display:block; text-align:center;">JKTV24 2026 a. &copy</p>
    </body>
    
</html>