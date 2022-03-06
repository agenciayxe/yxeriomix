<section class="content-title">
	<div class="container">
		<h1>Serviços</h1>
	</div>
</section>
<main class="page-clients">
    <div class="container">
        <div class="main-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="my-3">
                        <?= $this->Form->create($service) ?>
                        <fieldset>
                            <legend><?= __('Adicionar Serviço') ?></legend>
                            <?php
                                echo $this->Form->control('client_id', ['class' => 'input-contato', 'label' => 'Cliente', 'options' => $clients]);
                                echo $this->Form->control('date', ['class' => 'input-contato', 'label' => 'Data']);
                                echo $this->Form->control('title', ['class' => 'input-contato', 'label' => 'Título']);
                                echo $this->Form->control('price', ['class' => 'input-contato', 'label' => 'Valor']);
                                echo $this->Form->control('situation_id', ['class' => 'input-contato', 'label' => 'Situação', 'options' => $situations]);
                            ?>
                        </fieldset>
                        <?= $this->Form->button(__('Submit')) ?>
                        <?= $this->Form->end() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>