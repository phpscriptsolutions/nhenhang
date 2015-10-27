<div class="error_page">
    <div class="img-404">
        <img src="/web/images/not-found.png"/>
    </div>
    <div class="content-404">
        <?php
        $hotlist = MainContentModel::getListByCollection('HOTLIST', 1, 4);
        ?>
        <ul class="box_items_list">
            <?php if ($hotlist):
                $i=0;
                foreach ($hotlist as $album):
                    $obj = array("obj_type"=>$album->type,'name'=>$album->name,'id'=>$album->id,'artist'=>$album->artist_name);
                    $link = URLHelper::makeUrl($obj);

                    $linkArtist = Yii::app()->createUrl("/search")."?".http_build_query(array("keyword"=>CHtml::encode($album->artist_name)));
                    $titleLink = $altImg = CHtml::encode($album->name).' - '.CHtml::encode($album->artist_name);
                    ?>
                    <li class="item<?php echo $i;?> <?php if($i%2 == 0) echo 'marr_0'; else echo 'marr_1';?>">
                        <div class="wrr-row">
                        <a href="<?php echo $link ?>"><img class="thumb fll" width="48" height="48" src="<?php echo AvatarHelper::getAvatar("album", $album->id,'s3')?>" alt="<?php echo $altImg; ?>"/></a>
                        <div class="info-table">
                            <h3 class="name"><a href="<?php echo $link ?>" title="<?php echo CHtml::encode($album->name);?>"><?php echo Formatter::smartCut(CHtml::encode($album->name),70);;?></a></h3>
                        </div>
                        </div>
                    </li>
                    <?php
                    $i++;
                endforeach;?>
            <?php else:?>
                <p class="notfound"><?php echo Yii::t("web", "Chưa có album nào."); ?></p>
            <?php endif; ?>
        </ul>
    </div>
</div>

<?php
$erroMsg = "";
if (!empty($error))
    $erroMsg = $error['message'];


/* if(isset($error['code']) && $error['code']==404){
  echo "<h1>Không tìm thấy trang</h1>";
  }else{
  echo "<h1>Lỗi:$erroMsg</h1>";
  } */
echo "<br />";
if (YII_DEBUG):
    ?>
    <div class="traces">
        <h3>Error:</h3>
        <?php
        if (isset($_GET['dev'])) {
            echo "<pre>";
            print_r($error);
            echo "</pre>";
            exit();
        }
        ?>
        <h2>Stack Trace</h2>
        <?php $count = 0; ?>
        <table style="width:100%;">
            <?php foreach ($error['traces'] as $n => $trace): ?>
                <?php
                $cssClass = 'app expanded';
                ?>
                <tr class="trace <?php echo $cssClass; ?>">
                    <td class="number">
                        #<?php echo $n; ?>
                    </td>
                    <td class="content">
                        <div class="trace-file">
                            <?php
                            echo '&nbsp;';
                            echo htmlspecialchars($trace['file'], ENT_QUOTES, Yii::app()->charset) . "(" . $trace['line'] . ")";
                            echo ': ';
                            if (!empty($trace['class']))
                                echo "<strong>{$trace['class']}</strong>{$trace['type']}";
                            echo "<strong>{$trace['function']}</strong>(";
                            if (!empty($trace['args']))
                                echo htmlspecialchars(argumentsToString($trace['args']), ENT_QUOTES, Yii::app()->charset);
                            echo ')';
                            ?>
                        </div>

                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <?php
endif;

function argumentsToString($args) {
    $count = 0;

    $isAssoc = $args !== array_values($args);

    foreach ($args as $key => $value) {
        $count++;
        if ($count >= 5) {
            if ($count > 5)
                unset($args[$key]);
            else
                $args[$key] = '...';
            continue;
        }

        if (is_object($value))
            $args[$key] = get_class($value);
        elseif (is_bool($value))
            $args[$key] = $value ? 'true' : 'false';
        elseif (is_string($value)) {
            if (strlen($value) > 64)
                $args[$key] = '"' . substr($value, 0, 64) . '..."';
            else
                $args[$key] = '"' . $value . '"';
        }
        elseif (is_array($value))
            $args[$key] = 'array(' . argumentsToString($value) . ')';
        elseif ($value === null)
            $args[$key] = 'null';
        elseif (is_resource($value))
            $args[$key] = 'resource';

        if (is_string($key)) {
            $args[$key] = '"' . $key . '" => ' . $args[$key];
        } elseif ($isAssoc) {
            $args[$key] = $key . ' => ' . $args[$key];
        }
    }
    $out = implode(", ", $args);

    return $out;
}
?>