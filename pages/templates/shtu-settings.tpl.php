<?php
// get settings
$settings_model = SHTU_Loader::getModel('settings');
$settings = $settings_model->getSettings();
?>
<div class="wrap" style="height:auto;">
    <h1><?php echo __('Settings','share-to-unlock'); ?></h1>
    <?php
    if(array_key_exists('result',$_GET))
    {
        $result = $_GET['result'];

        if($result==1)
        {
            $result_msg = 'Settings have been saved';
        }
        elseif($result==2)
        {
            $result_msg = 'Saving settings error. Share buttons location is required field.';
        }
        else
        {
            $result_msg = 'Saving settings error';
        }
    }
    if(isset($result_msg))
    {
        echo '<div id="message" class="updated"><p>'.$result_msg.'</p></div>';
    }
    ?>
    <p><b>Thank you for the download &amp; activation of WP Share To Unlock Standard plugin!</b></p>
    <p>Within a few clicks you will be able to get your first content locked to engage your website visitors to action.</p>
    <p>If you have some questions or you need some help, please do not hesitate to contact our <a href="http://www.pghelpdesk.com/anonymous_requests/new?ticket%5Bfields%5D%5B20944601%5D=wp_share_to_unlock">support desk here</a></p>
    <p>
    Enjoy!<br>
    Peter Garety<br>
    The creator of WP Share To Unlock plugin
    </p>

    <p>P.S. Don't forget to watch the <a href="http://www.wpsharetounlock.com/pro">WP Share To Unlock Pro Demo video</a> - it is incredibly powerful stuff to convert more visitors and get viral traffic from Facebook.<p><br><br>

    <form action="<?php echo admin_url().'admin.php?shtu_c=settings&shtu_action=save';?>" method="post">
        <table>
            <tr>
                <td><?php echo __( 'Background color', 'share-to-unlock' );?></td>
                <td><div><input style="margin: 1px; width: 250px;" type="text" class="color-picker1" name="bg-color" id="bg-color" value="<?php echo $settings['bg-color'];?>"></div><div id="bg-colorpicker"></div>
            </tr>
            <tr>
                <td><?php echo __( 'Title', 'share-to-unlock' );?></td>
                <td><input style="margin: 1px; width: 250px;" type="text" name="title" id="title" value="<?php echo $settings['title'];?>"></td>
            </tr>
            <tr>
                <td><?php echo __( 'Title color', 'share-to-unlock' );?></td>
                <td><div><input style="margin: 1px; width: 250px;" type="text" class="color-picker2" name="title-clr" id="title-clr" value="<?php echo $settings['title-clr'];?>"></div><div id="title-clrpicker"></div></td>
            </tr>
            <tr>
                <td><?php echo __( 'Title font', 'share-to-unlock' );?></td>
                <td><select name="title-font" id="title-font"/>
                    <?php
                    echo '<option value="">'.__('- Use default site font -','share-to-unlock')."</option>";
                    foreach ($title_fnt as $key=>$val)
                    {
                        if(isset($settings['title-font']) && !empty($settings['title-font']))
                        {

                            if($key==$settings['title-font'])
                            {
                                echo "<option  selected value=".$key."> ".$val."</option>";
                            }
                            else
                            {
                                echo '<option value="'.$key.'"> '.$val.'</option>';
                            }
                        }
                        else
                        {
                            echo "<option value=".$key."> ".$val."</option>";
                        }

                    }
                    ?>

                    </select>

                </td>
            </tr>
            <tr>
                <td><?php echo __( 'Share buttons location', 'share-to-unlock' );?></td>
                <td><select name="buttons-align" id="buttons-align"/>
                    <?php
                    foreach ($buttons_align as $key=>$val)
                    {
                        if(isset($settings['buttons-align']) && !empty($settings['buttons-align']))
                        {

                            if($val==$settings['buttons-align'])
                            {
                                echo "<option  selected value=".$val."> ".$val."</option>";
                            }
                            else
                            {
                                echo "<option value=".$val."> ".$val."</option>";
                            }
                        }
                        else
                        {
                            echo "<option value=".$val."> ".$val."</option>";
                        }

                    }
                    ?>

                    </select>

                </td>
            </tr>
            <tr>
                <td><?php echo __( 'Cookies expiration time', 'share-to-unlock' );?></td>
                <td>
                    <div style="float:left; margin: 0 5px 0 1px;">
                        <input value="<?php echo $settings['exp-date'];?>" id="exp-date"  name="exp-date" class="easyui-numberspinner" style="width:63px;" min="1" max="365" editable="false"/>
                    </div>
                    <span style="line-height:22px; float:left; height:20px" > days</span>
                </td>
            </tr>
            <tr>
                <td colspan="2"><br></td>
             </tr>

            </table>
        <input type="submit" value="<?php echo __( 'Save', 'share-to-unlock' );?>" class="button-primary" />
    </form>

</div>
<script type="text/javascript">

    jQuery(document).ready(function() {
        //$('#bg-colorpicker').farbtastic('#bg-color');
        //$('#title-clrpicker').farbtastic('#title-clr');
        $(".color-picker1").miniColors();
        $(".color-picker2").miniColors();

    });

</script>