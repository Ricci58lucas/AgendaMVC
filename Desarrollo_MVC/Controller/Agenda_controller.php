<?php

    require_once("Model/Agenda_model.php");

    //instanciamos la agenda
    $agenda = new Agenda_model();

    $contactosArray = $agenda->getContactosArray();

    require_once("View/Agenda_view.php"); //mostramos el array

?>