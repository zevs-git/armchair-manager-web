<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <style>
                .dropdown-menu li:hover .sub-menu {
                    visibility: visible;
                }

                .dropdown:hover .dropdown-menu {
                    display: block;
                }

                .nav-tabs .dropdown-menu, .nav-pills .dropdown-menu, .navbar .dropdown-menu {
                    margin-top: 0;
                }

                .navbar .sub-menu:before {
                    border-bottom: 7px solid transparent;
                    border-left: none;
                    border-right: 7px solid rgba(0, 0, 0, 0.2);
                    border-top: 7px solid transparent;
                    left: -7px;
                    top: 10px;
                }
                .navbar .sub-menu:after {
                    border-top: 6px solid transparent;
                    border-left: none;
                    border-right: 6px solid #fff;
                    border-bottom: 6px solid transparent;
                    left: 10px;
                    top: 11px;
                    left: -6px;
                }

            </style>
            <!-- Be sure to leave the brand out there if you want it shown -->

            <div class="nav-collapse">
                <?php
                if (!Yii::app()->user->isGuest) {
                    $this->widget('bootstrap.widgets.TbNavbar', array(
                        'type' => 'inverse', // null or 'inverse'
                        'brand' => '<img src="\images\logo\Magic_Rest_logo_30.png">',
                        'brandUrl' => '#',
                        'collapse' => true, // requires bootstrap-responsive.css
                        'items' => array(
                            array(
                                'class' => 'bootstrap.widgets.TbMenu',
                                'htmlOptions' => array('class' => 'pull-right nav'),
                                'items' => array(
                                    array('label' => 'Мониторинг', 'url' => array('/DeviceStatus/admin', 'visible' => !Yii::app()->user->isGuest)),
                                    array('label' => 'Администрирование', 'url' => '/Object',
                                        'active' => (in_array(get_class($this), array('ObjectController', 'DeviceController', 'StaffController'))),
                                        'items' => array(
                                            array('label' => 'Объекты', 'url' => array('//Object'), 'active' => (get_class($this) == 'ObjectController')),
                                            array('label' => 'Устройства', 'url' => array('//Device'), 'active' => (get_class($this) == 'DeviceController')),
                                            array('label' => 'Персонал', 'url' => array('//Staff'), 'active' => (get_class($this) == 'StaffController')),
                                        ),),
                                    array('label' => 'Настройки', 'url' => '/settingsTemplate/admin',
                                        'active' => (in_array(get_class($this),array('settingsTemplate'))),
                                        ),
                                    array('label' => 'Отчеты', 'url' => '#',
                                        'active' => (in_array(get_class($this),array('ReportPageController'))),
                                        'htmlOptions' => array('onMouseOver' => 'js:$(this).click();'),
                                        'items' => array(
                                            array('label' => 'Характеристика работы', 'url' => array('/reportPage/StatusReport'), 'active' => ($this->action->id == 'StatusReport')),
                                            array('label' => 'Инкассация', 'url' => array('/reportPage/IncassatorReport'), 'active' => ($this->action->id == 'IncassatorReport')),
                                            array('label' => 'Выручка', 'url' => array('/reportPage/SumaryReport'), 'active' => ($this->action->id == 'SumaryReport')),
                                            array('label' => 'Массаж', 'url' => array('/reportPage/MassageReport'), 'active' => ($this->action->id == 'MassageReport')),
                                        ),
                                    ),
                                    array('label' => 'Выйти (' . Yii::app()->user->name . ')',
                                        'icon' => 'user',
                                        'url' => array('/site/logout'),
                                        'visible' => !Yii::app()->user->isGuest
                                    ),
                                ),
                            ),
                        //'<form class="navbar-search pull-left" action=""><input type="text" class="search-query span2" placeholder="Search"></form>',
                        ),
                            )

                            //'<form class="navbar-search pull-left" action=""><input type="text" class="search-query span2" placeholder="Search"></form>',
                    );
                }
                ?>
            </div>
        </div>
    </div>
</div>