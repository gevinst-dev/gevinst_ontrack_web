<!DOCTYPE html>
<html lang="en">

<head>
    <title><?= $title; ?> | <?= APP_NAME; ?></title>

    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- Favicon icon -->
    <link rel="icon" type="image/png" href="<?= base_url()?>public/favicon.png">
    <link rel="apple-touch-icon" href="<?= base_url()?>public/favicon.png">

    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Quicksand:500,700" rel="stylesheet">
    
    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="<?= base_url()?>public/components/bootstrap/css/bootstrap.min.css">
    
    <!-- waves.css -->
    <link rel="stylesheet" href="<?= base_url()?>public/assets/pages/waves/css/waves.min.css" type="text/css" media="all">
    
    <!-- feather icon -->
    <link rel="stylesheet" type="text/css" href="<?= base_url()?>public/assets/icon/feather/css/feather.css">
    
    <!-- font-awesome-5 -->
    <link rel="stylesheet" href="<?= base_url()?>public/components/fontawesome/css/all.css">
    
    <!-- themify-icons line icon -->
    <link rel="stylesheet" type="text/css" href="<?= base_url()?>public/assets/icon/themify-icons/themify-icons.css">
    
    <!-- ico font -->
    <link rel="stylesheet" type="text/css" href="<?= base_url()?>public/assets/icon/icofont/css/icofont.css">

    <!-- Select 2 css -->
    <link rel="stylesheet" href="<?= base_url()?>public/components/select2/css/select2.min.css" />
    
    <!-- bootstrap-colorpicker -->
    <link rel="stylesheet" type="text/css" href="<?= base_url()?>public/components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">

    <!-- jQuery Toast -->
    <link rel="stylesheet" type="text/css" href="<?= base_url()?>public/components/jquery-toast-plugin-master/dist/jquery.toast.min.css">
    
    <!-- DataTables Css -->
    <link rel="stylesheet" type="text/css" href="<?= base_url()?>public/components/datatables/datatables.min.css"/>

    <!-- Treeview css -->
    <link rel="stylesheet" type="text/css" href="<?= base_url()?>public/components/jstree/css/style.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url()?>public/assets/pages/treeview/treeview.css">

    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="<?= base_url()?>public/assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url()?>public/assets/css/widget.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url()?>public/assets/css/custom.css">

    <link rel="stylesheet" type="text/css" href="<?= base_url()?>public/assets/css/user-custom.css">

    <?php if($this->session->user_language_rtl == '1') { ?>
        <link rel="stylesheet" type="text/css" href="<?= base_url()?>public/assets/css/custom-rtl.css">
    <?php } ?>

    <!-- Required Jquery -->
    <script type="text/javascript" src="<?= base_url()?>public/components/jquery/js/jquery-3.6.1.min.js"></script>
    <!-- Moment -->
    <script type="text/javascript" src="<?= base_url()?>public/components/fullcalendar/lib/moment.min.js"></script>



    <style>

        <?php if(get_setting('user_accent_color') != '') {  $client_accent_color = get_setting('user_accent_color'); ?>

            body[themebg-pattern="theme1"] {
                background-color: <?= $client_accent_color ?>;
            }

            .pcoded .pcoded-header[header-theme="theme1"] {
                background: <?= $client_accent_color ?>;
            }

            .header-navbar .navbar-wrapper .navbar-logo[logo-theme="theme1"] {
                background: <?= $client_accent_color ?>;
            }

            .pcoded[theme-layout="horizontal"] .pcoded-navbar[active-item-theme="theme1"] .pcoded-item > li.active > a .pcoded-micon, .pcoded[theme-layout="horizontal"] .pcoded-navbar[active-item-theme="theme1"] .pcoded-item > li.active:hover > a .pcoded-micon, .pcoded[theme-layout="horizontal"] .pcoded-navbar[active-item-theme="theme1"] .pcoded-item > li.pcoded-trigger > a .pcoded-micon, .pcoded[theme-layout="horizontal"] .pcoded-navbar[active-item-theme="theme1"] .pcoded-item > li.pcoded-trigger:hover > a .pcoded-micon, .pcoded[theme-layout="horizontal"] .pcoded-navbar[active-item-theme="theme1"] .pcoded-item > li:hover > a .pcoded-micon, .pcoded[theme-layout="horizontal"] .pcoded-navbar[active-item-theme="theme1"] .pcoded-item > li:hover:hover > a .pcoded-micon {
                color: <?= $client_accent_color ?>;
            }

            .pcoded[theme-layout="horizontal"] .pcoded-navbar[active-item-theme="theme1"] .pcoded-item > li.active > a, .pcoded[theme-layout="horizontal"] .pcoded-navbar[active-item-theme="theme1"] .pcoded-item > li.active:hover > a, .pcoded[theme-layout="horizontal"] .pcoded-navbar[active-item-theme="theme1"] .pcoded-item > li.pcoded-trigger > a, .pcoded[theme-layout="horizontal"] .pcoded-navbar[active-item-theme="theme1"] .pcoded-item > li.pcoded-trigger:hover > a, .pcoded[theme-layout="horizontal"] .pcoded-navbar[active-item-theme="theme1"] .pcoded-item > li:hover > a, .pcoded[theme-layout="horizontal"] .pcoded-navbar[active-item-theme="theme1"] .pcoded-item > li:hover:hover > a {
                color: <?= $client_accent_color ?>;
            }

            .page-item.active .page-link {
                background-color: <?= $client_accent_color ?>;
                border-color: <?= $client_accent_color ?>;
            }

            .bg-c-blue {
                background: <?= $client_accent_color ?>;
            }


            .btn-primary, .sweet-alert button.confirm, .wizard > .actions a {
                background-color: <?= $client_accent_color ?>;
                border-color: <?= $client_accent_color ?>;
                color: #fff;
                cursor: pointer;
                -webkit-transition: all ease-in 0.3s;
                transition: all ease-in 0.3s;
            }

        <?php } ?>

    </style>

