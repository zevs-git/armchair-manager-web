<?php

class ReportPageController extends RController {

    public $layout = '//layouts/report_navigator';
    public $searchBy;
    public $showRep;
    
    public function filters() {
        return array(
            'rights', 
          );
    }

    public function actionStatusReport() {
        if ($this->checkInput()) {
            $sql = "SELECT
                     obj.id as obj_id, obj.obj as obj_name,
                     `d`.`id` AS `device_id`,
                     `d`.`comment`,
                     IFNULL(SUM(`srgd`.`m`), 0) AS `m`, 
                     IFNULL(SUM(`srgd`.`p`), 0) AS `p`, 
                     IFNULL(SUM(`srgd`.`c`), 0) AS `c`, 
                     IFNULL(SUM(`srgd`.`e`), 0) AS `e`
                     FROM (object obj,`device` `d`
                     LEFT JOIN `status_rep_group_day` `srgd`
                     ON ((`d`.`id` = `srgd`.`device_id`)))
                     WHERE
                     `srgd`.`day` >= '" . (date("Y-m-d", strtotime($_REQUEST['date_from']))) . "' AND `srgd`.`day` <= '" . date("Y-m-d", strtotime($_REQUEST['date_to'])) . "'
                     AND d.object_id = obj.id" .
                    (is_numeric($_REQUEST['object_id']) ? " AND obj.id = " . $_REQUEST['object_id'] : "") .
                    //(!empty($_REQUEST['country']) ? " AND obj.country = '" . $_REQUEST['country'] . "'" : "") .
                    (!empty($_REQUEST['region']) ? " AND obj.region = '" . $_REQUEST['region'] . "'" : "") .
                    (!empty($_REQUEST['city']) ? " AND obj.city = '" . $_REQUEST['city'] . "'" : "") .
                    " GROUP BY obj.id,obj.obj,`d`.`id`,`d`.`comment`";

            $rows = Yii::app()->db->createCommand($sql)->queryAll();
            $count = count($rows);

            $dataProvider = new CSqlDataProvider($sql, array(
                //'keyField'=>'device_id',
                'totalItemCount' => $count,
                'pagination' => array(
                    'pageSize' => 100,
                ),
            ));

            $obj = NULL;
            $data = array();
            
            foreach ($dataProvider->getData() as $data_row) {
                if (!isset($obj) || $obj != $data_row['obj_id']) {
                    $obj = $data_row['obj_id'];
                    $data[$obj] = array();
                    $data[$obj]['device'] = array();
                    $data[$obj]['m'] = array();
                    $data[$obj]['p'] = array();
                    $data[$obj]['c'] = array();
                    $data[$obj]['e'] = array();
                }
                $data[$obj]['device'][] = $data_row['comment'] . " [" . $data_row['device_id'] . "]";
                $data[$obj]['obj_name'][] = $data_row['obj_name'];
                $data[$obj]['m'][] = (int) $data_row['m'];
                $data[$obj]['p'][] = (int) $data_row['p'];
                $data[$obj]['c'][] = (int) $data_row['c'];
                $data[$obj]['e'][] = (int) $data_row['e'];
            }
        }

        //print_r($dataProvider->getData());
        $this->render('status_report', array(
            'data' => $data,
        ));
    }

    private function checkInput() {

        if (!isset($_REQUEST['date_from']) || !isset($_REQUEST['date_to'])) {
            foreach (Yii::app()->session->toArray() as $key => $value) {
                $key = str_replace('report_', '', $key);
                if (in_array($key, array('city', 'region', 'object_id', 'date_from', 'date_to'))) {
                    $_REQUEST[$key] = $value;
                }
            }
        }

        foreach ($_REQUEST as $key => $value) {
            if (in_array($key, array('city', 'region', 'object_id', 'date_from', 'date_to'))) {
                Yii::app()->session->add('report_' . $key, $value);
            }
        }
        if (is_numeric($_REQUEST['object_id']) || !empty($_REQUEST['city']) || !empty($_REQUEST['region'])) {
            if (is_numeric($_REQUEST['object_id'])) {
                /*unset($_REQUEST['country']);
                unset($_REQUEST['city']);
                unset($_REQUEST['region']);*/
                $this->searchBy = "по объекту '" . Object::model()->findByPk($_REQUEST['object_id'])->obj . "'";
            } else if (!empty($_REQUEST['city'])) {
                /*unset($_REQUEST['region']);
                unset($_REQUEST['country']);*/
                $this->searchBy = "по городу '" . $_REQUEST['city'] . "'";
            } else if (!empty($_REQUEST['region'])) {
                /*unset($_REQUEST['country']);*/
                $this->searchBy = "по региону '" . $_REQUEST['region'] . "'";
            } else {
                $this->searchBy = "по стране '" . $_REQUEST['country'] . "'";
            }
            $this->showRep = true;
        } else {
            $this->showRep = false;
        }

        return $this->showRep;
    }

