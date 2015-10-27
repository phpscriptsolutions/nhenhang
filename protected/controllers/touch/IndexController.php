<?php
/**
 * Created by PhpStorm.
 * User: tiennt
 * Date: 31/07/2015
 * Time: 17:54
 */
class IndexController extends TController
{
    const _NUMBER_ITEM = 6;

    public function actionIndex()
    {
        $limit = self::_NUMBER_ITEM;
        $hotlist = MainContentModel::getListByCollection('HOTLIST', 1, 8);
        $albums = WapAlbumModel::getListHot(1, $limit);
        $videos = WapVideoModel::getListByCollection('VIDEO_HOT', 1, $limit);
        $songs = WapSongModel::getListByCollection('SONG_HOT', 1, 5);
        $news = WapNewsModel::getTopNews(0, 5);
        $video_playlist = WapVideoPlaylistModel::getListByCollection('VIDEO_PLAYLIST_HOT', 1, $limit);


        $this->render("index", compact('albums', 'videos', 'songs', 'news', 'video_playlist', 'hotlist'));
    }
}