var pathName = window.document.location.pathname;
//var pathArray = window.location.pathname.split( '/' );
//var rootPath = "/" + pathArray[1];

var killScroll = false;
var t = 1;
$(window).bind('scroll', function() {
    var nav_open = $('#nav-panel').hasClass('ui-panel-open');
    if (($(document).height() >= $(window).height()))
            //if (!nav_open)
            {
                //console.log(killScroll+"--"+(t++)+'--windowTop:'+$(window).scrollTop()+'--windowHeight:'+$(window).height()+'--documentHeight:'+$(document).height());
                var header = $(".wrr-header");
                docH = 0;//fix on desktop

                if (deviceOs == 'IOS' || deviceOs == 'ANDROIDOS') {
                    docH = header.height();
                    if (($(window).scrollTop() + ($(window).height() * 0.15) >= $(document).height() - $(window).height() - docH)) {
                        //var pageId = $.mobile.activePage.attr('id');
                        var pageId = "vg_wrapper";

                        if (killScroll == false) {
                            killScroll = true;

                            $('.load-more-page').show();
                            setTimeout(function() {
                            	VegaCoreJs.loadmore(pageId);
                                //add image default
                                $('.vg_contentBody').css('height', 'auto');
                                //fixImagesError();
                            }, 3);

                        }
                        return false;
                    }
                }
                else {
                    //console.log($(window).scrollTop() +"--"+ $(document).height() +"--"+ $(window).height() +"--"+ killScroll);

                    if ($(window).scrollTop() >= $(document).height() - $(window).height() - 150) {
                        //var pageId = $.mobile.activePage.attr('id');
                        var pageId = "vg_wrapper";
                        if (killScroll == false) {
                            killScroll = true;

                            $('.load-more-page').show();
                            setTimeout(function() {
                            	VegaCoreJs.loadmore(pageId);
                                $('.vg_contentBody').css('height', 'auto');
                                //add image default
                                //fixImagesError();
                            }, 3);

                        }
                        return false;
                    }
                }
            }
});


var toPhone;
var docharge = function(type, objId, ojbCode)
{
    url = urlCharg;
    $.ajax({
        type: "GET",
        url: url,
        data: {type: type, id: objId, code: ojbCode, toPhone: toPhone},
        async: false,
        beforeSend: function() {
        },
        success: function(data) {
        	retCharge = data;
        },
        complete: function() {
        },
        statusCode: {
            404: function() {
                retCharge = {errorCode:404,message:"Error connect to charging"};
            }
        }
    });
    return retCharge;
}

var downloadContent = function(contentId, contentCode, type, url)
{
	
    if (!userId) {
        alert(msgNotLogin);
        window.location.href =  rootPath + '/account/login?back=' + document.URL;
        return false;
    }
    toPhone=userPhone;
    action = type;
    ret = docharge(action, contentId, contentCode);
    /*if(type=='downloadSong' || type=='downloadVideo'){*/
	if(ret.errorCode==0){
		window.location.href = ret.url;
		//window.open(ret.url,'_blank');
		//location.reload();
	}else{
		alert(ret.message);
	}
    /*}else{
	    if (!ret) {
	        alert(msgErrorCharg);
	        return false;
	    }
	    window.location.href = urlDownload + '?type=' + type + '&id=' + contentId;
    }*/
    return false;
}

var sharethis = function(title, url) {
    windowOpenCenter("http://www.facebook.com/share.php?u=" + encodeURIComponent(url) + "&t=" + encodeURIComponent(title), 620, 440);
    return false;
}
var subscribe = function(redirectUrl)
{
    if (!userPhone) {
        alert(msgDetect);
        window.location.href = rootPath + '/account/login?back=' + document.URL;
        return false;
    }
    ret = docharge('subscribe', '', '');
    if (!ret) {
        alert(msgErrorCharg);
        return false;
    } else {
        window.location.href = redirectUrl;
    }
    return false;
}

var shareFacebook = function()
{
    u = location.href;
    t = document.title;
    windowOpenCenter("http://www.facebook.com/share.php?u=" + encodeURIComponent(u) + "&t=" + encodeURIComponent(t), 620, 440);
    return false;
}

var windowOpenCenter = function(url, w, h) {
    var left = (screen.width / 2) - (w / 2);
    var top = (screen.height / 2) - (h / 2);
    var targetWin = window.open(url, '', 'toolbar=no, location=no, directories=no, status=yes, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);
}


window.dump = function(obj) {
    var out = '';
    for (var i in obj) {
        if (typeof obj[i] == 'object') {
            out += i + ": \n" + dump(obj[i]) + "\n";
        } else {
            out += i + ": " + obj[i] + "\n";
        }
    }

    return out;

}

window.dumpjs = function(obj) {
    out = dump(obj);
    alert(out);

    // or, if you wanted to avoid alerts...

    var pre = document.createElement('pre');
    pre.innerHTML = out;
    document.body.appendChild(pre)
}

function in_array(array, val) {
    for (var i = 0; i < array.length; i++) {    	
        if (parseInt(array[i].id) === parseInt(val)) {
            return true;
        }
    }
    return false;
}
function formatSecondsAsTime(secs) {
    var hr = Math.floor(secs / 3600);
    var min = Math.floor((secs - (hr * 3600)) / 60);
    var sec = Math.floor(secs - (hr * 3600) - (min * 60));

    if (min < 10) {
        min = "0" + min;
    }
    if (sec < 10) {
        sec = "0" + sec;
    }

    return min + ':' + sec;
}

function checkInput()
{
    txtcontent = $('#txt-content').val();
    txtcontent = $.trim(txtcontent);
    if (txtcontent == '') {
        return false;
    }
    return true;
}
function fixImagesError() {
    var img = document.getElementsByTagName('img');
    var i = 0, l = img.length;
    for (; i < l; i++) {
        var t = img[i];
        if (t.naturalWidth === 0) {
            t.src = '/images/default.jpg';
        }
    }
}


function showRegister() {
    $('#Popup_Register').popup('open');
}

function register() {
    $.ajax({
        type: "GET",
        url: rootPath +"/account/subscribe",
        data: {
            'source': "POPUP"
        },
        async: false,
        dataType: "json",
        beforeSend: function() {
        },
        success: function(data) {
            $('#Popup_Register').popup('close');
            if (data.errorCode === '0') {
                window.location.href = rootPath + "/account/successpopup";
                return false;
//                alert("Bạn đã đăng ký thành công, Cảm ơn bạn đã sử dụng dịch vụ!");
            } else {
                alert("Đăng ký không thành công, vui lòng thử lại sau!");
            }
        },
        complete: function() {
        },
        statusCode: {
            404: function() {
                alert("Lỗi kết nối");
                return false;
            }
        }
    });
}