<?php
include './././dbinteraction/Database.php';

// TODO à placer dans Database
$database = new Database();
$usernames = $database->getAllUsernames();
$_SESSION['errorLogin'] = false;
$_SESSION['usernameExist'] = false;
foreach($usernames as $username){
    $username['usePseudo'] == $_POST['nickname'] ? $_SESSION['usernameExist'] = true : null;
}

$errorMsg = 'Information(s) de login erronée(s)';

if($_SESSION['usernameExist'] == true){
    $user = $database->getOneUser($_POST['nickname']);
    if($user['usePassword'] == $_POST['password']){
        //$_SESSION['isConnected'] == true;
        header('Location: index.php?controller=home&action=index');
    }
    else{
        $_SESSION['errorLogin'] = true;
        header('Location: index.php?controller=login&action=login');
    }
}
else{
    $_SESSION['errorLogin'] = true;
    header('Location: index.php?controller=login&action=login');
}
?>