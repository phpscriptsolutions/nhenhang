<?php

class FBShare extends CWidget {

    public $url = "nhac.vn";
    public $title = "nhac.vn";
    public $imgsrc = "nhac.vn";
    public $desc = "nhac.vn";
    public $name = "nhac.vn";

    public function init() {}

    public function run() {
        $this->render("FBShare", array(
            "url" => $this->url,
            "title" => $this->title,
            "imgsrc" => $this->imgsrc,
            "desc" => $this->desc,
            "name" => $this->name
        ));
    }
}
?>