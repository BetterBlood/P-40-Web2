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
      
        // cook-2364221_1920.jpg
        echo '<img src="resources//image//Recipes//' . $lastRecipe["recImage"] . '" class="d-block w-100" alt="image de la dernière recette ajoutée au site">'; // à modifier en fonction des dernières recettes etc
        

      echo '<div class="carousel-caption d-none d-md-block">';
        echo '<h5>' . $lastRecipe["recName"] . '</h5>';
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
      ?>
        <img src="resources//image//egg-943413_1920.jpg" class="d-block w-100" alt="..."> <!-- à modifier en fonction des dernières recettes etc -->
        <div class="carousel-caption d-none d-md-block">
          <h5>nom de la recette ayant la meilleure notation</h5>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
        </div>
      </div>
      <?php 
        echo "<div class='carousel-item ";
        if (array_key_exists('image',$_GET) && $_GET['image'] == 2)
        {
          echo "active";
        }
        echo "'>";
      ?>
        <img src="resources//image//ingredients-498199_1920.jpg" class="d-block w-100" alt="..."> <!-- à modifier en fonction des dernières recettes etc -->
          <div class="carousel-caption d-none d-md-block">
            <h5>nom de la recette la plus facilement réalisable</h5>
            <p>Praesent commodo cursus magna, vel scelerisque nisl consectetur.</p>
          </div>
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
<br><br><br><br><br>