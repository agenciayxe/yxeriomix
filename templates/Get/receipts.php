<?php

$listReceipts = array();

foreach ($receipts as $receiptSingle) {

    switch ($receiptSingle['statuscost_id']) {

        case 1: $color = '#28a745'; break; 

        case 2: $color = '#c39300'; break;

        case 3: $color = '#dc3545'; break;

        default; $color = 'black'; break;

    }

    $listReceipts[] = array(

        'id' => $receiptSingle['id'],

        'title' => $receiptSingle['title'],

        'start' => $receiptSingle['date'],

        'color' => $color,

        'title_popup' => $receiptSingle['title'],

        'client' => 'teste',

        'responsible' => 'Fábio Freitas',

        'type' => 'order',

        'resourceId' => $receiptSingle['expense_id'],

        'recurrent' => false

    );

}

echo json_encode($listReceipts);

?>