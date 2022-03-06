<main class="c-main">
    <div class="container-fluid">
        <div class="fade-in">
            <!-- /.row-->
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title mb-0">
                                Clientes
                            </h4>
                            <div class="small text-muted">
                                Editar
                            </div>
                        </div>
                    </div>

                    <div class="c-chart-wrapper my-3">
                        <div class="my-3">
                            <aside class="column">
                                <div class="side-nav">
                                    <h4 class="heading"><?= __('Ações') ?></h4>
                                    <?= $this->Html->link(__('Ver Cliente'), ['action' => 'view', $client->id], ['class' => 'side-nav-item']) ?>
                                    -
                                    <?php
                                    if ($usuarioAtual['role_id'] == 1) {
                                        echo $this->Form->postLink(__('Excluir'), ['action' => 'delete', $client->id], ['confirm' => __('Tem certeza que deseja excluir # {0}?', $client->nome), 'class' => 'side-nav-item']) . ' - ';
                                    }
                                    ?>
                                    <?= $this->Html->link(__('Clientes'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
                                    -
                                    <?= $this->Html->link(__('Adicionar Novo'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
                                </div>
                            </aside>
                        </div>
                        <div class="my-3">
                            <?= $this->Form->create($client) ?>
                            <fieldset>
                                <legend><?= __('Editar Cliente') ?></legend>
                                <?php
                                    echo $this->Form->control('name', ['label' => 'Nome', 'class' => 'form-control']);
                                    echo $this->Form->control('cpf_cnpj', ['label' => 'CPF', 'class' => 'form-control']);
                                    echo $this->Form->control('phone', ['label' => 'Telefone', 'class' => 'form-control']);
                                    echo $this->Form->control('email', ['label' => 'E-mail', 'class' => 'form-control']);
                                    echo $this->Form->control('status_id', ['options' => $statuses, 'class' => 'form-control']);
                                ?>
                            </fieldset>
                            <?= $this->Form->button(__('Salvar')) ?>
                            <?= $this->Form->end() ?>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
