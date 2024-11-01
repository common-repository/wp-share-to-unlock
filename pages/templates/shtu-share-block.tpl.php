<form action="" method="post">
    <table>
        <tr>
            <td align="center">
                <?php echo __('Share to unlock', 'share-to-unlock');?>
            </td>
        </tr>
        <tr>
            <td align="center">
                <div class="panel" title="Like on Facebook">
                    <fb:like href="<?php echo get_permalink().'&post='.$post->ID; ?>" layout="button_count" action="like" font="arial" show_faces="false" width="48" height="65"></fb:like>
                </div>
            </td>
        </tr>
    </table>
</form>