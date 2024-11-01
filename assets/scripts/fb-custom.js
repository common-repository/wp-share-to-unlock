
jQuery("document").ready(function(){

    FB.Event.subscribe('edge.create', function(href, widget) {
        var post_id = jQuery('.fb_iframe_widget[href="'+href+'"]').attr('post_id');
        var redir_url = jQuery('#redirection_url_'+post_id).val();
        shtu.shareToUnlock.changeLockedStatus(href,1, redir_url, post_id);
    });
    //catch unlike event
    FB.Event.subscribe('edge.remove', function(href, widget) {
        var post_id = jQuery('.fb_iframe_widget[href="'+href+'"]').attr('post_id');
        //shtu.shareToUnlock.changeLockedStatus(href,0, '',post_id);
    });
});


