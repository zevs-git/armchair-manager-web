<?php

class ReportPageController extends Controller
{
        public $layout = '//layouts/report_navigator';
        
        public function actionStatusReport() {
            if (!isset($_REQUEST['object_id'])) {
                $this->render('status_report',array(
                    ));
                    return;
                };
                $sql="SELECT
                    `d`.`id` AS `device_id`,
                     IFNULL(`srgd`.`m`, 0) AS `m`,
                     IFNULL(`srgd`.`p`, 0) AS `p`,
                     IFNULL(`srgd`.`c`, 0) AS `c`,
                     IFNULL(`srgd`.`e`, 0) AS `e`
                     FROM (`device` `d`
                     LEFT JOIN `status_rep_group_day` `srgd`
                     ON ((`d`.`id` = `srgd`.`device_id`)))
                     WHERE `d`.`object_id` = " . $_REQUEST['object_id'] ."
                     AND `srgd`.`day` >= '" . $_REQUEST['date_from'] ."' AND `srgd`.`day` <= '" . $_REQUEST['date_to'] . "'
                     GROUP BY
                     srgd.device_id";
                $dataProvider=new CSqlDataProvider($sql, array(
                    //'totalItemCount'=>$count,
                    'pagination'=>array(
                        'pageSize'=>100,
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
                    $data['m'][] = (int)$data_row['m'];
                    $data['p'][] = (int)$data_row['p'];
                    $data['c'][] = (int)$data_row['c'];
                    $data['e'][] = (int)$data_row['e'];
                }
 
                //json formatted ajax response to request
                if(isset($_GET['json']) && $_GET['json'] == 1){
                    /*$count = ChartData::model()->count();
                    for($i=1; $i<=$count; $i++){
                        $data = ChartData::model()->findByPk($i);
                        $data->data1 = rand(0,100);
                        $data->data2 = rand(0,100);
                        $data->save();
                    }*/
                    echo CJSON::encode($dataProvider->getData());
                }else{
                    //print_r($dataProvider->getData());
                    $this->render('status_report',array(
                            'data'=>$data,
                    ));
                }
	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}