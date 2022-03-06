<?php

$listClients = array();

foreach ($clients as $clientsSingle) {


    $listClients['results'][] = array(

        'id' => $clientsSingle['id'],

        'text' => $clientsSingle['name'],

    );

}

echo json_encode($listClients);

?>
