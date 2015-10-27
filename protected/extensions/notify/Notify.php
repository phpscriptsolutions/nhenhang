<?php
/**
 * @author Egor Saveiko aka GOsha
 * @version 1.0
 */
interface INotify{
    public function register($user_id);
    public function unregister($user_id);
    public function check($user_id);
    public function listAll($user_id,$filter,$offset=0,$limit=100);
    public function listNew($user_id,$filter);
    public function remove($user_id,$msg_id);
    public function broadcast($user_id,$name,$receivers,$msg,$type);
    public function close();
}
class Notify extends CApplicationComponent
{
    public $engine;
    public $config;
    private $notify;
    /**
     * init function
     */
    public function init()
    {
        parent::init();
    }

    /**
     * Main extension loader
     * @param array $config - configuration array
     * @return upload
     */
    public function load()
    {
        if(!$this->notify){
            parent::init();
            $dir = dirname(__FILE__);
            $alias = md5($dir);
            Yii::setPathOfAlias($alias,$dir);
            Yii::import($alias.'.INotify');
            Yii::import($alias.'.'.$this->engine);
            //$this->notify = new EmailBasedNotify; // thangtv2 fixed
            $this->notify = new $this->engine;
            if(!empty($this->config))
            {
                foreach ($this->config as $key => $val)
                {
                    $this->notify->$key = $val;
                }
            }
        }
        return $this->notify;
    }


}



?>
