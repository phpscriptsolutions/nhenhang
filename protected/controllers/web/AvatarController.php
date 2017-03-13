<?php
class AvatarController extends Controller{
    public function actions() {
        return array(
            'upload' => array(
                'class' => 'ext.xupload.actions.XUploadAction',
                'path' => Yii::app()->params['storage']['baseStorage'],
                'alowType' => "image/jpeg,image/png,image/gif,image/x-png,image/pjpeg",
                'maxSize' => 8,
                'type' => 'image'
            ),
            'uploadCover' => array(
                'class' => 'application.components.web.EAjaxUpload',
                'path' => Yii::app()->params['storage']['baseStorage']
            ),
            'uploadThumbPlaylist' => array(
                'class' => 'application.components.web.EAjaxUpload',
                'path' => Yii::app()->params['storage']['baseStorage'],
                'allowedType'=>array('jpg','png')
            ),
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
                'foreColor' => 0x0BA14B,
                'offset' => 0,
                'minLength' => 5,
                'maxLength' => 5,
                'fontFile' => _APP_PATH_ . '/public/webroot/web/css/font/roboto/Roboto-Black.ttf'
            ),
        );
    }


    public function actionIndex(){
        $this->render('index');
    }

    public function actionCover() {
        if (Yii::app ()->request->isAjaxRequest) {
            $coverWidth = 1190;
            $coverHeight = 350;
            $minCoverWidth = 500;
            $minCoverHeight = 200;

            $fileName = CHtml::encode(Yii::app ()->request->getParam ( 'file' ));
            $file = substr($fileName,0,strpos($fileName,'.'));
            $type = substr($fileName,strpos($fileName,'.'));
            $filePath = Yii::app()->params['storage']['staticDir'] . DS . "tmp" . DS . $fileName;
            $filePath512 = Yii::app()->params['storage']['staticDir'] . DS . "tmp" . DS . $file.'_512'.$type;
            $filePath1024 = Yii::app()->params['storage']['staticDir'] . DS . "tmp" . DS . $file.'_1024'.$type;
            $filePath1280 = Yii::app()->params['storage']['staticDir'] . DS . "tmp" . DS . $file.'_1280'.$type;
            $filePath320 = Yii::app()->params['storage']['staticDir'] . DS . "tmp" . DS . $file.'_320'.$type;
            $filePath180 = Yii::app()->params['storage']['staticDir'] . DS . "tmp" . DS . $file.'_180'.$type;

            try {
                $fileSystem = new Filesystem ();
                $imgSize = getimagesize($filePath);
                $realW = $imgSize [0];
                $realH = $imgSize [1];
                if($realW>2048){
                    $desWidth = $coverWidth;
                    $aspectRatioW = $aspectRatioH = 1;
                    $desHeight = round($desWidth * intval($aspectRatioH) / intval($aspectRatioW));
                    $resizeFile = Yii::app()->params['storage']['staticDir'] . DS . "tmp" . DS . time() . ".".$type;
                    AvatarHelper::ImageCropPro($resizeFile,$filePath,$desWidth,$desHeight);
                    $fileSystem->remove($filePath);
                    $fileSystem->rename($resizeFile, $filePath);
                }

                list($width, $height) = getimagesize($filePath);
                if($width < $minCoverWidth || $height < $minCoverHeight){
                    echo CJSON::encode(array('status'=>false,'msg'=>Yii::t('web','Kích thước ảnh tối thiểu là '.
                        $minCoverWidth.'x'.$minCoverHeight.'px')));
                    Yii::app()->end();
                }

                //$coverPath = UserModel::model()->getCoverPath(1000);
                $imgCrop = new ImageCrop($filePath, 0, 0, $width, $height);


                //Utils::makeDir(dirname($coverPath));
                $imgCrop->resizeCrop($filePath512, 512, 512, 100);
                $imgCrop->resizeCrop($filePath1024, 1024, 500, 100);
                $imgCrop->resizeCrop($filePath1280, 1280, 720, 100);
                $imgCrop->resizeCrop($filePath320, 320, 180, 100);
                $imgCrop->resizeCrop($filePath180, 180, 120, 100);

                unlink($filePath);
                echo CJSON::encode(
                    array(
                        'status' => true,
                        'file'=>$filePath1024,
                        'msg' => Yii::t('web','Thay đổi ảnh Cover thành công.')
                    )
                );
            } catch (Exception $e) {
                echo $e->getMessage();
            }
            Yii::app()->end();
        }

    }

    public function actionWater(){

    }
}