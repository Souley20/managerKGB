// Gestion de la mise en forme en cas de message d'erreur lors de la soumission du formulaire d'ajout ou de modification:
if ($("#formMessage p").text().length != 0) {
  $("#mainContent").css("margin-top", "51px");
  $("#formMessage").css("margin-bottom", "40px");
  $("#mainContent h2").css("margin-bottom", "40px");
  $("#userForm select").css("margin", "20px 0px 51px 0px");
}

// Gestion de la mise en forme en cas de message d'erreur lors de la confirmation de suppression:
if ($("#messageContent p").text().length != 0) {
  $("#mainContent").css("height", "561px");
}

// Gestion du scroll dans le cas d'un grand nombre d'utilisateurs:
if ($("#userListContainer").height() > 632) {
  $("#mainContent").css({ "align-items": "normal", "overflow-y": "scroll" });
}
