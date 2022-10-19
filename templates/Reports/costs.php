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

                                Despesas

                            </div>

                        </div>

                    </div>

                    <div class="c-chart-wrapper my-3">

                        <h3>

                            <?php

                            if ($mensagemStamp) {

                                ?>

                                <h3>

                                <?php echo $mensagemStamp; ?>

                                </h3>

                                <?php

                            }

                            ?>

                        </h3>

                        <div class="main-content">

                            <form action="" method="get">

                                <div class="row my-4">

                                    <div class="col-md-3 mb-2">

                                        <input type="date" name="datestart" class="form-control" required="required" value="<?php if ($insertStart) { echo $insertStart; } ?>" data-validity-message="Este campo precisa ser preenchido" oninvalid="this.setCustomValidity(''); if (!this.value) this.setCustomValidity(this.dataset.validityMessage)" oninput="this.setCustomValidity('')" id="date" step="1" value="">

                                    </div>

                                    <div class="col-md-3 mb-2">

                                        <input type="date" name="dateend" class="form-control" required="required" value="<?php if ($insertEnd) { echo $insertEnd; } ?>" data-validity-message="Este campo precisa ser preenchido" oninvalid="this.setCustomValidity(''); if (!this.value) this.setCustomValidity(this.dataset.validityMessage)" oninput="this.setCustomValidity('')" id="date" step="1" value="">

                                    </div>

                                    <div class="col-md-3 mb-2">
                                        <?php echo $this->Form->control('statuscost_id', ['label' => false, 'options' => $statuscostsLabel, 'class' => 'form-control', 'default' => $statuscost_id]); ?>
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <?php echo $this->Form->control('expense_id', ['label' => false, 'options' => $expensesLabel, 'class' => 'form-control', 'default' => $expense_id]); ?>
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <?php echo $this->Form->control('method_id', ['label' => false, 'options' => $methodsLabel, 'class' => 'form-control', 'default' => $method_id]); ?>
                                    </div>
                                    <div class="col-md-12 py-3 no-print">

                                        <?= $this->Form->button(__('Filtrar '), ['class' => 'btn btn-pill mx-1 px-5 btn-primary float-right']) ?>

                                        <a href=javascript:print();><button type="button" class="btn btn-pill mx-1 px-5 btn-primary float-right">Imprimir Relatório</button></a>

                                        <?= $this->Html->link(__('Voltar aos Relatórios'), ['action' => 'index'], ['class' => 'btn btn-pill mx-1 px-5 btn-primary float-right']) ?>

                                    </div>

                                </div>

                                <?php

                                if ($mensagemPeriodo) {

                                    ?>

                                    <div class="alert alert-warning" role="alert">

                                    <?php echo $mensagemPeriodo; ?>

                                    </div>

                                    <?php

                                }

                                ?>

                            </form>

                        </div>

                        <div class="main-content">

                            <div class="row">

                                <div class="col-md-12">

                                    <table class="table table-sm">

                                        <thead>

                                            <tr>

                                                <th>Despesa</th>

                                                <th>Data</th>

                                                <th>Valor</th>

                                                <th>Ações</th>

                                            </tr>

                                        </thead>

                                        <tbody>

                                        <?php

                                        $vlr = 0;

                                        foreach ($costs as $cost) {

                                            $vlr = $vlr + $cost->price;

                                            ?>

                                            <tr>

                                                <td><?= $this->Html->link($cost->title, ['controller' => 'costs', 'action' => 'view', $cost->id]) ?></td>

                                                <td><?= date("d/m", strtotime($cost->date)); ?></td>

                                                <td><?php echo number_format($cost->price, 2, ',', '.') ?></td>

                                                <td>

                                               <div class="row">
                                                    <div class="col-md-4"><?php echo $this->Form->control('statuscost_id', ['class' => 'input-contato', 'label' => false, 'options' => $statuscosts, 'class' => 'form-control save-statuscost', 'id-cost' => $cost->id, 'default' => $cost->statuscost_id]); ?></div>
                                                    <div class="col-md-4"><?php echo $this->Form->control('expense_id', ['class' => 'input-contato', 'label' => false, 'options' => $expenses, 'class' => 'form-control save-expense', 'id-cost' => $cost->id, 'default' => $cost->expense_id]); ?></div>
                                                    <div class="col-md-4"><?php echo $this->Form->control('method_id', ['class' => 'input-contato', 'label' => false, 'options' => $methods, 'class' => 'form-control save-method', 'id-cost' => $cost->id, 'default' => $cost->method_id]); ?></div>
                                                </div>

                                                </td>

                                            </tr>

                                            <?php

                                        }

                                        ?>

                                        </tbody>

                                    </table>

                                </div>

                            </div>

                            <?php if (!$insertStart || !$insertStart) { ?>

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

                            <?php }

                            else {

                                ?>

                                <h3>Valor Total: R$ <?php echo number_format($vlr, 2, ',', '.') ; ?></h3>

                                <?php

                            }

                            ?>

                        </div>





                    </div>

                </div>

            </div>

        </div>

    </div>

</main>



<script>
    $(document).ready(function () {
        var statuscostAction = $(".save-statuscost");
        var methodAction = $(".save-method");
        var expenseAction = $(".save-expense");

        var saveAction = function (contentAction = false, action = false) {
            var idCost = contentAction.attr('id-cost');
            var valueCost = contentAction.val();
            var actionCost = action;
            if (contentAction != false && action != false) {
                $.post('<?php echo $this->Url->build(['controller' => 'get', 'action' => 'savecosts']); ?>', {
                    id: idCost,
                    field: actionCost,
                    value: valueCost
                })
                .done(function (contentReturn) {
                    contentResponse = JSON.parse(contentReturn);
                    console.log(contentResponse.response);
                })
                .fail(function () {
                    alert('Houve um erro ao salvar, verifique a internet ou informe o problema.');
                });
            }
        }
        statuscostAction.on('change', function () {
            saveAction($(this), 'statuscost');
        });
        methodAction.on('change', function () {
            saveAction($(this), 'method');
        });
        expenseAction.on('change', function () {
            saveAction($(this), 'expense');
        });
    })
</script>
