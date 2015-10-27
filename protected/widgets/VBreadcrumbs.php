<?php
Yii::import("zii.widgets.CBreadcrumbs");
class VBreadcrumbs extends CBreadcrumbs
{
	public function run()
	{
		if(empty($this->links))
			return;
		$this->activeLinkTemplate='<a href="{url}" title="{title}" itemprop="url">{label}</a>';
		echo CHtml::openTag($this->tagName,$this->htmlOptions)."\n";
		$links=array();

		foreach($this->links as $label=>$url)
		{
			if(is_string($label) || is_array($url)) {
				$links[] = strtr($this->activeLinkTemplate, array(
					'{url}' => CHtml::normalizeUrl($url),
					'{title}' => $this->encodeLabel ? CHtml::encode($label) : $label,
					//'{title}' => $this->encodeLabel ? CHtml::encode($label) : $label,
					'{label}' => $this->encodeLabel ? '<span class="breadcrumb-text" itemprop="title">'.CHtml::encode($label).'</span>' : '<span class="breadcrumb-text" itemprop="title">'.$label.'</span>',
					'{alt}' => $this->encodeLabel ? CHtml::encode($label) : $label,
				));
			}
			else
				$links[]=str_replace('{label}',$this->encodeLabel ? CHtml::encode($url) : $url, $this->inactiveLinkTemplate);
		}

		echo '<ul class="breadcrumbs">';
		echo '<li>'.CHtml::link('Trang chủ', 'http://nhenhang.com/', array('title' => 'nhenhang.com', 'alt' => 'nhenhang.com')).'</li>';
		echo '<li><i class="icon icon_arr"></i></li>';
		$i=0;
		foreach($links as $link){
			if($i>0){
				echo '<li><i class="icon icon_arr"></i></li>';
			}
			echo '<li itemscope="itemscope" itemtype="http://data-vocabulary.org/Breadcrumb">'.$link.'</li>';
			$i++;
		}
		echo '</ul>';
		//echo implode($this->separator,$links);
		echo CHtml::closeTag($this->tagName);
	}
}
