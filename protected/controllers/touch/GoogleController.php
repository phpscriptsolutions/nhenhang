<?php
class GoogleController extends Controller
{
    public $clientConnect;
    public $client_id;
    public $client_secret;
    public $redirect_uri;
    private function connect()
    {
        //spl_autoload_unregister(array('YiiBase','autoload'));
        $this->client_id = Yii::app()->params['social']['google']['client_id'];
        $this->client_secret = Yii::app()->params['social']['google']['client_secret'];
        $this->redirect_uri = Yii::app()->params['social']['google']['redirect_uri'];
        $this->clientConnect = new Google_Client();
        $this->clientConnect->setClientId($this->client_id);
        $this->clientConnect->setClientSecret($this->client_secret);
        $this->clientConnect->setRedirectUri($this->redirect_uri);
        //$this->clientConnect->setDeveloperKey('AIzaSyAXBSAj7G_AYd03AJwS8OilfRRPPWnZysA');
        return $this->clientConnect;
    }
    public function actionLogin()
    {
        $return_url = Yii::app()->request->getParam('return_url','');
        if(!empty($return_url)){
            Yii::app()->user->setState('last_url',$return_url);
        }
        $client = $this->connect();
        $client->addScope(array("https://www.googleapis.com/auth/userinfo.email","https://www.googleapis.com/auth/userinfo.profile"));

        //Send Client Request
        $objOAuthService = new Google_Service_Oauth2($client);
        //Logout
        if (isset($_REQUEST['logout'])) {
            unset($_SESSION['access_token']);
            $client->revokeToken();
            header('Location: ' . filter_var($this->redirect_uri, FILTER_SANITIZE_URL)); //redirect user back to page
        }

        //Authenticate code from Google OAuth Flow
        //Add Access Token to Session
        if (isset($_GET['code'])) {
            $client->authenticate($_GET['code']);
            $_SESSION['access_token'] = $client->getAccessToken();
            header('Location: ' . filter_var($this->redirect_uri, FILTER_SANITIZE_URL));
        }

        //Set Access Token to make Request
        if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
            $client->setAccessToken($_SESSION['access_token']);
        }
        //Get User Data from Google Plus
        //If New, Insert to Database
        if ($client->getAccessToken()) {
            $userData = $objOAuthService->userinfo->get();
            if(!empty($userData)) {
                //echo '<pre>';print_r($userData);
                $userGoogle = array(
                    'id'=>$userData->id,
                    'name'=>$userData->name,
                    'picture'=>$userData->picture,
                    'email'=>$userData->email
                );
                $user = null;
                if(!empty($userGoogle['email'])) {
                    $user = UserModel::model()->findByAttributes(array("email"=>$userGoogle['email'],"validate_email"=>1));
                }
                if(empty($user)) {
                    $userAccount = UserAccountModel::model()->findByAttributes(array("account" => $userGoogle['id'], "type" => "google"));
                    if (empty($userAccount)) {
                        $user = new UserModel();
                        $pass = $userGoogle['id'] . rand(1111, 9999);
                        $username = isset($userGoogle['id']) ? $userGoogle['id'] : "user_" . $userGoogle['id'];

                        $user->username = $username;
                        $user->password = '';
                        $user->fullname = $userGoogle['name'];
                        $user->created_time = new CDbExpression("NOW()");
                        $user->updated_time = date('Y-m-d H:i:s');
                        $user->status = UserModel::ACTIVE;
                        if(!empty($userGoogle['email'])) {
                            $user->email = $userGoogle['email'];
                            $user->validate_email = 1;
                        }
                        $res = $user->save(false);

                        //tao playlist yeu thich
                        AlbumModel::model()->createFavouritePlaylist($user->id);

                        $userAccount = new UserAccountModel();
                        $userAccount->user_id = $user->id;
                        $userAccount->account = $userGoogle['id'];
                        $userAccount->name = $userGoogle['name'];
                        $userAccount->type = 'google';
                        $userAccount->save(false);
                        //get avatar google for the first login or register
                        $picture = $userGoogle['picture'];
                        $target = Yii::app()->params['storage']['staticDir'] . DS . 'tmp' . DS . 'avatar_google_' . time() . '.jpg';
                        $fileRemote = new FileRemote();
                        $g = $fileRemote->getFromUrl($picture, $target);
                        if ($g && @getimagesize($target)) {
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
                if($user) {
                    $model = new LoginForm("Username");
                    $model->username = $user->username;
                    $model->password = $user->password;
                    $model->_type    = 'google';
                    $model->auto = true;
                    if($model->login()){
                        $returlUrl = Yii::app()->user->getState('last_url');
                        if(empty($returlUrl)){
                            $returlUrl = Yii::app()->createAbsoluteUrl('/');
                        }else if(urldecode($returlUrl) == Yii::app()->createUrl('/user/profile')){
                            $returlUrl = Yii::app()->createUrl('/user/profile',array('u'=>Yii::app()->user->getState('username')));
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
                }
            }
            $_SESSION['access_token'] = $client->getAccessToken();
        } else {
            $authUrl = $client->createAuthUrl();
        }
        if(isset($authUrl)){
            if(Yii::app()->request->isAjaxRequest){
                echo CJSON::encode(array(
                    'status' => 'redirect',
                    'url' => $authUrl
                ));
                Yii::app()->end();
            }else
                $this->redirect($authUrl);
            echo '<a href="'.$authUrl.'">connect me</a>';
        }
        exit;
    }
    /*public function actionLogin()
    {
        error_reporting(E_ALL | E_STRICT);
        ini_set('display_errors','On');
        spl_autoload_unregister(array('YiiBase','autoload'));
        $client = $this->connect();
        $client->setScopes(array('https://www.googleapis.com/auth/userinfo.email','https://www.googleapis.com/auth/userinfo.profile'));
        //$client->addScope("https://www.googleapis.com/auth/urlshortener");
        $service = new Google_Service_Urlshortener($client);
        if (isset($_REQUEST['logout'])) {
            unset($_SESSION['access_token']);
        }
        $oauth2 = new Google_Service_Oauth2($client);
        if (isset($_GET['code'])) {
            $client->authenticate($_GET['code']);
            $_SESSION['access_token'] = $client->getAccessToken();
            $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
            header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
        }

        if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
            $client->setAccessToken($_SESSION['access_token']);
        } else {
            $authUrl = $client->createAuthUrl();
        }
        if ($client->getAccessToken()) {
            //$user = $oauth2->userinfo;
            $google_account_email = $oauth2->userinfo->get();
            echo '<pre>';print_r($google_account_email);
            $url = new Google_Service_Urlshortener_Url();
            $url->longUrl = $_GET['url'];
            $short = $service->url->insert($url);
            $_SESSION['access_token'] = $client->getAccessToken();
        }
        echo "User Query - URL Shortener";
        if (strpos(self::_CLIENT_ID, "googleusercontent") == false) {
            echo missingClientSecretsWarning();
            exit;
        }
        if (isset($authUrl)) {
            echo "<a class='login' href='" . $authUrl . "'>Connect Me!</a>";
        } else {
            echo <<<END
    <form id="url" method="GET" action="{$_SERVER['PHP_SELF']}">
      <input name="url" class="url" type="text">
      <input type="submit" value="Shorten">
    </form>
    <a class='logout' href='?logout'>Logout</a>
END;
        }
    }*/
}