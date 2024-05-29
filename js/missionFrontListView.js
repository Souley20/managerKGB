// Gestion du scroll de #mainContent en cas d'un grnd nombre de mission:
if ($(".cardContainer").length > 6) {
  $("#mainContent").css("overflow-y", "scroll");
  $(".cardContainer").css("margin-bottom", "40px");
}

// Gestion de la mise en forme en cas de message d'erreur:
if ($("#messageContent p").text().length != 0) {
  $("#mainContent").css("margin", "48px 0 20px 0");
}
