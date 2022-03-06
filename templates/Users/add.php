<main class="c-main">
    <div class="container-fluid">
        <div class="fade-in">
            <!-- /.row-->
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title mb-0">
                                Administradores
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
                            <?= $this->Form->create($user) ?>
                            <fieldset>
                                <legend><?= __('Adicionar Usuário') ?></legend>
                                <?php
                                    echo $this->Form->control('name', ['label' => 'Nome', 'class' => 'form-control']);
                                    echo $this->Form->control('username', ['label' => 'Usuário', 'class' => 'form-control']);
                                    echo $this->Form->control('password', ['label' => 'Senha', 'class' => 'form-control']);
                                    echo $this->Form->control('role_id', ['options' => $roles, 'label' => 'Função', 'class' => 'form-control']);
                                ?>
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
