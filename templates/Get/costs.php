<?php

$listCosts = array();

foreach ($costs as $costSingle) {

    switch ($costSingle['statuscost_id']) {

        case 1: $color = '#28a745'; break; 

        case 2: $color = '#c39300'; break;

        case 3: $color = '#dc3545'; break;

        default; $color = 'black'; break;

    }

    $listCosts[] = array(

        'id' => $costSingle['id'],

        'title' => $costSingle['title'],

        'start' => $costSingle['date'],

        'color' => $color,

        'title_popup' => $costSingle['title'],

        'client' => 'teste',

        'responsible' => 'Fábio Freitas',

        'type' => 'order',

        'resourceId' => $costSingle['expense_id'],

        'recurrent' => false

    );

}

echo json_encode($listCosts);

?>