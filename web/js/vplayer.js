var canPlay = false;
var firstPlaySong = true;
var firstPlayAlbum = true;
var index = 0;
var listPlayed =Array();
var curentProfile = "";

var vplayer = function (cssSelector, contentObj)
{	

	var self = this;
	this.cssSelector = cssSelector;
	this.contentObj = contentObj;
	this.debug_mode = true;
	this.repeat = false;
	this.shuffle = false;
	if(typeof debug_mode != 'undefined' ){
		this.debug_mode = debug_mode;
	}

	if(typeof userPhone != 'undefined' ){
		this.user_phone = userPhone;
	}
	this.audio = document.getElementById(cssSelector);
	//this.audio.volume=0; // Only development mode
	this.progressHolder = document.getElementById("progress_box");

	$("#play").click(function() {
		self._play();
		return false;
	});

	$("#pause").click(function() {
		self._pause();
		return false;
	});
		
	/*Seek*/
	$("#progress_box").mouseup(function(e) {
		self._setPlayProgress(e.pageX);
    }, true);

	/*Repeat*/
	$("#bt-repeat").click(function(){
		self._setRepeat();
	});
	
	/*Shuffle*/
	$("#bt-shuffle").click(function(){
		self._setShuffle();
	});
	
	/*Change Quality*/
	var showProfile = false;
	$(".vp-quarity").click(function(event){
		event.stopPropagation();
		if(!showProfile){
			$(".vp-quarity ul").show();
			showProfile = true;
		}else{
			$(".vp-quarity ul").hide();
			showProfile = false;
		}
	});
	$('html').click(function() {
		$(".vp-quarity ul").hide();
		showProfile = false;
	});
	
	
	document.getElementById("hand_progress").addEventListener("mousedown", function() {
        document.onmousemove = function(e) {
        	self._setPlayProgress(e.pageX);
        };
        document.onmouseup = function() {
            document.onmousemove = null;
            document.onmouseup = null;
            self._trackPlayProgress();
        };
    }, true);	
	
	document.getElementById("hand_volume").addEventListener("mousedown", function() {
        document.onmousemove = function(e) {
        	self._setVolumeBar(e.pageX);
        };
        document.onmouseup = function() {
            document.onmousemove = null;
            document.onmouseup = null;
            self._trackVolumeBar();
        };
    }, true);
}
vplayer._getInstance = function() {
    if (!vplayer._instance)
    	vplayer._instance = new vplayer('audio',null);
    return vplayer._instance;
};

