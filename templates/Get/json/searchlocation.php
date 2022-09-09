<?php

$listLocations = array();

foreach ($locations as $locationsSingle) {


    $listLocations['results'][] = array(

        'id' => $locationsSingle['id'],

        'text' => $locationsSingle['address'],

    );

}

echo json_encode($listLocations);

?>
