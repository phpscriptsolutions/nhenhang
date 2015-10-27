(function($){
//	$.fn.ajax_load = function(url, data, beforesend, success){
//    	jQuery.ajax({
//            'url':url,
//            'type':'POST',
//            'data':data,
//            'cache':false,
//            'beforeSend':function(){
//            	beforesend && beforesend();
//            },
//            'complete':function(){
//            },
//            'success':function(html){
//            	success && success(html);
//            }
//        });
//	};

})(jQuery);
function LoadSongRank(genre){
    $.ajax({
        url: '/ajax',
        type: 'GET',
        data: {action:'chart', _type:'song',genre:genre},
        beforeSend: function(){
            $('#chart_song').prepend('<div class=\"ovelay-loading-face\">'+ajax_loading_content+'</div>');
        },
        success: function(data){
            $('#chart_song').html(data);
        }
    })
}
function LoadAlbumRank(genre){
    $.ajax({
        url: '/ajax',
        type: 'GET',
        data: {action:'chart', _type:'album',genre:genre},
        beforeSend: function(){
            $('#chart_album').prepend('<div class=\"ovelay-loading-face\">'+ajax_loading_content+'</div>');
        },
        success: function(data){
            $('#chart_album').html(data);
        }
    })
}
function LoadVideoRank(genre){
    $.ajax({
        url: '/ajax',
        type: 'GET',
        data: {action:'chart', _type:'video',genre:genre},
        beforeSend: function(){
            $('#chart_video').prepend('<div class=\"ovelay-loading-face\">'+ajax_loading_content+'</div>');
        },
        success: function(data){
            $('#chart_video').html(data);
        }
    })
}
var ajax_load = function(url, data, beforesend, success){
    	jQuery.ajax({
            'url':url,
            'type':'POST',
            'data':data,
            'cache':false,
            'beforeSend':function(){
            	beforesend && beforesend();
            },
            'complete':function(){
            },
            'success':function(html){
            	success && success(html);
            }
        });
	};
var reloadAddScroll = function(board){
    if(board==undefined){
        board = 'user-profile';
    }
    var h= $(window).height();
    var h_u = $("#"+board).height()+50;
    console.log('h_u:'+h_u+'|h:'+h);
    if(h_u>h){
        console.log('re add scroll');
        $("#"+board).css({
            //"overflow":"auto",
            "height":h
        })
        $('#'+board).jScrollPane();
    }
}
var addScroll = function(board){
    if(board==undefined){
        board = 'user-profile';
    }
    var h= $(window).height();
    var h_u = $("#"+board).height();
    if(h_u>h){
        $("#"+board).css({
            //"overflow":"auto",
            "height":h
        })
        $('#'+board).jScrollPane();
    }
    /*else{
        $("#"+board).css({
            "overflow":"none",
            "height":"auto"
        })
    }*/
    loadMoreScroll(board);
}
var loadMoreScroll = function(board){
    //var wscroll = $("#"+board).scrollTop();
    var page_load = $("#"+board+" .load_page_auto").val();
    var type = $("#"+board+" .load_page_auto").attr("id");
    var loading = false;

    if(page_load) {
        $("#" + board).scroll(function () {
            var wscroll = $("#" + board).scrollTop();
            var wh = $("#" + board).height();
            var doch = $("#" + board).height();
            var hOfScroll = $("#" + board)[0].scrollHeight;
            /*console.log('wscroll:' + wscroll);
            console.log('wh:' + wh);
            console.log('doch:' + doch);
            console.log('hOfScroll:' + hOfScroll);
            console.log('----------------');*/
            //if (wscroll >= doch-range && loading==false) {
            if ((wscroll + doch) == hOfScroll && loading==false) {
                loading = true;
                console.log('loading');
                $('.animation_image').show();
                setTimeout(function(){
                    $.post('/xhrUser/loadMore',{'page': page_load,'type':type}, function(data){
                        if(data){
                            $("#"+board+" .box_content ul.box_items_list").append(data);
                            $('#'+board).jScrollPane();
                            page_load++;
                            $("#"+board+" .load_page_auto").attr('value',page_load);
                            loading = false;
                        }else{
                            loading = true;
                        }
                        //hide loading image
                        $('.animation_image').hide(); //hide loading image once data is received
                    }).fail(function(xhr, ajaxOptions, thrownError) { //any errors?

                        alert(thrownError); //alert with HTTP error
                        $('.animation_image').hide(); //hide loading image
                        loading = false;

                    });
                },300)

            }
        })
    }
}
var sendSubmit = function(url,data,beforesend, success,datatype) {
    if(datatype=='undefined'){
        datatype = 'html';
    }
    $.ajax({
        'url': url,
        'data':{data:data},
        'type': 'POST',
        'dataType':datatype,
        'cache':false,
        'beforeSend':function(){
            beforesend && beforesend();
        },
        'success':function(data){
            success && success(data);
        }
    });
}
var make_friend_url = function(str){
	if(str && str!=""){
		str= str.toLowerCase();
	    str= str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g,"a");
	    str= str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g,"e");
	    str= str.replace(/ì|í|ị|ỉ|ĩ/g,"i");
	    str= str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g,"o");
	    str= str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g,"u");
	    str= str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g,"y");
	    str= str.replace(/đ/g,"d");
        str= str.replace("(","");
        str= str.replace(")","");
        str= str.replace("&","");
	    //        str= str.replace(/ |#|&|\(|\)|\?|{|}|\[|]|!|@|%|\$|\^|\*|\+/g,"-");
	    str= str.replace(/\W/g,"-");
        str= str.replace("---","-");
        str= str.replace("--","-");
        str= str.replace("--","-");
	}

    return str;
}


