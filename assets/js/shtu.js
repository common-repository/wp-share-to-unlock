var shtu = {

    shareToUnlock:
    {
        changeLockedStatus: function(url, flag, redirection_url,post_id)
        {
            var admin_url = jQuery('#shtu_admin_url').val();
            jQuery.post(admin_url+"admin.php?shtu_c=sharetounlock&shtu_action=changeLockedPosts",{'return_url':url, 'flag':flag, 'post_id':post_id}, function(data){
                var post_data = jQuery.parseJSON(data);
                if(post_data.liked==1)
                {
                    //jQuery.cookie(post_data.shtu_cookie_name, post_data.shtu_cookie_value,{ expires: post_data.lifetime, path: '/' });
                    shtu.set_cookie(post_data.shtu_cookie_name, post_data.shtu_cookie_value, '/', '', post_data.lifetime, '');

                    if(redirection_url=='')
                    {
                         jQuery.post(admin_url+"admin.php?shtu_c=sharetounlock&shtu_action=getLikedPostContent",{'post_id':post_data.shtu_post_id}, function(data){
                            jQuery('#post-'+post_data.shtu_post_id).find('.entry-content').html(data);
                        })
                    }
                    else
                    {
                        window.location.href=redirection_url;
                    }


                }

            });
        }

    },
    set_cookie: function(name, value, path, domain, expires, secure)
    {
        // set time, it's in milliseconds
        var today = new Date();
        today.setTime(today.getTime());

        if(expires){
            expires = expires * 1000 * 60 * 60 * 24;
        }
        var expires_date = new Date( today.getTime() + (expires) );

        document.cookie = name + "=" +escape( value ) +
            ( ( expires ) ? ";expires=" + expires_date.toGMTString() : "" ) +
            ( ( path ) ? ";path=" + path : "" ) +
            ( ( domain ) ? ";domain=" + domain : "" ) +
            ( ( secure ) ? ";secure" : "" );
    }


}