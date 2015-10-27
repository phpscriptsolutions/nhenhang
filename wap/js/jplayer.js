/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


/**
 * Comment
 */
function register() {
    window.location.href = '/account/packageInfo?id=3';
}

function _dialog(element,_title, _height, _width) {
    if(_height == null)
        _height = 120;
    if(_width == null)
        _width = 300;
    if(_title == "")
        _title = "THÔNG BÁO";
    $('#'+element).dialog({
        title : _title,
        dialogClass : 'dialog-box',
        width : _width,
        height : _height,
        resizable : false,
        modal : true,
        zIndex : 999
    });
}
