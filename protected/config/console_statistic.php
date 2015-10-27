<?php
return CMap::mergeArray(
    require(dirname(__FILE__).'/console.php'),
    array(
    		'commandPath' => dirname(__FILE__) . '/../commands/statistic/',
    		'components'=>array(
    		),
        'params' =>array(
            'cmd.listen.song' => 'play_song',
            'cmd.listen.album' => 'play_album',
            'cmd.listen.video' => 'play_video',
            'cmd.listen.playlist' => 'play_playlits',
        )
    )
)

?>

