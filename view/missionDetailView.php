<?php
// J'appelle ici le constructeur qui va gérer cette page:
require_once('../controller/missionDetailController.php');
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détail de la mission</title>
    <link rel="stylesheet" href="../css/missionDetailViewStyle.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="../js/missionDetailViewScript.js" defer></script>
</head>

<body>
    <!-- mainWrapper block start -->
    <div id="mainWrapper">
        <!-- navContent block start -->
        <div id="navContent">
            <a href="missionFrontListView.php"><img src="../assets/pictures/arrow.png" alt="Icone page précédente"></a>
        </div>
        <!-- navContent block end -->
        <!-- mainContainer block start -->
        <div id="mainContainer">
            <!-- Si l'une des clés d'un tableau renvoie un tableau vide aors je décide de ne pas afficher le titre de la mission -->
            <?php if (empty($allDatas['missionData']) || empty($allDatas['targets']) || empty($allDatas['agents']) || empty($allDatas['contacts']) || empty($allDatas['stashes'])) : ?>
                <h1>Aucun titre à afficher.</h1>
            <?php else : ?>
                <h1><?php echo $allMissionDatas['title']; ?></h1>
            <?php endif; ?>
            <div id="messageContent">
                <?php if (isset($missionDetailViewMessage)) : ?>
                    <p><?php echo $missionDetailViewMessage; ?></p>
                <?php endif; ?>
            </div>
            <div id="mainContent">
                <!-- Si l'une des clés d'un tableau renvoie un tableau vide aors je décide de n'afficher aucune donnée -->
                <?php if (empty($allDatas['missionData']) || empty($allDatas['targets']) || empty($allDatas['agents']) || empty($allDatas['contacts']) || empty($allDatas['stashes'])) : ?>
                    <p>Auncun détail de mission à afficher.</p>
                <?php else : ?>
                    <div class="informationColumn">
                        <p><span class="yellow bold">Code: </span><?php echo $allDatas['missionData']['codeName']; ?></p>
                        <p><span class="black bold">Statut: </span><?php echo $allDatas['missionData']['missionStatusName']; ?></p>
                        <p><span class="yellow bold">Pays: </span><?php echo $allDatas['missionData']['countryName']; ?></p>
                        <p><span class="black bold">Date de début: </span><?php echo date('d.m.Y H:i', strtotime($allDatas['missionData']['missionStart'])); ?></p>
                        <p><span class="yellow bold">Spécialité: </span><?php echo $allDatas['missionData']['specialityName']; ?></p>
                        <p>
                            <span class="black bold">Cibles(s): </span>
                            <?php foreach ($allDatas['targets'] as $key => $allTargetIdentity) : ?>
                                <?php if ($key != count($allDatas['targets']) - 1) : ?>
                                    <?php echo $allTargetIdentity . ',' ?>
                                <?php else : ?>
                                    <?php echo $allTargetIdentity . '.' ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </p>
                        <p><span class="yellow bold">Contact(s) affecté(s): </span>
                            <?php foreach ($allDatas['contacts'] as $key => $allContactIdentity) : ?>
                                <?php if ($key != count($allDatas['contacts']) - 1) : ?>
                                    <?php echo $allContactIdentity . ',' ?>
                                <?php else : ?>
                                    <?php echo $allContactIdentity . '.' ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </p>
                    </div>
                    <div class="informationColumn">
                        <p><span class="black bold">Description: </span><?php echo $allDatas['missionData']['description']; ?></p>
                        <p><span class="yellow bold">Date de fin: </span><?php echo date('d.m.Y H:i', strtotime($allDatas['missionData']['missionEnd'])); ?></p>
                        <p><span class="black bold">Type de mission: </span><?php echo $allDatas['missionData']['missionTypeName']; ?></p>
                        <p>
                            <span class="yellow bold">Agent(s) affecté(s): </span>
                            <?php foreach ($allDatas['agents'] as $key => $allAgentIdentity) : ?>
                                <?php if ($key != count($allDatas['agents']) - 1) : ?>
                                    <?php echo $allAgentIdentity . ',' ?>
                                <?php else : ?>
                                    <?php echo $allAgentIdentity . '.' ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </p>
                        <p><span class="black bold">Planque(s): </span>
                            <?php foreach ($allDatas['stashes'] as $key => $allStashIdentity) : ?>
                                <?php if ($key != count($allDatas['stashes']) - 1) : ?>
                                    <?php echo $allStashIdentity . ',' ?>
                                <?php else : ?>
                                    <?php echo $allStashIdentity . '.' ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
    <!-- mainContainer block end -->
    </div>
    <!-- mainWrapper block end -->
</body>

</html>