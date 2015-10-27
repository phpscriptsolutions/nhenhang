<?php
class ElfinderController extends Controller
{
    public function actions()
    {
        return array(
            'connector' => array(
                'class' => 'ext.elfinder.ElFinderConnectorAction',
                'settings' => array(
                    'root' => '/vega_storage/chacha2.0/uploads/event',
                	//'root' => Yii::getPathOfAlias('webroot') . '/data/tmp/',
                    //'URL' => Yii::app()->baseUrl . 'event/',
                    'URL' => 'http://s2.chacha.vn/uploads/event/',
                    'rootAlias' => 'Home',
                    'mimeDetect' => 'none'
                )
            ),
        );
    }
}
?>