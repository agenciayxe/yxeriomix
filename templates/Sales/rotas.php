<script>
function copiarTexto() {
    /* Get the text field */
    var copyText = document.getElementById("textoRota");

    /* Select the text field */
    copyText.select();
    copyText.setSelectionRange(0, 99999); /*For mobile devices*/

    /* Copy the text inside the text field */
    document.execCommand("copy");

    /* Alert the copied text */
    alert(" TEXTO COPIADO COM SUCESSO. ");
}
</script>
<main class="c-main">
    <div class="container-fluid">
        <div class="fade-in">
            <!-- /.row-->
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title mb-0">
                                Serviços
                            </h4>
                            <div class="small text-muted">
                                Rota do Técnico
                            </div>
                        </div>
                    </div>

                    <div class="c-chart-wrapper my-3">

                        <?= $this->Form->create(null, ['url' => [ 'controller' => 'services', 'action' => 'rotas'], 'type' => 'get']) ?>
                        <div class="row my-4">
                            <div class='col-md-5'>
                                <input type="date" name="datestart" class="form-control" required="required" value="<?php if ($insertDate) { echo $insertDate; } ?>" data-validity-message="Este campo precisa ser preenchido" oninvalid="this.setCustomValidity(''); if (!this.value) this.setCustomValidity(this.dataset.validityMessage)" oninput="this.setCustomValidity('')" id="date" step="1" value="">
                            </div>
                            <div class='col-md-5'>
                                <?php echo $this->Form->control('technician_id', ['class' => 'input-contato', 'label' => false, 'options' => $technicians, 'class' => 'form-control']); ?>
                            </div>
                            <div class="col-md-2">
                                <?= $this->Form->button(__('Filtrar '), ['class' => 'btn btn-pill btn-block mx-1 btn-primary']) ?>
                            </div>
                        </div>
                        <?= $this->Form->end() ?>

                        <div class="col-md-2">
                                <button class="btn btn-pill mx-1 btn-primary" onclick="copiarTexto()">Copiar texto</button>
                        </div>
                        <div class="my-3">

<?php
if ($services) {
?>
<textarea name="" class="form-control" id="textoRota" rows="100">
<?php
$n = 0;
foreach ($services as $service) {

if ($n == 0 && $technicianData) { ?>___*Rota de <?php echo $technicianData->name . ' - ' . date("d/m/Y", strtotime($service->date)); ?>*___<?php } ?>


DR.LIMPA TUDO
*OS:* <?php echo $service->os; ?>

*DATA:* <?php echo date("d/m/Y", strtotime($service->date)); ?>

*HORA:* <?php echo date("H:M", strtotime($service->date)); ?>

*NOME:* <?php echo $service->client->nome; ?>

*CPF:* <?php echo $service->client->cpf; ?>

*E-MAIL:* <?php echo $service->client->email; ?>

*TELEFONE:* <?php echo $service->client->phone; ?>

*ENDEREÇO:* <?php echo $service->client->address; ?>

*BAIRRO:* <?php echo $service->client->district; ?>

*CIDADE:* <?php echo $service->client->city; ?>

*REFERÊNCIA:* <?php echo $service->client->reference; ?>

*CEP:* <?php echo $service->client->cep; ?>

*SERVIÇO:* <?php echo $service->title; ?>

<?php echo $service->detail; ?>

<?php if ($service->voltagem) {
?>
*VOLTAGEM:* <?php echo $service->voltagem;
}
?>

*VALOR:* <?php echo number_format($service->price, 2, ',', '.') ?>

*FORMA DE PAGAMENTO:* <?php echo $service->method->title; ?>

*STATUS DO PAGAMENTO:* <?php echo $service->paid->title; ?>

*STATUS DO SERVIÇO:* <?php echo $service->situation->title; ?>

<?php if ($service->observation) {
?>
*(OBSERVAÇÃO)*
<?php
echo $service->observation;
}
?>

<?php
$detailAddress = array(
    $service->client->address,
    $service->client->district,
    $service->client->city,
    $service->client->state,
    $service->client->cep,

);
$addressComplete = implode(',', $detailAddress);
echo 'http://maps.google.com/?q=' . urlencode($addressComplete);
?>

-------------------
<?php
    $n++;
}
?>
</textarea>
<?php
}
?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

