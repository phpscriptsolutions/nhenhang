var ajax_loading_content = '<img src="/web/images/content_loading.gif" />';
var xhr=null;
function msieversion() {

    var ua = window.navigator.userAgent;
    var msie = ua.indexOf("MSIE ");

    if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer, return version number
        return parseInt(ua.substring(msie + 5, ua.indexOf(".", msie)));
    else                 // If another browser, return 0
        return false;

    return false;
}
ie = msieversion();
var Popup = {

    title_popup: 'Thông báo',
    //position_popup: 'fixed',
    position_popup: 'absolute',
    init: function() {
        $('.popup_inline').on('click', function() {
            var id = $(this).attr("rel");
            $("#vg_popup").html($("#"+id).html())
            Popup.show();
            return false;
        });
        $('.ajax_popup').on('click', function() {
            var l = $(this).attr("href");
            Popup.ajax(l);
            /*$.ajax({
             url: l,
             type: "post",
             success: function(response){
             $("#vg_popup").html(response)
             Popup.show();
             }
             })
             return false;*/
            return false;
        });
    },
    ajax: function(href){
        $.ajax({
            url: href,
            type: "post",
            success: function(response){
                $("#vg_popup").html(response);
                if(href.indexOf("getPopupPlaylist")>0){
                    Popup.position_popup='absolute';
                }
                Popup.show();
            }
        })
        return false;
    },
    alert: function(content){
        var html_alert=
            '<div id="Popup">'
            +	'<a href="javascript:void(0)" class="popup_close">X</a>'
            +		'<div id="popup_wr">'
            +			'<div class="popup_title">'
            +				'<span id="pop_title">'+Popup.title_popup+'</span>'
            +			'</div>'
            +			'<div class="popup_content">'
            +			'<div style="padding: 10px">'
            +			content
            +			'</div>'
            +			'</div>'
            +		'</div>'
            +	'</div>'
        $("#vg_popup").html(html_alert)
        Popup.show();
    },
    close: function() {
        $('#vg_popup').addClass('none');
        $('#vg_popup').html("");
        $('#popup_mask').addClass('none');
        $("#vg_wrapper").css({
            height: 'auto'
        });
        $("#wrr-page").css({
            height: 'auto'
        })
    },
    show: function() {
        $('#vg_popup').removeClass('none');
        $('#popup_mask').removeClass('none');
        var height_doc = $(document).height();
        var height_w = $(window).height();
        var height_popup = $("#vg_popup").height();

        var width_w = $(window).width();
        var widthpopup_w = $("#vg_popup").width();

        var pos_x = (width_w-widthpopup_w)/2
        $("#wrr-page").css({
            overflow: 'hidden',
            height: height_w+'px'
        })

        var left = (width_w/2)-(widthpopup_w/2);
        var top = (height_w/2)-(height_popup/2) - 50;
        position = Popup.position_popup;
        if(height_popup>height_w){
            top=0;
            position='absolute';
            document.body.scrollTop=0;
        }

        var p_mask_h='1500';
        if(height_popup<height_w){
            var p_mask_h = height_doc;
            if(height_doc<height_w){
                p_mask_h = height_w;
            }
        }else if(height_popup>height_w){
            var p_mask_h = height_popup+100;
        }else{
            var p_mask_h = height_doc;
        }
        p_mask_h = height_w;
        $("#vg_wrapper").css({
            height: p_mask_h+'px'
        });
        $('#popup_mask').css({
            height: p_mask_h+'px'
        });
        $('#vg_popup').css({
            top: top+'px',
            position: position,
            left: left+'px'
        });
        $('.popup_close').on('click', function() {
            Popup.close();
        });
        $('#popup_mask').on('click', function() {
            Popup.close();
        });
    }
};
var NhacVnCoreJs = {
    songId:0,
    userId:0,
    userPage:0,
    playlistTag:'',
    init: function(){
        NhacVnCoreJs.userId = $("#user_id").text();
        NhacVnCoreJs.userPage = $("#user_page").val();
        $(".addsongtmpl").bind('click',function() {
            userId = $("#user_id").text();
            if(userId == 0){
                addDialoglogin_form_dialog();
                jQuery('#login_form_dialog').dialog('open');
                return false;
            }

            var sid = $(this).attr('id');
            NhacVnCoreJs.songId = sid;
            $('#song_'+sid+' .more_action').addClass('show');
            $('#song_'+sid+' .more_action').find('.icon_add').addClass('active');

            $('#dialog-myplaylist-box .mp-f1').removeClass('hide');
            $('#dialog-myplaylist-box .mp-f2').removeClass('show');
            $('#dialog-myplaylist-box .mp-f2').addClass('hide');
            NhacVnCoreJs.showDialogPlaylist($(this).find('i'));
            $("#overlay_ts").bind('click', function(){
                NhacVnCoreJs.hideOverlay();
                NhacVnCoreJs.closePlaylist();
            })
            return false
        });
        $(".addsongtmpldt").bind('click',function() {
            userId = $("#user_id").text();
            if(userId == 0){
                addDialoglogin_form_dialog();
                jQuery('#login_form_dialog').dialog('open');
                return false;
            }
            NhacVnCoreJs.playlistTag = 'sdt';
            var sid = $(this).attr('id');
            NhacVnCoreJs.songId = sid;

            $('#dialog-myplaylist-box .mp-f1').removeClass('hide');
            $('#dialog-myplaylist-box .mp-f2').removeClass('show');
            $('#dialog-myplaylist-box .mp-f2').addClass('hide');
            NhacVnCoreJs.showDialogPlaylist($(this));
            $("#overlay_ts").bind('click', function(){
                NhacVnCoreJs.hideOverlay();
                NhacVnCoreJs.closePlaylist();
            })
            return false
        });
        $('.pl-create-nav a').bind('click', function(){
            NhacVnCoreJs.mpf1tof2();
            NhacVnCoreJs.buildFormCreatePl();
        })
        $('a.mp-f2-back').bind('click', function(){
            $('#dialog-myplaylist-box .mp-f1').removeClass('hide');
            $('#dialog-myplaylist-box .mp-f2').removeClass('show');
            $('#dialog-myplaylist-box .mp-f2').addClass('hide');
            var a = $("#dialog-myplaylist-box");
            var top = NhacVnCoreJs.playlistTop;
            var left = NhacVnCoreJs.playlistLeft;
            a.css("top", top).css("left", left);
        })
        $('#dialog-myplaylist-box .l-items li a').bind('click', function(){
            //$(this).toggleClass('added');
            var playlistId = $(this).attr('id');
            var songId = NhacVnCoreJs.songId;
            NhacVnCoreJs.addSongToPlaylist(songId,playlistId);
        })
        $('.crollto').bind('click',function(){
            var n = $(this).attr('rel');
            var t = $('#'+n).offset();
            $('body,html').animate({
                scrollTop: t.top-155
            }, 400);
        })
    },
    closePlaylist: function()
    {
        var s = NhacVnCoreJs.songId;
        $('#song_'+s+' .more_action').removeClass('show');
        var a = $("#dialog-myplaylist-box");
        $('#song_'+s+' .more_action').find('.icon_add').removeClass('active');
        a.addClass("hide");
        a.find('#playlist-items').html('');
    },
    mpf2tof1:function()
    {
        $('#dialog-myplaylist-box .mp-f1').removeClass('hide');
        $('#dialog-myplaylist-box .mp-f2').removeClass('show');
        $('#dialog-myplaylist-box .mp-f2').addClass('hide');
    },
    mpf1tof2: function()
    {
        $('#dialog-myplaylist-box .mp-f1').addClass('hide');
        $('#dialog-myplaylist-box .mp-f2').removeClass('hide');
        $('#dialog-myplaylist-box .mp-f2').addClass('show');
        if(NhacVnCoreJs.playlistPos>0){
            var a = $("#dialog-myplaylist-box");
            var top = NhacVnCoreJs.playlistPos-230;
            a.css("top", top);
            //NhacVnCoreJs.playlistPos=0;
        }
    },
    buildFormCreatePl: function()
    {
        $.ajax({
            url: '/xhrUser/createMyPlaylist',
            type:'post',
            data: {songId:NhacVnCoreJs.songId},
            dataType:'json',
            beforeSend: function()
            {
                $('#f-c-pl').html('<img width="16" src="/web/images/ajax-loader.gif" />');
            },
            success: function(data){
                if(data.errorCode==1) {
                    $('#f-c-pl').html(data.html);
                    $('#create-playlist-form #PlaylistForm_name').attr('value','Playlist mới').select();
                }
            }
        })
    },
    submitCreatePl: function()
    {
        var data = $('#f-c-pl form').serialize();
        $.ajax({
            url: '/xhrUser/createMyPlaylist',
            type:'post',
            dataType:'json',
            data: {post:data},
            beforeSend: function()
            {
                //$('#f-c-pl').html('<img width="16" src="/web/images/ajax-loader.gif" />');
            },
            success: function(data){
                if(data.errorCode==1) {
                    $('#f-c-pl').html(data.html);
                    $('#create-playlist-form #PlaylistForm_name').focus();
                }else if(data.errorCode==0){
                    //var a = $("#dialog-myplaylist-box");
                    //NhacVnCoreJs.buildMyPlaylist(a);
                    //NhacVnCoreJs.mpf2tof1();
                    NhacVnCoreJs.closePlaylist();
                    $('.album-player .more_action').removeClass('show');
                    NhacVnCoreJs.hideOverlay();
                    NhacVnCoreJs.addNotify(data.msg)
                }
            }
        })
    },
    playlistPos:0,
    playlistTop:0,
    playlistLeft:0,
    showPlaylist: function(top,left)
    {
        var a = $("#dialog-myplaylist-box");
        if(NhacVnCoreJs.playlistTag=='sdt'){
            left +=160;
            top += 10;
            a.find('.uarr').css('left',10);
            a.find('.darr').css('left',10);
        }
        NhacVnCoreJs.playlistTop = top;
        NhacVnCoreJs.playlistLeft = left;
        a.removeClass("hide").css("top", top).css("left", left).css("display", "block");
        this.showOverlay();
    },
    showDialogPlaylist: function(b) {
        var c = $(b).offset();
        var a = $("#dialog-myplaylist-box");
        var hp = 275;//height popup
        //c.top += $(b).height() + 8;
        //c.left += $(b).width() / 2;
        c.left = c.left-162;
        c.top = c.top+37;
        var wheight = $(window).height();
        var hcroll = $(window).scrollTop();
        var hetop = $(b).offset().top-hcroll;
        var hebottom = wheight-hetop;
        if(hebottom>hp || hebottom>hetop){
            c.top = c.top-11;
            NhacVnCoreJs.playlistPos = 0;
            $("#dialog-myplaylist-box .darr").removeClass('show');
            $("#dialog-myplaylist-box .uarr").addClass('show');
        }else{
            NhacVnCoreJs.playlistPos = c.top;
            c.top = c.top-hp-45;
            $("#dialog-myplaylist-box .uarr").removeClass('show');
            $("#dialog-myplaylist-box .darr").addClass('show');
        }
        /*if(hetop>hebottom){
            NhacVnCoreJs.playlistPos = c.top;
            c.top = c.top-335;
            $("#dialog-myplaylist-box .uarr").removeClass('show');
            $("#dialog-myplaylist-box .darr").addClass('show');
        }else{
            NhacVnCoreJs.playlistPos = 0;
            $("#dialog-myplaylist-box .darr").removeClass('show');
            $("#dialog-myplaylist-box .uarr").addClass('show');
        }*/
        this.buildMyPlaylist(a);
        //$('#playlist-items').jScrollPane();
        this.showPlaylist(c.top, c.left);
    },
    buildMyPlaylist: function(a)
    {
        $.ajax({
            url: '/xhrUser/findMyPlaylist',
            type:'get',
            dataType:'json',
            beforeSend: function()
            {
                //a.find('#playlist-items').html('<img width="16" src="/web/images/ajax-loader.gif" />');
                a.find('#playlist-items').addClass('loadding');
            },
            success: function(data){
                a.find('#playlist-items').removeClass('loadding');
                if(data.errorCode==0){
                    a.find('#playlist-items').html(data.data);
                    if(data.total>4) {
                        $('#wrr-mplaylist').css({'height': 226});
                        var element = $('#wrr-mplaylist').jScrollPane();
                        var api = element.data('jsp');
                        NhacVnCoreJs.loadMoreScroll('wrr-mplaylist', api);
                    }
                }
            }
        })
    },
    addSongToPlaylist: function(songId,playlistId)
    {
        $.ajax({
            url: '/xhrUser/updateSongToPlaylist',
            type:'post',
            data:{songId:songId, playlistId:playlistId},
            dataType:'json',
            beforeSend: function()
            {
                //a.find('#playlist-items').addClass('loadding');
                NhacVnCoreJs.closePlaylist();
                NhacVnCoreJs.hideOverlay();
            },
            success: function(data){
                if(data.errorCode==0){
                    //add success
                    NhacVnCoreJs.addNotify('Thêm bài hát vào playlist thành công.')
                }else{
                    NhacVnCoreJs.addNotify(data.msg);
                }
            }
        })
    },
    showOverlay: function()
    {
        $('#overlay_ts').remove();
        var $overlay = $('<div id="overlay_ts"></div>').hide().appendTo('body');
        $('#overlay_ts').width($(document).width());
        $('#overlay_ts').height($(document).height());
        $('#overlay_ts').fadeIn();
    },
    hideOverlay: function()
    {
        $('#overlay_ts').remove();
    },
    loadMoreScroll: function(vid,api)
    {
        var page_load = $("#"+vid+" .load_mypl_auto").val();
        var type = $("#"+vid+" .load_mypl_auto").attr("id");
        var loading = false;
        page_load = parseInt(page_load) +1;
        if(page_load) {
            $("#" + vid).scroll(function () {
                var pos = api.getContentPositionY();
                var cheight = '226'
                var wscroll = $("#" + vid).scrollTop();
                var wh = $("#" + vid).height();
                var doch = $("#" + vid).height();
                var hOfScroll = $("#" + vid)[0].scrollHeight;
                //if (wscroll >= doch-range && loading==false) {
                if ((cheight-pos) <= 0 && loading==false) {
                    loading = true;
                    $('.animation_image').show();
                    setTimeout(function(){
                        $.ajax({
                            url:'/xhrUser/findMyPlaylist',
                            data: {'page': page_load,'type':type},
                            dataType:'json',
                            beforeSend: function()
                            {
                                //$("#"+vid+" ul.l-items").append('<li><img width="32" src="/web/images/ajax-loader.gif" /></li>');
                                $('#mploading').css({'text-align':'center'}).css({'display':'block'}).html('<img width="28" src="/web/images/content_loading.gif" />');
                            },
                            success: function(data)
                            {
                                $('#mploading').css({'display':'none'}).html('');
                                if(data.errorCode==0){
                                    $("#"+vid+" ul.l-items").append(data.data);
                                    $('#'+vid).jScrollPane();
                                    page_load++;
                                    $("#"+vid+" #myplaylist_loadmore").attr('value',page_load);
                                    loading = false;
                                }else{
                                    loading = true;
                                }
                            },
                            error: function(){
                                alert(thrownError); //alert with HTTP error
                                $('.animation_image').hide(); //hide loading image
                                loading = false;
                            }
                        })
                    },300)

                }
            })
        }
    },
    whereMe:'',
    initMyMusic: function()
    {
        //sửa xóa nhạc của tôi
        $('.myplaylist .mp-nav-tool a.edit').bind('click', function(){
            var id = $(this).attr('rel');
            var a = $('.myplaylist li#albumlist-'+id);
            a.addClass('active');
            NhacVnCoreJs.whereMe = $(this).attr('data-type');
            var s = $(this).closest( ".mp-nav-tool" );
            NhacVnCoreJs.AddPopupMyMusic('Sửa playlist');
            s.addClass('show');
            var url = '/xhrUser/editMyPlaylist';
            NhacVnCoreJs.LoadPopupMyMusic(url,id);
            var popup = $('#popuppro-box');
            NhacVnCoreJs.showPopupMyMusic(popup,$(this));
        })
        $('.myplaylist .mp-nav-tool a.delete').bind('click', function(){
            var id = $(this).attr('rel');
            var a = $('.myplaylist li#albumlist-'+id);
            a.addClass('active');
            NhacVnCoreJs.whereMe = $(this).attr('data-type');
            var s = $(this).closest( ".mp-nav-tool" );
            NhacVnCoreJs.AddPopupMyMusic('Xóa playlist');
            s.addClass('show');
            var url = '/xhrUser/deleteMyPlaylist';
            NhacVnCoreJs.LoadPopupMyMusic(url,id);
            var popup = $('#popuppro-box');
            NhacVnCoreJs.showPopupMyMusic(popup,$(this));
        })
        $('.myplaylist .mp-nav-tool a.delete-album').bind('click', function(){
            var id = $(this).attr('rel');
            var a = $('.myplaylist li#albumlist-'+id);
            a.addClass('active');
            NhacVnCoreJs.whereMe = $(this).attr('data-type');
            var s = $(this).closest( ".mp-nav-tool" );
            NhacVnCoreJs.AddPopupMyMusic('Xóa playlist');
            s.addClass('show');
            var url = '/xhrUser/deleteAlbum';
            NhacVnCoreJs.LoadPopupMyMusic(url,id);
            var popup = $('#popuppro-box');
            NhacVnCoreJs.showPopupMyMusic(popup,$(this));
        })
    },
    AddPopupMyMusic: function(title)
    {
        $('#popuppro-box').remove();
        var html = '<div id="popuppro-box" class="hide">'+
                        '<div class="wrr-popuppro">'+
                            '<h3>'+title+'</h3>'+
                        '<div class="popuppro-content"></div>'+
                        '<span class="uarr"></span>'+
                        '<span class="darr"></span>'+
                        '</div>'+
                    '</div>';
        $("body").append(html);
        if(NhacVnCoreJs.whereMe=='user-page' || NhacVnCoreJs.whereMe=='user-page-pager'){
            $('#popuppro-box').css({'position':'absolute'});
        }
    },
    LoadPopupMyMusic: function(url,id)
    {
        $.ajax({
            url: url,
            data:{id:id},
            type:'get',
            dataType:'json',
            beforeSend: function()
            {
            },
            success: function(data){
                if(data.errorCode==1) {
                    $('#popuppro-box .popuppro-content').html(data.html);
                }
            }
        })
    },
    submitEditMyPlaylist: function()
    {
        var a = $("#popuppro-box");
        var data = a.find('#edit-playlist-form').serialize();
        $.ajax({
            url: '/xhrUser/editMyPlaylist',
            type:'post',
            dataType:'json',
            data: {post:data},
            beforeSend: function()
            {
                //$('#popuppro-box .popuppro-content').html('<img width="28" src="/web/images/content_loading.gif" />');
            },
            success: function(data){
                if(data.errorCode==1) {
                    $('#popuppro-box .popuppro-content').html(data.html);
                }else if(data.errorCode==0){
                    //success
                    NhacVnCoreJs.addNotify('Sửa tên playlist thành công.');
                    var d = data.playlist_id;
                    $('.myplaylist ul.box_items_list li#albumlist-'+d+' h3 a').html(data.playlist_name);
                    NhacVnCoreJs.closePopupMyMusic(a);
                }
            }
        })
    },
    submitDeleteMyPlaylist: function()
    {
        var a = $("#popuppro-box");
        var data = a.find('#delete-playlist-form').serialize();
        $.ajax({
            url: '/xhrUser/deleteMyPlaylist',
            type:'post',
            dataType:'json',
            data: {post:data},
            beforeSend: function()
            {
                //$('#f-c-pl').html('<img width="16" src="/web/images/ajax-loader.gif" />');
            },
            success: function(data){
                if(data.errorCode==1) {
                    $('#popuppro-box .popuppro-content').html(data.html);
                }else if(data.errorCode==0){
                    //success
                    if(NhacVnCoreJs.userId==NhacVnCoreJs.userPage && NhacVnCoreJs.userId!=0) {
                        if(NhacVnCoreJs.whereMe=='user-page'){
                            load_data_mymusic(NhacVnCoreJs.userId, 8, 'user-page');
                        }else if(NhacVnCoreJs.whereMe=='user-page-pager'){
                            load_data_mymusic(NhacVnCoreJs.userId, 32, 'user-page-pager');
                        }

                    }

                    NhacVnCoreJs.addNotify('Xóa playlist thành công.');
                    var d = data.playlist_id;
                    $('.myplaylist ul.box_items_list li#albumlist-'+d).animate("slow").remove();
                    NhacVnCoreJs.closePopupMyMusic(a);
                }
            }
        })
    },
    submitDeleteAlbumFa: function(){
        var a = $("#popuppro-box");
        var data = a.find('#delete-playlist-form').serialize();
        $.ajax({
            url: '/xhrUser/deleteAlbum',
            data: {post:data},
            type: 'post',
            dataType:'json',
            beforeSend: function(){
                //$("#box_load").show();
            },
            success: function(data){
                if(data.errorCode==1) {
                    $('#popuppro-box .popuppro-content').html(data.html);
                }else if(data.errorCode==0){
                    //success
                    if(NhacVnCoreJs.userId==NhacVnCoreJs.userPage && NhacVnCoreJs.userId!=0) {
                        if(NhacVnCoreJs.whereMe=='user-page'){
                            load_data_mymusic(NhacVnCoreJs.userId, 8, 'user-page');
                        }else if(NhacVnCoreJs.whereMe=='user-page-pager'){
                            load_data_mymusic(NhacVnCoreJs.userId, 32, 'user-page-pager');
                        }

                    }
                    NhacVnCoreJs.addNotify('Xóa Album thành công.');
                    var d = data.playlist_id;
                    $('.myplaylist ul.box_items_list li#albumlist-'+d).remove();
                    NhacVnCoreJs.closePopupMyMusic(a);
                }
            }
        })
    },
    showPopupMyMusic: function(a,b)
    {
        var c = $(b).offset();
        var a = $("#popuppro-box");
        var hp = 205;//height popup
        c.top += $(b).height() + 8;
        c.left += $(b).width() / 2;
        c.left = c.left-162;
        c.top = c.top+10;
        c.left = c.left-100;
        var right = c.right;
        var wheight = $(window).height();

        var hcroll = $(window).scrollTop();
        var hetop = $(b).offset().top-hcroll;
        var hebottom = wheight-hetop;

        var eTop = $(b).offset().top; //get the offset top of the element
        if(NhacVnCoreJs.whereMe==''){
            c.top = eTop-$(window).scrollTop()+35;
        }

        if(hebottom<hp){
            c.top = c.top-hp-50;
            a.find(".darr").addClass('show');
            a.find(".uarr").removeClass('show');
        }else{
            a.find(".darr").removeClass('show');
            a.find(".uarr").addClass('show');
        }
        //right = 60;
        a.removeClass("hide").css("top", c.top).css("left", c.left).css("display", "block");
        this.showOverlay();
        $("#overlay_ts").bind('click', function(){
            NhacVnCoreJs.closePopupMyMusic(a);
        })
    },
    focusInput: function(a)
    {
        a.focus();
    },
    closePopupMyMusic: function(a)
    {
        $('.myplaylist ul.box_items_list li').removeClass('active');
        $('.myplaylist ul.box_items_list li').find('.mp-nav-tool').removeClass('show');
        NhacVnCoreJs.hideOverlay();
        a.remove();
    },
    addNotify: function(msg)
    {
        $.notify.addStyle('nhacvn', {
            html: '<div class="notifyjs-corner">'+
                    '<div class="notifyjs-wrapper notifyjs-hidable">'+
                    '<div class="notifyjs-arrow"></div>'+
                    '<span class="notifyjs-close"></span>'+
                    '<div class="notifyjs-container"><div class="notifyjs-bootstrap-base notifyjs-bootstrap-success">'+
                    '<span data-notify-text=""></span>'+
                '</div></div>'+
                '</div></div>',
            /*classes: {
                base: {
                    "white-space": "nowrap",
                    "background-color": "lightblue",
                    "padding": "5px"
                },
                superblue: {
                    "color": "white",
                    "background-color": "blue"
                }
            }*/
        });
        $.notify(msg, {
            style: 'nhacvn',
            className: 'success',
            globalPosition: 'bottom left',
            autoHide: true,
            clickToHide: true,
            showDuration: 300,
        });
    }
}
$(document).ready(function() {
    $('.ads-item a').attr('target','_blank');
    Popup.init();
	var userId = $("#user_id").text();

    /* AJAX LINK POPUP */
    $('a.has-ajax-pop').bind('click',function(){
    	userId = $("#user_id").text();
    	var link = $(this).attr("rel");
    	if($(this).hasClass("reqlogin") && userId == 0){
    		//link = popup_login_url;
            addDialoglogin_form_dialog();
            jQuery('#login_form_dialog').dialog('open');
            return false;
    	}

    	open_popup(link);
        return false;
    })
    /* END AJAX LINK*/

    /*Begin Load liked song*/
    if($(".more_action").length){
    	load_like_song();
    }
    /*End Load liked song*/

    /*Begin Load banner*/
    if($(".banner_holder").length) {
        var data_loadbanner = {'action': 'getListBanner'};
        var beforesend_loadbanner = function () {
            $('.banner').each(function () {
                $(this).addClass('loading')
            })
        }
        var success_loadbanner = function (html) {
            $.each(html, function (key, value) {
                if ($('#banner_' + html[key].position).length > 0) {
                    $('#banner_' + html[key].position).removeClass('loading')
                    $('#banner_' + html[key].position).append(html[key].content);
                }
            });
        }
        ajax_load(ajax_url, data_loadbanner, beforesend_loadbanner, success_loadbanner);
    }
    /*End Load banner*/
    function xhr_load(url,result,method){
        $.ajax({
            url: url,
            type: method,
            beforeSend: function(){
                $('#'+result).prepend('<div class=\"ovelay-loading-face\">'+ajax_loading_content+'</div>');
            },
            success: function(data){
                $('#'+result).html(data);
            }
        })
    }
    $('#load_ajax .ajax_load li a').bind('click',function(){
        var rel = $(this).attr('rel');
        xhr_load(rel,'user_board','GET');
    })
})

