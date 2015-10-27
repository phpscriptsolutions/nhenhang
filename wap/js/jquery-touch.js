
jQuery.fn.center = function () {
    this.css("position","absolute");
    this.css("top", ( $(window).height() - this.height() ) / 2+$(window).scrollTop() + "px");
    this.css("left", ( $(window).width() - this.width() ) / 2+$(window).scrollLeft() + "px");
    return this;
}
            
function checkHtml5VideoSupport()
{
    if(!!document.createElement('video').canPlayType)
    {
        var vidTest=document.createElement("video");
        oggTest=vidTest.canPlayType('video/ogg; codecs="theora, vorbis"');
        if (!oggTest)
        {
            h264Test=vidTest.canPlayType('video/mp4; codecs="avc1.42E01E, mp4a.40.2"');
            if (!h264Test)
            {
                ///document.getElementById("checkVideoResult").innerHTML="Sorry. No video support."
                return false;
            }
            else
            {
                if (h264Test=="probably")
                {
                    ///document.getElementById("checkVideoResult").innerHTML="Yeah! Full support!";
                    return true;
                }
                else
                {
                    ///document.getElementById("checkVideoResult").innerHTML="Meh. Some support.";
                    return false;
                }
            }
        }
        else
        {
            if (oggTest=="probably")
            {
                ///document.getElementById("checkVideoResult").innerHTML="Yeah! Full support!";
                return true;
            }
            else
            {
                ///document.getElementById("checkVideoResult").innerHTML="Meh. Some support.";
                return false;
            }
        }
    }
    else
    {
        ///document.getElementById("checkVideoResult").innerHTML="Sorry. No video support."
        return false;
    }
}


$(document).ready(function(){
    // Keep the document scroll when change Paging
    var top = localStorage.getItem('top');
    var click_paging = localStorage.getItem('click_paging');
    if(top && click_paging){
        window.scrollTo(0, top);
        localStorage.removeItem('click_paging');
    }
    $(".yiiPager a").bind('click touch', function(e){
        localStorage.setItem('click_paging',1);
		localStorage.setItem('top',$(document).scrollTop());
    });
    
    
    // Ajax paging for /song, /video, /album page
    $(".ajax_paging .yiiPager a").live('click',function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        var page_ = getParameter(url,'page');
        var parentDiv = $(this).parent().parent().parent().parent('.ajax_paging');
        var parentWrapper = parentDiv.parent('.bl_item');
        var queryLink = parentDiv.attr('data-link');
        
        $.ajax({
            type: "GET",
            url: '/'+queryLink,
            context: document.body,
            data: {
                page: page_,
                ajax: 1
            },
            success: function(data){
                parentWrapper.empty();
                parentWrapper.append(data);
            },
            complete:function(){
            },
            statusCode: {
                404: function() {
                    console.log('page not found');
                }
            } 
        });
    });
});
function getParameter(url, paramName) {
  var searchString = url.replace('?','&'), i, val, params = searchString.split("&");

  for (i=0;i<params.length;i++) {
    val = params[i].split("=");
    if (val[0] == paramName) {
      return unescape(val[1]);
    }
  }
  return null;
}
        
/// mang luu tru downloadPrice, sendPrice cua bai hat moi album/playlist
arr_prices = new Array(60);
arr_charging = new Array(60);

function getDownloadPrice(id_,baseid_) {
    $("#downloadLink").attr('href','/song/view?id='+id_+'&download=1');
    $("#sendLink").attr('href','/song/sendoption?id='+id_+'');

    if(arr_prices[id_] != null)
    {
        data = arr_prices[id_] ;        
        var arr = data.split('++');
        $("#downloadPrice").html(arr[0]+' đ');
        $("#sendPrice").html(arr[1]+' đ');
    }
    else
        $.ajax({
            type: "GET",
            url: '/song/view',
            context: document.body,
            data: {
                id: id_, 
                baseid: baseid_,
                getPrice: 1
            },
            success: function(data){
                if(data.length > 20)
                    data = "0++0";
                var arr = data.split('++');
                $("#downloadPrice").html(arr[0]+' đ');
                $("#sendPrice").html(arr[1]+' đ');
                        
                arr_prices[id_] = arr[0]+'++'+arr[1];
            },
            complete:function(){                
            },
            statusCode: {
                404: function() {
                    alert('page not found');
                }
            } 
			  
        });
}




