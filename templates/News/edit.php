<main class="c-main">
    <div class="container-fluid">
        <div class="fade-in">
            <!-- /.row-->
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title mb-0">
                                Notícias
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
                                    <?= $this->Html->link(__('Ver Serviço'), ['action' => 'view', $new->id], ['class' => 'side-nav-item']) ?>
                                    -
                                    <?php
                                    if ($usuarioAtual['role_id'] == 1) {
                                        echo $this->Form->postLink(__('Excluir'), ['action' => 'delete', $new->id], ['confirm' => __('Tem certeza que deseja excluir # {0}?', $new->title), 'class' => 'side-nav-item']) . ' - ';
                                    }
                                    ?>
                                    <?= $this->Html->link(__('Serviços'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
                                </div>
                            </aside>
                        </div>
                        <div class="my-3">
                            <?= $this->Form->create($new) ?>
                            <fieldset>
                                <legend><?= __('Adicionar Serviço') ?></legend>
                                <div class="row">
                                    <div class="col-md-12 py-1"><?php echo $this->Form->control('title', ['class' => 'input-contato', 'label' => 'Título', 'class' => 'form-control']); ?></div>
                                    <div class="col-md-12 py-1"><?php echo $this->Form->control('content', ['class' => 'input-contato', 'type' => 'textarea', 'label' => 'Conteúdo', 'class' => 'form-control']); ?></div>
                                    <div class="col-md-12 py-1"><?php echo $this->Form->control('img', ['class' => 'input-contato', 'label' => 'Imagem', 'class' => 'form-control']); ?></div>
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
