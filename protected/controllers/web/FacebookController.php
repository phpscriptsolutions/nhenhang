<?php
Yii::import("application.vendors.FacebookSDK.*");
require_once 'autoload.php';

use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\Entities\AccessToken;
use Facebook\HttpClients\FacebookCurlHttpClient;
use Facebook\HttpClients\FacebookHttpable;
class FacebookController extends Controller
{
    public function actionLogin()
    {
        $return_url = Yii::app()->request->getParam('return_url','');
        if(!empty($return_url)){
            Yii::app()->user->setState('last_url',$return_url);
        }
        // init app with app id and secret
        $appId = Yii::app()->params['social']['facebook']['id'];
        $secret = Yii::app()->params['social']['facebook']['secret'];
        Facebook\FacebookSession::setDefaultApplication($appId, $secret);
        // login helper with redirect_uri
        $urlLogin = Yii::app()->createAbsoluteUrl('/facebook/login');
        $helper = new FacebookRedirectLoginHelper($urlLogin);
        try {
            $session = $helper->getSessionFromRedirect();
        } catch( FacebookRequestException $ex ) {
            // When Facebook returns an error
            echo $ex->getMessage();
        } catch( Exception $ex ) {
            echo $ex->getMessage();
            // When validation fails or other local issues
        }
        // see if we have a session
        if (isset( $session ) ){
            // graph api request for user data
            $request = new FacebookRequest( $session, 'GET', '/me' );
            $response = $request->execute();
            // get response
            $graphObject = $response->getGraphObject();
            $fbid = $graphObject->getProperty('id');              // To Get Facebook ID
            $fbfullname = $graphObject->getProperty('name'); // To Get Facebook full name
            $femail = $graphObject->getProperty('email');    // To Get Facebook email ID
            $fusername = $graphObject->getProperty('username');    // To Get Facebook username

            /* ---- Session Variables -----*/
            $_SESSION['FBID'] = $fbid;
            $_SESSION['FULLNAME'] = $fbfullname;
            $_SESSION['EMAIL'] =  $femail;

            /*$crit = new CDbCriteria();
            $crit->condition	= 'username=:username';
            $crit->params		= array(':username'=>$femail);
            $user = UserModel::model()->find($crit);
            if(!$user){
                $passForFace = Common::randomPassword();
                //create user
                $params = array(
                    'username'=>$femail,
                    'password'=>$passForFace,
                    'email'=>$femail
                );
            }*/
            $user_profile = array(
                'id'=>$fbid,
                'username'=>$fusername,
                'name'=>$fbfullname,
                'email'=>$femail,
            );
            $user = null;
            if(!empty($femail)) {
                $user = UserModel::model()->findByAttributes(array("email" => $femail, "validate_email" => 1));
            }
            if(empty($user)) {
                $userAccount = UserAccountModel::model()->findByAttributes(array("account" => $fbid, "type" => "facebook"));
                if (empty($userAccount)) {
                    $user = new UserModel();
                    $pass = $user_profile['username'] . rand(1111, 9999);
                    $username = isset($user_profile['username']) ? $user_profile['username'] : "user_" . $user_profile['id'];

                    $user->username = $username;
                    $user->password = '';
                    $user->fullname = $user_profile['name'];
                    $user->created_time = new CDbExpression("NOW()");
                    $user->updated_time = date('Y-m-d H:i:s');
                    $user->status = UserModel::ACTIVE;
                    if(!empty($user_profile['email'])) {
                        $user->email = $user_profile['email'];
                        $user->validate_email = 1;
                    }
                    $res = $user->save(false);
                    if($res){
                        $addPlaylist = AlbumModel::model()->createFavouritePlaylist($user->id);
                    }
                    $userAccount = new UserAccountModel();
                    $userAccount->user_id = $user->id;
                    $userAccount->account = $user_profile['id'];
                    $userAccount->name = $user_profile['name'];
                    $userAccount->type = 'facebook';
                    $userAccount->save(false);
                    //get avatar facebook for first login or register
                    $picture = 'http://graph.facebook.com/' . $fbid . '/picture?type=large';
                    $target = Yii::app()->params['storage']['staticDir'] . DS . 'tmp' . DS . 'avatar_facebook_' . time() . '.jpg';
                    $fileRemote = new FileRemote();
                    $g = $fileRemote->getFromUrl($picture, $target);
                    if ($g && file_exists($target)) {
                        $fileSystem = new Filesystem ();
                        list($width, $height) = getimagesize($target);
                        $imgCrop = new ImageCrop ($target, 0, 0, $width, $height);
                        $paths5 = UserModel::model()->getAvatarPath($user->id, "s5");
                        $paths4 = UserModel::model()->getAvatarPath($user->id, "s4");
                        $paths3 = UserModel::model()->getAvatarPath($user->id, "s3");
                        $paths2 = UserModel::model()->getAvatarPath($user->id, "s2");
                        $paths1 = UserModel::model()->getAvatarPath($user->id, "s1");
                        $paths0 = UserModel::model()->getAvatarPath($user->id, "s0");

                        Utils::makeDir(dirname($paths5));
                        Utils::makeDir(dirname($paths4));
                        Utils::makeDir(dirname($paths3));
                        Utils::makeDir(dirname($paths2));
                        Utils::makeDir(dirname($paths1));
                        Utils::makeDir(dirname($paths0));

                        $imgCrop->cropImage($paths0, $width, $height, 90);
                        $imgCrop->cropImage($paths1, 640, 640, 90);
                        $imgCrop->cropImage($paths2, 320, 320, 90);
                        $imgCrop->cropImage($paths3, 150, 150, 90);
                        $imgCrop->cropImage($paths4, 100, 100, 90);
                        $imgCrop->cropImage($paths5, 50, 50, 90);
                        $fileSystem->remove ( $target );
                    }
                } else {
                    $user = UserModel::model()->findByPk($userAccount->user_id);
                    $user->lastvisit_at = new CDbExpression("NOW()");
                    $user->update();
                }
            }else {
                $user = UserModel::model()->findByPk($user->id);
                $user->lastvisit_at = new CDbExpression("NOW()");
                $user->update();
            }

            $model = new LoginForm();
            $model->username = $user->username;
            $model->password = $user->password;
            $model->auto = true;
            if($model->login()){
                $returlUrl = Yii::app()->createAbsoluteUrl('/');
                if(!empty($this->lastUrl)){
                    $returlUrl = $this->lastUrl;
                }
                if(Yii::app()->request->isAjaxRequest){
                    echo CJSON::encode(array(
                        'status' => 'redirect',
                        'url' => $returlUrl
                    ));
                    Yii::app()->end();
                }else{
                    $this->redirect($returlUrl);
                }
            }else{
                $errors = $model->getErrors();
                var_dump($errors);
            }
            /* ---- header location after session ----*/
        } else {
            $loginUrl = $helper->getLoginUrl(array('email'));
            //header("Location: ".$loginUrl);
            if(Yii::app()->request->isAjaxRequest) {
                echo CJSON::encode(array(
                    'status' => 'redirect',
                    'url' => $loginUrl
                ));
                Yii::app()->end();
            }else{
                $this->redirect($loginUrl);
            }
        }
        exit;
    }
}