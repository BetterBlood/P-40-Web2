<h2>Login</h2>
<form method="post" action="index.php?controller=user&action=login">
    <label for="username">Nom d'utilisateur</label>
    <input type="text" name="username"></br>
    <label for="password">Mot de Passe</label>
    <input type="password" name="password"></br>
    <button type="submit">Connexion</button></br>
    <?php
    if(isset($_SESSION['errorLogin'])){
        if($_SESSION['errorLogin'] == true){
            echo '<span class="logMSG">Information(s) de login erronée(s)</span>';
            $_SESSION['errorLogin'] = false;
        }
    }
    ?>
</form>