</head>


<body>
    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-bar"></div>
    </div>
    <!-- [ Pre-loader ] end -->
    <div id="pcoded" class="pcoded">
        <div class="pcoded-overlay-box"></div>
        <div class="pcoded-container navbar-wrapper">
            <!-- [ Header ] start -->
            <nav class="navbar header-navbar pcoded-header">
                <div class="navbar-wrapper ">

                    <div class="container navbar-container">

                        <div class="navbar-logo t-transfrom-none">
                            <a href="<?= base_url(); ?>">
                                <?php if(file_exists(FCPATH.'public/logo_user_area.png')) { ?>
                                    <img src='<?= base_url('public/logo_user_area.png')?>' class="max-height-40">
                                <?php } else { ?>
                                    <?= get_setting('app_name'); ?>
                                <?php } ?>
                            </a>

                            <a class="mobile-menu" id="mobile-collapse" href="#!">
                                <i class="feather icon-menu icon-toggle-right"></i>
                            </a>

                            <a class="mobile-options waves-effect waves-light">
                                <i class="feather icon-more-horizontal"></i>
                            </a>
                        </div>


                        <ul class="nav-right">

                            <?php if($this->session->user_signed_in) { ?>
                                <li class="user-profile header-notification">
                                    <div class="dropdown-primary dropdown">

                                        <div class="dropdown-toggle" data-toggle="dropdown">
                                            <img src="<?= gravatar($this->session->user_email, 100); ?>" class="img-radius" alt="<?= $this->session->user_name; ?>">
                                            <span>
                                                <?= $this->session->user_name; ?>
                                                <small><?= $this->session->client['name']; ?></small>
                                            </span>
                                            <i class="feather icon-chevron-down"></i>
                                        </div>


                                        <ul class="show-notification profile-notification dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                            <?php if(user_has_permission('profile')) { ?>
                                            <li >
                                                <a href="<?= base_url('profile')?>"><i class="feather icon-user"></i> <?= __('My Profile') ?></a>
                                            </li>
                                            <?php } ?>

                                            <?php if(user_has_permission('client')) { ?>
                                            <li >
                                                <a href="<?= base_url('client_details')?>"><i class="feather icon-user"></i> <?= __('Client Details') ?></a>
                                            </li>
                                            <?php } ?>

                                            <li>
                                                <a href="<?= base_url('auth/sign_out')?>"><i class="feather icon-log-out"></i> <?= __('Sign Out') ?></a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            <?php } else { ?>

                                <li>
                                <a href="<?= base_url('auth/sign_in')?>"><i class="feather icon-log-in"></i> <?= __('Sign In') ?></a>
                                </li>



                            <?php } ?>



                        </ul>
                    </div>
                </div>
            </nav>


            <div class="pcoded-main-container">
                <div class="pcoded-wrapper">
                    <!-- [ navigation menu ] start -->
                    <nav class="pcoded-navbar user-navbar">

                        <div class="container">
                            <div class="pcoded-inner-navbar">

                                <ul class="pcoded-item">

                                    <?php if($this->session->user_signed_in) { ?>
                                        <li class="<?php menu_active($page, "dashboard", "active" ); ?>">
                                            <a href="<?= base_url(); ?>" class="waves-effect waves-dark">
                                                <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                                                <span class="pcoded-mtext"><?= __('Dashboard') ?></span>
                                            </a>
                                        </li>


                                        <?php if(user_has_permission('assets') || user_has_permission('licenses') || user_has_permission('domains') || user_has_permission('credentials')) { ?>
                                        <li class="pcoded-hasmenu <?php menu_active($page, "inventory", "active pcoded-triggerX" ); ?>">
                                            <a href="javascript:void(0)" class="waves-effect waves-dark">
                                                <span class="pcoded-micon"><i class="fas fa-th"></i></span>
                                                <span class="pcoded-mtext"><?= __('Inventory') ?></span>
                                            </a>
                                            <ul class="pcoded-submenu">


                                                    <?php if(user_has_permission('assets')) { ?>
                                                    <li class="<?php menu_active($page, "inventory/assets/", "active" ); ?>">
                                                        <a href="<?= base_url(); ?>inventory/assets/" class="waves-effect waves-dark">
                                                            <span class="pcoded-mtext"><?= __('Assets') ?></span>
                                                        </a>
                                                    </li>
                                                    <?php } ?>

                                                    <?php if(user_has_permission('licenses')) { ?>
                                                    <li class="<?php menu_active($page, "inventory/licenses/", "active" ); ?>">
                                                        <a href="<?= base_url(); ?>inventory/licenses/" class="waves-effect waves-dark">
                                                            <span class="pcoded-mtext"><?= __('Licenses') ?></span>
                                                        </a>
                                                    </li>
                                                    <?php } ?>

                                                    <?php if(user_has_permission('domains')) { ?>
                                                    <li class="<?php menu_active($page, "inventory/domains/", "active" ); ?>">
                                                        <a href="<?= base_url(); ?>inventory/domains/" class="waves-effect waves-dark">
                                                            <span class="pcoded-mtext"><?= __('Domains') ?></span>
                                                        </a>
                                                    </li>
                                                    <?php } ?>

                                                    <?php if(user_has_permission('credentials')) { ?>
                                                    <li class="<?php menu_active($page, "inventory/credentials/", "active" ); ?>">
                                                        <a href="<?= base_url(); ?>inventory/credentials/" class="waves-effect waves-dark">
                                                            <span class="pcoded-mtext"><?= __('Credentials') ?></span>
                                                        </a>
                                                    </li>
                                                    <?php } ?>


                                            </ul>
                                        </li>
                                        <?php } ?>

                                        <?php if(user_has_permission('projects')) { ?>
                                        <li class="<?php menu_active($page, "projects", "active" ); ?>">
                                            <a href="<?= base_url(); ?>projects" class="waves-effect waves-dark">
                                                <span class="pcoded-micon"><i class="fas fa-rocket"></i></span>
                                                <span class="pcoded-mtext"><?= __('Projects') ?></span>
                                            </a>
                                        </li>
                                        <?php } ?>


                                        <?php if(user_has_permission('tickets')) { ?>
                                        <li class="<?php menu_active($page, "tickets", "active" ); ?>">
                                            <a href="<?= base_url(); ?>tickets" class="waves-effect waves-dark">
                                                <span class="pcoded-micon"><i class="fas fa-ticket-alt"></i></span>
                                                <span class="pcoded-mtext"><?= __('Tickets') ?></span>
                                            </a>
                                        </li>
                                        <?php } ?>


                                        <?php if(user_has_permission('issues')) { ?>
                                        <li class="<?php menu_active($page, "issues", "active" ); ?>">
                                            <a href="<?= base_url(); ?>issues" class="waves-effect waves-dark">
                                                <span class="pcoded-micon"><i class="fas fa-tasks"></i></span>
                                                <span class="pcoded-mtext"><?= __('Issues') ?></span>
                                            </a>
                                        </li>
                                        <?php } ?>


                                        <?php if(user_has_permission('kb')) { ?>
                                        <li class="<?php menu_active($page, "knowledge_base", "active" ); ?>">
                                            <a href="<?= base_url(); ?>knowledge_base" class="waves-effect waves-dark">
                                                <span class="pcoded-micon"><i class="fas fa-life-ring"></i></span>
                                                <span class="pcoded-mtext"><?= __('Knowledge Base') ?></span>
                                            </a>
                                        </li>
                                        <?php } ?>

                                        <?php if(user_has_permission('documentation')) { ?>
                                        <li class="pcoded-hasmenu <?php menu_active($page, "documentation", "active pcoded-triggerX" ); ?>" >
                                            <a href="javascript:void(0)" class="waves-effect waves-dark">
                                                <span class="pcoded-micon"><i class="fas fa-book"></i></span>
                                                <span class="pcoded-mtext"><?= __('Documentation') ?></span>
                                            </a>
                                            <ul class="pcoded-submenu">
                                                <?php foreach(SPACES as $space) { ?>

                                                    <li class="<?php menu_active($page, "documentation/view/".$space['id'], "active" ); ?>">
                                                        <a href="<?= base_url(); ?>documentation/view/<?= $space['id'] ?>" class="waves-effect waves-dark">
                                                            <span class="pcoded-mtext"><?= $space['name'] ?></span>
                                                        </a>
                                                    </li>

                                                <?php } ?>

                                            </ul>
                                        </li>
                                        <?php } ?>

                                        <?php if(user_has_permission('invoices') || user_has_permission('proformas') || user_has_permission('proposals') || user_has_permission('transactions')) { ?>
                                        <li class="pcoded-hasmenu <?php menu_active($page, "billing", "active pcoded-triggerX" ); ?>">
                                            <a href="javascript:void(0)" class="waves-effect waves-dark">
                                                <span class="pcoded-micon"><i class="fas fa-coins"></i></span>
                                                <span class="pcoded-mtext"><?= __('Billing') ?></span>
                                            </a>
                                            <ul class="pcoded-submenu">

                                                    <?php if(user_has_permission('invoices')) { ?>
                                                    <li class="<?php menu_active($page, "billing/invoices/", "active" ); ?>">
                                                        <a href="<?= base_url(); ?>billing/invoices/" class="waves-effect waves-dark">
                                                            <span class="pcoded-mtext"><?= __('Invoices') ?></span>
                                                        </a>
                                                    </li>
                                                    <?php } ?>

                                                    <?php if(user_has_permission('proformas')) { ?>
                                                    <li class="<?php menu_active($page, "billing/proformas/", "active" ); ?>">
                                                        <a href="<?= base_url(); ?>billing/proformas/" class="waves-effect waves-dark">
                                                            <span class="pcoded-mtext"><?= __('Proformas') ?></span>
                                                        </a>
                                                    </li>
                                                    <?php } ?>

                                                    <?php if(user_has_permission('proposals')) { ?>
                                                    <li class="<?php menu_active($page, "billing/proposals/", "active" ); ?>">
                                                        <a href="<?= base_url(); ?>billing/proposals/" class="waves-effect waves-dark">
                                                            <span class="pcoded-mtext"><?= __('Proposals') ?></span>
                                                        </a>
                                                    </li>
                                                    <?php } ?>

                                                    <?php if(user_has_permission('receipts')) { ?>
                                                    <li class="<?php menu_active($page, "billing/receipts/", "active" ); ?>">
                                                        <a href="<?= base_url(); ?>billing/receipts/" class="waves-effect waves-dark">
                                                            <span class="pcoded-mtext"><?= __('Receipts') ?></span>
                                                        </a>
                                                    </li>
                                                    <?php } ?>


                                            </ul>
                                        </li>
                                        <?php } ?>

                                    <?php } else { ?>


                                        <?php if(client_has_permission('submit_ticket')) { ?>
                                        <li class="<?php menu_active($page, "submit_ticket", "active" ); ?>">
                                            <a href="<?= base_url(); ?>submit_ticket" class="waves-effect waves-dark">
                                                <span class="pcoded-micon"><i class="fas fa-ticket-alt"></i></span>
                                                <span class="pcoded-mtext"><?= __('Submit Ticket') ?></span>
                                            </a>
                                        </li>
                                        <?php } ?>

                                        <?php if(client_has_permission('kb')) { ?>
                                        <li class="<?php menu_active($page, "knowledge_base", "active" ); ?>">
                                            <a href="<?= base_url(); ?>knowledge_base" class="waves-effect waves-dark">
                                                <span class="pcoded-micon"><i class="fas fa-life-ring"></i></span>
                                                <span class="pcoded-mtext"><?= __('Knowledge Base') ?></span>
                                            </a>
                                        </li>
                                        <?php } ?>

                                        <?php if(client_has_permission('documentation')) { ?>
                                        <li class="pcoded-hasmenu <?php menu_active($page, "documentation", "active pcoded-triggerX" ); ?>" >
                                            <a href="javascript:void(0)" class="waves-effect waves-dark">
                                                <span class="pcoded-micon"><i class="fas fa-book"></i></span>
                                                <span class="pcoded-mtext"><?= __('Documentation') ?></span>
                                            </a>
                                            <ul class="pcoded-submenu">
                                                <?php foreach(SPACES as $space) { ?>

                                                    <li class="<?php menu_active($page, "documentation/view/".$space['id'], "active" ); ?>">
                                                        <a href="<?= base_url(); ?>documentation/view/<?= $space['id'] ?>" class="waves-effect waves-dark">
                                                            <span class="pcoded-mtext"><?= $space['name'] ?></span>
                                                        </a>
                                                    </li>

                                                <?php } ?>

                                            </ul>
                                        </li>
                                        <?php } ?>



                                    <?php } ?>



                                </ul>

                            </div>
                        </div>


                    </nav>



                    <div class="container">
                        <!-- main content start-->
                        <?php $this->load->view($page); ?>
                        <!-- main content end-->
                    </div>



                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="main-modal" role="dialog">
        <div class="modal-dialog modal-lg" id="main-modal-content" role="document">

        </div>
    </div>



    <!-- Required Jquery Components -->
    <script type="text/javascript" src="<?= base_url()?>public/components/jquery-ui/js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="<?= base_url()?>public/components/popper.js/js/popper.min.js"></script>
    <script type="text/javascript" src="<?= base_url()?>public/components/bootstrap/js/bootstrap.min.js"></script>
    <!-- waves js -->
    <script src="<?= base_url()?>public/assets/pages/waves/js/waves.min.js"></script>
    <!-- jquery slimscroll js -->
    <script type="text/javascript" src="<?= base_url()?>public/components/jquery-slimscroll/js/jquery.slimscroll.js"></script>
    <!-- jq validation -->
    <script src="<?= base_url()?>public/components/bootstrap-validator/validator.min.js"></script>
    <!-- jquery toast -->
    <script type="text/javascript" src="<?= base_url()?>public/components/jquery-toast-plugin-master/dist/jquery.toast.min.js"></script>
    <!-- Select 2 js -->
    <script type="text/javascript" src="<?= base_url()?>public/components/select2/js/select2.full.min.js"></script>

    <!-- bootstrap-colorpicker -->
    <script type="text/javascript" src="<?= base_url()?>public/components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>

    
    <!-- Tree view js -->
    <script type="text/javascript" src="<?= base_url()?>public/components/jstree/js/jstree.min.js"></script>
    <script type="text/javascript" src="<?= base_url()?>public/assets/pages/treeview/jquery.tree.js"></script>

    <!-- Tiny MCE -->
    <script type="text/javascript" src="<?= base_url()?>public/components/tinymce/js/tinymce/tinymce.min.js"></script>

    <!-- data-table js -->
    <script type="text/javascript" src="<?= base_url()?>public/components/datatables/datatables.min.js"></script>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <!-- Custom js -->
    <script src="<?= base_url()?>public/assets/js/pcoded.js"></script>
    <script src="<?= base_url()?>public/assets/js/vertical/menu/menu-hori-fixed.js"></script>
    <script type="text/javascript" src="<?= base_url()?>public/assets/js/script.js"></script>
    <script type="text/javascript" src="<?= base_url()?>public/assets/js/user-area.js"></script>

    <script>

        $(document).ready(function() {
            <?php if($this->session->flashdata('toast-success') != ''): ?>
                $.toast({
                    heading: '<?= __("Success") ?>',
                    text: "<?= preg_replace( "/\r|\n/", "", $this->session->flashdata('toast-success') ); ?>",
                    icon: 'success',
                    position: 'top-right',
                });
            <?php endif; ?>

            <?php if($this->session->flashdata('toast-warning') != ''): ?>
                $.toast({
                    heading: '<?= __("Warning") ?>',
                    text: "<?= preg_replace( "/\r|\n/", "", $this->session->flashdata('toast-warning') ); ?>",
                    icon: 'warning',
                    position: 'top-right',
                });
            <?php endif; ?>

            <?php if($this->session->flashdata('toast-error') != ''): ?>
                $.toast({
                    heading: '<?= __("Error") ?>',
                    text: "<?= preg_replace( "/\r|\n/", "", $this->session->flashdata('toast-error') ); ?>",
                    icon: 'error',
                    position: 'top-right',
                });
            <?php endif; ?>

            <?php if($this->session->flashdata('toast-validation') != ''): ?>
                $.toast({
                    heading: '<?= __("Data Validation Error") ?>',
                    text: "<?= preg_replace( "/\r|\n/", "", $this->session->flashdata('toast-validation') ); ?>",
                    icon: 'warning',
                    position: 'top-right',
                });
            <?php endif; ?>

            <?php if(validation_errors() !== ''): ?>
                $.toast({
                    heading: '<?= __("Data Validation Error") ?>',
                    text: "<?= preg_replace( "/\r|\n/", "", validation_errors() ); ?>",
                    icon: 'warning',
                    position: 'top-right',
                });
            <?php endif; ?>
        });


        function show_modal(modal) {
            url = '<?= base_url(); ?>' +  modal;

            $('#main-modal-content').empty();
            $('#main-modal-content').load(url);
            $('#main-modal').modal('show');
        }

    </script>

</body>

</html>