/*Begin Like bai hat*/
$(".like_song").bind("click",function(){
	userId = $("#user_id").text();
	if(userId == 0){
		//open_popup(popup_login_url);
        addDialoglogin_form_dialog();
        jQuery('#login_form_dialog').dialog('open');
        return false;
	}

	var self = this;
	var song_id = $(this).attr("id");
	song_id = song_id.replace("song-","");
	//var before_like = false;
	var before_like = function(){
        $(self).html('<i><img class="loading" width="16" src="/web/images/ajax-loader.gif" /></i>');
    }
	var success_like = function(data){
        if(data=='liked'){
            $(self).html('<i class="icon icon_liked"></i>');
            $(self).attr('title',__t("DisLike"));
        }else if(data=='disliked'){
            $(self).html('<i class="icon icon_like"></i>');
            $(self).attr('title',__t("Like"));
        }
	}

	ajax_load(ajax_url,{'action':'like_unlike_song','id':song_id}, before_like,success_like);

})
/*like box*/
$(".ilike").bind("click", function(){
    userId = $("#user_id").text();
    if(userId == 0){
        //open_popup(popup_login_url);
        addDialoglogin_form_dialog();
        jQuery('#login_form_dialog').dialog('open');
        return false;
    }

    var content_type = $(this).attr("rel");
    var id = $(this).attr("id")
    var before_like = function(){
        $(".ilike span").html('<i><img width="16" src="/web/images/ajax-loader.gif" /></i>');
    }
    var success_like = function(data){
        var numberlike = $(".ilike-box-count").find(".pluginCountTextConnected div");
        var curr_number_liked = parseInt(numberlike.html());
        if(data=='liked'){
            numberlike.html(curr_number_liked+1);
            $(".ilike span").html(__t("DisLike"));
        }else if(data=='disliked'){
            numberlike.html(curr_number_liked-1);
            $(".ilike span").html(__t("Like"));
        }
    }
    ajax_load(ajax_url,{'action':'like_unlike_'+content_type,'id':id}, before_like,success_like);
})
/*End like bai hat*/
/*like box*/
$(".ilike-artist").bind("click", function(){
    userId = $("#user_id").text();
    if(userId == 0){
        //open_popup(popup_login_url);
        addDialoglogin_form_dialog();
        jQuery('#login_form_dialog').dialog('open');
        return false;
    }

    var content_type = $(this).attr("rel");
    var id = $(this).attr("id")
    var before_like = function(){
        $(".ilike-artist span").html('<i><img width="16" src="/web/images/ajax-loader.gif" /></i>');
    }
    var success_like = function(data){
        var numberlike = $(".like-artist .ilike-box-count").find(".pluginCountTextConnected");
        var curr_number_liked = parseInt(numberlike.html());
        if(data=='liked'){
            numberlike.html(curr_number_liked+1);
            $(".ilike-artist span").html(__t("Bỏ thích"));
        }else if(data=='disliked'){
            numberlike.html(curr_number_liked-1);
            $(".ilike-artist span").html(__t("Thích"));
        }
    }
    ajax_load(ajax_url,{'action':'like_unlike_'+content_type,'id':id}, before_like,success_like);
})
/*End like bai hat*/

