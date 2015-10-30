/**
 * Created by tiennt on 29/10/2015.
 */
var story = {};

story.loadList = function(type){
    $.ajax({
        url: 'story/ajax',
        type: 'GET',
        data: {type:type},
        beforeSend: function(){
            $('#story-list-'+type).prepend('<div class=\"ovelay-loading-face\">'+ajax_loading_content+'</div>');
        },
        success: function(data){
            $('#story-list-'+type).html(data);
        }
    })
}