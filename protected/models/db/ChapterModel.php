<?php
/**
 * Created by PhpStorm.
 * User: tiennt
 * Date: 27/10/2015
 * Time: 20:17
 */
class ChapterModel{

    public function getChapterByStory($table,$story_slug,$limit = 25,$offset = 0,$select = null){
        $command = Yii::app()->db->createCommand();
        if(!empty($select)){
            $command->select($select);
        }
        $command->limit($limit);
        $command->offset($offset);
        $command->order('chapter_number asc');
        $command->from($table);
        $command->where('story_slug = :slug', array(':slug'=>$story_slug));
        return $command->queryAll();
    }
}