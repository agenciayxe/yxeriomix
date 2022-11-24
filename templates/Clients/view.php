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
                                Visualizar
                            </div>
                        </div>
                    </div>

                    <div class="c-chart-wrapper my-3">
                        <div class="my-3">
                            <aside class="column">
                                <div class="side-nav">
                                    <h4 class="heading"><?= __('Ações') ?></h4>
                                    <?= $this->Html->link(__('Editar'), ['action' => 'edit', $client->id], ['class' => 'side-nav-item']) ?>
                                    -
                                    <?php
                                    if ($usuarioAtual['role_id'] == 1) {
                                        echo $this->Form->postLink(__('Excluir'), ['action' => 'delete', $client->id], ['confirm' => __('Tem certeza que deseja excluir # {0}?', $client->name), 'class' => 'side-nav-item']) . ' - ';
                                    }
                                    ?>
                                    <?= $this->Html->link(__('Clientes'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
                                    -
                                    <?= $this->Html->link(__('Adicionar Novo'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
                                </div>
                            </aside>
                        </div>
                        <div class="my-3">
                            <h3><?= h($client->name) ?></h3>
                            <table class="table">
                                <tr>
                                    <th><?= __('Identificação') ?></th>
                                    <td><?= $this->Number->format($client->id) ?></td>
                                </tr>
                                <tr>
                                    <th><?= __('Nome') ?></th>
                                    <td><?= h($client->name) ?></td>
                                </tr>
                                <tr>
                                    <th><?= __('CPF') ?></th>
                                    <td><?= h($client->cpf_cnpj) ?></td>
                                </tr>
                                <tr>
                                    <th><?= __('Telefone') ?></th>
                                    <td>
                                        <?php
                                        $telefone = $client->phone;
                                        $phoneNumber = preg_replace("/[^0-9]/", "", $client->phone);
                                        $phoneQuantity = strlen($phoneNumber);
                                        $link = ($phoneQuantity == 9 || $phoneQuantity == 11) ? 'https://api.whatsapp.com/send?phone=+55' . $phoneNumber : 'tel:+55' . $phoneNumber;
                                        ?>
                                        <a href="<?php echo $link; ?>" target="_blank"><?= h($client->phone) ?></a>
                                    </td>
                                </tr>
                                <tr>
                                    <th><?= __('Email') ?></th>
                                    <td><?= h($client->email) ?></td>
                                </tr>
                                <tr>
                                    <th><?= __('Status') ?></th>
                                    <td><?= $client->has('status') ? $client->status->title : '' ?></td>
                                </tr>
                            </table>
                            <div class="related">
                                <?php if (!empty($listCustomers)) : ?>
                                <h4 class="my-2"><?= __('Usuários') ?></h4>
                                <div class="table-responsive">
                                    <table class="table">

                                        <thead>
                                            <tr>
                                                <th>Usuário</th>
                                                <th>Nome</th>
                                                <th>E-mail</th>
                                                <th>Telefone</th>
                                                <th class="actions"><?= __('Ações') ?></th>
                                            </tr>
                                        </thead>
                                        <?php
                                        foreach ($listCustomers as $singleCustomer) : ?>
                                        <tbody>
                                            <tr class="item-36896">
                                                <td data-th="Usuário">
                                                    <span class="nowrap"><?php echo $singleCustomer->username; ?></span>
                                                </td>
                                                <td data-th="Nome">
                                                    <span class="nowrap"><?php echo $singleCustomer->name; ?></span>
                                                </td>
                                                <td data-th="E-mail">
                                                    <span class="nowrap"><?php echo $singleCustomer->email; ?></span>
                                                </td>
                                                <td data-th="Telefone">
                                                    <span class="nowrap"><?php echo $singleCustomer->phone; ?></span>
                                                </td>
                                                <td class="actions">
                                                    <?php echo $this->Html->link(__('Ver Usuário'), ['controller' => 'Customers', 'action' => 'view', $singleCustomer->id], ['class' => 'btn btn-pill mx-1 px-5 btn-primary']) ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <?php endforeach; ?>
                                    </table>
                                </div>
                                <?php endif; ?>
                            </div>
                            <div class="related">
                                <h4 class="my-2"><?= __('Recolhimentos') ?></h4>
                                <?php if (!empty($client->sales)) : ?>
                                <div class="table-responsive">
                                    <table class="table">

                                        <thead>
                                            <tr>
                                                <th>Última Devolução</th>
                                                <th>Economia no Mês</th>
                                                <th>Economia Acumulado</th>
                                                <th class="actions"><?= __('Ações') ?></th>
                                            </tr>
                                        </thead>
                                        <?php
                                        $addressId = false;
                                        foreach ($sales as $saleSingle) : ?>

                                        <?php
                                        if ($addressId != $saleSingle->location_id) {
                                            $addressId = $saleSingle->location_id;
                                            ?>
                                            <tbody>
                                                <tr class="bg-light text-dark">
                                                    <th colspan="4">
                                                        <?php echo $saleSingle->location->address; ?>
                                                    </th>
                                                </tr>
                                            </tbody>
                                            <?php
                                        }
                                        ?>
                                        <tbody>
                                            <tr class="item-36896">
                                                <td data-th="Última Devolução">
                                                    <p><?php echo date("d/m/Y", strtotime($saleSingle->date_devolution)); ?></p>
                                                </td>
                                                <td data-th="Economia no Mês">
                                                    <span class="nowrap">
                                                        R$ <?php $printEconomia = ($saleSingle->economia) ? number_format($saleSingle->economia, 2, ',', '.') : '0,00'; echo $printEconomia; ?>
                                                    </span>
                                                </td>
                                                <td data-th="Economia Acumulado">
                                                    <span class="nowrap">
                                                        R$ <?php $printEconomiaAcumulado = ($saleSingle->economia_acumulado) ? number_format($saleSingle->economia_acumulado, 2, ',', '.') : '0,00'; echo $printEconomiaAcumulado; ?>
                                                    </span>
                                                </td>
                                                <td class="actions">
                                                    <?php echo $this->Html->link(__('Ver Serviço'), ['controller' => 'Sales', 'action' => 'view', $saleSingle->id], ['class' => 'btn btn-pill mx-1 px-5 btn-primary']) ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <?php endforeach; ?>
                                    </table>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

