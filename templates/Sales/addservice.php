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
                            <?= $this->Form->create($service) ?>
                            <fieldset>
                                <legend><?= __('Adicionar Serviço') ?></legend>
                                <div class="row">
                                    <div class="col-md-12 my-3">
                                        <select class="js-data-example-ajax js-states form-control" name="client_id"></select>
                                    </div>
                                    <div class="col-md-6 py-1"><?php echo $this->Form->control('title', ['class' => 'input-contato', 'label' => 'Título do Serviço', 'class' => 'form-control']); ?></div>
                                    <div class="col-md-6 py-1"><?php echo $this->Form->control('status_id', ['label' => 'Status do Cliente', 'options' => $statuses, 'class' => 'form-control']); ?></div>
                                    <div class="col-md-6 py-1"><?php echo $this->Form->control('date', ['class' => 'input-contato', 'label' => 'Data', 'class' => 'form-control']); ?></div>
                                    <div class="col-md-6 py-1"><?php echo $this->Form->control('date_end', ['class' => 'input-contato', 'label' => 'Data Final', 'class' => 'form-control']); ?></div>
                                    <div class="col-md-6 py-1"><?php echo $this->Form->control('price', ['class' => 'input-contato', 'label' => 'Valor', 'class' => 'form-control']); ?></div>
                                    <div class="col-md-6 py-1"><?php echo $this->Form->control('voltagem', ['class' => 'input-contato', 'label' => 'Voltagem', 'class' => 'form-control']); ?></div>
                                    <div class="col-md-6 py-1"><?php echo $this->Form->control('technician_id', ['label' => 'Técnico Responsável', 'options' => $technicians, 'class' => 'form-control']); ?></div>
                                    <div class="col-md-6 py-1"><?php echo $this->Form->control('seller_id', ['label' => 'Vendedor ou Atendente', 'options' => $sellers, 'class' => 'form-control']); ?></div>
                                    <div class="col-md-6 py-1"><?php echo $this->Form->control('method_id', ['label' => 'Forma de Pagamento', 'options' => $methods, 'class' => 'form-control']); ?></div>
                                    <div class="col-md-6 py-1"><?php echo $this->Form->control('paid_id', ['label' => 'Status do Pagamento', 'options' => $paids, 'class' => 'form-control']); ?></div>
                                    <div class="col-md-6 py-1"><?php echo $this->Form->control('situation_id', ['class' => 'input-contato', 'label' => 'Situação do Serviço', 'options' => $situations, 'class' => 'form-control']); ?></div>
                                </div>
                                <?php echo $this->Form->control('detail', ['label' => 'Detalhes', 'type' => 'textarea', 'class' => 'form-control']); ?>
                                <?php echo $this->Form->control('observation', ['label' => 'Observação', 'type' => 'textarea', 'class' => 'form-control']); ?>
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
