<?php

$listSales = array();

foreach ($sales as $saleSingle) {

    switch ($saleSingle['situation_id']) {

        case 1: $color = '#c39300'; break; // Agendado - Amarelo

        case 2: $color = '#acacac'; break; // Cancelado - Cinza

        case 3: $color = '#28a745'; break; // Faturado - Verde

        case 4: $color = '#cd98fc'; break; // Reprovado - Cinza

        case 5: $color = '#c39300'; break; // Em Contato - Amarelo

        case 6: $color = '#c39300'; break; // Em Andamento - Amarelo

        case 7: $color = '#007bff'; break; // Concluído - Azul

        case 8: $color = 'black'; break; // Retorno - Preto

        case 9: $color = '#dc3545'; break; // Retorno Emergencial - Vermelho

        case 10: $color = '#A500A8'; break; // Resgate - Roxo

        case 11: $color = '#FF0095'; break; // Reagendado (Aviso ao Cliente) - Rosa

        case 12: $color = '#ec5d00'; break; // Reagendado - Laranja

        default; $color = '#73E9FF'; break; // Sem Definição - Azul piscina

    }


    $listSales[] = array(

        'id' => $saleSingle['id'],

        'title' => $saleSingle->client->name,

        'start' => $saleSingle['date_buy'],

        'end' => $saleSingle['date_devolution'],

        'color' => $color,

        'title_popup' => $saleSingle['economia_acumulado'],

        'client' => 'teste',

        'responsible' => 'Fábio Freitas',

        'type' => 'order',

        'resourceId' => $saleSingle['technician_id'],

        'recurrent' => false

    );

}

echo json_encode($listSales);

?>