/*Begin Nghe radio*/
$(".listen_radio").bind("click",function(){
	alert(__t('Chức năng đang trong quá trình xây dựng'));
})
/*End Nghe radio*/

var load_like_song = function()
{
	var userId = $("#user_id").text();
	if(userId && userId!=0){
		var songList = [];
		$( ".content_song_id" ).each(function (i) {
			var songId = $(this).text();
			songList.push(songId);
		})

		var data_loadlike = {'action':'loadLikeSong','user_id':userId, '_data':songList};
		var beforesend_loadlike = false;
		var success_loadlike = function(html){
            $(".more_action a.like_song").each(function(i){
                var songIdStr = $(this).attr("id");
                var id = songIdStr.replace('song-','');
                if(in_array_item(html,id)){
                    $(".more_action a#song-"+id).html('<i class="icon icon_liked"></i>');
                    $(".more_action a#song-"+id).attr('title',__t('DisLike'));
                }
            })
		}
		ajax_load(ajax_url,data_loadlike, beforesend_loadlike, success_loadlike);
	}

}

/*Begin Like artist*/
$(".like_artist").bind("click",function(){
    userId = $("#user_id").text();
    if(userId == 0){
        //open_popup(popup_login_url);
        addDialoglogin_form_dialog();
        jQuery('#login_form_dialog').dialog('open');
        return false;
    }

    var self = this;
    var artist_id = $(this).attr("id");
    artist_id = artist_id.replace("artist-","");
    var action = "like";
    if($(this).hasClass("liked")){
            action = "unlike";
    }
    var before_like = false;
    var success_like = function(html){
            $(self).removeClass("liked");
            $(self).addClass(action+"d");
            if(html=='liked'){
                $(self).find("span").html(__t('DisLike'));
            }else{
                $(self).find("span").html(__t('Like'));
            }
            if($(".icon_artist_like")){
                $(".icon_artist_like").removeClass("liked");
                $(".icon_artist_like").addClass(action + "d");
            }
    }

    ajax_load(ajax_url,{'action':'like_unlike_artist','type':action,'artist_id':artist_id}, before_like,success_like);
})
/*End Like artist*/

