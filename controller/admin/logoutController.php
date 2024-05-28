<?php
// J'ai bessoin de démarrer la gestion de session:
session_start();
// Avant de me déconnecter et de retourner à la page de connexion de mon espace administration (choix de ma part), je vais supprimer toutes les  données contenues dans ma super globale pour des raisons de sécurité:
if (isset($_SESSION['userEmail']) || isset($_SESSION['userRole'])) {
    session_destroy();
}
// La suppression étant faite, je retourne donc à la page de connexion de mon espace administration:
header('Location: ../../view/admin/loginView.php');