vplayer.prototype = {
	_play:function(){

	},
	_pause: function(){
		this.audio.pause();
		$('#play').css('display','block');
    	$('#pause').css('display','none');
	},
    _charging: function(action, contentId, contentCode){
    	return docharge(action, contentId, contentCode);
    	//return {errorCode:1,message:'Error'};
    },
    _trackPlayProgress: function(){
    	var time = this.audio.currentTime * 100 / this.audio.duration;
    	 $("#play_progress").css('width',time+'%');
    	 var hand  = (((this.audio.currentTime / this.audio.duration) * (this.progressHolder.offsetWidth - 2)) - 0) + "px";
    	 $("#hand_progress").css('left',hand);
		 $("#current_time_display").html(formatTime(this.audio.currentTime));
    },
    _setPlayProgress:function(clickX){		
        var newPercent = Math.max(0, Math.min(1, (clickX - findPosX(this.progressHolder)) / this.progressHolder.offsetWidth));
        this.audio.currentTime = newPercent * this.audio.duration;
        playProgressBar = newPercent * (this.progressHolder.offsetWidth - 2) + "px";
        $("#play_progress").css("width",playProgressBar);
        handControl = ((newPercent * (this.progressHolder.offsetWidth - 2)) - 0) + "px";
        $("#hand_progress").css('left',handControl);
        //updateTimeDisplay();
		
		$("#current_time_display").html(formatTime(this.audio.currentTime));
    },
	
    _trackVolumeBar: function(){
   
    },
    _setVolumeBar:function(clickX){
		vlHolder = document.getElementById("vp-volume-bar");
		
        var newPercent = Math.max(0, Math.min(1, (clickX - findPosX(vlHolder)) / vlHolder.offsetWidth));				        		
        this.audio.volume = newPercent ;	

        playProgressBar = newPercent * (vlHolder.offsetWidth - 2) + "px";		
        $("#vp-volume-bar-value").css("width",playProgressBar);
        handControl = ((newPercent * (vlHolder.offsetWidth - 2)) - 0) + "px";
        $("#hand_volume").css('left',handControl);
    },
	
	_setRepeat:function(){
		if(this.repeat == false){
			this.repeat = true;
			$("#bt-repeat").removeClass("repeat-off").addClass("repeat-on");
		}else{
			this.repeat = false;
			$("#bt-repeat").removeClass("repeat-on").addClass("repeat-off");
		}
	},
	_setShuffle:function(){
		if(this.shuffle == false){
			this.shuffle = true;
			$("#bt-shuffle").removeClass("shuffle-off").addClass("shuffle-on");
		}else{
			this.shuffle = false;
			$("#bt-shuffle").removeClass("shuffle-on").addClass("shuffle-off");
		}
	},
	_makeProfile: function(listProfiles){		
		var quarityHTML = "<ul>";
		var selected = "";
		var flag = false;
		for (var profile in listProfiles) {
			quarityHTML += "<li>";
			if(profile!="" && profile == curentProfile){
				quarityHTML += "<a class=\"change_quarity selected\" rel='"+profile+"'>";
			}else{
				quarityHTML += "<a class=\"change_quarity\" rel='"+profile+"'>";
			}
			
			quarityHTML += profile;			
			quarityHTML += "</a>";			
			quarityHTML += "</li>";
			
			if(profile!="" && profile == curentProfile){
				selected = "<div id=\"curent-profile\">"+curentProfile+"</div>";
				flag = true;				
			}else if(listProfiles[profile].default && !flag){				
				selected = "<div id=\"curent-profile\">"+profile+"</div>";
			}
		}
		quarityHTML += "</ul>"+selected;
		$(".vp-quarity").html(quarityHTML);
		
		var self = this;
		$('.change_quarity').click(function() {
			var quarity = $(this).attr("rel");
			var audio = document.getElementById("audio");
			
			var time = audio.currentTime;
		
			self._setProfile(quarity,listProfiles);			
			//audio.currentTime = 5; 
			audio.play();
			
			return false;
		});
			
	},
	_setProfile: function(selectProfile,listProfiles){
		if(selectProfile == curentProfile){		
			return;
		}		
		
		for (var profile in listProfiles) {
			if((selectProfile=="default" && listProfiles[profile].default) || 
			(selectProfile!="default" && selectProfile == profile) ){				
				curentProfile = profile;				
				this.audio.src = listProfiles[profile].url;					
				$("#curent-profile").html(curentProfile);
				$(".vp-quarity ul").hide();
				showProfile = false;
				return;
			}
		}
	},	
}

var audioPlayer = function(cssSelector, contentObj)
{	
	vplayer.call(this,cssSelector,contentObj);
	
	var self = this;
	document.getElementById("audio").addEventListener("ended",
	function() {		
		if(self.repeat){
			self._play();			
		}		
	}, false);	
	self._makeProfile(contentObj.mp3);		
	self._setProfile("default",contentObj.mp3);		
}

audioPlayer._getInstance = function() {
    if (!audioPlayer._instance)
    	audioPlayer._instance = new audioPlayer('audio',null);
    return audioPlayer._instance;
};

audioPlayer.prototype =  $.extend(true, vplayer.prototype,{
    _play: function(){    	
    	 if($("#play").hasClass("before-load")){
			//alert("Xin vui lòng chờ khi media đang tải media");
			return false;
    	 }

    	this.audio.play();
    	if(firstPlaySong){    		
    		console.log("do loging");
    	}		

    	firstPlaySong = false;
    	$('#play').css('display','none');
    	$('#pause').css('display','block');
    },
})

