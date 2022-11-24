<main class="c-main">
    <div class="container-fluid">
        <div class="fade-in">
            <!-- /.row-->
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title mb-0">
                                Usuários
                            </h4>
                            <div class="small text-muted">
                                Adicionar
                            </div>
                        </div>
                    </div>
                    <div class="c-chart-wrapper my-3">
                        <div class="my-3">
                            <aside class="column">
                                <div class="side-nav">
                                    <?= $this->Html->link(__('Usuários'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
                                    -
                                    <?= $this->Html->link(__('Adicionar Novo'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
                                </div>
                            </aside>
                        </div>
                        <div class="my-3">
                            <?= $this->Form->create($customer) ?>
                            <fieldset>
                                <legend><?= __('Adicionar Usuário') ?></legend>
                                <div class="row">
                                    <div class="col-md-12 my-3">
                                        <select class="js-client-ajax js-states form-control" name="client_id" id="client-id"></select>
                                    </div>
                                    <hr>
                                    <div class="col-md-6 py-1"><?php echo $this->Form->control('name', ['label' => 'Nome da Empresa / Pessoa', 'class' => 'form-control']); ?></div>
                                    <div class="col-md-6 py-1"><?php echo $this->Form->control('cpf_cnpj', ['label' => 'CPF / CNPJ', 'class' => 'form-control']); ?></div>
                                    <hr>
                                    <div class="col-md-6 py-1"><?php echo $this->Form->control('phone', ['label' => 'Telefone', 'class' => 'form-control']); ?></div>
                                    <div class="col-md-6 py-1"><?php echo $this->Form->control('email', ['label' => 'E-mail', 'class' => 'form-control']); ?></div>
                                    <hr>
                                    <div class="col-md-6 py-1"><?php echo $this->Form->control('username', ['label' => 'Usuário', 'class' => 'form-control']); ?></div>
                                    <div class="col-md-6 py-1"><?php echo $this->Form->control('password', ['label' => 'Senha', 'value' => '', 'class' => 'form-control']); ?></div>
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
