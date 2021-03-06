<div class="container">

  <h2 class="h2">Home</h2>
    
    <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
      <ol class="carousel-indicators"> <!-- petit truc en bas -->
      <a href="index.php?controller=home&action=index&image=0">
      <?php 
        echo "<li "; // data-target='#carouselExampleCaptions' data-slide-to='0' 
        if (array_key_exists('image',$_GET) && $_GET['image'] == 0)
        {
          echo "class='active'";
        }
        echo "></li> ";
      ?>
      </a>
      <a href="index.php?controller=home&action=index&image=1">
      <?php 
        echo "<li "; // data-target='#carouselExampleCaptions' data-slide-to='1' 
        if (array_key_exists('image',$_GET) && $_GET['image'] == 1)
        {
          echo "class='active'";
        }
        echo "></li> ";
      ?>
      </a>
      <a href="index.php?controller=home&action=index&image=2">
      <?php 
        echo "<li "; // data-target='#carouselExampleCaptions' data-slide-to='2' 
        if (array_key_exists('image',$_GET) && $_GET['image'] == 2)
        {
          echo "class='active'";
        }
        echo "></li> ";
      ?>
      </a>
    </ol>
    <div class="carousel-inner">
      <?php 
        echo "<div class='carousel-item ";
        if (array_key_exists('image',$_GET) && $_GET['image'] == 0)
        {
          echo "active";
        }
        echo "'>";

        echo '<span class="bg-success rounded-top d-block w-100 text-center mb-n3 pb-3"><h3>Dernier ajout !!!</h3></span>'; // bandeau vert en haut de l'image

        echo '<img src="resources//image//Recipes//' . $lastRecipe["recImage"] . '" class="d-block w-100" alt="image de la dernière recette ajoutée au site">'; // à modifier en fonction des dernières recettes etc
        
        echo '<div class="carousel-caption d-none d-md-block bg-dark rounded-pill">';
          echo '<h4>' . $lastRecipe["recName"] . '</h4>';
          echo '<p>ajouté le : [ ' . $lastRecipe["recDate"] . ' ]</p>';
        echo '</div>';
      ?>
    </div>

      <?php 
        echo "<div class='carousel-item ";
        if (array_key_exists('image',$_GET) && $_GET['image'] == 1)
        {
          echo "active";
        }
        echo "'>";

        echo '<span class="bg-danger rounded-top d-block w-100 text-center mb-n3 pb-3"><h3>Meilleure note !!!</h3></span>'; // bandeau rouge en haut de l'image
      
        echo '<img src="resources//image//Recipes//' . $bestRecipe["recImage"] . '" class="d-block w-100" alt="image de la recette avec la meilleure note">'; // <!-- à modifier en fonction des meilleures recettes etc -->
        echo '<div class="carousel-caption d-none d-md-block bg-dark rounded-pill">';
          echo '<h4>' . $bestRecipe["recName"] . '</h4>';
          echo '<p>ajouté le : [ ' . $bestRecipe["recDate"] . ' ]</p>';
        echo '</div>';
        
      ?>
      </div>
      <?php 
        echo "<div class='carousel-item ";
        if (array_key_exists('image',$_GET) && $_GET['image'] == 2)
        {
          echo "active";
        }
        echo "'>";

        echo '<span class="bg-warning rounded-top d-block w-100 text-center mb-n3 pb-3"><h3>Recette la plus facile</h3></span>'; // bandeau jaune en haut de l'image
      
        echo '<img src="resources//image//Recipes//' . $easiestRecipe["recImage"] . '" class="d-block w-100" alt="image de la recette la plus facile">'; // <!-- à modifier en fonction des recettes les plus faciles etc -->
        echo '<div class="carousel-caption d-none d-md-block bg-dark rounded-pill">';
          echo '<h4>' . $easiestRecipe["recName"] . '</h4>';
          echo '<p>ajouté le : [ ' . $easiestRecipe["recDate"] . ' ]</p>';
        echo '</div>';
      ?>
      </div>
      </div>
      <?php 
        echo "<a class='carousel-control-prev' href='";
        if (array_key_exists('image',$_GET) && $_GET['image'] == 0)
        {
          echo "index.php?controller=home&action=index&image=2";
        }
        else if (array_key_exists('image',$_GET) && $_GET['image'] == 1)
        {
          echo "index.php?controller=home&action=index&image=0";
        }
        else if (array_key_exists('image',$_GET) && $_GET['image'] == 2)
        {
          echo "index.php?controller=home&action=index&image=1";
        }
        echo "' role='button' data-slide='prev'>";
      ?>
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <?php 
        echo "<a class='carousel-control-next' href='";
        if (array_key_exists('image',$_GET) && $_GET['image'] == 0)
        {
          echo "index.php?controller=home&action=index&image=1";
        }
        else if (array_key_exists('image',$_GET) && $_GET['image'] == 1)
        {
          echo "index.php?controller=home&action=index&image=2";
        }
        else if (array_key_exists('image',$_GET) && $_GET['image'] == 2)
        {
          echo "index.php?controller=home&action=index&image=0";
        }
        echo "' role='button' data-slide='next'>";
      ?>
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>
    <br><br>
    <div class="text-light">
      <h1>Bienvenue sur Swedish Tortilla</h1>
      <p>Ce site a pour but de recenser tous types de recettes. Nous vous invitions à toutes les essayer afin de les évaluer selon vos compétences en cuisine. Nous sommes tous des explorateurs des papilles gustatives.</p>
    </div>