/*Submit search form*/
$("#submit-search").bind("click",function(){
	if($("#keyword").val()!=""){
		$(this).parent('form').get(0).submit();
	}else{
		$("#keyword").focus();
	}
	return false;

})
/*End Submit search form*/

var open_popup = function(url){
	jQuery.ajax({
        'onclick':'$("#dialog").dialog("option", "position", "center").dialog("open"); return false;',
        'url':url,
        'type':'GET',
        'cache':false,
        'beforeSend':function(){
        	overlay_show();
        },
        'success':function(html){
            jQuery('#dialog').html(html);
            overlay_hide();
        },
        'complete':function(){
        	overlay_hide();
        }
    });
}

var overlay_show = function(){
    //$("#overlay").show();
    $("#box_load").show();
};
var overlay_hide = function(){
    //$("#overlay").hide();
    $("#box_load").hide();
};

var login_success = function(userid,username)
{
	var curent_page = $("#page_id").text();

	//if(curent_page=='user_register' || curent_page=='user_active' || curent_page=='user_forgotpass'){
		//window.location.href = '/';
        //location.reload();
	//}
	var avatar = avatarObject("user",userid);

    var html = '<div class="fll"><ul class="main_nav user-nav">';
    html +='<li class="user_avatar"><img class="u-thumb" width="35" width="35" src="'+avatar+'" alt="'+username+'"/></li>';
    html +='<li  class="user_phone"><a href="javascript:;" class="fll username">'+username+'<i class="icon icon_mt"></i></a>';
    html +='<ul class="sub_nav"><li><a href="/user/logout.html">'+__t('Logout')+'</a></li></ul></li></ul>';
    html +='</div>';
	$("#user-menu-box").html(html);
}

