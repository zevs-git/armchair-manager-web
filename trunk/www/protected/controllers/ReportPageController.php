<?php

class ReportPageController extends Controller {

    public $layout = '//layouts/report_navigator';
    public $searchBy;
    public $showRep;

    public function actionStatusReport() {
        if ($this->checkInput()) {
            $sql = "SELECT
                    `d`.`id` AS `device_id`,
                     IFNULL(`srgd`.`m`, 0) AS `m`,
                     IFNULL(`srgd`.`p`, 0) AS `p`,
                     IFNULL(`srgd`.`c`, 0) AS `c`,
                     IFNULL(`srgd`.`e`, 0) AS `e`
                     FROM (object obj,`device` `d`
                     LEFT JOIN `status_rep_group_day` `srgd`
                     ON ((`d`.`id` = `srgd`.`device_id`)))
                     WHERE
                     `srgd`.`day` >= '" . (date("Y-m-d", strtotime($_REQUEST['date_from']))) . "' AND `srgd`.`day` <= '" . date("Y-m-d", strtotime($_REQUEST['date_to'])) . "'
                     AND d.object_id = obj.id" .
                    (is_numeric($_REQUEST['object_id']) ? " AND obj.id = " . $_REQUEST['object_id'] : "") .
                    (!empty($_REQUEST['country']) ? " AND obj.country = '" . $_REQUEST['country'] . "'" : "") .
                    (!empty($_REQUEST['region']) ? " AND obj.region = '" . $_REQUEST['region'] . "'" : "") .
                    (!empty($_REQUEST['city']) ? " AND obj.city = '" . $_REQUEST['city'] . "'" : "") .
                    " GROUP BY srgd.device_id";

            $rows = Yii::app()->db->createCommand($sql)->queryAll();
            $count = count($rows);

            $dataProvider = new CSqlDataProvider($sql, array(
                //'keyField'=>'device_id',
                'totalItemCount' => $count,
                'pagination' => array(
                    'pageSize' => 100,
                ),
            ));

            $data = array();
            $data['device'] = array();
            $data['m'] = array();
            $data['p'] = array();
            $data['c'] = array();
            $data['e'] = array();
            foreach ($dataProvider->getData() as $data_row) {
                $data['device'][] = $data_row['device_id'];
                $data['m'][] = (int) $data_row['m'];
                $data['p'][] = (int) $data_row['p'];
                $data['c'][] = (int) $data_row['c'];
                $data['e'][] = (int) $data_row['e'];
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
                if (in_array($key, array('country', 'city', 'region', 'object_id', 'date_from', 'date_to'))) {
                    $_REQUEST[$key] = $value;
                }
            }
        }

        foreach ($_REQUEST as $key => $value) {
            if (in_array($key, array('country', 'city', 'region', 'object_id', 'date_from', 'date_to'))) {
                Yii::app()->session->add('report_' . $key, $value);
            }
        }
        if (is_numeric($_REQUEST['object_id']) || !empty($_REQUEST['country']) || !empty($_REQUEST['city']) || !empty($_REQUEST['region'])) {
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

            $sql = "SELECT ir.device_id,d.comment AS name,ir.dt,s.FIO,ir.count_cash,ir.summ_cash,ir.count_coin,ir.summ_coin, summ_cash + summ_coin as all_summ
                            FROM incassator_report ir, device d, staff s, object obj
                            WHERE ir.device_id = d.id
                            AND d.object_id = obj.id
                            AND ir.dt >= '" . date("Y-m-d H:i:s", strtotime($_REQUEST['date_from'])) . "' AND ir.dt <= '" . date("Y-m-d H:i:s", strtotime($_REQUEST['date_to'])) . "'" .
                    (is_numeric($_REQUEST['object_id']) ? " AND obj.id = " . $_REQUEST['object_id'] : "") .
                    (!empty($_REQUEST['country']) ? " AND obj.country = '" . $_REQUEST['country'] . "'" : "") .
                    (!empty($_REQUEST['region']) ? " AND obj.region = '" . $_REQUEST['region'] . "'" : "") .
                    (!empty($_REQUEST['city']) ? " AND obj.city = '" . $_REQUEST['city'] . "'" : "") .
                    " AND ir.staff_id = s.id
                            AND summ_cash + summ_coin > 0
                            order by ir.device_id, ir.dt";

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

    public function actionSumaryReport() {
        if ($this->checkInput()) {
            $sql = "SELECT ir.device_id,d.comment AS name, CAST(ir.dt AS DATE) AS dt, SUM(ir.summ_cash)+SUM(ir.summ_coin)+IFNULL(SUM(dcr.summ),0) AS sum,
                        CASE WHEN DAYOFWEEK(ir.dt) IN (7,1) THEN \"weekend\" ELSE \"\" END AS class
                        FROM incassator_report ir, device d RIGHT JOIN device_cash_report dcr ON d.id = dcr.device_id, object obj
                        WHERE ir.device_id = d.id
                        AND d.object_id = obj.id
                        AND ir.dt >= '" . date("Y-m-d H:i:s", strtotime($_REQUEST['date_from'])) . "' AND ir.dt <= '" . date("Y-m-d H:i:s", strtotime($_REQUEST['date_to'])) . "'" .
                    (is_numeric($_REQUEST['object_id']) ? " AND obj.id = " . $_REQUEST['object_id'] : "") .
                    (!empty($_REQUEST['country']) ? " AND obj.country = '" . $_REQUEST['country'] . "'" : "") .
                    (!empty($_REQUEST['region']) ? " AND obj.region = '" . $_REQUEST['region'] . "'" : "") .
                    (!empty($_REQUEST['city']) ? " AND obj.city = '" . $_REQUEST['city'] . "'" : "") .
                    " GROUP BY d.id,CAST(ir.dt AS DATE)
                         order by ir.device_id";

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

            $sql = "SELECT m.device_id,d.comment AS name,SEC_TO_TIME(SUM(m.time)) AS time 
                    FROM massage m , device d, object obj
                    WHERE m.device_id = d.id
                    AND d.object_id = obj.id
                    AND m.dt >= '" . date("Y-m-d H:i:s", strtotime($_REQUEST['date_from'])) . "' AND m.dt <= '" . date("Y-m-d H:i:s", strtotime($_REQUEST['date_to'])) . "'" .
                    (is_numeric($_REQUEST['object_id']) ? " AND obj.id = " . $_REQUEST['object_id'] : "") .
                    (!empty($_REQUEST['country']) ? " AND obj.country = '" . $_REQUEST['country'] . "'" : "") .
                    (!empty($_REQUEST['region']) ? " AND obj.region = '" . $_REQUEST['region'] . "'" : "") .
                    (!empty($_REQUEST['city']) ? " AND obj.city = '" . $_REQUEST['city'] . "'" : "") .
                    " GROUP BY m.device_id,d.comment";
            $dataProvider = new CSqlDataProvider($sql, array(
                //'totalItemCount'=>$count,
                'pagination' => array(
                    'pageSize' => 100,
                ),
            ));
        }
        $this->render('massage_report', array(
            'data' => $dataProvider,
        ));
    }
    
    public function ActiongetListData() {
        $dataType = @$_REQUEST['datatype'];
        $country  = @$_REQUEST['country'];
        $region   = @$_REQUEST['region'];
        $city     = @$_REQUEST['city'];
        
        $crit = NULL;
        
        $crit .=  ($country)?"country = '$country'":"country = 'Россия'";
        $crit .=  ($region)?"and region = '$region'":$region;
        $crit .=  ($city)?"and city = '$city'":$city;
       
        
        switch($dataType) {
            case 'country': 
                $list = array_unique(CHtml::listData(Object::model()->findAll($crit), 'country', 'country'));
                break;
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
