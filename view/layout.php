<!DOCTYPE html>
<html>
    <head>
        <title>Construct Portal</title>
                <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
                integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
                crossorigin="anonymous">
                <link rel="stylesheet" type="text/css" href="style.css">
        <link href="https://fonts.googleapis.com/css?family=Noto+Serif" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet"> <!-- Added Roboto font -->
        <meta charset="utf-8">

    </head>
    <body>
        <nav class="one">
            <ul class="topmenu">
                <li><a href="#">Kategooriad<i class="fa fa-angle-down"></i></a>
                    <ul class="submenu">
                        <?php
                            Controller::AllCategory();
                        ?>
                    </ul>
                </li>
                <li><a href="iwww">Info</a></li>
                <li><a href="./">Stardileht</a></li>
                <li><a href="registerForm">Register</a></li>
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

        <script src="public/js/jquery-3.1.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="public/js/bootstrap.min.js"></script>
    </body>
    
</html>