var in_array = function (array, val) {
    for(var i=0;i<array.length;i++) {
        if(array[i].id === val) {
            return true;
        }
    }
    return false;
}
var in_array_item = function (array, val) {
    for(var i=0;i<array.length;i++) {
        if(array[i] == val) {
            return true;
        }
    }
    return false;
}

var substr = function (str, start, len) {
  // Returns part of a string
  //
  // version: 909.322
  // discuss at: http://phpjs.org/functions/substr
  // +     original by: Martijn Wieringa
  // +     bugfixed by: T.Wild
  // +      tweaked by: Onno Marsman
  // +      revised by: Theriault
  // +      improved by: Brett Zamir (http://brett-zamir.me)
  // %    note 1: Handles rare Unicode characters if 'unicode.semantics' ini (PHP6) is set to 'on'
  // *       example 1: substr('abcdef', 0, -1);
  // *       returns 1: 'abcde'
  // *       example 2: substr(2, 0, -6);
  // *       returns 2: false
  // *       example 3: ini_set('unicode.semantics',  'on');
  // *       example 3: substr('a\uD801\uDC00', 0, -1);
  // *       returns 3: 'a'
  // *       example 4: ini_set('unicode.semantics',  'on');
  // *       example 4: substr('a\uD801\uDC00', 0, 2);
  // *       returns 4: 'a\uD801\uDC00'
  // *       example 5: ini_set('unicode.semantics',  'on');
  // *       example 5: substr('a\uD801\uDC00', -1, 1);
  // *       returns 5: '\uD801\uDC00'
  // *       example 6: ini_set('unicode.semantics',  'on');
  // *       example 6: substr('a\uD801\uDC00z\uD801\uDC00', -3, 2);
  // *       returns 6: '\uD801\uDC00z'
  // *       example 7: ini_set('unicode.semantics',  'on');
  // *       example 7: substr('a\uD801\uDC00z\uD801\uDC00', -3, -1)
  // *       returns 7: '\uD801\uDC00z'
  // Add: (?) Use unicode.runtime_encoding (e.g., with string wrapped in "binary" or "Binary" class) to
  // allow access of binary (see file_get_contents()) by: charCodeAt(x) & 0xFF (see https://developer.mozilla.org/En/Using_XMLHttpRequest ) or require conversion first?
  var i = 0,
    allBMP = true,
    es = 0,
    el = 0,
    se = 0,
    ret = '';
  str += '';
  var end = str.length;

  // BEGIN REDUNDANT
  this.php_js = this.php_js || {};
  this.php_js.ini = this.php_js.ini || {};
  // END REDUNDANT
  switch ((this.php_js.ini['unicode.semantics'] && this.php_js.ini['unicode.semantics'].local_value.toLowerCase())) {
  case 'on':
    // Full-blown Unicode including non-Basic-Multilingual-Plane characters
    // strlen()
    for (i = 0; i < str.length; i++) {
      if (/[\uD800-\uDBFF]/.test(str.charAt(i)) && /[\uDC00-\uDFFF]/.test(str.charAt(i + 1))) {
        allBMP = false;
        break;
      }
    }

    if (!allBMP) {
      if (start < 0) {
        for (i = end - 1, es = (start += end); i >= es; i--) {
          if (/[\uDC00-\uDFFF]/.test(str.charAt(i)) && /[\uD800-\uDBFF]/.test(str.charAt(i - 1))) {
            start--;
            es--;
          }
        }
      } else {
        var surrogatePairs = /[\uD800-\uDBFF][\uDC00-\uDFFF]/g;
        while ((surrogatePairs.exec(str)) != null) {
          var li = surrogatePairs.lastIndex;
          if (li - 2 < start) {
            start++;
          } else {
            break;
          }
        }
      }

      if (start >= end || start < 0) {
        return false;
      }
      if (len < 0) {
        for (i = end - 1, el = (end += len); i >= el; i--) {
          if (/[\uDC00-\uDFFF]/.test(str.charAt(i)) && /[\uD800-\uDBFF]/.test(str.charAt(i - 1))) {
            end--;
            el--;
          }
        }
        if (start > end) {
          return false;
        }
        return str.slice(start, end);
      } else {
        se = start + len;
        for (i = start; i < se; i++) {
          ret += str.charAt(i);
          if (/[\uD800-\uDBFF]/.test(str.charAt(i)) && /[\uDC00-\uDFFF]/.test(str.charAt(i + 1))) {
            se++; // Go one further, since one of the "characters" is part of a surrogate pair
          }
        }
        return ret;
      }
      break;
    }
    // Fall-through
  case 'off':
    // assumes there are no non-BMP characters;
    //    if there may be such characters, then it is best to turn it on (critical in true XHTML/XML)
  default:
    if (start < 0) {
      start += end;
    }
    end = typeof len === 'undefined' ? end : (len < 0 ? len + end : len + start);
    // PHP returns false if start does not fall within the string.
    // PHP returns false if the calculated end comes before the calculated start.
    // PHP returns an empty string if start and end are the same.
    // Otherwise, PHP returns the portion of the string from start to end.
    return start >= str.length || start < 0 || start > end ? !1 : str.slice(start, end);
  }
  return undefined; // Please Netbeans
}

