<?php $this->load->view($modal); ?>

<script type="text/javascript" src="<?= base_url()?>public/assets/js/user-modal.js"></script>

<script>
    $(document).ready(function() {

        $('#datepicker, #datepicker2, .datepicker').datepicker({
            format: '<?php echo date_js_format(); ?>',
            clearBtn: 'true',
            weekStart: '<?php echo get_setting("week_start"); ?>',
            autoclose: true
        });

        moment.updateLocale('en', {
            week: { dow: <?php echo get_setting("week_start"); ?> } // Monday is the first day of the week
        });

    });
</script>
