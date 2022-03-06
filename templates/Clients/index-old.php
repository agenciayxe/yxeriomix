<section class="content-title">
	<div class="container">
		<h1>Clientes</h1>
	</div>
</section>
<main class="page-clients">
    <div class="container">
        <div class="main-action text-right">
            <?= $this->Html->link(__('Adicionar Cliente'), ['action' => 'add'], ['class' => 'btn mt-3']) ?>
        </div>
        <div class="main-header">
            <div class="row">
                <div class="col-lg-6">
                    <div class="clients-filters">
                        <a href=""><div class="single-day">Tudo</div></a>
                        <a href=""><div class="single-day">Antigos</div></a>
                        <a href=""><div class="single-day">Recentes</div></a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <form action="<?php echo $this->Url->build(['controller' => 'clients']); ?>" class="service-search" method="GET">
                        <input name="s" type="text" placeholder="Pesquisar Serviço" class="service-input" value="<?php echo $pesquisa; ?>">
                    </form>
                </div>
            </div>
        </div>
        <div class="main-content">
            <div class="row">
            <?php
                foreach ($clients as $client) {
                    ?>
                    <div class="col-md-6">
                        <div class="box-clients">
                            <a href="<?php echo $this->Url->build(['action' => 'view', $client->id]); ?>">
                                <div class="clients-title">
                                    <div class="clients-data"><?= h($client->nome) ?></div>
                                    <div class="clients-local"><?= h($client->district) ?> (<?= h($client->city) ?>)</div>
                                </div>
                            </a>
                            <div class="clients-contact">
                                <div class="clients-whatsapp">
                                    <a href="" target="_blank"><i class="fab fa-whatsapp"></i> <?= h($client->phone) ?></a>
                                </div>
                                <div class="clients-email">
                                    <a href="" target="_blank"><i class="far fa-envelope"></i> <?= h($client->email) ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
            <div class="paginator">
                <ul class="col-md-12 pagination">
                    <?= $this->Paginator->first('<< ' . __('Primeira')) ?>
                    <?= $this->Paginator->prev('< ' . __('Anterior')) ?>
                    <?= $this->Paginator->numbers() ?>
                    <?= $this->Paginator->next(__('Próxima') . ' >') ?>
                    <?= $this->Paginator->last(__('Última') . ' >>') ?>
                </ul>
                <p><?= $this->Paginator->counter(__('Página {{page}} de {{pages}}, mostrando {{current}} resultados de {{count}} no total')) ?></p>
            </div>
        </div>
    </div>
</main>