    public function actionIncassatorReport() {
        if ($this->checkInput()) {

            $sql = "SELECT obj.obj,d.comment AS name,ir.dt,s.FIO,ir.count_cash,ir.summ_cash,ir.count_coin,ir.summ_coin, summ_cash + summ_coin as all_summ
                            FROM incassator_report ir, device d, staff s, object obj
                            WHERE ir.device_id = d.id
                            AND d.object_id = obj.id
                            AND ir.dt >= '" . date("Y-m-d H:i:s", strtotime($_REQUEST['date_from'])) . "' AND ir.dt <= '" . date("Y-m-d H:i:s", strtotime($_REQUEST['date_to'])) . "'" .
                    (is_numeric($_REQUEST['object_id']) ? " AND obj.id = " . $_REQUEST['object_id'] : "") .
                    //(!empty($_REQUEST['country']) ? " AND obj.country = '" . $_REQUEST['country'] . "'" : "") .
                    (!empty($_REQUEST['region']) ? " AND obj.region = '" . $_REQUEST['region'] . "'" : "") .
                    (!empty($_REQUEST['city']) ? " AND obj.city = '" . $_REQUEST['city'] . "'" : "") .
                    " AND ir.staff_id = s.id
                            AND summ_cash + summ_coin > 0
                            order by obj.obj,d.comment, ir.dt";

            $dataProvider = new CSqlDataProvider($sql, array(
                //'totalItemCount'=>$count,
                'pagination' => array(
                    'pageSize' => 100,
                ),
            ));
        };
        $this->render('incassator_report', array(
            'data' => $dataProvider,
        ));
    }
    
    public function actionStaffReport() {
        if ($this->checkInput()) {

            $sql = "SELECT o.obj,d.comment, ik.dt,s.FIO, st.descr as type
                    FROM ident_key ik,staff s,object o, device d, staff_type st
                    WHERE ik.`key` = CONV(s.`key`,16,10)
                    AND ik.device_id = d.id
                    AND d.object_id = o.id
                    AND s.staff_type_id = st.id
                    AND ik.dt >= '" . date("Y-m-d H:i:s", strtotime($_REQUEST['date_from'])) . "' AND ik.dt <= '" . date("Y-m-d H:i:s", strtotime($_REQUEST['date_to'])) . "'" .
                    (is_numeric($_REQUEST['object_id']) ? " AND o.id = " . $_REQUEST['object_id'] : "") .
                    //(!empty($_REQUEST['country']) ? " AND obj.country = '" . $_REQUEST['country'] . "'" : "") .
                    (!empty($_REQUEST['region']) ? " AND o.region = '" . $_REQUEST['region'] . "'" : "") .
                    (!empty($_REQUEST['city']) ? " AND o.city = '" . $_REQUEST['city'] . "'" : "") .
                    " order by o.obj,d.comment, ik.dt";

            $dataProvider = new CSqlDataProvider($sql, array(
                //'totalItemCount'=>$count,
                'pagination' => array(
                    'pageSize' => 100,
                ),
            ));
        };
        $this->render('staff_report', array(
            'data' => $dataProvider,
        ));
    }

    public function actionSumaryReport() {
        if ($this->checkInput()) {
            $sql = "SELECT obj.obj,d.id,d.comment AS name, CAST(c.dt AS DATE) AS dt, SUM(c.value) AS sum,
                        CASE WHEN DAYOFWEEK(c.dt) IN (7,1) THEN \"weekend\" ELSE \"\" END AS class
                        FROM cash c, device d, object obj
                        WHERE c.device_id = d.id
                        AND d.object_id = obj.id
                        AND c.dt >= '" . date("Y-m-d H:i:s", strtotime($_REQUEST['date_from'])) . "' AND c.dt <= '" . date("Y-m-d H:i:s", strtotime($_REQUEST['date_to'])) . "'" .
                    (is_numeric($_REQUEST['object_id']) ? " AND obj.id = " . $_REQUEST['object_id'] : "") .
                    //(!empty($_REQUEST['country']) ? " AND obj.country = '" . $_REQUEST['country'] . "'" : "") .
                    (!empty($_REQUEST['region']) ? " AND obj.region = '" . $_REQUEST['region'] . "'" : "") .
                    (!empty($_REQUEST['city']) ? " AND obj.city = '" . $_REQUEST['city'] . "'" : "") .
                    " GROUP BY obj.obj,d.id,CAST(c.dt AS DATE)
                         order by obj.obj,d.id,c.dt";
            $dataProvider = new CSqlDataProvider($sql, array(
                //'totalItemCount'=>$count,
                'pagination' => array(
                    'pageSize' => 100,
                ),
            ));
        }
        $this->render('summary_report', array(
            'data' => $dataProvider,
        ));
    }

