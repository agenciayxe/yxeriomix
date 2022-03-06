<main class="c-main">
    <div class="container-fluid">
        <div class="fade-in">
            <!-- /.row-->
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title mb-0">
                                Relatórios
                            </h4>
                            <div class="small text-muted">
                                Gráficos
                            </div>
                        </div>
                    </div>

                    <div class="c-chart-wrapper my-3">
                        <div class="row">
                            <div class="col-md-6 my-3">
                                <h3>Vendas X Devoluções</h3>
                                <canvas id="comparativoVendasDevolucoes"></canvas>
                            </div>
                            <div class="col-md-6 my-3">
                                <h3>Total de Unidades vendidas</h3>
                                <canvas id="totalVendas"></canvas>
                            </div>
                            <div class="col-md-6 my-3">
                                <h3>Devoluções</h3>
                                <canvas id="totalDevolucoes"></canvas>
                            </div>
                            <div class="col-md-6 my-3">
                                <h3>Coeficientes Mensais</h3>
                                <canvas id="totalCoeficientes"></canvas>
                            </div>
                            <div class="col-md-6 my-3">
                                <h3>Total de Economia</h3>
                                <canvas id="totalEconomia"></canvas>
                            </div>
                            <div class="col-md-6 my-3">
                                <h3>Quantidade de Vendas</h3>
                                <canvas id="quantityVendas"></canvas>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script>

var ctxVlServicos = document.getElementById('comparativoVendasDevolucoes').getContext('2d');
var chartVlServicos = new Chart(ctxVlServicos, {
    type: 'line',
    data: {
        labels: [ <?php foreach ($arrayGraphics as $gpname => $gpvalue) {  echo '\'' . $gpname . '\','; } ?> ],
        datasets: [{
            label: 'Vendas',
            backgroundColor: 'rgba(0, 0, 0, 0)',
            borderColor: 'rgb(11, 46, 90)',
            data: [
                <?php foreach ($arrayGraphics as $gpname => $gpvalue) { echo '\'' . $gpvalue['totalVendas'] . '\','; } ?>
            ]
        }, {
            label: 'Devoluções',
            backgroundColor: 'rgba(0, 0, 0, 0)',
            borderColor: 'rgb(155, 0, 0)',
            data: [
                <?php foreach ($arrayGraphics as $gpname => $gpvalue) { echo '\'' . $gpvalue['totalDevolucoes'] . '\','; } ?>
            ]
        }]
    },
    options: {}
});

var ctxVlServicos = document.getElementById('totalVendas').getContext('2d');
var chartVlServicos = new Chart(ctxVlServicos, {
    type: 'line',
    data: {
        labels: [ <?php foreach ($arrayGraphics as $gpname => $gpvalue) {  echo '\'' . $gpname . '\','; } ?> ],
        datasets: [{
            label: 'Unidades vendidas',
            backgroundColor: 'rgba(0, 0, 0, 0)',
            borderColor: 'rgb(11, 46, 90)',
            data: [
                <?php foreach ($arrayGraphics as $gpname => $gpvalue) { echo '\'' . $gpvalue['totalVendas'] . '\','; } ?>
            ]
        }]
    },
    options: {}
});

var ctxVlServicos = document.getElementById('totalDevolucoes').getContext('2d');
var chartVlServicos = new Chart(ctxVlServicos, {
    type: 'line',
    data: {
        labels: [ <?php foreach ($arrayGraphics as $gpname => $gpvalue) {  echo '\'' . $gpname . '\','; } ?> ],
        datasets: [{
            label: 'Devoluções',
            backgroundColor: 'rgba(0, 181, 232, 0.2)',
            borderColor: 'rgb(11, 46, 90)',
            data: [
                <?php foreach ($arrayGraphics as $gpname => $gpvalue) { echo '\'' . $gpvalue['totalDevolucoes'] . '\','; } ?>
            ]
        }]
    },
    options: {}
});

var ctxVlServicos = document.getElementById('totalCoeficientes').getContext('2d');
var chartVlServicos = new Chart(ctxVlServicos, {
    type: 'line',
    data: {
        labels: [ <?php foreach ($arrayGraphics as $gpname => $gpvalue) {  echo '\'' . $gpname . '\','; } ?> ],
        datasets: [{
            label: 'Coeficiente',
            backgroundColor: 'rgba(0, 181, 232, 0.2)',
            borderColor: 'rgb(11, 46, 90)',
            data: [
                <?php foreach ($arrayGraphics as $gpname => $gpvalue) { echo '\'' . $gpvalue['coeficiente'] . '\','; } ?>
            ]
        }]
    },
    options: {}
});

var ctxServicos = document.getElementById('totalEconomia').getContext('2d');
var chartServicos = new Chart(ctxServicos, {
    type: 'line',
    data: {
        labels: [ <?php foreach ($arrayGraphics as $gpname => $gpvalue) {  echo '\'' . $gpname . '\','; } ?> ],
        datasets: [{
            label: 'Total Economia',
            backgroundColor: 'rgba(0, 181, 232, 0.2)',
            borderColor: 'rgb(11, 46, 90)',
            data: [
                <?php foreach ($arrayGraphics as $gpname => $gpvalue) { echo '\'' . $gpvalue['economia'] . '\','; } ?>
            ]
        }]
    },
    options: {}
});

var ctxServicos = document.getElementById('quantityVendas').getContext('2d');
var chartServicos = new Chart(ctxServicos, {
    type: 'line',
    data: {
        labels: [ <?php foreach ($arrayGraphics as $gpname => $gpvalue) {  echo '\'' . $gpname . '\','; } ?> ],
        datasets: [{
            label: 'Vendas',
            backgroundColor: 'rgba(0, 181, 232, 0.2)',
            borderColor: 'rgb(11, 46, 90)',
            data: [
                <?php foreach ($arrayGraphics as $gpname => $gpvalue) { echo '\'' . $gpvalue['quantityVendas'] . '\','; } ?>
            ]
        }]
    },
    options: {}
});
</script>