function submitDelete(el, url, container)
{
   /* if(confirm(__t("Bạn có chắc chắn muốn xóa đối tượng này không?")) ){
    	 $.ajax({
             url : url,
             dataType: 'json',
             success : function(_data) {
             	if(_data == 0) {
             		 $("#"+container).css('display', 'none');
                 }
             }
         });
    }else{
            el.value = '';
    }*/
	_confirm(__t("Bạn có chắc chắn muốn xóa đối tượng này không?"),url,container)
}

function deleteObject(url, container){
	 $.ajax({
         url : url,
         dataType: 'json',
         success : function(_data) {
         	if(_data == 0) {
         		 $("#"+container).css('display', 'none');
         		$("#dialog").dialog("close");
             }
         }
     });
	 $("#dialog").dialog("close");
}

function _confirm(_msg,url,container) {
	_msg = "<div class='msg-content'  style='text-align: center; margin: 10px 0px;'>"
	+_msg+"</div><br />"
	+"<div class='btn' style='text-align: center; margin: 5px 0px;'>"
	+"<input type='button'  value='Confirm' class='button-sub' onclick=\"deleteObject('"+url+"','"+container+"')\">"
	+"<input type='button'  value='Cancel' class='close-popup' onclick='$(\"#dialog\").dialog(\"close\");'>"
	+"</div>";
    $('#dialog').html(_msg);
    $('#dialog').dialog({
        dialogClass : 'dialog-box',
        width : 380,
        height : 86,
        resizable : false,
        modal : true,
        zIndex : 999
    },'title','Thông báo');
}

