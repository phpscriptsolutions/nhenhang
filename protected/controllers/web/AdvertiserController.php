<?php
class AdvertiserController extends Controller{
    public function actionIndex(){
        $this->layout = 'application.views.web.layouts.main';
        $limit = 24;
        $total = AdvertiserModel::model()->countAdvertiser();
        $pager = new CPagination($total);
        $pager->setPageSize($limit);
        $ads = AdvertiserModel::model()->getAdvertiser(null, $limit,$pager->getOffset());

        $this->render('index', compact('total','ads','pager'));
    }
}