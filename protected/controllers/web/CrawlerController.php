<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/ganon.php';
class CrawlerController extends Controller{

    public function actionVietlott(){
        $day ='2017-03-04';
        $drawId = 45;
        $range = [2,2,3];
        $k = 0;
        for($i = $drawId; $i>0; $i--){
            $this->max4d($day,$i);
            $day = date('Y-m-d',strtotime($day)-$range[$k]*24*3600);
            $k++;
            $k = $k%3;
        }
    }

    public function actionMega645(){
        $day ='2017-03-08';
        $drawId = 99;
        $range = [2,2,3];
        $k = 0;
        for($i = $drawId; $i>0; $i--){
            $this->mega645($day,$i);
            $day = date('Y-m-d',strtotime($day)-$range[$k]*24*3600);
            $k++;
            $k = $k%3;
        }
    }

    public function actionMoney(){
        $html = file_get_dom('http://vietlott.vn/vi/home/');
        $content = $html('#mega-6-45 .jackpot-win')[0]->html();

        echo '<pre>';
        print_r($content);
        echo '</pre>';
        if(!empty($content)){
            $info = Mega645Model::model()
                ->findBySql('SELECT * from mega645 ORDER BY day DESC LIMIT 1');

            if(!empty($info)){
                $info->next_money = trim($content);
                $info->save(false);
                echo 'Update successfull';
            }else{
                echo 'Not found last info';
            }

        }else{
            echo 'cannot get data crawler';
        }

    }
    public function max4d($day,$drawId){
        try {
            $url = 'http://vietlott.vn/Ajax/PrevNextResultGameMax4D';
            $days = explode('-',$day);
            $params = [
                'gameId' => 2,
                'drawId' => $drawId,
                //'dayPrize' => '3/7/2017 12:00:00 AM',
                'dayPrize' => (int)$days[1].'/'.(int)$days[2].'/'.$days[0].' 12:00:00 AM',
                'type' => 0
            ];

            $result = $this->_request($url, $params, 'POST');
            echo '<pre>';
            print_r($params);
            echo '</pre>';
            $html = str_get_dom($result);

            $date = $html('.time-result')[0]->getPlainText();

            preg_match('/#[\d]+\s/', $date, $no);
            preg_match('/[\d]{2}\/[\d]{2}\/[\d]{4}/', $date, $spin);
            $spin = explode('/',trim($spin[0]));
            $data = [
                'order_lott' => trim($no[0]),
                'day' => $spin[2].'-'.$spin[1].'-'.$spin[0],
                'content' => $result
            ];

            /* foreach($html('.box-result-max4d') as $item){
                 $nameResult = trim($item('span')[0]->getPlainText());
                 echo $nameResult.'--';
                 switch($nameResult){
                     case 'Giải Nhất':
                         $data['no_first'] = trim($item('ul')[0]->getPlainText());
                         break;
                     case 'Giải Nhì':
                         $data['no_second1'] = trim($item('ul')[0]->getPlainText());
                         $data['no_second2'] = trim($item('ul')[1]->getPlainText());
                         break;
                     case 'Giải Ba':
                         $data['no_third1'] = trim($item('ul')[0]->getPlainText());
                         $data['no_third2'] = trim($item('ul')[1]->getPlainText());
                         $data['no_third3'] = trim($item('ul')[2]->getPlainText());
                         break;
                     case 'Giải Khuyến Khích 1':
                         $data['no_fourth1'] = trim($item('ul')[0]->getPlainText());
                         break;
                     case 'Giải Khuyến Khích 2':
                         $data['no_fourth2'] = trim($item('ul')[0]->getPlainText());
                         break;
                 }
             }*/

            foreach ($html('div.result tbody tr') as $item) {
                $nameResult = trim($item('td')[0]->getPlainText());
                echo $nameResult . '--';
                switch ($nameResult) {
                    case 'Giải Nhất':
                        $data['no_first'] = trim($item('b')[0]->getPlainText());
                        $data['first'] = trim($item('b')[1]->getPlainText());
                        break;
                    case 'Giải Nhì':
                        $data['no_second1'] = trim($item('b')[0]->getPlainText());
                        $data['no_second2'] = trim($item('b')[1]->getPlainText());
                        $data['second'] = trim($item('b')[2]->getPlainText());
                        break;
                    case 'Giải Ba':
                        $data['no_third1'] = trim($item('b')[0]->getPlainText());
                        $data['no_third2'] = trim($item('b')[1]->getPlainText());
                        $data['no_third3'] = trim($item('b')[2]->getPlainText());
                        $data['third'] = trim($item('b')[3]->getPlainText());
                        break;
                    case 'Giải Khuyến Khích 1':
                        $data['no_fourth1'] = trim($item('b')[0]->getPlainText());
                        $data['fourth'] = trim($item('b')[1]->getPlainText());
                        break;
                    case 'Giải Khuyến Khích 2':
                        $data['no_fourth2'] = trim($item('b')[0]->getPlainText());
                        $data['fourth2'] = trim($item('b')[1]->getPlainText());
                        break;
                }
            }

            $max4d = new Max4dModel();
            $max4d->attributes = $data;
            $max4d->created_time = date('Y-m-d H:i:s');
            $max4d->status = 1;
            $max4d->save(false);
            echo PHP_EOL . '***************FINISH CRAWLER ' . $date . '***************' . PHP_EOL;
        }catch (Exception $ex){
            echo PHP_EOL . '$$$$$$$$$ ERROR CRAWLER ' . $ex->getMessage() . '$$$$$' . PHP_EOL;
        }

    }

