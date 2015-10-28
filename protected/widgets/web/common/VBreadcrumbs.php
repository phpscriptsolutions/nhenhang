<?php
Yii::import("zii.widgets.CBreadcrumbs");
class VBreadcrumbs extends CBreadcrumbs
{
	/* public function run()
	{
		if(empty($this->links))
			return;

		echo CHtml::openTag($this->tagName,$this->htmlOptions)."\n";
		$links=array();
		if($this->homeLink===null)
			$links[]=CHtml::link(Yii::t('zii','Home'),Yii::app()->homeUrl);
		elseif($this->homeLink!==false)
		$links[]=$this->homeLink;
		foreach($this->links as $label=>$url)
		{
			if(is_string($label) || is_array($url))
				$links[]=strtr($this->activeLinkTemplate,array(
						'{url}'=>CHtml::normalizeUrl($url),
						'{label}'=>$this->encodeLabel ? CHtml::encode($label) : $label,
				));
			else
				$links[]=str_replace('{label}',$this->encodeLabel ? CHtml::encode($url) : $url,$this->inactiveLinkTemplate);
		}

		echo "<ul>";
		$i=0;
		foreach($links as $link){
			if($i>0){
				echo '<li><i class="icon icon_mt"></i></li>';
			}
			echo '<li>'.$link.'</li>';
			$i++;
		}
		echo "</ul>";
		//echo implode($this->separator,$links);
		echo CHtml::closeTag($this->tagName);
	} */
	public function run()
	{
		if(empty($this->links))
			return;
		$this->activeLinkTemplate='<a href="{url}" title="{title}" rel="v:url" property="v:title">{label}</a>';
		echo CHtml::openTag($this->tagName,$this->htmlOptions)."\n";
		$links=array();
		if($this->homeLink===null)
			$links[]=CHtml::link(Yii::t('zii','Home'),Yii::app()->homeUrl);
		elseif($this->homeLink!==false)
		$links[]=$this->homeLink;
		foreach($this->links as $label=>$url)
		{
			if(is_string($label) || is_array($url))
				$links[]=strtr($this->activeLinkTemplate,array(
						'{url}'=>CHtml::normalizeUrl($url),
						'{label}'=>$this->encodeLabel ? CHtml::encode($label) : $label,
						'{title}'=>$this->encodeLabel ? CHtml::encode($label) : $label,
				));
			else
				$links[]=str_replace('{label}',$this->encodeLabel ? CHtml::encode($url) : $url,$this->inactiveLinkTemplate);
		}

		echo "<div xmlns:v='http://rdf.data-vocabulary.org/#'>";
		$i=0;
		foreach($links as $link){
			if($i>0){
				echo '&nbsp;&nbsp;<i class="icon icon_mt"></i>&nbsp;&nbsp;';
			}
			echo '<span typeof="v:Breadcrumb">'.$link.'</span>';
			$i++;
		}
		echo "</div>";
		//echo implode($this->separator,$links);
		echo CHtml::closeTag($this->tagName);
	}
}
