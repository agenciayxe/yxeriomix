<main class="c-main">
    <div class="container-fluid">
        <div class="fade-in">
            <!-- /.row-->
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title mb-0">
                                Leads
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
                                    <?= $this->Html->link(__('Ver Serviço'), ['action' => 'view', $contact->id], ['class' => 'side-nav-item']) ?>
                                    -
                                    <?php
                                    if ($usuarioAtual['role_id'] == 1) {
                                        echo $this->Form->postLink(__('Excluir'), ['action' => 'delete', $contact->id], ['confirm' => __('Tem certeza que deseja excluir # {0}?', $contact->title), 'class' => 'side-nav-item']) . ' - ';
                                    }
                                    ?>
                                    <?= $this->Html->link(__('Serviços'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
                                </div>
                            </aside>
                        </div>
                        <div class="my-3">
                            <?= $this->Form->create($contact) ?>
                            <fieldset>
                                <legend><?= __('Adicionar Serviço') ?></legend>
                                <div class="row">
                                    <div class="col-md-6 py-1"><?php echo $this->Form->control('name', ['class' => 'input-contato', 'label' => 'Nome', 'class' => 'form-control']); ?></div>
                                    <div class="col-md-6 py-1"><?php echo $this->Form->control('email', ['class' => 'input-contato', 'label' => 'E-mail', 'class' => 'form-control']); ?></div>
                                    <div class="col-md-6 py-1"><?php echo $this->Form->control('phone', ['class' => 'input-contato', 'label' => 'Telefone', 'class' => 'form-control']); ?></div>
                                    <div class="col-md-6 py-1"><?php echo $this->Form->control('date_created', ['class' => 'input-contato', 'label' => 'Data', 'class' => 'form-control']); ?></div>
                                </div>
                            </fieldset>
                            <?= $this->Form->button(__('Salvar'), ['class' => 'btn btn-pill mx-1 my-3 px-5 btn-primary']) ?>
                            <?= $this->Form->end() ?>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
