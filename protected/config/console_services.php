<?php
return CMap::mergeArray(
    require(dirname(__FILE__).'/console.php'),
    array(
    		'commandPath' => dirname(__FILE__) . '/../commands/services/',
    		'components'=>array(
    		),
    )
)

?>

