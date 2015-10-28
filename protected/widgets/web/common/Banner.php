<?php

class Banner extends CWidget {
    public $position = '';
    
    public function run() {
        $this->render("banner", array());
    }
}