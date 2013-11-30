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
                        'brandUrl' => '#',
                        'collapse' => true, // requires bootstrap-responsive.css
                        'htmlOptions' => array('class' => 'pull-right nav'),
                        'items' => array(
                            array(
                                'class' => 'bootstrap.widgets.TbMenu',
                                'htmlOptions' => array('class' => 'pull-right'),
                                'items' => array(
                                    array('label' => 'Мониторинг', 'url' => array('/DeviceStatus/admin', 'visible' => !Yii::app()->user->isGuest)),
                                    array('label' => 'Настройка', 'url' => '#',
                                        'itemOptions' => array('class' => 'dropdown', 'tabindex' => "-1"),
                                        'linkOptions' => array('class' => 'dropdown-toggle', 'data-toggle' => "dropdown"),
                                        'items' => array(
                                            array('label' => 'Управление песоналом', 'url' => '/index.php/staff/admin'),
                                            array('label' => 'Объекты', 'url' => '/index.php/object/admin'),
                                            array('label' => 'Устройства', 'url' => '/index.php/device/admin'),
                                        )),
                                    array('label' => 'Аналитика', 'url'=>array('/site/page', 'view'=>'graphs')),
                                    //array('label' => 'Карта', 'url' => array('#')),
                                    //array('label' => 'Помощь', 'url' => array('#')),
                                    array('label' => 'Выйти (' . Yii::app()->user->name . ')', 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest),
                                ),
                            ),
                            //'<form class="navbar-search pull-left" action=""><input type="text" class="search-query span2" placeholder="Search"></form>',
                        ),
                    ));

                    /* $this->widget('zii.widgets.CMenu', array(
                      'htmlOptions' => array('class' => 'pull-right nav'),
                      'submenuHtmlOptions' => array('class' => 'dropdown-menu'),
                      'itemCssClass' => 'item-test',
                      'lastItemCssClass' => 'item-last',
                      'encodeLabel' => false,
                      'items' => array(
                      array('label' => 'Мониторинг', 'url' => array('/site/index', 'visible' => !Yii::app()->user->isGuest)),
                      array('label' => 'Настройка', 'url' => array('/admin')),
                      array('label' => 'Настройка <span class="caret"></span>', 'url' => '#', 'itemOptions' => array('class' => 'dropdown', 'tabindex' => "-1"), 'linkOptions' => array('class' => 'dropdown-toggle', 'data-toggle' => "dropdown"),
                      'items' => array(
                      array('label' => 'Управление песоналом', 'url' => '/index.php/staff/admin'),
                      array('label' => 'Организации', 'url' => '#'),
                      array('label' => 'Объекты', 'url' => '#'),
                      )),
                      array('label' => 'Аналитика', 'url' => array('/site/index')),
                      array('label' => 'Карта', 'url' => array('/site/index')),
                      array('label' => 'Помощь', 'url' => array('/site/index')),
                      array('label' => 'Dashboard', 'url' => array('/site/index')),
                      array('label'=>'Graphs & Charts', 'url'=>array('/site/page', 'view'=>'graphs')),
                      array('label'=>'Forms', 'url'=>array('/site/page', 'view'=>'forms')),
                      array('label'=>'Tables', 'url'=>array('/site/page', 'view'=>'tables')),
                      array('label'=>'Interface', 'url'=>array('/site/page', 'view'=>'interface')),
                      array('label'=>'Typography', 'url'=>array('/site/page', 'view'=>'typography')),
                      array('label'=>'Gii generated', 'url'=>array('customer/index')), 
                             array('label'=>'My Account <span class="caret"></span>', 'url'=>'#','itemOptions'=>array('class'=>'dropdown','tabindex'=>"-1"),'linkOptions'=>array('class'=>'dropdown-toggle','data-toggle'=>"dropdown"), 
                              'items'=>array(
                              array('label'=>'My Messages <span class="badge badge-warning pull-right">26</span>', 'url'=>'#'),
                              array('label'=>'My Tasks <span class="badge badge-important pull-right">112</span>', 'url'=>'#'),
                              array('label'=>'My Invoices <span class="badge badge-info pull-right">12</span>', 'url'=>'#'),
                              array('label'=>'Separated link', 'url'=>'#'),
                              array('label'=>'One more separated link', 'url'=>'#'),
                              )), 
                            array('label' => 'Login', 'url' => array('/site/login'), 'visible' => Yii::app()->user->isGuest),*/
                            /*array('label' => 'Logout (' . Yii::app()->user->name . ')', 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest),
                        ),
                    ));*/
                }
                ?>
            </div>
        </div>
    </div>
</div>

<!--

<div class="subnav navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
        
                <div class="style-switcher pull-left">
                <a href="javascript:chooseStyle('none', 60)" checked="checked"><span class="style" style="background-color:#0088CC;"></span></a>
                <a href="javascript:chooseStyle('style2', 60)"><span class="style" style="background-color:#7c5706;"></span></a>
                <a href="javascript:chooseStyle('style3', 60)"><span class="style" style="background-color:#468847;"></span></a>
                <a href="javascript:chooseStyle('style4', 60)"><span class="style" style="background-color:#4e4e4e;"></span></a>
                <a href="javascript:chooseStyle('style5', 60)"><span class="style" style="background-color:#d85515;"></span></a>
                <a href="javascript:chooseStyle('style6', 60)"><span class="style" style="background-color:#a00a69;"></span></a>
                <a href="javascript:chooseStyle('style7', 60)"><span class="style" style="background-color:#a30c22;"></span></a>
                </div>
           <form class="navbar-search pull-right" action="">
                 
           <input type="text" class="search-query span2" placeholder="Search">
           
           </form>
        </div>
    </div>
</div>
-->