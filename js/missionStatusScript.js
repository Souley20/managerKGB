// Gestion de la mise en forme en cas de message d'erreur lors de la soumission du formulaire d'ajout ou de modification:
if ($("#formMessage p").text().length != 0) {
  $("#mainContent").css("margin-top", "127px");
  $("#formMessage").css("margin-bottom", "142px");
  $("#missionStatusForm input:first-child").css("margin-bottom", "142px");
}

// Gestion de la mise en forme en cas de message d'erreur lors de la confirmation de suppression:
if ($("#messageContent p").text().length != 0) {
  $("#mainContent").css("height", "561px");
}
