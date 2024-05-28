<?php
// Je vais utiliser la fonction session donc je le démarre:
session_start();
// Afin que cette page d'accueil de mon espace administration ne puisse pas être accessible si on tape son url par exemple, je décide de la protéger en utilisant la super globale $_SESSION. Si la superglobale n'est connue et que l'utilisateur n'a pas le rôle ROLE_ADMIN alors l'utilisateur sera redirigé vers la page de connexion:
if (!isset($_SESSION['userEmail']) || $_SESSION['userRole'] != 'ROLE_ADMIN') {
    header('Location: loginView.php');
}
