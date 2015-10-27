<?php
class SearchSolrHelper
{
    protected $host;
    protected $port;
    protected $path;
    protected $keyword;
    protected $type;// type: song,album,video,artist
    protected $data;
    protected $errors;

    public function __construct($host='', $port='', $path='') {
        $this->host = Yii::app()->params['solr.server.host'];
        $this->port = Yii::app()->params['solr.server.port'];
        $this->path = Yii::app()->params['solr.server.path'];
    }
    public function search($keyword,$type='',$limit=10,$offset=0)
    {
        try {
            if(!in_array($type, array("","song","album","video","artist"))){
                $this->setErrors(array("msg"=>'Invalid search type'));
                return;
            }


            $host           = $this->host;
            $port           = $this->port;
            $path           = $this->path;
            $this->type     = $type;
            $this->keyword  = $keyword;

            $url = "http://{$host}:{$port}{$path}nhacvn/search?wt=json&indent=true&group=true&group.field=type&group.limit=$limit&group.offset=$offset";
            $q = $keyword;
            $nq = $q;
            $output = preg_replace('!\s+!', ' ', $nq);
            if (substr_count($output, ' ') < 2)
                $nq = "\"" . $output . "\"~1";
            else
                $nq = $output;
            $ch = curl_init();
            $enq = urlencode($nq);
            if ($type != '') {
                $query = '&fq=type:' . $type;
            } else {
                $query = '';
            }
            $url = "{$url}&q={$enq}{$query}";
            curl_setopt($ch, CURLOPT_URL, "$url");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Accept: application/json'
            ));
            $data = curl_exec($ch);
            $data = json_decode($data);
            if (!$data || $data->responseHeader->status!=0) {
                $error = curl_error($ch);
                $this->setErrors($error);
            }else{
                $this->data = $data;
                return $this->getDataSearchByType();
            }
        }catch (Exception $e)
        {
            $error = $e->getMessage();
            $this->setErrors($error);
        }
    }
    public function setErrors($errors)
    {
        $this->errors = json_encode($errors);
    }
    public function getErrors()
    {
        if(empty($this->errors)){
            return 0;
        }
        return $this->errors;
    }

    /**
     * return result copyAndCastSearch
     * $this->type: song,album,video,artist
     */
    public function getDataSearchByType()
    {
        if(empty($this->type)){
            $result = array(
                'keyword' => $this->keyword,
                'countSong' => 0,
                'listSong' => array(),
                'countVideo' => 0,
                'listVideo' => array(),
                'countAlbum' => 0,
                'listAlbum' => array(),
                'countArtist' => 0,
                'listArtist' => array(),
                'count' => 0
            );
        }else{
            $type = ucfirst($this->type);

            $result = array(
                "keyword" => $this->keyword,
                "count{$type}" => 0,
                "list{$type}"  => array(),
                "count"        => 0
            );
        }

        $data = $this->data->grouped->type;

        //tong so records tim thay
        $result['count'] = $data->matches;

        //cast array with each type
        $init = array(
            'album' => array(
                'cast' => array('artist' => 'artist_name'),
                'model' => 'AlbumModel'
            ),
            'video' => array(
                'cast' => array('artist' => 'artist_name'),
                'model' => 'VideoModel'
            ),
            'artist' => array(
                'cast' => array(),
                'model' => 'ArtistModel'
            ),
            'song' => array(
                'cast' => array('artist' => 'artist_name'),
                'model' => 'SongModel'
            )
        );


        foreach($data->groups as $group){
            $type = ucfirst($group->groupValue);

            //lay tong so ban ghi tim duoc theo type
            $result["count{$type}"] = $group->doclist->numFound;

            //xu ly du lieu theo tung loai
            $result["list{$type}"] = $init[$group->groupValue]['model']::updateResultFromSearch(
                $this->copyAndCastSearch($group->doclist->docs,$init[$group->groupValue]['cast'])
            );

        }

        return $result;
    }

    /**
     * @param $type: song,album,video,artist
     */
    public function getNumberFound($type)
    {
        //
    }
    private function copyAndCastSearch($array, $mapping, $res=null) {
        $rs = array();
        foreach ($array as $item) {
            $cast = array();
            foreach ($item as $key => $value) {
                if($key == 'real_id'){
                    $cast['id'] = $value;
                }elseif($key!='id')
                    $cast[$key] = $value;
            }
            if(!empty($mapping) && $res){
                foreach($mapping as $mkey => $value){
                    $ctId = $item->id;
                    $cast[$mkey] = isset($res->highlighting->$ctId->$value)?$res->highlighting->$ctId->$value:"";
                    if(!empty($cast[$mkey])){
                        $cast[$mkey] = implode(',',$cast[$mkey]);
                        $cast[$mkey] = strip_tags($cast[$mkey]);
                    }
                }
            }
            $rs[] = $cast;
        }
        return $rs;
    }

    public function suggest($keyword=''){
        try{
            $url = "http://10.0.9.194:3123/suggest";
            $url = "{$url}?".http_build_query(array('q'=>$keyword));

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "$url");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Accept: application/json'
            ));
            $data = curl_exec($ch);
            $data = json_decode($data);
            if (!$data || $data->responseHeader->status!=0) {
                $error = curl_error($ch);
                $this->setErrors($error);
            }else{
                return $data;
            }
        }catch (Exception $ex){

        }
    }
}