//validate email address
function validateEmail(email) {
    var reg =/^([A-Za-z0-9])+([A-Za-z0-9_\-\.])*\@([A-Za-z0-9_\-])+(\.([A-Za-z0-9_\-])+)*\.([A-Za-z]{2,4})$/;
    return reg.test(email);
}


// validate phone number
function validateVinaPhone(phone_number) {
    if(isNaN(phone_number)) {
        return false;
    } else {
        //var pattern = /^(091|094|0123|0125|0127|0129|0124|0164)([0-9]{7})$/;
        //return pattern.test(phone_number);
    	
    	var pattern1 = /^(060|066|067|068|090|031|097)([0-9]{7})$/;
        var pattern2 = /^(02346|02446|04246|07246|07346|04346|07546|07446|04446|03446|02546|03346|03546|03646|03246|06346|06246|06546|06446|05346|05446|02646|05546|05246)([0-9]{5})$/;
        return (pattern1.test(phone_number) || pattern2.test(phone_number));
    }
}

function validatePhone(phone_number) {
    if(isNaN(phone_number)) {
        return false;
    } else {
    	var prefix = phone_number.substr(0,3);
    	if(prefix='855' && phone_number.length >= 11){
    		phone_number = phone_number.replace("855",""); 
    	}
        var pattern1 = /^(060|066|067|068|090|031|097|088)([0-9]{7})$/;
        var pattern2 = /^(02346|02446|04246|07246|07346|04346|07546|07446|04446|03446|02546|03346|03546|03646|03246|06346|06246|06546|06446|05346|05446|02646|05546|05246)([0-9]{5})$/;
        return (pattern1.test(phone_number) || pattern2.test(phone_number));
    }
}

/*return phone have sufix 84*/
function formatPhone($phone){
    if($phone.substr(0,2) == '00'){
        $phone=$phone.substr(2);
    }else if($phone.substr(0,1) == '+'){
    	$phone=$phone.substr(1);
    }else if($phone.substr(0,1) == '0'){
        $phone='84'+substr($phone,1);
    }
    return $.trim($phone);
}

function removePrefixPhone($phone)
{
	if($phone.substr(0,3) == '855'){
		$phone = "0"+substr($phone,3);
	}else if($phone.substr(0,4) == '+855'){
        $phone = "0"+substr($phone,4);
    }else if($phone.substr(0,1) != '0'){
		$phone = "0"+$phone;
	}
	return $.trim($phone);
}


window.dump =  function(obj) {
    var out = '';
    for (var i in obj) {
    	if(typeof obj[i] =='object'){
    		out += i + ": \n" + dump(obj[i]) + "\n";
    	}else{
    		out += i + ": " + obj[i] + "\n";
    	}
    }

    return out;

}
window.dumpjs =  function(obj) {
	out = dump(obj);
	alert(out);

    // or, if you wanted to avoid alerts...

    var pre = document.createElement('pre');
    pre.innerHTML = out;
    document.body.appendChild(pre)
}
function validKeySearch(){
    var keyword = $("#keyword").val();
    var SCRIPT_REGEX = /<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/gi;
    match = SCRIPT_REGEX.test(keyword);
    if(match==true){
        alert('Từ khóa tìm kiếm không được chứa mã javascript');
        return false;
    }
    return true;
}
function OpenOptionsMenu(id){
    $('#op-'+id+' .options-dialog').toggleClass('open');
}