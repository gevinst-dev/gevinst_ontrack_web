<!DOCTYPE html>
<html lang="en">

<head>
    <title><?= $title; ?> | <?= APP_NAME; ?></title>

    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />


    <meta name="author" content="Codeniner" />


    <!-- Favicon icon -->
    <link rel="icon" type="image/png" href="<?= base_url()?>public/favicon.png">
    <link rel="apple-touch-icon" href="<?= base_url()?>public/favicon.png">

    <!-- Google font-->
    <link href="//fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
    <link href="//fonts.googleapis.com/css?family=Quicksand:500,700" rel="stylesheet">

    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="<?= base_url()?>public/components/bootstrap/css/bootstrap.min.css">

    <?php if($this->session->staff_language_rtl == '1') { ?>
        <link rel="stylesheet" href="<?= base_url()?>public/components/bootstrap-rtl/bootstrap.min.css">
    <?php } ?>

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
    
    <!-- jQuery Toast -->
    <link rel="stylesheet" type="text/css" href="<?= base_url()?>public/components/jquery-toast-plugin-master/dist/jquery.toast.min.css">
    
    <!-- DataTables Css -->
    <link rel="stylesheet" type="text/css" href="<?= base_url()?>public/components/datatables/datatables.min.css"/>

    <!-- B Datepicker -->
    <link rel="stylesheet" type="text/css" href="<?= base_url()?>public/components/bootstrap-datepicker/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url()?>public/components/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css">

    <!-- jQueyUI -->
    <link rel="stylesheet" href="<?= base_url()?>public/components/jquery-ui/jquery-ui.css">

    <!-- bootstrap-colorpicker -->
    <link rel="stylesheet" type="text/css" href="<?= base_url()?>public/components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">

    <!-- Treeview css -->
    <link rel="stylesheet" type="text/css" href="<?= base_url()?>public/components/jstree/css/style.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url()?>public/assets/pages/treeview/treeview.css">

    <!-- Dragula -->
    <link rel="stylesheet" type="text/css" href="<?= base_url()?>public/components/dragula/dragula.min.css">

    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="<?= base_url()?>public/assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url()?>public/assets/css/pages.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url()?>public/assets/css/widget.css">


    <link rel="stylesheet" type="text/css" href="<?= base_url()?>public/assets/css/custom.css">
    <?php if($this->session->staff_language_rtl == '1') { ?>
        <link rel="stylesheet" type="text/css" href="<?= base_url()?>public/assets/css/custom-rtl.css">
    <?php } ?>

    <!-- Required Jquery -->
    <script type="text/javascript" src="<?= base_url()?>public/components/jquery/js/jquery-3.6.1.min.js"></script>
    <!-- Moment -->
    <script type="text/javascript" src="<?= base_url()?>public/components/fullcalendar/lib/moment.min.js"></script>



</head>