var open_popup_raw = function(url,params){
    jQuery.ajax({
        'onclick':'$("#dialog").dialog("option", "position", "center").dialog("open"); return false;',
        'url':url,
        'data':params,
        'type':'GET',
        'cache':false,
        'beforeSend':function(){
            //overlay_show();
            $("#box_load").show();
        },
        'success':function(html){
            jQuery('#dialog').html(html);
            $("#box_load").hide();
            //overlay_hide();
        },
        'complete':function(){
            //overlay_hide();
        }
    });
}
/*DISPLAY POPUP - BEGIN*/
//window.displayPop = function(action,params){
function displayPop(action,params){
  $("#dialog").dialog({
      autoOpen: false,
      hide: 'fold',
      show: 'blind',
      open: function(event,ui){
          $('.ui-dialog').css('z-index',9999);
      }
  });

  xhr = jQuery.ajax({
      'onclick':'$("#dialog").dialog("open"); return false;',
      'url':action,
      'data':params,
      'type':'GET',
      'cache':false,
      'beforeSend':function(){
    	  overlay_show();
      },
      'success':function(html){
          jQuery('#dialog').html(html);
          overlay_hide();
      },
      'complete':function(){
    	  //overlay_hide();
      }
  });
  return false;
}
window.overlayShow = function(){
	$('#overlay').fadeIn('fast',function(){
		$('#box').show();
	});
};
window.overlayHide = function(){
		$('#box').hide();
		$('#overlay').fadeOut('fast');

	if(xhr)	xhr.abort();
};
$("#stop").bind('click', function() {
	overlayHide();
});

