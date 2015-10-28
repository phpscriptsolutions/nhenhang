<?php

class FavouriteUsers extends CWidget {
    public $order;
    public $users;
    public $boxName = '';
    public $limit = 8;
    public $type = null;
    
    public function run() {
        $this->render("favouriteUsers", array('users'=>$this->users,
                                             'boxName'=>$this->boxName,
                                             'limit'=>$this->limit, 
                                             'order'=>$this->order,
                                             'type'=>$this->type));
    }
}