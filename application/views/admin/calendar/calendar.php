<div class="pcoded-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header card">
        <div class="row">
            <div class="col-md-8">
                <div class="page-header-title">
                    <i class="far fa-calendar bg-c-blue"></i>
                    <div class="d-inline">
                        <h4><?= $title; ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-right">



                        <?php if(has_permission('calendar-add')) { ?>
                            <button data-modal='admin/calendar/add' class="btn btn-primary btn-md waves-effect waves-light"><?= __('Add Event') ?></button>
                        <?php } ?>

                        <div class="btn-group dropdown-split-primary">

                            <button type="button" class="btn btn-primary btn-md dropdown-toggle dropdown-toggle-split waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?= __('Calendars') ?>
                            </button>
                            <div class="dropdown-menu">

                                <a class="dropdown-item waves-effect waves-light" href="<?= base_url('admin/calendar/toggle_calendars/0'); ?>">
                                    <?php if(in_array(0, $selected_calendars)) { ?>
                                        <i class="far fa-fw fa-check-square font-color-blue"></i>
                                    <?php } else { ?>
                                        <i class="far fa-fw fa-square font-color-blue"></i>
                                    <?php } ?>
                                    <?= __('Group') ?>
                                </a>


  
            



                                <div class="dropdown-divider"></div>



                                <?php foreach($staff as $item) { ?>
                                    <a class="dropdown-item waves-effect waves-light" href="<?= base_url('admin/calendar/toggle_calendars/'.$item['id']); ?>">
                                        <?php if(in_array($item['id'], $selected_calendars)) { ?>
                                            <i class="far fa-fw fa-check-square" style="color:#<?= $item['color']; ?>"></i>
                                        <?php } else { ?>
                                            <i class="far fa-fw fa-square" style="color:#<?= $item['color']; ?>"></i>
                                        <?php } ?>
                                        <?= $item['name']; ?>
                                    </a>
                                <?php } ?>


                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item waves-effect waves-light" href="<?= base_url('admin/calendar/toggle_calendars/all'); ?>"><?= __('Check all') ?></a>
                                <a class="dropdown-item waves-effect waves-light" href="<?= base_url('admin/calendar/toggle_calendars/none'); ?>"><?= __('Uncheck all') ?></a>
                            </div>
                        </div>



                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->



    <!-- Page Body start -->

    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">

                    <div class="card">
                        <div class="card-block">

                            <div id='calendar'></div>

                            <br>
                            <h6><?= __('Legend') ?></h6>
                            <ul class="list-inline">

                            
                                <li class="list-inline-item">
                                    <i class="fas fa-fw fa-square font-color-blue"></i> <?= __('Group') ?>
                                </li>

                                <?php foreach($staff as $item) { ?>
                                    <li class="list-inline-item">
                                        <i class="fas fa-fw fa-square" style="color:#<?= $item['color']; ?>"></i> <?= $item['name']; ?>
                                    </li>
                                <?php } ?>

                            </ul>


                        </div>


                    </div>



                </div>
            </div>
        </div>
    </div>

    <!-- Page Body end -->

</div>



<!-- FullCalendar -->
<link rel="stylesheet" type="text/css" href="<?= base_url()?>public/components/fullcalendar/fullcalendar.min.css">
<link rel="stylesheet" type="text/css" href="<?= base_url()?>public/components/fullcalendar/fullcalendar.print.min.css" rel='stylesheet' media='print'>

<!-- Fullcalendar -->

<script type="text/javascript" src="<?= base_url()?>public/components/fullcalendar/fullcalendar.min.js"></script>


<script>

$(document).ready(function() {

    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay,listWeek'
        },
        firstDay: <?php echo get_setting("week_start"); ?>,
        navLinks: true, // can click day/week names to navigate views
        editable: false,
        eventLimit: true, // allow "more" link when too many events
        timeFormat: 'H(:mm)',
        themeSystem: 'bootstrap4',
        height: 850,
        eventSources: [
            <?php foreach($selected_calendars as $selected_calendar) { ?>
                {
                    url: '<?= base_url('admin/calendar/events_json/'.$selected_calendar) ?>',
                    <?php if($selected_calendar == '0') { ?>
                        color: '#3a87ad',    // an option!
                    <?php } else { ?>
                        color: '#<?= $this->staff->get_color($selected_calendar) ?>',
                     <?php } ?>
                },
            <?php } ?>
        ],

        eventClick: function(event) {
            if (event.url) {
                show_modal(event.url)
                return false;
            }
        }

    });

});

</script>
