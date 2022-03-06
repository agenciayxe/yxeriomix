<main class="c-main">
    <div class="container-fluid">
        <div class="fade-in">
            <!-- /.row-->
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title mb-0">
                                Perfil 
                            </h4>
                            <div class="small text-muted">
                                Editar
                            </div>
                        </div>
                    </div>

                    <div class="c-chart-wrapper my-3">
                        <div class="my-3">
                            <?= $this->Form->create($user) ?>
                            <fieldset>
                                <legend><?= __('Editar Meus Dados') ?></legend>
                                <?php
                                    echo $this->Form->control('name', ['label' => 'Nome', 'class' => 'form-control']);
                                    echo $this->Form->control('username', ['label' => 'Usuário', 'class' => 'form-control']);
                                    echo $this->Form->control('password', ['label' => 'Senha', 'value' => '', 'class' => 'form-control']);
                                ?>
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