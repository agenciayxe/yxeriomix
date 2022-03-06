<style>
.disabled .fc-day-content {
    background-color: #123959 !important;
    color: #FFFFFF;
    cursor: default;
}
</style>
<main class="c-main">
    <div class="container-fluid">
        <div class="fade-in">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title mb-0">Serviços</h4>
                            <div class="small text-muted">Calendário</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mt-3">
                            <form action="<?php echo $this->Url->build(['controller' => 'sales', 'action' => 'pesquisa']); ?>" class="service-search" method="GET">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input name="s" type="text" placeholder="Pesquisar Serviço" class="service-input form-control" value="">
                                            </div>
                                            <div class="col-md-6">
                                                <button type="submit" class="btn btn-pill mx-1 px-5 btn-primary">Filtrar</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <?= $this->Html->link(__('Adicionar Serviço'), ['action' => 'add'], ['class' => 'btn btn-pill float-right mx-1 btn-primary']) ?>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="c-chart-wrapper my-3">
                        <div id='script-warning' style="display: none;"><div class="alert alert-danger text-center" role="alert">Dados do calendário não foram recebidos.</div></div>
                        <div id='loading'><div class="alert alert-warning text-center" role="alert">Carregando...</div></div>
                        <div id='calendar'></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php
$listTech = array();
$listTech[] = array( 'id' => 0, 'title' => 'Sem Técnico' );
foreach ($technicians as $technicianSingle) {
    $listTech[] = array(
        'id' => $technicianSingle->id,
        'title' => $technicianSingle->name
    );
}
$listTech = json_encode($listTech);
?>
<script src="<?php echo $this->Url->build('/'); ?>calendar/main.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            slotMinTime: "08:00:00",
            slotMaxTime: "23:00:00",
            schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives',
            timeZone: 'America/Bahia',
            locales: 'pt-br',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,resourceTimeGridDay,listWeek'
            },
	        resources: <?php echo $listTech; ?>,
            initialDate: Date.now(),
            editable: true,
            navLinks: true,
            dayMaxEvents: true,
            eventClick: function(info) {
                window.location.href = '<?php echo $this->Url->build(['controller' => 'sales', 'action' => 'view']); ?>/' + info.event.id;
            },
            eventDrop: function(info) {
                var id = info.event.id;
                console.log(info.event.id);
                var title = info.event.title;
                var newData = info.event.startStr;
	            try { var technician_id = info.newResource.id; } catch (err) { var technician_id = { };}
                $.post('<?php echo $this->Url->build(['controller' => 'get', 'action' => 'editservice']); ?>', {
                    id: id,
                    date: newData,
                    technician_id
                }).done();
            },
            events: {
                url: '<?php echo $this->Url->build(['controller' => 'get', 'action' => 'sales']); ?>',
                failure: function() {
                    document.getElementById('script-warning').style.display = 'block'
                }
            },
            loading: function(bool) {
                document.getElementById('loading').style.display =
                    bool ? 'block' : 'none';
            }
        });
        calendar.render();
    });
</script>