if(page_id == 'album-view'){
var albumPlayer = function(cssSelector, contentObj)
{
	var self = this;
	vplayer.call(this,cssSelector,contentObj);
	
	var listSong = contentObj.listSong;
	self._makeProfile(listSong[0].mp3);		
	self._setProfile("default",listSong[0].mp3);	
	

	$("#next").click(function() {
		if(typeof self.contentObj.listSong == 'undefined' ||  self.contentObj.listSong.length ==0){
			alert(__t("There is not any song"));
			return false;
		}
		var listSong = self.contentObj.listSong;

		index = (index + 1 < listSong.length) ? index + 1 : 0;
		self._play();
		return false;
	});
	$("#prev").click(function() {
		if(typeof self.contentObj.listSong == 'undefined' ||  self.contentObj.listSong.length ==0){
			alert(__t("There is not any song"));
			return false;
		}
		var listSong = self.contentObj.listSong;

		if (index == 'undefined')
			index = 0;
		else if (index <= 0)
			index = listSong.length - 1;
		else
			index--;
		self._play();
		return false;
	});

	document.getElementById("audio").addEventListener("ended",
	function() {
		var listSong = self.contentObj.listSong;
		index = (index + 1 < listSong.length) ? index + 1 : 0;
		self._play();
	}, false);

	$(".item-in-list").click(function(){
		var id_item = $(this).attr("id");
		id_item = id_item.replace("item-","");
		index = parseInt(id_item);
		var listSong = self.contentObj.listSong;
		if(index >= 0 && index <= listSong.length){
			self._play();
		}
	});

}
albumPlayer.prototype =  $.extend(true, vplayer.prototype,{
	 _play: function(){

		if(typeof this.contentObj.listSong == 'undefined' ||  this.contentObj.listSong.length ==0){
			alert(__t("There is not any song"));
			return false;
		}			
	
		$("#listSong li").removeClass("active_play");
		$("#item-"+index).addClass("active_play");
    	
    	if(firstPlayAlbum){    		
    		console.log("do loging");
    	}
    	firstPlayAlbum = false;
    	var listSong = this.contentObj.listSong;
		var profiles = listSong[index].mp3;
		
		if(!profiles[curentProfile]){			
			this._setProfile("default",listSong[index].mp3);			
		}else{
			this._setProfile(curentProfile,listSong[index].mp3);			
		}		
		this._makeProfile(listSong[index].mp3);
		
		var url = profiles[curentProfile].url;
		    	 
    	var src = this.audio.src;
    	if(src==''){
    		src = $("#mp3_src").attr("src");
    	}
    	if(src != url){
    		this.audio.src = url;
    		$("#mp3_src").attr("src",url)
    		/*if(os=='ANDROIDOS' && os_version<2.4){
    			this.audio.load();
    		}*/

    	}
    	this.audio.play();
    	$('#play').css('display','none');
    	$('#pause').css('display','block');
    	var duration = this.audio.duration;
    	if(isNaN('duration')){
    		duration =  listSong[index].duration;
    	}
    	var time = formatTime(duration);
    	$("#total_time_display").text(time);
    	$("#song-playing").text(listSong[index].name);
		$("#vp-avatar").attr("src",listSong[index].avatar);
	 }
})
}


function myOnCanPlayFunction() {
	canPlay = true;
	$("#play").removeClass("before-load");
	$("#play").html("");
	var audio = document.getElementById("audio");
	var totalTime = audio.duration;
	$("#total_time_display").html(formatTime(totalTime));
	
}
function myOnCanPlayThroughFunction() {
	
}
function myOnLoadedData() {}

function updateProgressBar(){
	vplayer._getInstance()._trackPlayProgress();
}

function formatTime(seconds) {
    seconds = Math.round(seconds);
    minutes = Math.floor(seconds / 60);
    minutes = (minutes >= 10) ? minutes : "0" + minutes;
    seconds = Math.floor(seconds % 60);
    seconds = (seconds >= 10) ? seconds : "0" + seconds;
    return minutes + ":" + seconds;
}

function findPosX(obj) {
    var curleft = obj.offsetLeft;
    while (obj = obj.offsetParent) {
        curleft += obj.offsetLeft;
    }
    return curleft;
}
function checkStatus()
{
	var audio = document.getElementById("audio");
	if(audio.currentTime > 0){
		clearInterval(playInterval);
	}else{
		audio.play()
	}
}
