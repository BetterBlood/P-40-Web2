<div class="container pb-5 pt-5">
    
    <div class="mastHead">
        
        <nav class="navbar navbar-expand-lg fixed-top bg-dark" id="mainNav"> <!-- TODO : remettre : bg-dark (quand il n'y a plus d'erreur, ou quand le projet est terminé)-->
            
            <div class="container">
                <!-- menu de base -->
                <a class="navbar-brand js-scroll-trigger" href="index.php?controller=home&action=index&image=0">Menu</a>
                <a class="navbar-brand js-scroll-trigger" href="index.php?controller=recipe&action=list">Recettes</a>
                <a class="navbar-brand js-scroll-trigger" href="index.php?controller=home&action=contact">Contact</a>
                
                <?php
                if(isset($_SESSION['isConnected']))
                {
                    if($_SESSION['isConnected'] == true) // vérification de la connection
                    {
                        echo '<div class="logMessage" ><a class="logOutButton btn btn-danger" href="index.php?controller=user&action=logout">Déconnexion</a>'; // déconnexion
                            echo '<a class="btn btn-warning ml-2" href="index.php?controller=user&action=profile&idUser=' . $_SESSION["idUser"] . '">profile</a>'; // accès au profile de l'utilisateur
                            //echo $_SESSION['username']; // DEBUG 
                        echo '<br><span class="logMSG">Connecté en tant que ' . $_SESSION['username'] . '</span></div>';
                    }
                    else
                    {
                        echo '<div class="collapse navbar-collapse" id="navbarResponsive">';
                            echo '<ul class="navbar-nav text-uppercase ml-auto">';
                                echo '<li class="nav-item">'; // accès au login ou au register
                                echo '<a id="login" class="nav-link btn btn-primary btn-lg text-uppercase js-scroll-trigger" class="conn" href="index.php?controller=user&action=loginForm">Login<i class="fa fa-lock"></i></a></li>';
                                echo '<li class="nav-item">';
                                echo '<a class="nav-link js-scroll-trigger" href="index.php?controller=user&action=registerForm">';
                        echo 'Register</a></li></ul></div>';
                    }
                }
                else
                {
                    $_SESSION['isConnected'] = false; // si la session n'existe pas on le set à false pour éviter des erreurs
                    echo '<div class="collapse navbar-collapse" id="navbarResponsive">';
                        echo '<ul class="navbar-nav text-uppercase ml-auto">'; // accès au login ou au register
                            echo '<li class="nav-item"><a id="login" class="nav-link btn btn-primary btn-lg text-uppercase js-scroll-trigger" class="conn" href="index.php?controller=user&action=loginForm">Login<i class="fa fa-lock"></i></a></li>';
                            echo '<li class="nav-item"><a class="nav-link js-scroll-trigger" href="index.php?controller=user&action=registerForm">Register</a></li>';
                        echo '</ul>';
                    echo '</div>';
                }
                ?>
                
            </div>
        </nav>
        
    </div>
    
    <h3 class="text-muted pt-2">Menu de votre choix</h3>