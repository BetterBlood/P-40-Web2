<h2>Login</h2>
<form method="post" action="index.php?controller=user&action=login">
    <label for="username">Nom d'utilisateur</label>
    <input type="text" name="username">
    <label for="password">Mot de Passe</label>
    <input type="password" name="password">
    <button type="submit">Connexion</button>
    <?php
    if(isset($_SESSION['errorLogin'])){
        if($_SESSION['errorLogin'] == true){
            echo 'Information(s) de login erronée(s)';
        }
    }
    ?>
</form>