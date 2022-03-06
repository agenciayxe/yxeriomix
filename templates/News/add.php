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
                                Adicionar Novo
                            </div>
                        </div>
                    </div>

                    <div class="c-chart-wrapper my-3">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="my-3">
                                <?= $this->Form->create($new) ?>
                                <fieldset>
                                    <legend><?= __('Adicionar Notícia') ?></legend>
                                    <div class="row">
                                        <div class="col-md-12 py-1"><?php echo $this->Form->control('title', ['class' => 'input-contato', 'label' => 'Título', 'class' => 'form-control']); ?></div>
                                        <div class="col-md-12 py-1"><?php echo $this->Form->control('content', ['class' => 'input-contato', 'type' => 'textarea', 'label' => 'Conteúdo', 'class' => 'form-control']); ?></div>
                                        <div class="col-md-12 py-1"><?php echo $this->Form->control('img', ['class' => 'input-contato', 'label' => 'Imagem', 'class' => 'form-control']); ?></div>
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
        </div>
    </div>
</main>
