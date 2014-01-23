<?php

class ReportPageController extends Controller {

    public $layout = '//layouts/report_navigator';

    public function actionStatusReport() {
        if (!isset($_REQUEST['object_id'])) {
            $this->render('status_report', array(
            ));
            return;
        };
        $sql = "SELECT
                    `d`.`id` AS `device_id`,
                     IFNULL(`srgd`.`m`, 0) AS `m`,
                     IFNULL(`srgd`.`p`, 0) AS `p`,
                     IFNULL(`srgd`.`c`, 0) AS `c`,
                     IFNULL(`srgd`.`e`, 0) AS `e`
                     FROM (`device` `d`
                     LEFT JOIN `status_rep_group_day` `srgd`
                     ON ((`d`.`id` = `srgd`.`device_id`)))
                     WHERE `d`.`object_id` = " . $_REQUEST['object_id'] . "
                     AND `srgd`.`day` >= '" . $_REQUEST['date_from'] . "' AND `srgd`.`day` <= '" . $_REQUEST['date_to'] . "'
                     GROUP BY
                     srgd.device_id";

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

        //json formatted ajax response to request
        if (isset($_GET['json']) && $_GET['json'] == 1) {
            /* $count = ChartData::model()->count();
              for($i=1; $i<=$count; $i++){
              $data = ChartData::model()->findByPk($i);
              $data->data1 = rand(0,100);
              $data->data2 = rand(0,100);
              $data->save();
              } */
            echo CJSON::encode($dataProvider->getData());
        } else {
            //print_r($dataProvider->getData());
            $this->render('status_report', array(
                'data' => $data,
            ));
        }
    }

    public function actionIncassatorReport() {
        if (!isset($_REQUEST['object_id'])) {
            $this->render('status_report', array(
            ));
            return;
        };

        $sql = "SELECT ir.device_id,ir.dt,s.FIO,ir.count_cash,ir.summ_cash,ir.count_coin,ir.summ_coin, summ_cash + summ_coin as all_summ
                        FROM incassator_report ir, device d, staff s
                        WHERE ir.device_id = d.id
                        AND CAST(ir.dt as DATE) >= '" . $_REQUEST['date_from'] . "' AND CAST(ir.dt as DATE) <= '" . $_REQUEST['date_to'] . "'
                        AND d.object_id = " . $_REQUEST['object_id'] . "
                        AND ir.staff_id = s.id";
        $dataProvider = new CSqlDataProvider($sql, array(
            //'totalItemCount'=>$count,
            'pagination' => array(
                'pageSize' => 100,
            ),
        ));

        $this->render('incassator_report', array(
            'data' => $dataProvider,
        ));
    }

    public function actionSumaryReport() {
        if (!isset($_REQUEST['object_id'])) {
            $this->render('status_report', array(
            ));
            return;
        };

        $sql = "SELECT ir.device_id, CAST(ir.dt AS DATE) AS dt, SUM(ir.summ_cash)+SUM(ir.summ_coin)+IFNULL(SUM(dcr.summ),0) AS sum
                        FROM incassator_report ir, device d LEFT JOIN device_cash_report dcr ON d.id = dcr.device_id
                        WHERE ir.device_id = d.id
                        AND CAST(ir.dt as DATE) >= '" . $_REQUEST['date_from'] . "' AND CAST(ir.dt as DATE) <= '" . $_REQUEST['date_to'] . "'
                        AND d.object_id = " . $_REQUEST['object_id'] . "
                         GROUP BY d.id,CAST(ir.dt AS DATE)";
        $dataProvider = new CSqlDataProvider($sql, array(
            //'totalItemCount'=>$count,
            'pagination' => array(
                'pageSize' => 100,
            ),
        ));

        $this->render('summary_report', array(
            'data' => $dataProvider,
        ));
    }
    
    public function actionMassageReport() {
        if (!isset($_REQUEST['object_id'])) {
            $this->render('status_report', array(
            ));
            return;
        };
        
        $sql = "SELECT srgd.device_id,d.comment AS name,SEC_TO_TIME(SUM(srgd.m)) AS time 
                    FROM status_rep_group_day srgd , device d
                    WHERE srgd.device_id = d.id
                    AND CAST(srgd.day as DATE) >= '" . $_REQUEST['date_from'] . "' AND CAST(srgd.day as DATE) <= '" . $_REQUEST['date_to'] . "'
                    AND d.object_id = " . $_REQUEST['object_id'] . "
                GROUP BY srgd.device_id,d.comment";
        
        $dataProvider = new CSqlDataProvider($sql, array(
            //'totalItemCount'=>$count,
            'pagination' => array(
                'pageSize' => 100,
            ),
        ));

        $this->render('massage_report', array(
            'data' => $dataProvider,
        ));
    }

}
