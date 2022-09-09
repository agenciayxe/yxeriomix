<main class="c-main">
    <div class="container-fluid">
        <div class="fade-in">
            <!-- /.row-->
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title mb-0">
                                Relatórios
                            </h4>
                            <div class="small text-muted">
                                Lista
                            </div>
                        </div>
                    </div>

                    <div class="c-chart-wrapper my-3">
                        <div class="main-content">
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Cliente</th>
                                                <th class="text-right">Vendas </th>
                                                <th class="text-right">Devoluções </th>
                                                <th class="text-right">Coeficiente </th>
                                                <th class="text-right">Economia </th>
                                                <th class="text-right">protetrometro </th>
                                                <th class="text-right">Recolhimentos </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($clients as $client) {
                                                $idCurrent = $client->id;
                                            ?>
                                                <tr>

                                                    <td><?php echo $client->name; ?></td>
                                                    <td class="text-right"><?php echo number_format($sales[$idCurrent]['vendas'], 0, ',', '.'); ?></td>
                                                    <td class="text-right"><?php echo number_format($sales[$idCurrent]['devolucao'], 0, ',', '.'); ?></td>
                                                    <td class="text-right"><?php echo number_format($sales[$idCurrent]['coeficiente'], 3, ',', '.'); ?></td>
                                                    <td class="text-right">R$ <?php echo number_format($sales[$idCurrent]['economia'], 2, ',', '.'); ?></td>
                                                    <td class="text-right"><?php echo number_format((($sales[$idCurrent]['devolucao'] / 100) / 50), 2, ',', '.'); ?></td>
                                                    <td class="text-right"><?php echo $sales[$idCurrent]['number']; ?></td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="paginator">
                                <ul class="col-md-12 pagination">
                                    <?= $this->Paginator->first('<< ' . __('Primeira')) ?>
                                    <?= $this->Paginator->prev('< ' . __('Anterior')) ?>
                                    <?= $this->Paginator->numbers() ?>
                                    <?= $this->Paginator->next(__('Próxima') . ' >') ?>
                                    <?= $this->Paginator->last(__('Última') . ' >>') ?>
                                </ul>
                                <p><?= $this->Paginator->counter(__('Página {{page}} de {{pages}}, mostrando {{current}} resultados de {{count}} no total')) ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script>
    $(document).ready(function() {
        var paidAction = $(".save-paid");
        var methodAction = $(".save-method");
        var situationAction = $(".save-situation");

        var saveAction = function(contentAction = false, action = false) {
            var idsale = contentAction.attr('id-sale');
            var valuesale = contentAction.val();
            var actionsale = action;
            if (contentAction != false && action != false) {
                $.post('<?php echo $this->Url->build(['controller' => 'get', 'action' => 'savestatus']); ?>', {
                        id: idsale,
                        field: actionsale,
                        value: valuesale
                    })
                    .done(function(contentReturn) {
                        contentResponse = JSON.parse(contentReturn);
                        console.log(contentResponse.response);
                    })
                    .fail(function() {
                        alert('Houve um erro ao salvar, verifique a internet ou informe o problema.');
                    });
            }
        }
        paidAction.on('change', function() {
            saveAction($(this), 'paid');
        });
        methodAction.on('change', function() {
            saveAction($(this), 'method');
        });
        situationAction.on('change', function() {
            saveAction($(this), 'situation');
        });
    })
</script>
