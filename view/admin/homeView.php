<?php
// J'appelle ici le constructeur qui va gérer cette page:
require_once('../../controller/admin/homeController.php');
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace administration - Accueil</title>
    <link rel="stylesheet" href="../../css/homeViewStyle.css">
</head>

<body>
    <!-- mainWrapper block start -->
    <div id="mainWrapper">
        <!-- navContent block start -->
        <div id="navContent">
            <a href="../../controller/admin/logoutController.php"><img src="../../assets//pictures//logout.png" alt="Icone déconnexion"></a>
        </div>
        <!-- navContent block end -->
        <!-- mainContainer block start -->
        <div id="mainContainer">
            <div class="cardContainer">
                <div class="menuNumberContent">
                    <p>1</p>
                </div>
                <div class="menuActionContainer">
                    <p>Spécialité</p>
                    <div class="menuActionButton">
                        <p><a href="specialityFormView.php">Ajoutez</a></p>
                        <p><a href="specialityListView.php">Listez</a></p>
                    </div>
                </div>
            </div>
            <div class="cardContainer">
                <div class="menuNumberContent">
                    <p>2</p>
                </div>
                <div class="menuActionContainer">
                    <p>Type de mission</p>
                    <div class="menuActionButton">
                        <p><a href="missionTypeFormView.php">Ajoutez</a></p>
                        <p><a href="missionTypeListView.php">Listez</a></p>
                    </div>
                </div>
            </div>
            <div class="cardContainer">
                <div class="menuNumberContent">
                    <p>3</p>
                </div>
                <div class="menuActionContainer">
                    <p>Statut de mission</p>
                    <div class="menuActionButton">
                        <p><a href="missionStatusFormView.php">Ajoutez</a></p>
                        <p><a href="missionStatusListView.php">Listez</a></p>
                    </div>
                </div>
            </div>
            <div class="cardContainer">
                <div class="menuNumberContent">
                    <p>4</p>
                </div>
                <div class="menuActionContainer">
                    <p>Nationalité</p>
                    <div class="menuActionButton">
                        <p><a href="nationalityCountryFormView.php">Ajoutez</a></p>
                        <p><a href="nationalityCountryListView.php">Listez</a></p>
                    </div>
                </div>
            </div>
            <div class="cardContainer">
                <div class="menuNumberContent">
                    <p>5</p>
                </div>
                <div class="menuActionContainer">
                    <p>Mission</p>
                    <div class="menuActionButton">
                        <p><a href="missionFormView.php">Ajoutez</a></p>
                        <p><a href="missionListView.php">Listez</a></p>
                    </div>
                </div>
            </div>
            <div class="cardContainer">
                <div class="menuNumberContent">
                    <p>6</p>
                </div>
                <div class="menuActionContainer">
                    <p>Planque</p>
                    <div class="menuActionButton">
                        <p><a href="stashFormView.php">Ajoutez</a></p>
                        <p><a href="stashListView.php">Listez</a></p>
                    </div>
                </div>
            </div>
            <div class="cardContainer">
                <div class="menuNumberContent">
                    <p>7</p>
                </div>
                <div class="menuActionContainer">
                    <p>Contact</p>
                    <div class="menuActionButton">
                        <p><a href="contactFormView.php">Ajoutez</a></p>
                        <p><a href="contactListView.php">Listez</a></p>
                    </div>
                </div>
            </div>
            <div class="cardContainer">
                <div class="menuNumberContent">
                    <p>8</p>
                </div>
                <div class="menuActionContainer">
                    <p>Cible</p>
                    <div class="menuActionButton">
                        <p><a href="targetFormView.php">Ajoutez</a></p>
                        <p><a href="targetListView.php">Listez</a></p>
                    </div>
                </div>
            </div>
            <div class="cardContainer">
                <div class="menuNumberContent">
                    <p>9</p>
                </div>
                <div class="menuActionContainer">
                    <p>Agent</p>
                    <div class="menuActionButton">
                        <p><a href="agentFormView.php">Ajoutez</a></p>
                        <p><a href="agentListView.php">Listez</a></p>
                    </div>
                </div>
            </div>
            <div class="cardContainer">
                <div class="menuNumberContent">
                    <p>10</p>
                </div>
                <div class="menuActionContainer">
                    <p>Agent / Spécialté</p>
                    <div class="menuActionButton">
                        <p><a href="agentSpecialityFormView.php">Ajoutez</a></p>
                        <p><a href="agentSpecialityListView.php">Listez</a></p>
                    </div>
                </div>
            </div>
            <div class="cardContainer">
                <div class="menuNumberContent">
                    <p>11</p>
                </div>
                <div class="menuActionContainer">
                    <p>Rôle</p>
                    <div class="menuActionButton">
                        <p><a href="roleFormView.php">Ajoutez</a></p>
                        <p><a href="roleListView.php">Listez</a></p>
                    </div>
                </div>
            </div>
            <div class="cardContainer">
                <div class="menuNumberContent">
                    <p>12</p>
                </div>
                <div class="menuActionContainer">
                    <p>Utilisateur</p>
                    <div class="menuActionButton">
                        <p><a href="userFormView.php">Ajoutez</a></p>
                        <p><a href="userListView.php">Listez</a></p>
                    </div>
                </div>
            </div>
        </div>
        <!-- mainContainer block end -->
    </div>
    <!-- mainWrapper block end -->
</body>

</html>