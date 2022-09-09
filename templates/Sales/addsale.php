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
                                        <select class="js-client-ajax js-states form-control" name="client_id" id="client-id"></select>
                                    </div>
                                    <hr>
                                    <div class="col-md-3 py-1"><?php echo $this->Form->control('vendas', ['class' => 'input-contato', 'label' => 'Quantidade de Vendas', 'class' => 'form-control']); ?></div>
                                    <div class="col-md-3 py-1"><?php echo $this->Form->control('devolucao', ['class' => 'input-contato', 'label' => 'Quantidade de Devolução/Retorno', 'class' => 'form-control']); ?></div>
                                    <div class="col-md-3 py-1"><?php echo $this->Form->control('date_buy', ['class' => 'input-contato', 'label' => 'Data da Compra', 'class' => 'form-control']); ?></div>
                                    <div class="col-md-3 py-1"><?php echo $this->Form->control('date_devolution', ['class' => 'input-contato', 'label' => 'Data do Recolhimento', 'class' => 'form-control']); ?></div>
                                </div>
                                <legend><?= __('Endereço') ?></legend>
                                <select name="select-location" class="form-control" id="select-location">
                                    <option value="0" selected disabled>Selecione um endereço</option>
                                    <option value="1">Endereço Novo</option>
                                    <option value="2">Endereço Existente</option>
                                </select>
                                <div class="row my-3" id="imp-location"></div>
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
    $('.js-client-ajax').select2({
        placeholder: "Selecionar Usuário",
        ajax: {
            url: '<?php echo $this->Url->build(['controller' => 'get', 'action' => 'searchclient']); ?>',
            dataType: 'json'
        }
    });
    var addressNew = '<div class="col-md-3 py-1"><?php echo $this->Form->control('address', ['class' => 'input-contato', 'label' => 'Endereço', 'class' => 'form-control']); ?></div><div class="col-md-3 py-1"><?php echo $this->Form->control('complement', ['class' => 'input-contato', 'label' => 'Complemento', 'class' => 'form-control']); ?></div>';
    var addressOld = '<div class="col-md-12 py-1"><select class="js-address-ajax js-states form-control" name="location_id"></select></div>';
    $('#select-location').on('change', function() {
        var resultLocation = $("#select-location option:selected").val();
        if (resultLocation == 1) {
            $("#imp-location").html(addressNew);
        } else if (resultLocation == 2) {
            $("#imp-location").html(addressOld);
            $('.js-address-ajax').select2({
                placeholder: "Selecionar Endereço",
                ajax: {
                    url: '<?php echo $this->Url->build(['controller' => 'get', 'action' => 'searchlocation']); ?>',
                    data: function(params) {
                        if ($("#client-id option:selected").val() > 0) {
                            var query = {
                                search: params.term,
                                clientId: $("#client-id option:selected").val(),
                                type: 'public'
                            }
                            return query;
                        }
                        else {
                            alert('Informe o ID do cliente antes');
                        }
                    },
                    dataType: 'json'
                }
            });
        }
    });
</script>
