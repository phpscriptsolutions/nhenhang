var Avideo = Avideo || {};

!function() {
	
	 // Ready
    $(function() {
		// Menu
//		$('.cpage').css({
//			width: $(window).width() + 'px'
//		});
		
		$('.menu-n').on('click', function(){
                //var heightSet = $( document ).height() >= $( window ).height() ? $( document ).height() : $( window ).height();
                var heightSet = $( window ).height();
			if ($('.menu-list').hasClass('hidden')) {
				// Show overlay background
				$('.menu-n').addClass('active');
				$('#overlay-bg').css({
					height: heightSet + 'px',
					width: $( document ).width() + 'px',
					left: '275px',
					top:'50px',
					display: 'block'
				});
				$('.menu-list').removeClass('hidden');
				$('.menu-list').css({
					position: 'absolute',
					top: '49px',
					right: '0px',
					height: heightSet + 'px'
				});
				/*$('section').css({
					height: heightSet + 'px'
				})*/
				$('#wrr-page').css({
					height: heightSet + 'px',
					overflow: 'hidden'
				})
				$('.cpage').css({
					position: 'absolute',
					left: '275px',
					top: '0px'
				});
                $('.cpage').css({
                    position: 'static'
                });
				var heightLeft = $('.menu-right').height();
                if(heightLeft< heightSet){
                    heightLeft = heightSet;
                }else{
					$('.menu-footer').css({'position':'relative'});
					heightLeft = $('.menu-right').height();
				}
				$('#wrr-page,.menu-list, .menu-right,#overlay-bg').css({
					'height' : heightLeft + 'px'
				});
				$('.form-search').addClass('hide').removeClass('show');
				$('.search-n').removeClass('search-active');
			}
			else {
				$('.menu-n').removeClass('active');
				$('#wrr-page').css({
					height: 'auto',
					//overflow: 'hidden'
				})
				$('#overlay-bg').css({
					height: '0',
					width: '0',
					display: 'none'
				});
				$('.menu-list').addClass('hidden');
				var pw = $(window).width();
                $('.cpage').css({
                    left: 0,
                    width: pw + 'px',
					position: 'absolute',
					opacity: '1'
                });
                $('.cpage').css({
                    width: 'auto',
                    position: 'relative'
                });
                $('header').css({
					left: 0
				});
			}
		});
		
		$('#overlay-bg').on('click', function(){
			$('.search-n').removeClass('search-active');
			if (!$('.menu-list').hasClass('hidden') || $('.form-search').hasClass('show')) {
				$('.form-search').addClass('hide').removeClass('show');
				$('#wrr-page').css({
					height: 'auto',
					//overflow: 'hidden'
				})
				$('#overlay-bg').css({
					height: '0',
					width: '0',
					display: 'none'
				});
				$('.menu-list').addClass('hidden');
				$('.menu-n').removeClass('active');
				var pw = $(window).width();
                $('.cpage').css({
                    left: 0,
                    width: pw + 'px',
					position: 'absolute',
					opacity: '1'
                });
                $('.cpage').css({
                    position: 'relative',
                    width: 'auto'
                });
                 $('header').css({
					left: 0
				});
				return false;
			}
		});
		
		$(window).resize(function() {
            $('.cpage').css({
                width: 'auto'
            });
        });
		
		// Search
		$('.search-n').on('click', function() {
			if ($('.form-search').hasClass('hide')) {
				$('.menu-list').addClass('hidden');
				$('.menu-n').removeClass('active');
				var heightSet = $( window ).height();
				$('.form-search').removeClass('hide').addClass('show');
				$('.form-search input').focus();

				$('#overlay-bg').css({
					height: heightSet + 'px',
					width: $( document ).width() + 'px',
					left: '275px',
					top:'111px',
					display: 'block'
				});
				$(".form-search input").keypress(function(event) {
					if (event.which == 13) {
						event.preventDefault();
						$("form").submit();
					}
				});
				$('.search-n').addClass('search-active');
			}
			else {
				$('.search-n').removeClass('search-active');
				$('#overlay-bg').css({
					height: '0',
					width: '0',
					display: 'none'
				});
				$('.form-search').addClass('hide').removeClass('show');
			}
		});
		
		
		// select box
		$('.title .arrow-select').click(function(){
			var $this = $(this);
			$this.parent().find('select[class="ct-op"]').click();
		});
		
		// More loading
		$('a.viewmore').click(function() {
			var $this = $(this);
			var load = $this.data('listid');
			var url = $this.data('url');
			var $parent =  $('#' + load);
			$.ajax({
				url: url,
				cache: false,
				dataType: 'html',
				beforeSend: function() {
					$this.find('span').addClass('loadding');
				},
				success: function(html) {
					
					/* Hard code html to demo. When code app remove or comment this code */
					var html = '<a href=\'http://clip.vn\' title=\'Tool tip\'><div class=\'thumb-row clearfix\'><div class=\'thumbs\'><img src=\'images/video.jpg\' /></div><div class=\'video-info\'><span class=\'title-video\'>Text tiêu biểu hiển thị 2 dòng như sau ...</span><div class=\'one-line mr-t-5\'><span class=\'views-ic\'></span><span class=\'vt\'>100</span><span class=\'sm\'></span><span class=\'sm-vt\'>25</span></div></div></div></a>';
					/* End code demo*/
					
					if ($.trim(html) == 'false') {
						$parent.after('<p>Không có kết quả nào</p>');
						$this.hide();
						return;
					}
					window.setTimeout(function() {
						$this.find('span').removeClass('loadding');
						$parent.append(html);
					}, 1000); //delay 1s                    
				}
			});
		});
		
		// View more
		$('.viewmore').click(function() {
            if ($('.lyric').hasClass('expand'))
                $('.lyric').removeClass('expand');
            else
                $('.lyric').addClass('expand');
            return false;
        });
		
		// Tabs
		$('ul.tabs li').click(function(){
			var tab_id = $(this).attr('data-tab');
			$('ul.tabs li').removeClass('current');
			$('.tab-content').removeClass('current');
			$(this).addClass('current');
			$("#" + tab_id).addClass('current');
		});
		
		// Popup
		$('.add').click(function (e) {
			$('.popup.tadd').modal();
			return false;
		});
		$('.wait').click(function (e) {
			$('.popup.tmusicwait').modal();
			return false;
		});
		$('.share').click(function (e) {
			$('.popup.tmusicfriend').modal();
			return false;
		});
		
		// Go top
		/*$('#gotop').click(function() {
			 $("html, body").animate({ scrollTop: 0 }, "slow");
			return false;
		});*/
		
		
	});
}(window, window.jQuery, window.Avideo);


