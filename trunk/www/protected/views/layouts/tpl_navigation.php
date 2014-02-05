<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>

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
                                    array('label' => 'Администрирование', 'url' => '/Object'),
                                    array('label' => 'Настройки', 'url' => '/settingsTemplate/admin'),
                                    array('label' => 'Отчеты', 'url' => array('/ReportPage/StatusReport')),
                                    array('label' => 'Выйти (' . Yii::app()->user->name . ')',
                                        'icon'=>'user',
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