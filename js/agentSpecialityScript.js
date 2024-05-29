// Gestion de la mise en forme en cas de message d'erreur lors de la soumission du formulaire d'ajout ou de modification:
if ($("#formMessage p").text().length != 0) {
  $("#mainContent").css("margin-top", "146px");
  $("#formMessage").css("margin-bottom", "50px");
  $("#agentSpecialityForm select:last-of-type").css("margin-bottom", "146px");
}

// Gestion du scroll dans le cas d'un grand nombre d'agents avec leurs spécialités:
if ($("#agentSpecialityListContainer").height() > 632) {
  $("#mainContent").css({ "align-items": "normal", "overflow-y": "scroll" });
}
