<?php
class VLinkPager extends CLinkPager {
	public $internalPageCssClass = "";
	public $selectedPageCssClass="active";

	public $object_link;
	public $suffix;
	public function init() {
		if ($this->nextPageLabel === null)
			$this->nextPageLabel = '&#187;';
		if ($this->prevPageLabel === null)
			$this->prevPageLabel = '&#171;';
		if ($this->firstPageLabel === null)
			$this->firstPageLabel = "";
		if ($this->lastPageLabel === null)
			$this->lastPageLabel = "";
		if ($this->header === null)
			$this->header = "";

		if (! isset ( $this->htmlOptions ['id'] ))
			$this->htmlOptions ['id'] = $this->getId ();
		if (! isset ( $this->htmlOptions ['class'] ))
			$this->htmlOptions ['class'] = 'yiiPager';
		$this->pages->pageVar = 'p';
	}

	protected function createPageButtons()
	{
		if(($pageCount=$this->getPageCount())<=1)
			return array();

		list($beginPage,$endPage)=$this->getPageRange();
		$currentPage=$this->getCurrentPage(false); // currentPage is calculated in getPageRange()
		$buttons=array();

		// first page
		if($this->firstPageLabel){
			$buttons[]=$this->createPageButton($this->firstPageLabel,0,$this->firstPageCssClass,$currentPage<=0,false);
		}

		// prev page
		if(($page=$currentPage-1)<0)
			$page=0;
		$buttons[]=$this->createPageButton($this->prevPageLabel,$page,$this->previousPageCssClass,$currentPage<=0,false);

		// internal pages
		for($i=$beginPage;$i<=$endPage;++$i)
			$buttons[]=$this->createPageButton($i+1,$i,$this->internalPageCssClass,false,$i==$currentPage);

		// next page
		if(($page=$currentPage+1)>=$pageCount-1)
			$page=$pageCount-1;
		$buttons[]=$this->createPageButton($this->nextPageLabel,$page,$this->nextPageCssClass,$currentPage>=$pageCount-1,false);

		// last page
		if($this->lastPageLabel){
			$buttons[]=$this->createPageButton($this->lastPageLabel,$pageCount-1,$this->lastPageCssClass,$currentPage>=$pageCount-1,false);
		}
		return $buttons;
	}

	protected function createPageButton($label,$page,$class,$hidden,$selected)
	{
		$a_class_active = "";
		if($hidden || $selected){
			$class.=' '.($hidden ? $this->hiddenPageCssClass : $this->selectedPageCssClass);
			if(!$hidden){
				$a_class_active = $this->selectedPageCssClass;
			}
		}

		//return '<li class="'.$class.'">'.CHtml::link($label,$this->createPageUrl($page),array('class'=>$a_class_active)).'</li>';
		return '<li class="'.$class.'">'.CHtml::link($label,$this->createPageUrlSeo($page),array('class'=>$a_class_active)).'</li>';
	}
	private function createPageUrlSeo($pageNumber=0)
	{
		$link="#";
		if(!empty($this->suffix) && !empty($this->object_link)) {
			$object = $this->object_link;
			if ($pageNumber > 0) {
				$object['other']['p'] = $pageNumber+1;
			}
			switch ($this->suffix) {
				case 'gr'://genre
					$link = URLHelper::makeUrlGenre($object);
					break;
				case 'at'://genre
				case 'ai'://artist_list
					$link = URLHelper::makeUrlMultiLevel($object);
					break;
			}
		}else{

			$link = Yii::app()->request->requestUri;
			preg_match("/p=(\w+)/", $link, $match);
			if($match){
				if(!empty($match[0])){
					if ($pageNumber > 0) {
						$p = $pageNumber+1;
						$link = str_replace($match[0],'p='.$p, $link);
					}else{
						$link = str_replace(array('?'.$match[0],'&'.$match[0]),'', $link);;
					}
				}
			}else{
				if ($pageNumber > 0) {
					$p = $pageNumber+1;
					if(strpos($link,'?')!==false){
						$link .="&p=".$p;
					}else
						$link .="?p=".$p;
				}

			}
		}
		return $link;
	}
}
