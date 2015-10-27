<?php 
if(count($imported)>0):
?>
<div>(<?php echo $imported['stt'];?>) (Success!) (<?php echo $imported['name'];?>) (<?php echo $imported['path'];?>) (<?php echo $imported['songId'];?>)</div>
    
<?php else:?>
<div>(<?php echo $notImport['stt'];?>) (Fail!) (<?php echo $notImport['name'];?>) (<?php echo $notImport['path'];?>) (<?php echo $notImport['errorDesc'];?>)</div>
<?php endif;?>