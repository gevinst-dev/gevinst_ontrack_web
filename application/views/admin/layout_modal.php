<?php $this->load->view($modal); ?>

<script type="text/javascript" src="<?= base_url()?>public/assets/js/admin-modal.js"></script>


<script>

    $(document).ready(function() {



        tinymce.init({
          selector: '#tinymceinput',
          height : 300,

          <?php if($this->session->staff_body_class  == "nightynight") { ?>
              skin: "oxide-dark",
              content_css: "dark",
          <?php } ?>

          cleanup : false,
          verify_html : false,
          relative_urls: false,
          remove_script_host : false,
          convert_urls: false,
          plugins: 'print preview powerpaste casechange importcss tinydrive searchreplace autolink autosave save directionality advcode visualblocks visualchars fullscreen image link media mediaembed template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists checklist wordcount tinymcespellchecker a11ychecker imagetools textpattern noneditable help formatpainter permanentpen pageembed charmap tinycomments mentions quickbars linkchecker emoticons advtable export',
        });



        $('#receipt_checkbox').on( "click", function() 
        {
            var thisCheck = $(this);
            if (thisCheck.is (':checked')) {
                $('#reference_input').val('<?= __("--- Auto ---") ?>');
                $('#reference_input').prop('readonly', true);
            } else {
                $('#reference_input').val('');
                $('#reference_input').prop('readonly', false);
            }
        });

        $('.select2_unpaid_invoices').select2({
            placeholder: '<?= __("--- Select Items ---") ?>',
            ajax: {
                url: '<?= base_url(); ?>admin/json/unpaid_invoices',
                data: function (term, page) {
                  return {
                      client_id: $('#client_id').val(),
                  };
                 },

                dataType: 'json',
                delay: 0,
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true,
                minimumResultsForSearch: Infinity
            }
        });


        $('.select2_unpaid_invoices_edit').select2({
            placeholder: '<?= __("--- Select Items ---") ?>',
            ajax: {
                url: '<?= base_url(); ?>admin/json/unpaid_invoices_edit',
                data: function (term, page) {
                  return {
                      client_id: $('#client_id').val(),
                      transaction_id: $('#transaction_id').val(),
                  };
                 },

                dataType: 'json',
                delay: 0,
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true,
                minimumResultsForSearch: Infinity
            }
        });

        $('#datepicker, #datepicker2, .datepicker').datepicker({
            format: '<?php echo date_js_format(); ?>',
            clearBtn: 'true',
            weekStart: '<?php echo get_setting("week_start"); ?>',
            autoclose: true
        });

        moment.updateLocale('en', {
            week: { dow: <?php echo get_setting("week_start"); ?> } // Monday is the first day of the week
        });

        $('#datetimepicker, #datetimepicker2').datetimepicker({
            format: '<?php echo strtoupper(date_js_format()); ?> HH:mm',
            icons: {
                time: 'far fa-clock',
                date: 'far fa-calendar',
                up: 'fas fa-arrow-up',
                down: 'fas fa-arrow-down',
                previous: 'fas fa-chevron-left',
                next: 'fas fa-chevron-right',
                today: 'fas fa-calendar-check',
                clear: 'far fa-trash-alt',
                close: 'far fa-times-circle'
            }
        });

        $('.select2_items').select2({
            placeholder: '<?= __("--- Select Item ---") ?>',
            ajax: {
                url: '<?= base_url(); ?>admin/json/items_all',
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });


        $('.select2_suppliers').select2({
            placeholder: '<?= __("--- Select Item ---") ?>',
            ajax: {
                url: '<?= base_url(); ?>admin/json/suppliers_all',
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });

        $('.select2_clients').select2({

            allowClear: true,
            placeholder: {
                id: '0',
                text: '<?= __("- Nobody -") ?>'
            },

            ajax: {
                url: '<?= base_url(); ?>admin/json/clients_all',
                dataType: 'json',
                delay: 250,

                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });


        $('.select2_users').select2({

            allowClear: true,
            placeholder: {
                id: '0',
                text: '<?= __("- Nobody -") ?>'
            },

            ajax: {
                url: '<?= base_url(); ?>admin/json/users_all',
                dataType: 'json',
                delay: 250,


                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });

        $('.select2_leads').select2({
            placeholder: '<?= __("--- Select Item ---") ?>',
            ajax: {
                url: '<?= base_url(); ?>admin/json/leads_all',
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });


        $('.select2_clients_leads').select2({
            placeholder: '<?= __("--- Select Item ---") ?>',
            ajax: {
                url: '<?= base_url(); ?>admin/json/clients_leads_all',
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });


        $('.select2_suppliers_none').select2({
            placeholder: '<?= __("--- Select Item ---") ?>',
            ajax: {
                url: '<?= base_url(); ?>admin/json/suppliers_all_none',
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });

        $('.select2_clients_none').select2({
            placeholder: '<?= __("--- Select Item ---") ?>',
            ajax: {
                url: '<?= base_url(); ?>admin/json/clients_all_none',
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });

        $('.select2_users_none').select2({
            placeholder: '<?= __("--- Select Item ---") ?>',
            ajax: {
                url: '<?= base_url(); ?>admin/json/users_all_none',
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });


        $('.select2_assets_none').select2({
            placeholder: '<?= __("--- Select Item ---") ?>',
            ajax: {
                url: '<?= base_url(); ?>admin/json/assets_all_none',
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });

        $('.select2_licenses_none').select2({
            placeholder: '<?= __("--- Select Item ---") ?>',
            ajax: {
                url: '<?= base_url(); ?>admin/json/licenses_all_none',
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });



        $('.select2_projects_none').select2({
            placeholder: '<?= __("--- Select Item ---") ?>',
            ajax: {
                url: '<?= base_url(); ?>admin/json/projects_all_none',
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });


    });

</script>
