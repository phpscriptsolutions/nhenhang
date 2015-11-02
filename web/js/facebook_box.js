function facebook(callback){
	jQuery(document).ready(function(){
		var state = getCookie("connect");
		if(!state){
			var img = new Image();
			img.onload=function(){
				setCookie("connect","OK");
				callback();
			};
			img.src='http://www.facebook.com/images/loaders/indicator_black.gif?t='+new Date();
		}else{
			if(state == "OK"){
				callback();
			}
		}
		
	});
}
	
window.setCookie = 	function(name, value, expires) {
	document.cookie = name + "=" + value + "; path=/" + ((expires == null) ? "" : "; expires=" + expires.toGMTString());
};
window.getCookie = 	function (name) {
	var start = document.cookie.indexOf( name + "=" );
	var len = start + name.length + 1;
	if ( ( !start ) &&
	( name != document.cookie.substring( 0, name.length ) ) )
	{
		return null;
	}
	if ( start == -1 ) return null;
	var end = document.cookie.indexOf( ";", len );
	if ( end == -1 ) end = document.cookie.length;
	return unescape( document.cookie.substring( len, end ) );
};
	
facebook(function(){
	$("#facebook-fan").show();
	var html = '';
	html = html.concat('<div>');
	html = html.concat('<iframe src="http://www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fkhotruyenhay4u&width=335&colorscheme=light&show_faces=true&border_color&stream=false&header=false" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:335px; height:260px;" allowTransparency="true"></iframe>');
	html = html.concat('</div>');
	$("#facebook-fan").html(html);
})
