<h2>Login</h2>
<form method="post" action="index.php?controller=user&action=register">
    <label for="username">Nom d'utilisateur</label>
    <input type="text" name="username"></br>
    <label for="firstName">Prénom</label>
    <input type="text" name="firstName"></br>
    <label for="lastName">Nom</label>
    <input type="text" name="lastName"></br>
    <label for="password1">Mot de Passe</label>
    <input type="password" name="password1"></br>
    <label for="password2">Répétez le Mot de Passe</label>
    <input type="password" name="password2"></br>
    <button type="submit">S&apos;inscrire</button></br>
    <?php
    if(isset($_SESSION['errorLogin'])){
        if($_SESSION['errorLogin'] == true){
            echo '<span class="logMSG">Information(s) d&apos;enregistrement erronée(s)</span>';
            $_SESSION['errorLogin'] = false;
        }
    }
    ?>
</form>