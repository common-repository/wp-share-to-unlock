<?php
class SHTU_Controller_Sharetounlock extends SHTU_Controller
{
    /**
     * Method prepares data to unlock and to store it in cookie.
     *
     * @param mixed $_GET
     * @param mixed $_POST
     * @return mixed data array to store in cookie
     */
    function changeLockedPosts($get, $post)
    {

        $settings_model = SHTU_Loader::getModel('settings');
        $cookie_time = $settings_model->getSetting('exp-date');

        $flag = (int)$post['flag'];
        $pid=trim($post['post_id']);

        if($pid && $flag==1)
        {
           $response['shtu_post_id'] = $pid;
           $response['shtu_cookie_name'] = md5(site_url().'_post_'.$pid);
           $response['shtu_cookie_value'] = md5($pid);
           $response['liked'] = 1;
           $response['lifetime'] = $cookie_time;
           setcookie($response['shtu_cookie_name'],$response['shtu_cookie_value'], time()+60*60*24*(int)$cookie_time);
        }
        elseif($pid && $flag==0)
        {
            $response['shtu_post_id'] = $pid;
            $response['shtu_cookie_name'] = md5(site_url().'_post_'.$pid);
            $response['shtu_cookie_value'] = md5($pid);
            $response['liked'] = 0;
            $response['lifetime'] = $cookie_time;
        }
        echo json_encode($response);
    }

    /**
     * Method gets 'liked' post's content and returns data to client code(ajax).
     *
     * @param mixed $_GET
     * @param mixed $_POST
     * @return string post content that is shown instead of 'Share to unlock' form.
     */
    function getLikedPostContent($get, $post)
    {
        $post_id = $post['post_id'];
        $current_post = get_post($post_id);
        $content = preg_replace('/\[share-to-unlock(.*?)\]/','',$current_post->post_content);
        $content = str_replace('[/share-to-unlock]','',$content);
        echo $content;
    }


}