$(".download-song-pr").bind('click', function() {
	$("#dialog").dialog("close");
});

function loadLyrics(songId) {

    /*GET song lyric*/
    var before_song_lyric = false;
    var success_song_lyric = function(html){
        if(html!=""){
            $(".box_lyric").html(html);
            if($("#lyric_box").height() > 198){
                $("#lyric_box").height("198px");
                $("#lyric_more").show();
            }else{
                $("#lyric_more").hide();
            }
        }
    }
    ajax_load(ajax_url,{'action':'songLyric','song_id':songId}, before_song_lyric,success_song_lyric);
}
$(function(){
    $('select').bind('change', function(){
        if ($(this).children('option:first-child').is(':selected')) {
            $(this).addClass('placeholder');
        } else {
            $(this).removeClass('placeholder');
        }
    })
});
$(document).ready(function() {
    $('.main_nav li').hover(function(){
        var timer = $(this).data('timer');
        if(timer) clearTimeout(timer);
        $(this).addClass('over');
    }, function(){
        var li = $(this);
        li.data('timer', setTimeout(function(){ li.removeClass('over'); }, 100));
    });
});
function LoadAjaxContent(link,id){
    $.ajax({
        url: link,
        type: 'GET',
        beforeSend: function(){
            $('#'+id).prepend('<div class=\"ovelay-loading-face\">'+ajax_loading_content+'</div>');
        },
        success: function(data){
            $('#'+id).html(data);
        }
    })
}
$(function(){
    $('#chart_song .ajax_load li a').bind('click',function(){
        var genre = $(this).attr('rel');
        LoadSongRank(genre);
    })
    $('#chart_album .ajax_load li a').bind('click',function(){
        var genre = $(this).attr('rel');
        LoadAlbumRank(genre);
    })
    $('#chart_video .ajax_load li a').bind('click',function(){
        var genre = $(this).attr('rel');
        LoadVideoRank(genre);
    });
    //add to playlist
    function closeDialogAddSong(id)
    {
        $('#overlay_ts').remove();
        $('#song_'+id+' .addsong-dialog').remove();
        $('#song_'+id+' .more_action').removeAttr('style');
        $('.jspContainer').css({'overflow':'hidden'});
        $('#playlist').css({'overflow':'hidden'});
    }
    NhacVnCoreJs.init();
    NhacVnCoreJs.initMyMusic();
})
