<div id="fb-root"></div>
<script>
    window.fbAsyncInit = function() {
        FB.init({
            appId      : '<?php echo Yii::app()->params['social']['facebook']['id']?>',
            xfbml      : true,
            version    : 'v2.3'
        });
    };
    function feedFacebook(title,link){
        FB.ui({
            method: 'feed',
            link: title,
            caption: link
        }, function(response){});
    }
    function shareFacebook(url,title){
        var winWidth = 520;
        var winHeight = 350;
        var winTop = (screen.height / 2) - (winHeight / 2);
        var winLeft = (screen.width / 2) - (winWidth / 2);
        window.open('https://www.facebook.com/sharer.php?u='+encodeURIComponent(url)+'&title='+encodeURIComponent(title), 'sharer', 'top=' + winTop + ',left=' + winLeft + ',toolbar=0,status=0,width=' + winWidth + ',height=' + winHeight);
    }
    (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/vi_VN/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

</script>