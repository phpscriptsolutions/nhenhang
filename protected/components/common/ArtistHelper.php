<?php

class ArtistHelper {    
    public static function ArtistsByAlbum($id) {
       	$artists = AlbumArtistModel::model()->getArtistsByAlbum($id);
       	$i = 0;
       	$html = "";
       	foreach ($artists as $artist) {        	
			$html .= ($i > 0) ? "<span>&nbsp;-&nbsp;</span>" : "";		
        	$html .= '<a href="' . URLHelper::buildFriendlyURL("artist", $artist->artist_id, Common::makeFriendlyUrl($artist->artist_name)) 
        			. '" title="' . $artist->artist_name . '">'
        	        . Formatter::substring($artist->artist_name, " ", 3, 15) 
        	        . '</a>';        	
			$i++;
       	}
       	
       	return $html;
    }
    
    public static function ArtistNamesByAlbum($id) {
    	$artists = AlbumArtistModel::model()->getArtistsByAlbum($id);
    	$i = 0;
    	$html = "";
    	foreach ($artists as $artist) {    		
    		$html .= ($i > 0) ? " - " : "";
    		$html .= $artist->artist_name;    		    		
    		$i++;
    	}    
    	return $html;
    }
    
    public static function ArtistNamesByVideoPlaylist($id) {
    	$artists = VideoPlaylistArtistModel::model()->getArtistsByVideoPlaylist($id);
    	$i = 0;
    	$html = "";
    	foreach ($artists as $artist) {
    		$html .= ($i > 0) ? " - " : "";
    		$html .= $artist->artist_name;
    		$i++;
    	}
    	return $html;
    }
    
    public static function ArtistsByAlbumForWapDetail($id) {
    	$artists = AlbumArtistModel::model()->getArtistsByAlbum($id);
    	$i = 0;
    	$html = "";
    	foreach ($artists as $artist) {
    		$html .= ($i > 0) ? "&nbsp;-&nbsp" : "";
    		$html .= '<a href="' . URLHelper::buildFriendlyURL("artist", $artist->artist_id, Common::makeFriendlyUrl($artist->artist_name)) .'">' . $artist->artist_name . '</a>';    		
    		$i++;
    	}
    	return $html;
    }
}