    public function mega645($day,$drawId){
        try {
            $url = 'http://vietlott.vn/Ajax/PrevNextResultGameMega645';
            $days = explode('-',$day);
            $params = [
                'gameId' => 2,
                'drawId' => $drawId,
                //'dayPrize' => '3/7/2017 12:00:00 AM',
                'dayPrize' => (int)$days[1].'/'.(int)$days[2].'/'.$days[0].' 12:00:00 AM',
                'type' => 0
            ];

            $result = $this->_request($url, $params, 'POST');
            echo '<pre>';
            print_r($params);
            echo '</pre>';
            $html = str_get_dom($result);

            $date = $html('.time-result')[0]->getPlainText();

            preg_match('/#[\d]+\s/', $date, $no);
            preg_match('/[\d]{2}\/[\d]{2}\/[\d]{4}/', $date, $spin);
            $spin = explode('/',trim($spin[0]));
            $data = [
                'order_lott' => trim($no[0]),
                'day' => $spin[2].'-'.$spin[1].'-'.$spin[0],
                'content' => $result
            ];
            $data['no1'] = trim($html('.result-number li')[1]->getPlainText());
            $data['no2'] = trim($html('.result-number li')[2]->getPlainText());
            $data['no3'] = trim($html('.result-number li')[3]->getPlainText());
            $data['no4'] = trim($html('.result-number li')[4]->getPlainText());
            $data['no5'] = trim($html('.result-number li')[5]->getPlainText());
            $data['no6'] = trim($html('.result-number li')[6]->getPlainText());

            foreach ($html('div.result table') as $k => $table) {
                if($k==0){
                    continue;
                }
                foreach($table('tbody tr') as $item) {
                    $nameResult = trim($item('td')[0]->getPlainText());
                    echo $nameResult . '--';
                    switch ($nameResult) {
                        case 'Jackpot':
                            $data['jackpot'] = trim($item('td')[2]->getPlainText());
                            $data['money'] = trim($item('td')[3]->getPlainText());
                            break;
                        case 'Giải nhất':
                            $data['first'] = trim($item('td')[2]->getPlainText());
                            break;
                        case 'Giải nhì':
                            $data['second'] = trim($item('td')[2]->getPlainText());
                            break;
                        case 'Giải ba':
                            $data['third'] = trim($item('td')[2]->getPlainText());
                            break;
                    }
                }
            }

            $data['no_win'] = $data['no1'].$data['no2'].$data['no3'].$data['no4'].$data['no5'].$data['no6'];

            $max4d = new Mega645Model();
            $max4d->attributes = $data;
            $max4d->created_time = date('Y-m-d H:i:s');
            $max4d->status = 1;
            $max4d->save(false);
            echo PHP_EOL . '***************FINISH CRAWLER ' . $date . '***************' . PHP_EOL;
        }catch (Exception $ex){
            echo PHP_EOL . '$$$$$$$$$ ERROR CRAWLER ' . $ex->getMessage() . '$$$$$' . PHP_EOL;
        }

    }

    private function _request($url, $params, $method="GET") {
        $timeOut = 10;
        $result = null;
        try {
            $ch = curl_init();

            if($method=="POST") {	// POST JSON request
                curl_setopt($ch,CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json; charset=utf-8',
                    //'Authorization: Bearer '.self::ACCESS_TOKEN
                ));
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($params));
            } else {	// GET request
                $data = http_build_query($params);
                $url .= "?$data";
                curl_setopt($ch,CURLOPT_URL, $url);
                //Yii::log("[GET] $url", "trace", "ENCODE_REQUEST");
            }
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
            curl_setopt($ch,CURLOPT_CONNECTTIMEOUT, $timeOut);
            $result=curl_exec($ch);
            if(curl_errno( $ch ))
            {
                $result =  null;
            }
        } catch (Exception $e) {
            $result =  null;
        }
        curl_close ($ch);

        return $result;
    }
}