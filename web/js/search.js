var ajaxCache={};
$.widget("custom.catcomplete", $.ui.autocomplete, {
    _renderMenu: function( ul, items ) {
        var _self = this;
        ul.addClass('suggested-box');
        $.each( items, function( index, item ) {
            var docs = item.doclist.docs;
            var max = docs.length < 3 ? docs.length : 3;
            if(item.groupValue != "rbt" && item.groupValue != "rington" && item.groupValue != "playlist"){
            	var group_name;
            	switch (item.groupValue){
	            	case "song":
	            		group_name = __t("Song");
	            		break;
	            	case "artist":
	            		group_name = __t("Artist");
	            		break;
	            	default:
	            		group_name = item.groupValue;
	            		break;
            	}
	            var li_type =$("<li></li>").addClass('group_type item-'+item.groupValue).data("item.autocomplete",{
	            }).append($("<span></span>")).append($("<a></a>").append(group_name)).appendTo(ul);
            }


            for(var i = 0;i<max;i++){
                var row = docs[i];
                row.groupValue	= item.groupValue;
                row.id = row.id.substring(item.groupValue.length);
                row.other = docs;

                if(item.groupValue != "rbt" && item.groupValue != "rington" && item.groupValue != "playlist"){

                    var name = $('<h1></h1>').text(row.name.length > 28 ? row.name.substring(0,28) + '...' : row.name);
                    var artist ="";
                    if(item.groupValue != "artist" && item.groupValue != "playlist"){
                    	artist = $("<span></span>").text(row.artist && row.artist.length > 28 ? " - "+row.artist.substring(0,28) + '...':" - "+row.artist);
                    }

                    li = $("<li></li>").data("item.autocomplete",row);
                    var a = $("<a></a>");
                    if(i==0)li.addClass('group');
                    if((i+1)==max)li.addClass('lastitem');

                    li.append(a).addClass('item-'+item.groupValue);

                    a.append(name).append(artist);
                    li.appendTo(ul);
                }
            }
        });
    }
});

function SearchEngine(_service) {
    this._service = _service;
    this._applyUI();
}

SearchEngine._getInstance = function() {
    if (!SearchEngine._instance)
        SearchEngine._instance = new SearchEngine('/search/suggest');
    return SearchEngine._instance;
}

SearchEngine.prototype = {
    _applyUI : function() {
        var _self = this;
        $(".input_search.autocomplete").catcomplete({
            focus: function( event, ui ) {
                $(this).val( ui.item.name);
                return false;
            },
            source: function(request, response) {
                //the cacheterm that we use to save it in the cache
                var cachedTerm = (request.term) . toLowerCase();
                //if the data is in the cache and the data is not too long, use it
                if (ajaxCache[cachedTerm] != undefined && ajaxCache[cachedTerm].length < 13) {
                    response(ajaxCache[cachedTerm]);
                } else {
                    $.ajax({
                        url: _self._service,
                        dataType: "json",
                        data: {
                            term: request.term
                        },
                        success: function(data) {
                            ajaxCache[cachedTerm] = data;
                            var data=data.groups;
                            response(data);
                        }
                    });
                }
            },
            select: function(event, ui){
                if(ui.item.showAll){
                    $(this).parent('form').get(0).submit();
                    return;
                }
                var link =   "/"+ui.item.groupValue+"/"+make_friend_url(ui.item.name)+","+ui.item.id+".html";
                window.location=link;
            },
            minLength:2
        });
    }
};
$(function(){
    SearchEngine._getInstance();
})