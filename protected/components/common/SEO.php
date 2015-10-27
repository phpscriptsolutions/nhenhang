<?php
class SEO extends CApplicationComponent
{
    public $metaTitle;
    public $metaDescription;
    public $metaKeyword;
    public $metaNewsKeywords;
    public $canonical;

    public $metaKeyOthers = array();
    public $metaProperties = array();

    public $contentId;
    public $contentType;
    public function init()
    {
        parent::init();
    }

    /**
     * @param $id
     * @String $type song,video,album,playlist
     */
    public function setInitialize($id,$type)
    {
        $this->contentId = $id;
        $this->contentType = $type;
    }
    private function findCustomMetaContent($id,$type)
    {
        //find meta in db
        switch($type)
        {
            case 'song':
                $criteria = new CDbCriteria();
                $criteria->condition = "song_id = :song_id";
                $criteria->params = array(':song_id'=>$id);
                $data = SongMetadataModel::model()->findAll($criteria);
                break;
            case 'video':
                $criteria = new CDbCriteria();
                $criteria->condition = "video_id = :video_id";
                $criteria->params = array(':video_id'=>$id);
                $data = VideoMetadataModel::model()->findAll($criteria);
                break;
            case 'album':
                $criteria = new CDbCriteria();
                $criteria->condition = "album_id = :album_id";
                $criteria->params = array(':album_id'=>$id);
                $data = AlbumMetadataModel::model()->findAll($criteria);
                break;
            case 'collection':
                $criteria = new CDbCriteria();
                $criteria->condition = "collection_id = :id";
                $criteria->params = array(':id'=>$id);
                $data = CollectionMetadataModel::model()->findAll($criteria);
                break;
            case 'artist':
                $criteria = new CDbCriteria();
                $criteria->condition = "artist_id = :id";
                $criteria->params = array(':id'=>$id);
                $data = ArtistMetadataModel::model()->findAll($criteria);
                break;
            default:
                $data = false;
                break;
        }
        return $data;
    }
    public function setCustomMetaData()
    {
        $metaData = $this->findCustomMetaContent($this->contentId, $this->contentType);
        if(!empty($metaData)){
            foreach($metaData as $meta){
                if(isset($meta->meta_key) && $meta->meta_key=='title' && !empty($meta->meta_value)){
                    $this->setMetaTitle($meta->meta_value);
                    //$this->addMetaProp('og:title', $meta->meta_value, false);
                }elseif(isset($meta->meta_key) && $meta->meta_key=='keywords' && !empty($meta->meta_value)){
                    $this->setMetaKeyword($meta->meta_value);
                }elseif(isset($meta->meta_key) && $meta->meta_key=='description' && !empty($meta->meta_value)){
                    $this->setMetaDescription($meta->meta_value);
                    //$this->addMetaProp('og:description', $meta->meta_value, false);
                }/*else{
                    $this->addMetaKeyword($meta->meta_key, $meta->meta_value);
                }*/
            }
        }
    }
    public function setMetaTitle($value)
    {
        $value = strip_tags($value);
        $value = CHtml::encode($value);
        $this->metaTitle = $value;
    }
    public function setMetaDescription($value)
    {
        $value = strip_tags($value);
        $value = CHtml::encode($value);
        $this->metaDescription = $value;
    }
    public function setMetaKeyword($value)
    {
        $value = strip_tags($value);
        $value = CHtml::encode($value);
        $this->metaKeyword = $value;
    }

    public function setMetaNewsKeywords($value)
    {
        $value = strip_tags($value);
        $value = CHtml::encode($value);
        $this->metaNewsKeywords = $value;
    }

    public function setCanonical($value)
    {
        $this->canonical = $value;
    }
    public function addMetaProp($name, $value, $duplicate=true)
    {
        $value = strip_tags($value);
        $value = CHtml::encode($value);
        if($name=='og:title'){
            if($value!=''){
                $value.=" | NHENHANG.COM";
            }else{
                $value="NHENHANG.COM";
            }
        }elseif($name=='og:site_name')
        {
            $value="NHENHANG.COM";
        }elseif($name=='og:updated_time')
        {
            $value = date('Y-m-d H:i:s', $value);
        }
        if(!$duplicate){
            if($this->metaProperties){
                $isReplace = false;
                foreach($this->metaProperties as $key => $meta)
                {
                    if($meta['name']==$name){
                        $this->metaProperties[$key]['value'] = $value;
                        $isReplace = true;
                    }
                }
                if(!$isReplace){
                    $this->metaProperties[] = array(
                        'name' => $name,
                        'value' => $value
                    );
                }
            }
        }else {
            $this->metaProperties[] = array(
                'name' => $name,
                'value' => $value
            );
        }
    }
    public function addMetaKeyword($name, $value)
    {
        $value = strip_tags($value);
        $value = CHtml::encode($value);
        $this->metaKeyOthers[$name] = $value;
    }
    public function renderMeta()
    {
        if(empty($this->metaTitle)){
            $this->metaTitle = Yii::app()->params['htmlMetadata']['title'];
        }
        if(empty($this->metaDescription)){
            $this->metaDescription = Yii::app()->params['htmlMetadata']['description'];
        }
        if(empty($this->metaKeyword)){
            $this->metaKeyword = Yii::app()->params['htmlMetadata']['keywords'];
        }
        if(empty($this->canonical)){
            $this->canonical = Yii::app()->request->getHostInfo().Yii::app()->request->url;
        }
        echo CHtml::tag('link',array(
            'rel'=>'canonical',
            'href'=>$this->canonical
        ));

        $this->setCustomMetaData();
        $metaKeywords = CMap::mergeArray(
            array(
                'title'=>$this->metaTitle,
                'description'=>$this->metaDescription,
                'keywords'=>$this->metaKeyword,
            ),
            $this->metaKeyOthers
        );
        //tag default
        echo CHtml::tag('title',array(),$metaKeywords['title']).PHP_EOL;
        echo CHtml::metaTag('NHENHANG.COM','author').PHP_EOL;
        echo '<meta http-equiv="X-UA-Compatible" content="requiresActiveX=true" />'.PHP_EOL;
        echo CHtml::metaTag('Truyện hay online, truyện ngôn tình, kiếm hiệp, tiên hiệp, kinh dị hay nhất','abstract').PHP_EOL;
        echo CHtml::metaTag('Copyright © 2015 by Nhenhang.com','copyright').PHP_EOL;
        $this->addMetaProp('fb:app_id',Yii::app()->params['social']['facebook']['id']);
        //end tag default
        foreach($metaKeywords as $name => $content) {
            echo CHtml::metaTag($content, $name) . PHP_EOL;
        }
        if(!empty($this->metaNewsKeywords)){
            echo CHtml::metaTag($this->metaNewsKeywords, 'news_keywords') . PHP_EOL;
        }
        if(!empty($this->metaProperties)) {
            foreach ($this->metaProperties as $key => $content)
                echo '<meta property="'.$content['name'].'" content="' . $content['value'] . '" />' . PHP_EOL; // we can't use Yii's method for this.
        }

    }
}