/**
 * show pop up tao playlist
 */
function popupPlaylist(fromSong) {
    if(fromSong != null){
        $("#createPlaylist #sId").val(fromSong);
    }
    _dialog("createPlaylist","Tạo Playlist mới", 270, 300);
}

/**
 * show pop up add Song to playlist
 */
function popupSong() {
    _dialog("addToPlaylist","Thêm vào Playlist", 240, 300);
}

/**
 * Comment
 */
function closeDialog(element) {
    $('#'+element).dialog('close');    
}
/**
 * post to Save playlist
 */
function createPlaylist() {
    var name_ = $("#createPlaylist #newplaylist-name").val();
    name_ = encodeURI(name_);
    
    var intro_ = $("#createPlaylist #newplaylist-intro").val();
    intro_ = encodeURI(intro_);
    
    var type_ = $("#createPlaylist #type").val();
    type_ = encodeURI(type_);
    
    $.ajax({
        type: "GET",
        url: '/playlist/create',
        context: document.body,
        data: {
            name: name_, 
            intro: intro_,
            sidebar: 1,
            type : type_
        },
        success: function(data){
            if(data.indexOf('success') >= 0){
                data = $.parseJSON(data);
                $("#messsage-crP").html(data['message']);
                $("#listPlaylist ul").append('<li><a href="'+data['link']+'">'+data['img']+'<p class="m0 fontB">'+decodeURI(data['name'])+'</p><p class="m0 ovh"><span class="fll cl6"><i class="icon_phone1 vg_icon">&nbsp;</i>0</span></p></a></li>');
                
                
                // them bai hat vao playlist vua tao
                var sId = $("#createPlaylist #sId").val();
                if(sId != ""){
                    $("#scrolls .box-inner").html('<div class="fll wid100"><input type="radio" value="'+data['id']+'" name="pId[]"><label class="for_radio">'+decodeURI(data['name'])+'</label></div>' + $("#scrolls .box-inner").html());
                    var input_ = $("#scrolls .box-inner div").first().find('input');
                    input_.attr('checked',true);
                    addToPlaylist(sId,data['id'],'ajax');
                }                
            }
            else if(data.indexOf('exist') >= 0){
                data = $.parseJSON(data);
                $("#messsage-crP").html(data['message']);
            }
            else if(data.indexOf('error') >= 0){
                data = $.parseJSON(data);
                $("#messsage-crP").html(data['message']);
            }            
        },
        complete:function(){                
        },
        statusCode: {
            404: function() {
                alert('page not found');
            }
        } 

    });
}


/**
 * post to add Song to playlist
 */
function addToPlaylist(sId, pId, type) {    
    var sId_ = (sId == null)? $("#addToPlaylist #sId").val(): sId;
    sId_ = encodeURI(sId_);
    var type_ = (type == null)? $("#addToPlaylist #type").val(): type;
    type_ = encodeURI(type_);
    
    if((pId == null)){
        var pId_ = '';
        pId_ = $("#scrolls input:checked").val();
        /*$("input:checked[name=pId[]]").each(function(){
            pId_ = $(this).val();        
        });*/
        pId_ = encodeURI(pId_); 
    }
    else
        pId_ = pId;
    
    $.ajax({
        type: "GET",
        url: '/playlist/addSong',
        context: document.body,
        data: {
            sId: sId_,
            pId : pId_,
            type : type_
        },
        success: function(data){
            if(data.indexOf('success') >= 0){
                data = $.parseJSON(data);
                $("#messsage-addToP").fadeOut(100).delay(100).fadeIn(100).html(data['message']);                
            }
            else if(data.indexOf('exist') >= 0){
                data = $.parseJSON(data);
                $("#messsage-addToP").fadeOut(100).delay(100).fadeIn(100).html(data['message']);
            }
            else if(data.indexOf('error') >= 0){
                data = $.parseJSON(data);
                $("#messsage-addToP").fadeOut(100).delay(100).fadeIn(100).html(data['message']);
            }
            
            if((pId != null)){
                setTimeout(function(){
                    closeDialog("createPlaylist");
                },2000);
            }
        },
        complete:function(){                
        },
        statusCode: {
            404: function() {
                alert('page not found');
            }
        } 

    });
}