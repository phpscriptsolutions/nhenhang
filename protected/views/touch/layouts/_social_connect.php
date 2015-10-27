<div id="fb-root"></div>
<script>
    window.fbAsyncInit = function() {
        FB.init({
            appId      : '<?php echo Yii::app()->params['social']['facebook']['id']?>',
            xfbml      : true,
            version    : 'v2.3'
        });
    };
    function shareFacebook(title,link){
        FB.ui({
            method: 'feed',
            link: title,
            caption: link
        }, function(response){});
    }
    (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/vi_VN/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

</script>