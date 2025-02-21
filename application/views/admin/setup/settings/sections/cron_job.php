<div class="row">
    <div class="col-md-12">


        <p><?= __('For normal system operation, onTrack requires one of the following cron jobs to be configured:'); ?></p>


        <code>*/5 * * * * php -q <?= FCPATH ?>index.php cron >/dev/null 2>&1</code>

        <br><br>
       

        <code>*/5 * * * * wget -q -O- <?= base_url('cron'); ?> >/dev/null 2>&1</code>

        <br><br><br>

        <p class="alert alert-warning"><b><?= __('Warning!') ?></b> <?= __('Set only one of the above.') ?></p>


        <p><b><?= __('Last execution: '); ?></b> <?= get_setting('cron_lastrun') ?></p>
    </div>
</div>