<body class="<?= $this->session->staff_body_class ?>">
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
                <div class="navbar-wrapper">
                    <div class="navbar-logo t-transform-none">

                        <a href="<?= base_url('admin/dashboard')?>">
                          
                            <?php if(file_exists(FCPATH.'public/logo_light.png')) { ?>
                                    <img src='<?= base_url('public/logo_light.png')?>' class="max-height-40">
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
                    <div class="navbar-container container-fluid">
                        <ul class="nav-left">
                            <li class="header-search">
                                <div class="main-search morphsearch-search">
                                    <div class="input-group">
                                        <span class="input-group-prepend search-close">
										    <i class="feather icon-x input-group-text"></i>
									    </span>
                                        <?= form_open(base_url('admin/search/')); ?>
                                            <input type="text" class="form-control" placeholder="<?= __("Enter keyword") ?>" name="query">
                                        <?= form_close(); ?>
                                        <span class="input-group-append search-btn">
										    <i class="feather icon-search input-group-text"></i>
									    </span>
                                    </div>
                                </div>
                            </li>

                            <li>
                                <?php if($this->session->staff_body_class == "day" || $this->session->staff_body_class == "") { ?>

                                    <a href="<?= base_url('admin/misc/set_body_class/nightynight') ?>"  class="waves-effect waves-light">
                                        <i class="full-screen feather icon-moon"></i>
                                    </a>

                                <?php } else { ?>

                                    <a href="<?= base_url('admin/misc/set_body_class/day') ?>"  class="waves-effect waves-light">
                                        <i class="full-screen feather icon-sun"></i>
                                    </a>

                                <?php } ?>


                            </li>


                            <li>
                                <a href="#!" class="waves-effect waves-light go-fullscreen">
                                    <i class="full-screen feather icon-maximize"></i>
                                </a>
                            </li>


                        </ul>
                        <ul class="nav-right">

                            <li class="header-notification">
                                <div class="dropdown-primary dropdown">
                                    <div class="dropdown-toggle" data-toggle="dropdown">
                                        <i class="feather icon-bell"></i>
                                        <?php if(MENU_DATA['alert_count'] > 0) { ?>
                                            <span class="badge bg-c-red"><?= MENU_DATA['alert_count'] ?></span>
                                        <?php } ?>
                                    </div>
                                    <ul class="show-notification notification-view dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                        <li>
                                            <h6><?= __('Alerts') ?></h6>
                                            <label class="label label-danger"><?= MENU_DATA['alert_count'] ?> <?= __('Active') ?></label>
                                            <hr>
                                        </li>

                                        <?php if(has_permission('tickets-add')) { ?>
                                            <?php if(MENU_DATA['tickets_assigned'] > 0) { ?>
                                                <li class="top-nav-li">
                                                    <a href="<?= base_url('admin/tickets/assigned'); ?>">
                                                        <div class="media">
                                                            <i class="fas fa-fw fa-ticket-alt"></i>
                                                            <div class="media-body">
                                                                <p class="notification-msg"><?= __('You have') ?> <?= MENU_DATA['tickets_assigned'] ?> <?= __('assigned tickets.') ?></p>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li>
                                            <?php } ?>
                                        <?php } ?>

                                        <?php if(has_permission('issues-add')) { ?>
                                            <?php if(MENU_DATA['issues_assigned'] > 0) { ?>
                                                <li class="top-nav-li">
                                                    <a href="<?= base_url('admin/issues/assigned'); ?>">
                                                        <div class="media">
                                                            <i class="fas fa-fw fa-tasks"></i>
                                                            <div class="media-body">
                                                                <p class="notification-msg"><?= __('You have') ?> <?= MENU_DATA['issues_assigned'] ?> <?= __('assigned issues.') ?></p>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li>
                                            <?php } ?>
                                        <?php } ?>


                                    </ul>
                                </div>
                            </li>
                            

                            <li class="header-notification">
                                <div class="dropdown-primary dropdown">
                                    <div class="dropdown-toggle" data-toggle="dropdown">
                                        <i class="fas fa-fw fa-star"></i>
                                    </div>
                                    <ul class="show-notification profile-notification dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">

                                        <div class="m-20 m-top-0">
                                            <h6><?= __('Quick Actions') ?></h6>

                                            <hr>
                                        </div>

                                        <?php if(has_permission('issues-add')) { ?>
                                        <li>
                                            <a href="#" data-modal="admin/issues/add"><i class="fas fa-fw fa-tasks"></i> <?= __('New Issue') ?></a>
                                        </li>
                                        <?php } ?>

                                        <?php if(has_permission('tickets-add')) { ?>
                                        <li>
                                            <a href="#" data-modal="admin/tickets/add"><i class="fas fa-fw fa-ticket-alt"></i> <?= __('New Ticket') ?></a>
                                        </li>
                                        <?php } ?>

                                        <?php if(has_permission('assets-add')) { ?>
                                        <li>
                                            <a href="#" data-modal="admin/inventory/assets/add"><i class="fas fa-fw fa-laptop"></i> <?= __('New Asset') ?></a>
                                        </li>
                                        <?php } ?>

                                        <?php if(has_permission('licenses-add')) { ?>
                                        <li>
                                            <a href="#" data-modal="admin/inventory/licenses/add"><i class="fas fa-fw fa-certificate"></i> <?= __('New License') ?></a>
                                        </li>
                                        <?php } ?>

                                        <?php if(has_permission('domains-add')) { ?>
                                        <li>
                                            <a href="#" data-modal="admin/inventory/domains/add"><i class="fas fa-fw fa-globe"></i> <?= __('New Domain') ?></a>
                                        </li>
                                        <?php } ?>

                                        <?php if(has_permission('credentials-add')) { ?>
                                        <li>
                                            <a href="#" data-modal="admin/inventory/credentials/add"><i class="fas fa-fw fa-asterisk"></i> <?= __('New Credential') ?></a>
                                        </li>
                                        <?php } ?>

                                        <?php if(has_permission('projects-add')) { ?>
                                        <li>
                                            <a href="#" data-modal="admin/projects/add"><i class="fas fa-fw fa-rocket"></i> <?= __('New Project') ?></a>
                                        </li>
                                        <?php } ?>

                                        <?php if(has_permission('clients-add')) { ?>
                                        <li>
                                            <a href="#" data-modal="admin/clients/add"><i class="fas fa-fw fa-sitemap"></i> <?= __('New Department') ?></a>
                                        </li>
                                        <?php } ?>
                                        
                                        <?php if(has_permission('users-add')) { ?>
                                        <li>
                                            <a href="#" data-modal="admin/users/add"><i class="fas fa-fw fa-user"></i> <?= __('New User') ?></a>
                                        </li>
                                        <?php } ?>

                                        <?php if(has_permission('reminders-add')) { ?>
                                        <li>
                                            <a href="#" data-modal="admin/reminders/add"><i class="fas fa-fw fa-bell"></i> <?= __('New Reminder') ?></a>
                                        </li>
                                        <?php } ?>


                                    </ul>
                                </div>
                            </li>


                            <li class="user-profile header-notification">
                                <div class="dropdown-primary dropdown">
                                    <div class="dropdown-toggle" data-toggle="dropdown">
                                        <img src="<?= gravatar($this->session->staff_email, 100); ?>" class="img-radius" alt="<?= $this->session->staff_name; ?>">
                                        <span><?= $this->session->staff_name; ?></span>
                                        <i class="feather icon-chevron-down"></i>
                                    </div>
                                    <ul class="show-notification profile-notification dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                        <li>
                                            <a href="<?= base_url('admin/profile')?>"><i class="feather icon-user"></i> <?= __('My Profile') ?></a>
                                        </li>

                                        <li>
                                            <a href="<?= base_url('admin/auth/sign_out')?>"><i class="feather icon-log-out"></i> <?= __('Sign Out') ?></a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>


            <div class="pcoded-main-container">
                <div class="pcoded-wrapper">
                    <!-- [ navigation menu ] start -->
                    <nav class="pcoded-navbar">
                        <div class="nav-list">
                            <div class="pcoded-inner-navbar main-menu">
                                <div class="pcoded-navigation-label"><?= __('Navigation') ?></div>
                                <ul class="pcoded-item pcoded-left-item">
                                    <li class="<?php menu_active($page, "admin/dashboard", "active" ); ?>">
                                        <a href="<?= base_url(); ?>admin/dashboard" class="waves-effect waves-dark">
                                            <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                                            <span class="pcoded-mtext"><?= __('Dashboard') ?></span>

                                        </a>
                                    </li>


                                    <?php if(
                                        has_permission('assets-view') || 
                                        has_permission('licenses-view') || 
                                        has_permission('domains-view') || 
                                        has_permission('credentials-view') || 
                                        has_permission('attributes-view')
                                        ) { ?>
                                    <li class="pcoded-hasmenu <?php menu_active($page, "admin/inventory", "active pcoded-trigger" ); ?>">
                                        <a href="javascript:void(0)" class="waves-effect waves-dark">
                                            <span class="pcoded-micon"><i class="fas fa-th"></i></span>
                                            <span class="pcoded-mtext"><?= __('Inventory') ?></span>
                                        </a>
                                        <ul class="pcoded-submenu">
                                            <?php if(has_permission('assets-view')) { ?>
                                            <li class="<?php menu_active($page, "admin/inventory/assets", "active" ); ?>">
                                                <a href="<?= base_url(); ?>admin/inventory/assets" class="waves-effect waves-dark">
                                                    <span class="pcoded-mtext"><?= __('Assets') ?></span>
                                                </a>
                                            </li>
                                            <?php } ?>

                                            <?php if(has_permission('licenses-view')) { ?>
                                            <li class="<?php menu_active($page, "admin/inventory/licenses", "active" ); ?>">
                                                <a href="<?= base_url(); ?>admin/inventory/licenses" class="waves-effect waves-dark">
                                                    <span class="pcoded-mtext"><?= __('Licenses') ?></span>
                                                </a>
                                            </li>
                                            <?php } ?>

                                            <?php if(has_permission('domains-view')) { ?>
                                            <li class="<?php menu_active($page, "admin/inventory/domains", "active" ); ?>">
                                                <a href="<?= base_url(); ?>admin/inventory/domains" class="waves-effect waves-dark">
                                                    <span class="pcoded-mtext"><?= __('Domains') ?></span>
                                                </a>
                                            </li>
                                            <?php } ?>

                                            <?php if(has_permission('credentials-view')) { ?>
                                            <li class="<?php menu_active($page, "admin/inventory/credentials", "active" ); ?>">
                                                <a href="<?= base_url(); ?>admin/inventory/credentials" class="waves-effect waves-dark">
                                                    <span class="pcoded-mtext"><?= __('Credentials') ?></span>
                                                </a>
                                            </li>
                                            <?php } ?>

                                            <?php if(has_permission('attributes-view')) { ?>
                                            <li class="<?php menu_active($page, "admin/inventory/attributes", "active" ); ?>">
                                                <a href="<?= base_url(); ?>admin/inventory/attributes" class="waves-effect waves-dark">
                                                    <span class="pcoded-mtext"><?= __('Attributes') ?></span>
                                                </a>
                                            </li>
                                            <?php } ?>
                                        </ul>
                                    </li>
                                    <?php } ?>

                                    <?php if(has_permission('clients-view')) { ?>
                                    <li class="<?php menu_active($page, "admin/clients", "active" ); ?>">
                                        <a href="<?= base_url(); ?>admin/clients" class="waves-effect waves-dark">
                                            <span class="pcoded-micon"><i class="fas fa-sitemap"></i></span>
                                            <span class="pcoded-mtext"><?= __('Clients') ?></span>
                                        </a>
                                    </li>
                                    <?php } ?>

                                    <?php if(has_permission('users-view')) { ?>
                                    <li class="<?php menu_active($page, "admin/users", "active" ); ?>">
                                        <a href="<?= base_url(); ?>admin/users" class="waves-effect waves-dark">
                                            <span class="pcoded-micon"><i class="feather icon-users"></i></span>
                                            <span class="pcoded-mtext"><?= __('Users') ?></span>
                                        </a>
                                    </li>
                                    <?php } ?>

                                    <?php if(has_permission('projects-view')) { ?>
                                    <li class="<?php menu_active($page, "admin/projects", "active" ); ?>">
                                        <a href="<?= base_url(); ?>admin/projects" class="waves-effect waves-dark">
                                            <span class="pcoded-micon"><i class="fas fa-rocket"></i></span>
                                            <span class="pcoded-mtext"><?= __('Projects') ?></span>
                                        </a>
                                    </li>
                                    <?php } ?>


                                    <?php if(has_permission('tickets-view')) { ?>
                                    <li class="pcoded-hasmenu <?php menu_active($page, "admin/tickets", "active pcoded-trigger" ); ?>">
                                        <a href="javascript:void(0)" class="waves-effect waves-dark">
                                            <span class="pcoded-micon"><i class="fas fa-ticket-alt"></i></span>
                                            <span class="pcoded-mtext"><?= __('Tickets') ?></span>
                                        </a>
                                        <ul class="pcoded-submenu">
                                            <li class="<?php menu_active($page, "admin/tickets/list_assigned", "active" ); ?>">
                                                <a href="<?= base_url(); ?>admin/tickets/assigned" class="waves-effect waves-dark">
                                                    <span class="pcoded-mtext"><?= __('Assigned') ?></span>
                                                    <span class="pcoded-badge label label-primary"><?= MENU_DATA['tickets_assigned'] ?></span>
                                                </a>
                                            </li>
                                            <li class="<?php menu_active($page, "admin/tickets/list_open", "active" ); ?>">
                                                <a href="<?= base_url(); ?>admin/tickets/open" class="waves-effect waves-dark">
                                                    <span class="pcoded-mtext"><?= __('Open') ?></span>
                                                    <span class="pcoded-badge label label-primary"><?= MENU_DATA['tickets_open'] ?></span>
                                                </a>
                                            </li>
                                            <li class="<?php menu_active($page, "admin/tickets/list_reopened", "active" ); ?>">
                                                <a href="<?= base_url(); ?>admin/tickets/reopened" class="waves-effect waves-dark">
                                                    <span class="pcoded-mtext"><?= __('Reopened') ?></span>
                                                    <span class="pcoded-badge label label-primary"><?= MENU_DATA['tickets_reopened'] ?></span>
                                                </a>
                                            </li>

                                            <li class="<?php menu_active($page, "admin/tickets/list_inprogress", "active" ); ?>">
                                                <a href="<?= base_url(); ?>admin/tickets/inprogress" class="waves-effect waves-dark">
                                                    <span class="pcoded-mtext"><?= __('In Progress') ?></span>
                                                    <span class="pcoded-badge label label-primary"><?= MENU_DATA['tickets_inprogress'] ?></span>
                                                </a>
                                            </li>

                                            <li class="<?php menu_active($page, "admin/tickets/list_answered", "active" ); ?>">
                                                <a href="<?= base_url(); ?>admin/tickets/answered" class="waves-effect waves-dark">
                                                    <span class="pcoded-mtext"><?= __('Answered') ?></span>
                                                </a>
                                            </li>

                                            <li class="<?php menu_active($page, "admin/tickets/list_all", "active" ); ?>">
                                                <a href="<?= base_url(); ?>admin/tickets/all" class="waves-effect waves-dark">
                                                    <span class="pcoded-mtext"><?= __('All') ?></span>
                                                </a>
                                            </li>

                                        </ul>
                                    </li>
                                    <?php } ?>

                                    <?php if(has_permission('issues-view')) { ?>
                                    <li class="pcoded-hasmenu <?php menu_active($page, "admin/issues", "active pcoded-trigger" ); ?>">
                                        <a href="javascript:void(0)" class="waves-effect waves-dark">
        									<span class="pcoded-micon"><i class="fas fa-tasks"></i></span>
                                            <span class="pcoded-mtext"><?= __('Issues') ?></span>
                                        </a>
                                        <ul class="pcoded-submenu">
                                            <li class="<?php menu_active($page, "admin/issues/list_assigned", "active" ); ?>">
                                                <a href="<?= base_url(); ?>admin/issues/assigned" class="waves-effect waves-dark">
                                                    <span class="pcoded-mtext"><?= __('Assigned') ?></span>
                                                    <span class="pcoded-badge label label-primary"><?= MENU_DATA['issues_assigned'] ?></span>
                                                </a>
                                            </li>
                                            <li class="<?php menu_active($page, "admin/issues/list_todo", "active" ); ?>">
                                                <a href="<?= base_url(); ?>admin/issues/todo" class="waves-effect waves-dark">
                                                    <span class="pcoded-mtext"><?= __('To Do') ?></span>
                                                    <span class="pcoded-badge label label-primary"><?= MENU_DATA['issues_todo'] ?></span>
                                                </a>
                                            </li>
                                            <li class="<?php menu_active($page, "admin/issues/list_inprogress", "active" ); ?>">
                                                <a href="<?= base_url(); ?>admin/issues/inprogress" class="waves-effect waves-dark">
                                                    <span class="pcoded-mtext"><?= __('In Progress') ?></span>
                                                    <span class="pcoded-badge label label-primary"><?= MENU_DATA['issues_inprogress'] ?></span>
                                                </a>
                                            </li>

                                            <li class="<?php menu_active($page, "admin/issues/list_done", "active" ); ?>">
                                                <a href="<?= base_url(); ?>admin/issues/done" class="waves-effect waves-dark">
                                                    <span class="pcoded-mtext"><?= __('Done') ?></span>
                                                </a>
                                            </li>

                                            <li class="<?php menu_active($page, "admin/issues/list_all", "active" ); ?>">
                                                <a href="<?= base_url(); ?>admin/issues/all" class="waves-effect waves-dark">
                                                    <span class="pcoded-mtext"><?= __('All') ?></span>
                                                </a>
                                            </li>

                                        </ul>
                                    </li>
                                    <?php } ?>

                                    <?php if(
                                        has_permission('leads-view') || 
                                        has_permission('proposals-view') || 
                                        has_permission('proformas-view') || 
                                        has_permission('invoices-view') || 
                                        has_permission('recurring-view') || 
                                        has_permission('items-view') || 
                                        has_permission('receipts-view') 
                                        ) { ?>
                                    <li class="pcoded-hasmenu <?php menu_active($page, "admin/sales", "active pcoded-trigger" ); ?>">
                                        <a href="javascript:void(0)" class="waves-effect waves-dark">
                                            <span class="pcoded-micon"><i class="fas fa-dollar-sign"></i></span>
                                            <span class="pcoded-mtext"><?= __('Sales') ?></span>
                                        </a>
                                        <ul class="pcoded-submenu">

                                            <?php if(has_permission('leads-view')) { ?>
                                            <li class="<?php menu_active($page, "admin/sales/leads", "active" ); ?>">
                                                <a href="<?= base_url(); ?>admin/sales/leads" class="waves-effect waves-dark">
                                                    <span class="pcoded-mtext"><?= __('Leads') ?></span>
                                                </a>
                                            </li>
                                            <?php } ?>


                                            <?php if(has_permission('proposals-view')) { ?>
                                            <li class="<?php menu_active($page, "admin/sales/proposals", "active" ); ?>">
                                                <a href="<?= base_url(); ?>admin/sales/proposals" class="waves-effect waves-dark">
                                                    <span class="pcoded-mtext"><?= __('Proposals') ?></span>
                                                </a>
                                            </li>
                                            <?php } ?>


                                            <?php if(has_permission('proformas-view')) { ?>
                                            <li class="<?php menu_active($page, "admin/sales/proformas", "active" ); ?>">
                                                <a href="<?= base_url(); ?>admin/sales/proformas" class="waves-effect waves-dark">
                                                    <span class="pcoded-mtext"><?= __('Proformas') ?></span>
                                                </a>
                                            </li>
                                            <?php } ?>


                                            <?php if(has_permission('invoices-view')) { ?>
                                            <li class="<?php menu_active($page, "admin/sales/invoices", "active" ); ?>">
                                                <a href="<?= base_url(); ?>admin/sales/invoices" class="waves-effect waves-dark">
                                                    <span class="pcoded-mtext"><?= __('Invoices') ?></span>
                                                </a>
                                            </li>
                                            <?php } ?>


                                            <?php if(has_permission('recurring-view')) { ?>
                                            <li class="<?php menu_active($page, "admin/sales/recurring", "active" ); ?>">
                                                <a href="<?= base_url(); ?>admin/sales/recurring" class="waves-effect waves-dark">
                                                    <span class="pcoded-mtext"><?= __('Recurring') ?></span>
                                                </a>
                                            </li>
                                            <?php } ?>


                                            <?php if(has_permission('items-view')) { ?>
                                            <li class="<?php menu_active($page, "admin/sales/items", "active" ); ?>">
                                                <a href="<?= base_url(); ?>admin/sales/items" class="waves-effect waves-dark">
                                                    <span class="pcoded-mtext"><?= __('Items') ?></span>
                                                </a>
                                            </li>
                                            <?php } ?>


                                            <?php if(has_permission('receipts-view')) { ?>
                                            <li class="<?php menu_active($page, "admin/sales/receipts", "active" ); ?>">
                                                <a href="<?= base_url(); ?>admin/sales/receipts" class="waves-effect waves-dark">
                                                    <span class="pcoded-mtext"><?= __('Receipts') ?></span>
                                                </a>
                                            </li>
                                            <?php } ?>



                                        </ul>
                                    </li>
                                    <?php } ?>


                                    <?php if(
                                        has_permission('suppliers-view') || 
                                        has_permission('expenses-view') || 
                                        has_permission('recurringexp-view')
                                        ) { ?>
                                    <li class="pcoded-hasmenu <?php menu_active($page, "admin/expenses", "active pcoded-trigger" ); ?>">
                                        <a href="javascript:void(0)" class="waves-effect waves-dark">
                                            <span class="pcoded-micon"><i class="fas fa-credit-card"></i></span>
                                            <span class="pcoded-mtext"><?= __('Expenses') ?></span>
                                        </a>
                                        <ul class="pcoded-submenu">

                                            <?php if(has_permission('suppliers-view')) { ?>
                                            <li class="<?php menu_active($page, "admin/expenses/suppliers", "active" ); ?>">
                                                <a href="<?= base_url(); ?>admin/expenses/suppliers" class="waves-effect waves-dark">
                                                    <span class="pcoded-mtext"><?= __('Suppliers') ?></span>
                                                </a>
                                            </li>
                                            <?php } ?>


                                            <?php if(has_permission('expenses-view')) { ?>
                                            <li class="<?php menu_active($page, "admin/expenses/expenses", "active" ); ?>">
                                                <a href="<?= base_url(); ?>admin/expenses/expenses" class="waves-effect waves-dark">
                                                    <span class="pcoded-mtext"><?= __('Expenses') ?></span>
                                                </a>
                                            </li>
                                            <?php } ?>


                                            <?php if(has_permission('recurringexp-view')) { ?>
                                            <li class="<?php menu_active($page, "admin/expenses/recurring", "active" ); ?>">
                                                <a href="<?= base_url(); ?>admin/expenses/recurring" class="waves-effect waves-dark">
                                                    <span class="pcoded-mtext"><?= __('Recurring') ?></span>
                                                </a>
                                            </li>
                                            <?php } ?>

                                        </ul>
                                    </li>
                                    <?php } ?>



                                    <?php if(has_permission('calendar-view')) { ?>
                                    <li class="<?php menu_active($page, "admin/calendar", "active" ); ?>">
                                        <a href="<?= base_url(); ?>admin/calendar" class="waves-effect waves-dark">
                                            <span class="pcoded-micon"><i class="fas fa-calendar-alt"></i></span>
                                            <span class="pcoded-mtext"><?= __('Calendar') ?></span>
                                        </a>
                                    </li>
                                    <?php } ?>

                                    <?php if(has_permission('reminders-view')) { ?>
                                    <li class="<?php menu_active($page, "admin/reminders", "active" ); ?>">
                                        <a href="<?= base_url(); ?>admin/reminders" class="waves-effect waves-dark">
                                            <span class="pcoded-micon"><i class="fas fa-bell"></i></span>
                                            <span class="pcoded-mtext"><?= __('Reminders') ?></span>
                                            <span class="pcoded-badge label label-primary"><?= MENU_DATA['reminders_upcoming'] ?></span>
                                        </a>
                                    </li>
                                    <?php } ?>

                                    <?php if(has_permission('filemanager')) { ?>
                                    <li class="<?php menu_active($page, "admin/filemanager", "active" ); ?>">
                                        <a href="<?= base_url(); ?>admin/filemanager" class="waves-effect waves-dark">
                                            <span class="pcoded-micon"><i class="fas fa-folder-open"></i></span>
                                            <span class="pcoded-mtext"><?= __('File Manager') ?></span>
                                        </a>
                                    </li>
                                    <?php } ?>


                                    <?php if(
                                        has_permission('kb-view') || 
                                        has_permission('documentation-view') || 
                                        has_permission('pr-view')
                                        ) { ?>
                                    <li class="pcoded-hasmenu <?php menu_active($page, "admin/content", "active pcoded-trigger" ); ?>">
                                        <a href="javascript:void(0)" class="waves-effect waves-dark">
                                            <span class="pcoded-micon"><i class="fas fa-book"></i></span>
                                            <span class="pcoded-mtext"><?= __('Content') ?></span>
                                        </a>
                                        <ul class="pcoded-submenu">
                                            <?php if(has_permission('kb-view')) { ?>
                                            <li class="<?php menu_active($page, "admin/content/knowledge_base", "active" ); ?>">
                                                <a href="<?= base_url(); ?>admin/content/knowledge_base" class="waves-effect waves-dark">
                                                    <span class="pcoded-mtext"><?= __('Knowledge Base') ?></span>
                                                </a>
                                            </li>
                                            <?php } ?>

                                            <?php if(has_permission('documentation-view')) { ?>
                                            <li class="<?php menu_active($page, "admin/content/documentation", "active" ); ?>">
                                                <a href="<?= base_url(); ?>admin/content/documentation" class="waves-effect waves-dark">
                                                    <span class="pcoded-mtext"><?= __('Documentation') ?></span>
                                                </a>
                                            </li>
                                            <?php } ?>

                                            <?php if(has_permission('pr-view')) { ?>
                                            <li class="<?php menu_active($page, "admin/content/predefined_replies", "active" ); ?>">
                                                <a href="<?= base_url(); ?>admin/content/predefined_replies" class="waves-effect waves-dark">
                                                    <span class="pcoded-mtext"><?= __('Predefined Replies') ?></span>
                                                </a>
                                            </li>
                                            <?php } ?>
                                        </ul>
                                    </li>
                                    <?php } ?>


                                    <?php if(has_permission('reports-view')) { ?>
                                    <li class="<?php menu_active($page, "admin/reports", "active" ); ?>">
                                        <a href="<?= base_url(); ?>admin/reports/index" class="waves-effect waves-dark">
                                            <span class="pcoded-micon"><i class="fas fa-chart-bar"></i></span>
                                            <span class="pcoded-mtext"><?= __('Reports') ?></span>
                                        </a>
                                    </li>
                                    <?php } ?>





                                    <?php if(
                                        has_permission('staff-view') || 
                                        has_permission('roles-view') || 
                                        has_permission('cf-view') || 
                                        has_permission('logs') || 
                                        has_permission('settings')
                                       
                                        ) { ?>
                                    <li class="pcoded-hasmenu <?php menu_active($page, "admin/setup", "active pcoded-trigger" ); ?>">
                                        <a href="javascript:void(0)" class="waves-effect waves-dark">
        									<span class="pcoded-micon"><i class="feather icon-settings"></i></span>
                                            <span class="pcoded-mtext"><?= __('Setup') ?></span>
                                        </a>
                                        <ul class="pcoded-submenu">
                                            <?php if(has_permission('staff-view')) { ?>
                                            <li class="<?php menu_active($page, "admin/setup/staff", "active" ); ?>">
                                                <a href="<?= base_url(); ?>admin/setup/staff" class="waves-effect waves-dark">
                                                    <span class="pcoded-mtext"><?= __('Staff') ?></span>
                                                </a>
                                            </li>
                                            <?php } ?>

                                            <?php if(has_permission('roles-view')) { ?>
                                            <li class="<?php menu_active($page, "admin/setup/roles", "active" ); ?>">
                                                <a href="<?= base_url(); ?>admin/setup/roles" class="waves-effect waves-dark">
                                                    <span class="pcoded-mtext"><?= __('Roles') ?></span>
                                                </a>
                                            </li>
                                            <?php } ?>

                                            <?php if(has_permission('cf-view')) { ?>
                                            <li class="<?php menu_active($page, "admin/setup/customfields", "active" ); ?>">
                                                <a href="<?= base_url(); ?>admin/setup/customfields" class="waves-effect waves-dark">
                                                    <span class="pcoded-mtext"><?= __('Custom Fields') ?></span>
                                                </a>
                                            </li>
                                            <?php } ?>

                                            <?php if(has_permission('logs')) { ?>
                                            <li class="<?php menu_active($page, "admin/setup/logs", "active" ); ?>">
                                                <a href="<?= base_url(); ?>admin/setup/logs/" class="waves-effect waves-dark">
                                                    <span class="pcoded-mtext"><?= __('Logs') ?></span>
                                                </a>
                                            </li>
                                            <?php } ?>

                                            <?php if(has_permission('settings')) { ?>
                                            <li class="<?php menu_active($page, "admin/setup/settings", "active" ); ?>">
                                                <a href="<?= base_url(); ?>admin/setup/settings" class="waves-effect waves-dark">
                                                    <span class="pcoded-mtext"><?= __('Settings') ?></span>
                                                </a>
                                            </li>
                                            <?php } ?>
                                        </ul>
                                    </li>
                                    <?php } ?>

                                </ul>
                                


                            </div>
                        </div>
                    </nav>




                    <!-- main content start-->
                    <?php $this->load->view($page); ?>
                    <!-- main content end-->



                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="main-modal" role="dialog">
        <div class="modal-dialog modal-lg" id="main-modal-content" role="document">

        </div>
    </div>


    <!-- Warning Section Ends -->
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

    <!-- Tree view js -->
    
    <script type="text/javascript" src="<?= base_url()?>public/components/jstree/js/jstree.min.js"></script>
    <script type="text/javascript" src="<?= base_url()?>public/assets/pages/treeview/jquery.tree.js"></script>

    <!-- bootstrap-colorpicker -->
    <script type="text/javascript" src="<?= base_url()?>public/components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>


    <!-- Tiny MCE -->
    <script type="text/javascript" src="<?= base_url()?>public/components/tinymce5/js/tinymce/tinymce.min.js"></script>


    <!-- data-table js -->
    <script type="text/javascript" src="<?= base_url()?>public/components/datatables/datatables.min.js"></script>


    <!-- B Datepicker -->
    <script type="text/javascript" src="<?= base_url()?>public/components/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="<?= base_url()?>public/components/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>


    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>


    <!-- Custom js -->
    <script src="<?= base_url()?>public/assets/js/pcoded.js"></script>
    <script src="<?= base_url()?>public/assets/js/vertical/vertical-layout.min.js"></script>
    <script type="text/javascript" src="<?= base_url()?>public/assets/js/script.js"></script>

  
    <script src="<?= base_url()?>public/components/elfinder/js/elfinder.min.js" ></script>
    <link rel="stylesheet" href="<?= base_url()?>public/components/elfinder/css/elfinder.min.css" />
    <script type="text/javascript" src="<?= base_url()?>public/components/elfinder/tinymceElfinder.js"></script>
    <link rel="stylesheet" href="<?= base_url(); ?>/public/Material/css/theme-gray.css" type="text/css">
   
    <script>

        const mceElf = new tinymceElfinder({
            // connector URL (Set your connector)
            url: '<?= site_url() . 'admin/filemanager/connector'; ?>',
            // upload target folder hash for this tinyMCE
            uploadTargetHash: 'dsdsds', // Hash value on elFinder of writable folder
            // elFinder dialog node id
            nodeId: 'elfinder' // Any ID you decide
        });

        tinymce.init({
          selector: '#tinymceinput',
          height : 500,

          <?php if($this->session->staff_body_class  == "nightynight") { ?>
              skin: "oxide-dark",
              content_css: "dark",
          <?php } ?>

          cleanup : false,
          verify_html : false,
          relative_urls: false,
          remove_script_host : false,
          convert_urls: false,

          plugins: 'print preview importcss searchreplace autolink autosave save directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars emoticons lists',

          toolbar: 'undo redo | styleselect | numlist bullist | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | link image | code',

          file_picker_callback : mceElf.browser,
          images_upload_handler: mceElf.uploadHandler,
          browser_spellcheck : true,
          contextmenu: false,


        });

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


            // initiate datepicker
            $('#datepicker, #datepicker2, #datepicker3').datepicker({
                format: '<?php echo date_js_format(); ?>',
                clearBtn: 'true',
                weekStart: '<?php echo get_setting("week_start"); ?>',
                autoclose: true
            });


            $( "#manual_name" ).autocomplete({
              source: function( request, response ) {
                $.ajax( {
                  url: "<?= base_url(); ?>admin/json/items_all_autocomplete",
                  dataType: "json",
                  data: {
                    q: request.term
                  },
                  success: function( data ) {
                    response( data );
                  }
                } );
              },
              minLength: 1,
   
            });


        });



        function show_modal(modal) {
            url = '<?= base_url(); ?>' +  modal;

            $('#main-modal-content').empty();
            $('#main-modal-content').load(url);
            $('#main-modal').modal('show');
        }

    </script>

    <?php if($page == "admin/filemanager") { ?>
        
        <script src="<?= base_url()?>public/components/require/require.min.js"></script>

        <script>
            define('elFinderConfig', {
                defaultOpts : {
                    url : '<?php echo $connector ?>' // connector URL (REQUIRED)
                    ,commandsOptions : {
                        edit : {
                            extraOptions : {
                                // set API key to enable Creative Cloud image editor
                                // see https://console.adobe.io/
                                creativeCloudApiKey : '',
                                // browsing manager URL for CKEditor, TinyMCE
                                // uses self location with the empty value
                                managerUrl : ''
                            }
                        }
                        ,quicklook : {
                            // to enable preview with Google Docs Viewer
                            googleDocsMimes : ['application/pdf', 'image/tiff', 'application/vnd.ms-office', 'application/msword', 'application/vnd.ms-word', 'application/vnd.ms-excel', 'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']
                        }
                    }
                    // bootCalback calls at before elFinder boot up 
                    ,bootCallback : function(fm, extraObj) {

                    
                    }
                },
                managers : {
                    // 'DOM Element ID': { /* elFinder options of this DOM Element */ }
                    'elfinder': {}
                }
            });

            define('returnVoid', void 0);

            (function(){
                var // elFinder version
                    elver = '<?php echo elFinder::getApiFullVersion()?>',
                    // jQuery and jQueryUI version
                    jqver = '3.2.1',
                    uiver = '1.12.1',
                    
                    // Detect language (optional)
                    lang = (function() {
                        var locq = window.location.search,
                            fullLang, locm, lang;
                        if (locq && (locm = locq.match(/lang=([a-zA-Z_-]+)/))) {
                            // detection by url query (?lang=xx)
                            fullLang = locm[1];
                        } else {
                            // detection by browser language
                            fullLang = (navigator.browserLanguage || navigator.language || navigator.userLanguage);
                        }
                        lang = fullLang.substr(0,2);
                        if (lang === 'ja') lang = 'jp';
                        else if (lang === 'pt') lang = 'pt_BR';
                        else if (lang === 'ug') lang = 'ug_CN';
                        else if (lang === 'zh') lang = (fullLang.substr(0,5).toLowerCase() === 'zh-tw')? 'zh_TW' : 'zh_CN';
                        return lang;
                    })(),
                    
                    // Start elFinder (REQUIRED)
                    start = function(elFinder, editors, config) {
                        // load jQueryUI CSS
                        elFinder.prototype.loadCss('<?= base_url()?>public/components/jquery-ui/jquery-ui-smootnes.css');
                        
                        $(function() {
                            var optEditors = {
                                    commandsOptions: {
                                        edit: {
                                            editors: Array.isArray(editors)? editors : []
                                        }
                                    }
                                },
                                opts = {};
                            
                            // Interpretation of "elFinderConfig"
                            if (config && config.managers) {
                                $.each(config.managers, function(id, mOpts) {
                                    opts = Object.assign(opts, config.defaultOpts || {});
                                    // editors marges to opts.commandOptions.edit
                                    try {
                                        mOpts.commandsOptions.edit.editors = mOpts.commandsOptions.edit.editors.concat(editors || []);
                                    } catch(e) {
                                        Object.assign(mOpts, optEditors);
                                    }
                                    // Make elFinder
                                    $('#' + id).elfinder(
                                        // 1st Arg - options
                                        $.extend(true, { lang: lang }, opts, mOpts || {}),
                                        // 2nd Arg - before boot up function

                                    );
                                });
                            } else {
                                alert('"elFinderConfig" object is wrong.');
                            }
                        });
                    },
                    
                    // JavaScript loader (REQUIRED)
                    load = function() {
                        require(
                            [
                                'elfinder'
                                , 'extras/editors.default'       // load text, image editors
                                , 'elFinderConfig'
                            ],
                            start,
                            function(error) {
                                alert(error.message);
                            }
                        );
                    },
                    
                    // is IE8? for determine the jQuery version to use (optional)
                    ie8 = (typeof window.addEventListener === 'undefined' && typeof document.getElementsByClassName === 'undefined');

                // config of RequireJS (REQUIRED)
                require.config({
                    baseUrl : '<?= base_url() ?>public/components/elfinder/js',
                    paths : {
                        'jquery'   : '<?= base_url()?>public/components/jquery/js/jquery-3.6.1.min',
                        'jquery-ui': '<?= base_url()?>public/components/jquery-ui/js/jquery-ui.min',
                        'elfinder' : 'elfinder.min',
                       
                    },
                    waitSeconds : 10 // optional
                });

                //load JavaScripts (REQUIRED)
                load();

            })();
        </script>

   

    <?php } ?>

   

</body>

</html>
