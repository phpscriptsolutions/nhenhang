<?php
/**
 * Created by PhpStorm.
 * User: tiennt
 * Date: 27/10/2015
 * Time: 20:17
 */
class ChapterModel{
    public function getOtherChapterByChapterNumber($table,$storyId,$chapterNumbers){
        try {
            $command = Yii::app()->db->createCommand();
            $command->select('id,chapter_number,chapter_slug,chapter_name');
            $command->from($table);
            $command->where(array('in','chapter_number',$chapterNumbers));
            $command->andwhere('story_id = :storyId', array(':storyId' => $storyId));
            return $command->queryAll();
        }catch (Exception $ex){
            return null;
        }
    }

    public function getChapterByStoryId($table,$storyId,$limit = 25,$offset = 0,$select = null){
        try {
            $command = Yii::app()->db->createCommand();
            if (!empty($select)) {
                $command->select($select);
            }
            $command->limit($limit);
            $command->offset($offset);
            $command->order('chapter_number asc');
            $command->from($table);
            $command->where('story_id = :storyId', array(':storyId' => $storyId));
            return $command->queryAll();
        }catch (Exception $ex){
            return null;
        }
    }
    public function countChapterByStoryId($table,$storyId){
        try {
            $command = Yii::app()->db->createCommand();
            $command->select('COUNT(*) as total');
            $command->from($table);
            $command->where('story_id = :storyId', array(':storyId' => $storyId));
            $data = $command->queryRow();
            return $data['total'];
        }catch (Exception $ex){
            return 0;
        }
    }

    public function getChapterByStory($table,$story_slug,$limit = 25,$offset = 0,$select = null){
        try {
            $command = Yii::app()->db->createCommand();
            if (!empty($select)) {
                $command->select($select);
            }
            $command->limit($limit);
            $command->offset($offset);
            $command->order('chapter_number asc');
            $command->from($table);
            $command->where('story_slug = :slug', array(':slug' => $story_slug));
            return $command->queryAll();
        }catch (Exception $ex){
            return null;
        }
    }

    public function getChapterById($table,$chapterId,$select = null){
        try {
            $command = Yii::app()->db->createCommand();
            if (!empty($select)) {
                $command->select($select);
            }
            $command->from($table);
            $command->where('id = :chapterId', array(':chapterId' => $chapterId));
            return $command->queryRow();
        }catch (Exception $ex){
            return null;
        }
    }

    public function countChapterByStory($table,$story_slug){
        try {
            $command = Yii::app()->db->createCommand();
            $command->select('COUNT(*) as total');
            $command->from($table);
            $command->where('story_slug = :slug', array(':slug' => $story_slug));
            $data = $command->queryRow();
            return $data['total'];
        }catch (Exception $ex){
            return 0;
        }
    }
}