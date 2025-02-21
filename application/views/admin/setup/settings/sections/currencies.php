<div class="row">
    <div class="col-md-12">


        <div class="dt-responsive table-responsive">

            <table id="DataTables" class="table table-striped table-bordered nowrap">
                <thead>
                    <tr>
                        <th><?= __('ID') ?></th>
                        <th><?= __('Code') ?></th>
                        <th><?= __('Prefix') ?></th>
                        <th><?= __('Suffix') ?></th>
                        <th><?= __('Rate') ?></th>
                        <th class="text-right no-sort"><?= __('Actions') ?></th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach($currencies as $currency) { ?>
                        <tr>
                            <td><?= $currency['id']; ?></td>
                            <td>
                                <?= $currency['code']; ?>
                                <?php if($currency['id'] == get_setting('default_currency')) { ?>
                                    <span class="label label-primary"><?= __('Default') ?></span>
                                <?php } ?>
                            </td>
                            <td><?= $currency['prefix']; ?></td>
                            <td><?= $currency['suffix']; ?></td>
                            <td>
                                <?= $currency['rate']; ?>

                            </td>
                            <td class="text-right">
                                <div class="btn-group" role="group">
                                    <button data-modal="admin/setup/settings/edit_currency/<?= $currency['id']; ?>" data-toggle="tooltip" title="<?= __('Edit Currency') ?>" type="button" class="btn btn-success btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-edit"></i></button>
                                    <button data-modal="admin/setup/settings/delete_currency/<?= $currency['id']; ?>" data-toggle="tooltip" title="<?= __('Delete Currency') ?>" type="button" class="btn btn-danger btn-mini waves-effect waves-dark"><i class="fas fa-fw fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>

            </table>

        </div>



        <?= form_open(base_url('admin/setup/settings/currencies'), 'data-toggle="validator"'); ?>

            <h6><?= __('Exchange Rates Auto Update'); ?></h6>
            <hr>

            <p class="alert alert-info">
                <?= __('You can setup onTrack to automatically update the exchnage rates daily from fixer.io.'); ?><br>
                <?= __('The free account from fixer.io will be enough to update daily for up to three currencies.'); ?>
            </p>

            <p class="alert alert-warning">
                <?= __('The exchange rate will be fetched based on your default currency (base currency).'); ?><br>
                <?= __('The default currency (base currency) exchange rate will always be 1.'); ?>

            </p>

            <div class="form-group">
                <label class=""><?php _e('Exchange Rates Provider'); ?></label>
                <select class="form-control select2" name="exchange_rates_provider">
                    <option <?php if(get_setting('exchange_rates_provider') == '') echo 'selected'; ?> value=""><?= __('None') ?></option>
                    <option <?php if(get_setting('exchange_rates_provider') == 'fixer.io') echo 'selected'; ?> value="fixer.io">fixer.io</option>
                    <option <?php if(get_setting('exchange_rates_provider') == 'bnro.ro') echo 'selected'; ?> value="bnro.ro">bnro.ro</option>
                </select>
            </div>

            <div class="form-group">
                <label class=""><?= __("Api Key") ?></label>
                <input type="text" class="form-control" name="exchange_rates_provider_key" value="<?= get_setting('exchange_rates_provider_key'); ?>" >
                <span class="help-block with-errors messages text-danger"></span>
            </div>



            <div class="text-right">
                <button type="submit" class="btn btn-success waves-effect waves-light "><?= __("Save Changes") ?></button>
            </div>

        <?= form_close(); ?>

                                    
        <p class=""><?= __('Last sync') ?> <b><?= exrate_latest_date_formated(); ?></b></p>
        <p><a href="<?= base_url('cron/currencies_manual_update'); ?>"><?= __('Update now') ?></a></p>






    </div>
</div>



<script type="text/javascript">
    $(document).ready(function() {

        $('#DataTables').DataTable({
            "processing": true,
            "stateSave": true,
            "fixedHeader": true,
        });

    });
</script>
