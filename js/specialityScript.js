// Gestion de la mise en forme en cas de message d'erreur lors de la soumission du formulaire d'ajout ou de modification:
if ($("#formMessage p").text().length != 0) {
  $("#mainContent").css("margin-top", "127px");
  $("#formMessage").css("margin-bottom", "142px");
  $("#specialityForm input:first-child").css("margin-bottom", "142px");
}

// Gestion de la mise en forme en cas de message d'erreur lors de la confirmation de suppression:
if ($("#messageContent p").text().length != 0) {
  $("#mainContent").css("height", "561px");
}

// Gestion du scroll dans le cas d'un grand nombre de spécialités:
if ($("#specialityListContainer").height() > 632) {
  $("#mainContent").css({ "align-items": "normal", "overflow-y": "scroll" });
}
