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
                                Preferências
                            </div>
                        </div>
                    </div>

                    <div class="c-chart-wrapper my-3">
                        <div class="my-3">
                            <?= $this->Form->create($user) ?>
                                <table class="table">
                                    <tr>
                                        <th><?= __('Mostrar Menu (Desabilitando essa função, todo o menu fica oculto)') ?></th>
                                        <td>
                                            <label class="c-switch c-switch-pill c-switch-primary">
                                                <input class="c-switch-input" name="menu_show" type="checkbox" <?php if ($user->menu_show == 1) { echo ' checked="checked"'; } ?>><span class="c-switch-slider"></span>
                                            </label>    
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><?= __('Mostrar Apenas Ícones (Esta opção você vê apenas ícones sem os nomes no menu)') ?></th>
                                        <td>
                                            <label class="c-switch c-switch-pill c-switch-primary">
                                                <input class="c-switch-input" name="menu_minimized" type="checkbox" <?php if ($user->menu_minimized == 1) { echo ' checked="checked"'; } ?>><span class="c-switch-slider"></span>
                                            </label>    
                                        </td>
                                    </tr>
                                </table>

                            <p>Lembre-se que será necessário sair da conta para atualizar seu painel logo depois da atualização.</p>
                            <?= $this->Form->button(__('Salvar'), ['class' => 'btn btn-pill mx-1 my-3 px-5 btn-primary']) ?>
                            <?= $this->Form->end() ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>