<?php

class ReportPageController extends Controller
{
	public function actionIndex()
	{
            $criteria=new CDbCriteria;
            $dataProvider=new CActiveDataProvider('VDeviceStatusReport',
            array(
                'criteria'=>$criteria,
            )
        );
 
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
                $this->render('index',array(
                        'dataProvider'=>$dataProvider,
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