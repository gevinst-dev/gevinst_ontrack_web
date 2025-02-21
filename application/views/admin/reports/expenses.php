<div class="pcoded-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header card">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header-title">
                    <i class="fas fa-chart-bar bg-c-blue"></i>
                    <div class="d-inline">
                        <h4><?= $title; ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-12 m-t-20">

                <div class="text-left">
                    <?= form_open(base_url('admin/reports/index/set_filters')); ?>

                        <div class="row">


                        <div class="col-md-2">
                                <input type="text" class="form-control" name="filter_start onchange-submit" id="datepicker" value="<?= date_display($_SESSION['filter_start']) ?>">
                                <p>&nbsp;</p>
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="form-control" name="filter_end onchange-submit" id="datepicker2" value="<?= date_display($_SESSION['filter_end']) ?>">
                                <p>&nbsp;</p>
                            </div>
                            
                           <div class="col-md-4">
                                <select class="form-control select2 onchange-submit" name="filter_currency_id" required>
                                    <?php foreach ($currencies as $item) { ?>
                                        <option value="<?php echo $item['id']; ?>" <?php if($this->session->filter_currency_id == $item['id']) echo "selected"; ?> ><?php echo $item['code']; ?></option>
                                    <?php } ?>
                                </select>

                                <p>&nbsp;</p>
                            </div>

                            <div class="col-md-4">

                                <select class="form-control select2 onchange-submit" name="filter_entity_id" required>
                                    <option value=""><?= __('- All Entities -') ?></option>
                                    <?php foreach ($entities as $item) { ?>
                                        <option value="<?php echo $item['id']; ?>" <?php if($this->session->filter_entity_id == $item['id']) echo "selected"; ?> ><?php echo $item['name']; ?></option>
                                    <?php } ?>
                                </select>

                                <p>&nbsp;</p>
                            </div>

                            <div class="col-md-4">

                                <select class="form-control select2 onchange-submit" name="filter_supplier_id" required>
                                    <option value=""><?= __('- All Suppliers -') ?></option>
                                    <?php foreach ($suppliers as $item) { ?>
                                        <option value="<?php echo $item['id']; ?>" <?php if($this->session->filter_supplier_id == $item['id']) echo "selected"; ?> ><?php echo $item['name']; ?></option>
                                    <?php } ?>
                                </select>

                                <p>&nbsp;</p>
                            </div>

                            <div class="col-md-4">

                                <select class="form-control select2 onchange-submit" name="filter_invoice_status" required>
                                    <option value=""><?= __('- All Statuses -') ?></option>
                                   
                                    <option value="Valid" <?php if($this->session->filter_invoice_status == 'Valid') echo "selected"; ?> ><?= __('Valid'); ?></option>
                                    <option value="Draft" <?php if($this->session->filter_invoice_status == 'Draft') echo "selected"; ?> ><?= __('Draft'); ?></option>
                                    <option value="Canceled" <?php if($this->session->filter_invoice_status == 'Canceled') echo "selected"; ?> ><?= __('Canceled'); ?></option>
                                    
                                </select>

                                <p>&nbsp;</p>
                            </div>


                        </div>

                    <?= form_close(); ?>
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->



    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">




                    <div class="card">
                        <div class="card-block">



                            <div class="dt-responsive table-responsive">

                                <table id="DataTables" class="table table-striped table-bordered nowrap">
                                    <thead>
                                        <tr>
                                            <th><?= __('ID #') ?></th>
                                            <th><?= __('Description') ?></th>
                                            <th><?= __('Entity') ?></th>
                                            <th><?= __('Supplier') ?></th>
                                            <th><?= __('Date') ?></th>
                                  
                                            <th><?= __('Value') ?></th>
                                            <th><?= __('Tax') ?></th>
                                            <th><?= __('Total') ?></th>
                                     
                                            <th><?= __('Currency') ?></th>
                                            <th><?= __('Status') ?></th>



                                        </tr>

                                    </thead>

                                    <tbody>
                                        <?php
                                            $value = 0;
                                            $tax = 0;
                                            $total = 0;
                                     
                                        ?>
                                    
                                        <?php foreach ($items as $item) { ?>
                                            <tr>


                                                <td><?= $item['id']; ?></td>
                                                <td><?= $item['description']; ?></td>
                                                <td><?= get_entity_title($item['entity_id']); ?></td>
                                                <td><?= get_supplier_name($item['supplier_id']); ?></td>

                                                <td data-sort="<?= $item['date']; ?>"><?= date_display($item['date']); ?></td>
                                        

                                                <td><?= $item['value']; ?></td>
                                                <td><?= $item['tax']; ?></td>
                                                <td><?= $item['total']; ?></td>
                          

                                                <td><?= get_currency_name($item['currency_id']); ?></td>

                                                <td><?= __($item['status']); ?></td>

                                                <?php
                                                    $value += $item['value'];
                                                    $tax += $item['tax'];
                                                    $total += $item['total'];
                                     
                                                ?>

                                            </tr>
                                        <?php } ?>
                                    </tbody>

                                    <tfoot>

                                            <tr>
                                                <th colspan="5"><?= __('TOTALS') ?></th>
                                                <th><?= $value ?></th>
                                                <th><?= $tax ?></th>
                                                <th><?= $total ?></th>
                               

                                                <th colspan="2"></th>
                                            </tr>

                                    </tfoot>

                                </table>

                            </div>


                        </div>

                    </div>





                </div>
            </div>
        </div>
    </div>


</div>


<script type="text/javascript">
    $(document).ready(function() {

        $('#DataTables').DataTable({
            "processing": true,
            "stateSave": true,
            "fixedHeader": true,
            
            'autoWidth':false,
            


            <?php if($this->session->staff_language_rtl == '1') { ?>
                "language": {
                    "url": "<?= base_url()?>public/components/datatables/ar.json"
                },
            <?php } ?>

            "dom": "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p><'dtbuttons'B>>",
            buttons: [
                'copy', 'csv', 'excel', 'pdf'
            ]

        });

    });
</script>
