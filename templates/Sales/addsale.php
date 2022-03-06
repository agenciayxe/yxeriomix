<main class="c-main">
    <div class="container-fluid">
        <div class="fade-in">
            <!-- /.row-->
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title mb-0">
                                Serviços
                            </h4>
                            <div class="small text-muted">
                                Adicionar a um cliente
                            </div>
                        </div>
                    </div>
                    <div class="c-chart-wrapper my-3">
                        <div class="my-3">
                            <?= $this->Form->create($sale) ?>
                            <fieldset>
                                <legend><?= __('Adicionar Serviço') ?></legend>
                                <div class="row">
                                    <div class="col-md-12 my-3">
                                        <select class="js-data-example-ajax js-states form-control" name="client_id"></select>
                                    </div>
                                    <hr>
                                    <div class="col-md-3 py-1"><?php echo $this->Form->control('vendas', ['class' => 'input-contato', 'label' => 'Quantidade de Vendas', 'class' => 'form-control']); ?></div>
                                    <div class="col-md-3 py-1"><?php echo $this->Form->control('devolucao', ['class' => 'input-contato', 'label' => 'Quantidade de Devolução/Retorno', 'class' => 'form-control']); ?></div>
                                    <div class="col-md-3 py-1"><?php echo $this->Form->control('date_buy', ['class' => 'input-contato', 'label' => 'Data da Compra', 'class' => 'form-control']); ?></div>
                                    <div class="col-md-3 py-1"><?php echo $this->Form->control('date_devolution', ['class' => 'input-contato', 'label' => 'Data do Recolhimento', 'class' => 'form-control']); ?></div>
                                </div>
                                <legend><?= __('Endereço') ?></legend>
                                <div class="row my-3">
                                    <div class="col-md-3 py-1"><?php echo $this->Form->control('address', ['class' => 'input-contato', 'label' => 'Endereço', 'class' => 'form-control']); ?></div>
                                    <div class="col-md-3 py-1"><?php echo $this->Form->control('complement', ['class' => 'input-contato', 'label' => 'Complemento', 'class' => 'form-control']); ?></div>
                                </div>
                            </fieldset>
                            <?= $this->Form->button(__('Adicionar'), ['class' => 'btn btn-pill mx-1 my-3 px-5 btn-primary']) ?>
                            <?= $this->Form->end() ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    $('.js-data-example-ajax').select2({
        placeholder: "Selecionar Usuário",
        ajax: {
            url: '<?php echo $this->Url->build(['controller' => 'get', 'action' => 'searchclient']); ?>',
            dataType: 'json'
        }
    });
</script>