    public function actionMassageReport() {
        if ($this->checkInput()) {

            $sql = "SELECT obj.id as obj_id, obj.obj,m.device_id,d.comment AS name,SEC_TO_TIME(SUM(m.time)) AS time, SUM(m.time) AS sec 
                    FROM massage m , device d, object obj
                    WHERE m.device_id = d.id
                    AND d.object_id = obj.id
                    AND m.dt >= '" . date("Y-m-d H:i:s", strtotime($_REQUEST['date_from'])) . "' AND m.dt <= '" . date("Y-m-d H:i:s", strtotime($_REQUEST['date_to'])) . "'" .
                    (is_numeric($_REQUEST['object_id']) ? " AND obj.id = " . $_REQUEST['object_id'] : "") .
                    //(!empty($_REQUEST['country']) ? " AND obj.country = '" . $_REQUEST['country'] . "'" : "") .
                    (!empty($_REQUEST['region']) ? " AND obj.region = '" . $_REQUEST['region'] . "'" : "") .
                    (!empty($_REQUEST['city']) ? " AND obj.city = '" . $_REQUEST['city'] . "'" : "") .
                    " GROUP BY obj.id, obj.obj,m.device_id,d.comment";
            if (!empty($_REQUEST['sort_by_time'])) $sql .= " ORDER BY sec DESC";
            $dataProvider = new CSqlDataProvider($sql, array(
                //'totalItemCount'=>$count,
                'pagination' => array(
                    'pageSize' => 100,
                ),
            ));
            
            
            if ($_REQUEST['rep_type']) {
                $obj = NULL;
                $data = array();

                foreach ($dataProvider->getData() as $data_row) {
                    if (!isset($obj) || $obj != $data_row['obj_id']) {
                        $obj = $data_row['obj_id'];
                        $data[$obj] = array();
                        $data[$obj]['device'] = array();
                        $data[$obj]['time'] = array();
                    }
                    $data[$obj]['device'][] = $data_row['name'] . " [" . $data_row['device_id'] . "]";
                    $data[$obj]['obj_name'][] = $data_row['obj'];
                    $data[$obj]['time'][] = (int)$data_row['sec'];
                }
            }
            
        }
        
        if ($_REQUEST['rep_type']) {
            $this->render('massage_report_graph', array(
                'data' => $data,
            ));
        } else {
            $this->render('massage_report', array(
                'data' => $dataProvider,
            ));
        }
    }
    
    public function actionGetListData() {
        $dataType = @$_REQUEST['datatype'];
        //$country  = @$_REQUEST['country'];
        $region   = @$_REQUEST['region'];
        $city     = @$_REQUEST['city'];
        
        $crit = (Yii::app()->user->checkAccess('Superadmin'))?"1 = 1 ":'departament_id = ' . Yii::app()->getModule('user')->user()->departament_id;
        $crit .=  " and country = 'Россия'";
        $crit .=  ($region)?" and region = '$region'":$region;
        $crit .=  ($city)? " and city = '$city'":$city;
       
        
        switch($dataType) {
            /*case 'country': 
                $list = array_unique(CHtml::listData(Object::model()->findAll($crit), 'country', 'country'));
                break;*/
            case 'region': 
                $list = array_unique(CHtml::listData(Object::model()->findAll($crit), 'region', 'region'));
                break;
            case 'city': 
                $list = array_unique(CHtml::listData(Object::model()->findAll($crit), 'city', 'city'));
                break;
            case 'object_id': 
                $list = CHtml::listData(Object::model()->findAll($crit), 'id', 'obj');
                break;
        }
        //echo '<select>';
        echo '<option value="">Выберите значение</option>';
        
        foreach ($list as $val) {
            echo '<option value="' . $val .'">' .$val . '</option>';
        }
        
        //echo '</select>';
                
        //print_r($list);
        //echo json_encode($list);
    }

}
