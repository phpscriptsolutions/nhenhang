/**
 * Created by NGUYEN NGOC BAO AN on 3/11/2015.
 */
$(function() {
    $('#keyword').keypress(function (e) {
        var key = e.which;
        if(key == 13)  // the enter key code
        {
            $(this).closest('form').submit();
            return false;
        }
    });

    function log(message) {
        $("<div>").text(message).prependTo("#log");
        $("#log").scrollTop(0);
    }
    function match(ar) {
        if (typeof ar.extra1 === "undefined")
            return "";
        rs = ar.extra1;
        return rs;
        for (i=0;i<ar.extra1.lenght;i++) {
            if (ar.extra1[i].indexOf("<b>") != -1) {
                rs = ar.extra1[i];
                break;
            }
        }
        return rs;
    }
    $("#keyword").autocomplete({
        source: function(request, response) {
            $.ajax({
                //url: "http://192.168.241.31:8984/solr/chacha/search?wt=json&indent=true&group=true&group.field=type&group.limit=5",
                url: link_url+"/suggest",
                dataType: "json",
                //jsonp: 'json.wrf',
                data: {
                    // q: request.term.normalize()
                    q: "\"" + request.term.normalize() + "\""
                },
                success: function(data) {
                    var song = [];
                    var artist = [];
                    var album = [];
                    var video = [];
                    var temp = [];
                    $.map(data.grouped.type.groups, function(key) {
                        var br = {
                            name: key.groupValue,
                            score: '--------',
                            weight: '++++++++'
                        };
                        switch (br.name) {
                            case 'song':
                                temp.push(br);
                                $.map(key.doclist.docs, function(item) {
                                    item.type='song';
                                    temp.push(item);
                                });
                                break;
                            case 'artist':
                                temp.push(br);
                                $.map(key.doclist.docs, function(item) {
                                    item.type='artist';
                                    temp.push(item);
                                });
                                break;
                            case 'album':
                                temp.push(br);
                                $.map(key.doclist.docs, function(item) {
                                    console.log('item:'+item);
                                    item.type='album';
                                    temp.push(item);
                                });
                                break;
                            case 'video':
                                temp.push(br);
                                $.map(key.doclist.docs, function(item) {
                                    item.type='video';
                                    temp.push(item);
                                });
                                break;
                        };
                        //temp = song.concat(artist);
                        //temp = temp.concat(album);
                        //temp = temp.concat(video);

                    });
                    response($.map(temp, function(key) {
                        if (key.id){
                            if(key.type=='artist'){
                                return {
                                    //label: data.highlighting[key.id].name_autocomplete_ngram[0]  + " -[score: " + key.score + ", play count: " + key.weight + "]",
                                    label: data.highlighting[key.id].name_autocomplete_ngram[0],
                                    value: key.name,
                                    id: key.real_id,
                                    extra1: key.extra1,
                                    class_name: "item-" + key.type,
                                    type: key.type
                                }
                            }else if(key.type=='album'){
                                console.log('reponse|extra1:'+data.highlighting[key.id].extra1);
                                return {
                                    //label: data.highlighting[key.id].name_autocomplete_ngram[0]  + " -[score: " + key.score + ", play count: " + key.weight + "]",
                                    label: data.highlighting[key.id].name_autocomplete_ngram[0] + "<span> - " + match(data.highlighting[key.id]) + '</span>',
                                    value: key.name,
                                    id: key.real_id,
                                    extra1: key.extra1,
                                    artist_name: data.highlighting[key.id].extra1,
                                    class_name: "item-" + key.type,
                                    type: key.type,
                                    object_type: key.object_type
                                }
                            }else {
                                return {
                                    //label: data.highlighting[key.id].name_autocomplete_ngram[0]  + " -[score: " + key.score + ", play count: " + key.weight + "]",
                                    label: data.highlighting[key.id].name_autocomplete_ngram[0] + "<span> - " + match(data.highlighting[key.id]) + '</span>',
                                    value: key.name,
                                    id: key.real_id,
                                    extra1: key.extra1,
                                    artist_name: data.highlighting[key.id].extra1,
                                    class_name: "item-" + key.type,
                                    type: key.type
                                }
                            }
                        } else {
                            return {
                                label: data.highlighting[key.id],
                                value: key.name,
                                extra1: key.extra1,
                                class_name: "group_type"
                            }
                        }
                    }));
                }
            });
        },
        minLength: 1,
        selectFirst: 1,
        autoFocus: true,
        select: function( event, ui ) {
            var key = event.keyCode;
            if(key==13){
                $(this).closest('form').submit();
                return false;
            }
        }
    }).data("ui-autocomplete")._renderItem = function (ul, item) {
        li = $("<li></li>")
            .data("item.autocomplete", item).addClass(item.class_name);
        if(item.id){
            if(item.type!='artist') {
                hashdis = new Hashids(has_key);
                id = hashdis.encode(parseInt(item.id));

                var labelName = String(item.label);
                var name = item.label.split("-");


                if(name.length<2){
                    var artist_name = '';
                }else{
                    var artist_name = name[name.length-1].trim();
                    artist_name = artist_name.substr(0,artist_name.length-7);

                }
                if(item.type=='song'){
                    var prefix = "";
                    var suffix = "so";
                }else if(item.type=='video'){
                    var prefix = "";
                    var suffix = "mv";
                }else{
                    if(item.object_type=='playlist'){
                        var prefix = "playlist-";
                        var suffix = "pl";
                    }else {
                        var prefix = "album-";
                        var suffix = "ab";
                    }
                }
                var artist_name = String(item.artist_name.join(' '));
                var regex = /(<([^>]+)>)/ig
                var artist_name = artist_name.replace(regex, "");
                //console.log('item.value:'+item.value);
                //console.log('make_friend_url(item.value):'+make_friend_url(item.value));
                //console.log('make_friend_url:'+make_friend_url(artist_name));
                if(item.object_type=='playlist'){
                    link = link_url+'/'+prefix+make_friend_url(item.value)+"-"+suffix+id;
                }else{
                    link = link_url+'/'+prefix+make_friend_url(item.value)+"-"+make_friend_url(artist_name)+"-"+suffix+id;
                }

            }else{
                var prefix = "";
                var suffix = "at";
                hashdis = new Hashids(has_key);
                id = hashdis.encode(parseInt(item.id));
                //link = link_url+'/'+'artist/view/id/'+item.id+'/title/'+make_friend_url(item.value);
                link = link_url+'/'+'nghe-si/'+make_friend_url(item.value)+'-'+suffix+id;
            }

            li.append("<a href='"+link+"'>" + item.label + "</a>");
        }else{
            switch (item.label){
                case 'song':
                    group_name = "Bài hát";
                    group_class = 'group-suggest-song';
                    break;
                case 'artist':
                    group_name = "Nghệ sỹ";
                    group_class = 'group-suggest-artist';
                    break;
                case 'video':
                    group_name = "Video";
                    group_class = 'group-suggest-video';
                    break;
                case 'album':
                    group_name = "Album";
                    group_class = 'group-suggest-album';
                    break;
                default:
                    group_name = item.label;
                    group_class = 'group-suggest-song'
                    break;
            }
            li.addClass(group_class);
            li.append("<span></span><p>" + group_name + "</p>");
        }
        ul.addClass("suggested-box").removeClass('ui-front ui-menu ui-widget ui-widget-content');
        return li.appendTo(ul);
    };
});