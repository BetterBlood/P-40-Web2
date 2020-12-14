<div class="container">
    
    <div class="mastHead">
        
        <nav class="navbar navbar-expand-lg fixed-top bg-dark" id="mainNav">
            
            <div class="container">
                
                <a class="navbar-brand js-scroll-trigger" href="index.php?controller=home&action=index&image=0">Menu</a>
                <a class="navbar-brand js-scroll-trigger" href="index.php?controller=recipe&action=list">Recettes</a>
                <a class="navbar-brand js-scroll-trigger" href="index.php?controller=home&action=contact">Contact</a>
                <?php
                if(isset($_SESSION['isConnected'])){
                    if($_SESSION['isConnected'] == true){
                        echo '<div class="logMessage" ><a href="index.php?controller=user&action=logout"><button class="logOutButton">Déconnexion</button></a>';
                        echo '<span class="logMSG">Connecté en tant que ' . $_SESSION['username'] . '</span></div>';
                        echo $_SESSION['username'];
                    }
                    else{
                        echo '<div class="collapse navbar-collapse" id="navbarResponsive">';
                        echo '<ul class="navbar-nav text-uppercase ml-auto">';
                        echo '<li class="nav-item">';
                        echo '<a id="login" class="nav-link btn btn-primary btn-lg text-uppercase js-scroll-trigger" class="conn" href="index.php?controller=user&action=loginForm">Login<i class="fa fa-lock"></i></a></li>';
                        echo '<li class="nav-item">';
                        echo '<a class="nav-link js-scroll-trigger" href="index.php?controller=user&action=registerForm">';
                        echo 'Register</a></li></ul></div>';
                    }
                }
                else{
                    $_SESSION['isConnected'] = false;
                    echo '<div class="collapse navbar-collapse" id="navbarResponsive">';
                    echo '<ul class="navbar-nav text-uppercase ml-auto">';
                    echo '<li class="nav-item">';
                    echo '<a id="login" class="nav-link btn btn-primary btn-lg text-uppercase js-scroll-trigger" class="conn" href="index.php?controller=user&action=loginForm">Login<i class="fa fa-lock"></i></a></li>';
                    echo '<li class="nav-item">';
                    echo '<a class="nav-link js-scroll-trigger" href="index.php?controller=user&action=registerForm">';
                    echo 'Register</a></li></ul></div>';
                }
                ?>
            </div>
        </nav>
        
    </div>
    <br>
    <br>
    <h3 class="text-muted">Menu de votre choix</h3>