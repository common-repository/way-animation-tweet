<?
add_action( 'admin_menu', 'wtp_settings_page_init' );
function wtp_settings_page_init() {
	$theme_data = get_plugin_data( plugin_dir_url( __FILE__ ).'settings.php' );
	$settings_page = add_theme_page( $theme_data['Name']. ' Theme Settings', $theme_data['Name']. ' Theme Settings', 'edit_theme_options', 'way-tweet-settings', 'wtp_settings_page' );
    add_menu_page(__('Way Tweet','menu-test'), __('Way Tweet','way-tweet-settings'), 'edit_theme_options', 'way-tweet-settings', 'wtp_settings_page' );
}
add_action( 'admin_enqueue_scripts', 'wp_enqueue_color_picker' );
if(!function_exists("wp_enqueue_color_picker")){
function wp_enqueue_color_picker( ) {

    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'wp-color-picker-script', plugins_url('script.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
}
}
function wtp_admin_tabs( $current = 'api' ) { 
    $tabs = array( 'api' => 'Api Setting', 'widget' => 'Widget Option', 'theme' => 'Theme Set', 'custom' => 'Custom Template' ); 
    $links = array();
    echo '<div id="icon-way" class="icon-way"><br></div>';
    echo '<h2 class="nav-tab-wrapper">';
    foreach( $tabs as $tab => $name ){
        $class = ( $tab == $current ) ? ' nav-tab-active' : '';
        echo "<a class='nav-tab$class' href='?page=way-tweet-settings&tab=$tab'>$name</a>";
        
    }
    echo '</h2>';
}

function wtp_settings_page() {
	global $pagenow;
	$tsettings = get_option( "wtp_tweet_settings" );
    if($_REQUEST["savedata"]){
    if ( isset ( $_GET['tab'] ) ) $tab = $_GET['tab']; 
    else $tab = 'api';        
    
    switch ( $tab ){
	case 'api' :
        if ($_REQUEST["CONSUMER_KEY"]==null || $_REQUEST["CONSUMER_KEY"]=="") { 
            $conkeyErr = "API_KEY is required";
        }else
        {
            //Lazy_JTweet_option("Lazy_JTweet_CONSUMER_KEY",$_REQUEST["CONSUMER_KEY"]);
            $tsettings["apikey"] = $_REQUEST["CONSUMER_KEY"];
        }
        
        if ($_REQUEST["CONSUMER_SECRET"]==null || $_REQUEST["CONSUMER_SECRET"]=="") { 
            $consecretErr = "API_SECRET is required";
        }else
        {
            //Lazy_JTweet_option("Lazy_JTweet_CONSUMER_SECRET",$_REQUEST["CONSUMER_SECRET"]);
            $tsettings["apisecret"] = $_REQUEST["CONSUMER_SECRET"];
        }
        
        if ($_REQUEST["ACCESS_TOKEN"]==null || $_REQUEST["ACCESS_TOKEN"]=="") { 
            $accesstokenErr = "ACCESS_TOKEN is required";
        }else
        {
            //Lazy_JTweet_option("Lazy_JTweet_ACCESS_TOKEN",$_REQUEST["ACCESS_TOKEN"]);
            $tsettings["accesstoken"] = $_REQUEST["ACCESS_TOKEN"];
        }
        
        if ($_REQUEST["ACCESS_SECRET"]==null || $_REQUEST["ACCESS_SECRET"]=="") { 
            $accesssecretErr = "ACCESS_SECRET is required";
        }else
        {
            //Lazy_JTweet_option("Lazy_JTweet_ACCESS_SECRET",$_REQUEST["ACCESS_SECRET"]);
            $tsettings["accesssecret"] = $_REQUEST["ACCESS_SECRET"];
        }
        
        if ($_REQUEST["Owner_Name"]==null || $_REQUEST["Owner_Name"]=="") { 
            $nameErr = "Owner_Name is required";
        }else
        {
            //Lazy_JTweet_option("Lazy_JTweet_Owner_Name",$_REQUEST["Owner_Name"]);
            $tsettings["username"] =  $_REQUEST["Owner_Name"];
        }
    break;
    case 'theme' :
        
        $tsettings["background"]=$_REQUEST["Lazy_JTweet_Background"];
        $tsettings["fontcolor"]=$_REQUEST["Lazy_JTweet_FontColor"];
        $tsettings["timecolor"]=$_REQUEST["Lazy_JTweet_TimeColor"];
        
        $tsettings["borderstyle"]=$_REQUEST["Lazy_JTweet_Border"];
        if($_REQUEST["Lazy_JTweet_Border_Size"]<=0){
            $tsettings["bordersize"]="null";    
        }else
        {
            $tsettings["bordersize"]=$_REQUEST["Lazy_JTweet_Border_Size"];
        }
        $tsettings["bordercolor"]=$_REQUEST["Lazy_JTweet_Border_Color"];
        if($_REQUEST["Lazy_JTweet_Box_X"]<=0){
            $tsettings["boxx"]="null";    
        }else
        {
            $tsettings["boxx"]=$_REQUEST["Lazy_JTweet_Box_X"];
        }
        if($_REQUEST["Lazy_JTweet_Box_Y"]<=0){
            $tsettings["boxy"]="null";    
        }else
        {
            $tsettings["boxy"]=$_REQUEST["Lazy_JTweet_Box_Y"];
        }
        if($_REQUEST["Lazy_JTweet_Box_Spred_Size"]<=0){
            $tsettings["boxspred"]="null";    
        }else
        {
            $tsettings["boxspred"]=$_REQUEST["Lazy_JTweet_Box_Spred_Size"];
        }
        $tsettings["boxscolor"]=$_REQUEST["Lazy_JTweet_Box_Shadow_Color"];
        
        $tsettings["retweet"]=$_REQUEST["Lazy_JTweet_Retweet"];
        $tsettings["retweetcolor"]=$_REQUEST["Lazy_JTweet_Retweet_Background"];
        
        $tsettings["share"]=$_REQUEST["Lazy_JTweet_Share"];
        $tsettings["sharecolor"]=$_REQUEST["Lazy_JTweet_Share_Background"];
        
        $tsettings["fevorite"]=$_REQUEST["Lazy_JTweet_Fevorite"];
        $tsettings["fevoritecolor"]=$_REQUEST["Lazy_JTweet_Fevorite_Background"];
        
        $tsettings["retweetcount"]=$_REQUEST["Lazy_JTweet_Retweet_Count"];
        $tsettings["retweetcountcolor"]=$_REQUEST["Lazy_JTweet_Retweet_TextColor"];
        
        $tsettings["favoritecount"]=$_REQUEST["Lazy_JTweet_Favorite_Count"];
        $tsettings["favoritecountcolor"]=$_REQUEST["Lazy_JTweet_Favorite_TextColor"];
        
        $tsettings["avatar"]=$_REQUEST["Lazy_JTweet_Avatar"];
        $tsettings["avatarshape"]=$_REQUEST["Lazy_JTweet_Avatar_Shape"];
    break;
    case 'widget' :
        if($_REQUEST["Feed_Count"]<=0){
            $tsettings["count"]="1";    
        }else
        {
            $tsettings["count"]=$_REQUEST["Feed_Count"];
        }
        $tsettings["searchapi"]=$_REQUEST["Lazy_JTweet_API"];
        if ($_REQUEST["Lazy_JTweet_API"]=="search/tweets") 
        { 
             if ($_REQUEST["Lazy_JTweet_Search"]==null || $_REQUEST["Lazy_JTweet_Search"]=="") { 
                $search = "Serach Quary is required";   
                }else
                {
                $tsettings["query"]=$_REQUEST["Lazy_JTweet_Search"];
                }
        }
        else
        {
            $tsettings["query"]="";
        }
        $tsettings["filter"]=$_REQUEST["Lazy_JTweet_Filter"];
        $tsettings["geolatitude"]=$_REQUEST["Lazy_JTweet_Geo_Latitude"];
        $tsettings["geolongitude"]=$_REQUEST["Lazy_JTweet_Geo_Longitude"];
        if($_REQUEST["Lazy_JTweet_Geo_Area"]<=0){
            $tsettings["geoarea"]="";    
        }else
        {
            $tsettings["geoarea"]=$_REQUEST["Lazy_JTweet_Geo_Area"];
        }
        $tsettings["refresh"]=$_REQUEST["Lazy_JTweet_Refresh"];
        $tsettings["interval"]=$_REQUEST["Lazy_JTweet_Refresh_Interval"];
         $tsettings["animation"]=$_REQUEST["Lazy_JTweet_Animation"];
        $tsettings["animationtype"]=$_REQUEST["Lazy_JTweet_Animation_Type"];
        $tsettings["followbutton"]=$_REQUEST["Lazy_JTweet_FollowButton"];
        
     break;
     case 'custom' :
        $tsettings["customtheme"]=$_REQUEST["customtheme"];
        $tsettings["customtemplate"] = stripslashes($_REQUEST["customtemplate"]);
     break;   
     }   
        update_option("wtp_tweet_settings",$tsettings);
    }
	$theme_data = get_plugin_data( plugin_dir_url( __FILE__ ) . '/settings.php' );
	
    
    ?>
	
	<div class="wrap">
		<h2><?php echo $theme_data["Name"]; ?> Plugins Settings</h2>
		
		<?php
			if ( 'true' == esc_attr( $_GET['updated'] ) ) echo '<div class="updated" ><p>Theme Settings updated.</p></div>';
			
			if ( isset ( $_GET['tab'] ) ) wtp_admin_tabs($_GET['tab']); else wtp_admin_tabs('api');
		?>

		<div id="poststuff">
			<form method="post" action="<?php admin_url( 'themes.php?page=way-tweet-settings' ); ?>">
				<?php
			
				if ( $_GET['page'] == 'way-tweet-settings' ){ 
				?>
             
                <?
					if ( isset ( $_GET['tab'] ) ) $tab = $_GET['tab']; 
					else $tab = 'api'; 
					
					echo '<table class="form-table">';
					switch ( $tab ){
						case 'api' :
                                echo "<table><tr><td>";
                                echo "<h3><font color='gray'>Tweet API Configuration</font></h3>
                                <p>This setting is required. You need to set App settings provided by Twitter. For api visit <a  href='https://apps.twitter.com'>Twitter Api</a></p>";
                                echo "<table class='Lazy_JTweet_Table'>";
                                echo "<tr><th><label>API_KEY</label></th><td><input  class='regular-text' type='text' name='CONSUMER_KEY' value='".$tsettings["apikey"]."' /><span class='error'> "; echo $conkeyErr; echo"</span></td><td class='msg'>Set Your <strong>API KEY</strong></td></tr>";
                                echo "<tr><th><label>API_SECRET</label></th><td><input class='regular-text' type='text' name='CONSUMER_SECRET' value='".$tsettings["apisecret"]."' /><span class='error'>"; echo  $consecretErr; echo"</span></td><td colspan='2' class='msg'>Set Your <strong>API SECRET</strong>, This key should never be human-readable in your application.</td></tr>";
                                echo "<tr><th><label>ACCESS_TOKEN</label></th><td><input class='regular-text' type='text' name='ACCESS_TOKEN' value='".$tsettings["accesstoken"]."' /><span class='error'>"; echo $accesstokenErr; echo"</span></td><td colspan='2' class='msg'>Set Your <strong>Access Token</strong>, This access token can be used to make API requests on your own account's behalf. </td></tr>";
                                echo "<tr><th><label>ACCESS_SECRET</label></th><td><input class='regular-text' type='text' name='ACCESS_SECRET' value='".$tsettings["accesssecret"]."' /><span class='error'>"; echo $accesssecretErr; echo"</span></td><td colspan='2' class='msg'>Set Your <strong>Access Token Secret</strong>, Do not share your access token secret with anyone.  </td></tr>";
                                echo "<tr><th><label>OWNER ID / USERNAME</label></th><td><input class='regular-text' type='text' name='Owner_Name' value='".$tsettings["username"]."' /><span class='error'>"; echo $nameErr; echo"</span></td><td class='msg'>The ID of the <strong>Owner</strong> for whom to <strong>return results</strong>.</td><td></td></tr>";
                                echo "</table>";
                                echo "</td></tr></table><br /><a href='https://apps.twitter.com'>Twitter api</a>";
						break; 
						case 'widget' : 
                            
	 echo "<table><tr><td>";
    echo "<h3><font color='gray'>Tweet Widget Configuration</font></h3>";
    echo "<table class='Lazy_JTweet_Table'>
    <tr><th><label>Tweet API :</label></th><td>
        <select class='small_text' name=\"Lazy_JTweet_API\">";
        if ($tsettings["searchapi"]=="search/tweets"){
           echo " <option value=\"search/tweets\">Search</option>";
           }
           else
           {
            echo " <option value=\"statuses/user_timeline\">Statuses</option>";
           }
          echo" <option value=\"search/tweets\">Search</option>
            <option value=\"statuses/user_timeline\">Statuses</option></select></td><td class='msg'>Set Your <strong>API Resources</strong>.</td></tr>
    <tr><th><label>Tweet Search Quary :</label></th><td><input class='small_text' type='text' name='Lazy_JTweet_Search' value='".$tsettings["query"]."' /><br /><span class='error'> "; echo $search; echo"</span></td><td class='msg' colspan='2'>If Set <strong>Search Resources</strong> than add your <strong>Search Quary</strong>.</td></tr>
    <tr><th><label>Tweet Filter Bad Words :</label></th><td><input class='small_text' type='text' name='Lazy_JTweet_Filter' value='".$tsettings["filter"]."' placeholder='word1, word2' /><br /><span class='error'> "; echo $filter; echo"</span></td><td class='msg' colspan='2'><strong>Coma seperated</strong>Filter non required words or Bad words from  <strong>Search Quary Filter</strong>.</td></tr>
    <tr><th><label>Feed Count</label></th><td><input class='small_text' type='text' id='Feed_Count' name='Feed_Count' value='".$tsettings["count"]."' /></td><td colspan=\"3\" class='msg'>Specifies the <strong> number of tweets</strong> to try and retrieve. up to a maximum of 200.</td></tr>
    <tr><th><label>Tweet Geocode</label></th><td><input type='text'class='small_text' name='Lazy_JTweet_Geo_Latitude' value='".$tsettings["geolatitude"]."' />&nbsp;N,</td><td><input class='small_text'  type='text' name='Lazy_JTweet_Geo_Longitude' value='".$tsettings["geolongitude"]."' />&nbsp;E</td><td><input class='small_box' type='text' name='Lazy_JTweet_Geo_Area' value='".$tsettings["geoarea"]."' />&nbsp;Km</td><td class='msg' >Represents the <strong>Geographic Location</strong> of this Tweet.</td></tr>
    <tr>
        <th><label>Auto Refresh(Secound)</label></th>
            <td><div class='togglebox'>
                    <input name=\"Lazy_JTweet_Refresh\" type='checkbox' value=\"true\" ";
                    if($tsettings["refresh"]=="true")
                        echo "checked";
                    echo " id='chkbx'>
                     <label for='chkbx'><b></b></label>
                   </div></td>
         
            <td class='msg' colspan='3'><select class='small_text ' name=\"Lazy_JTweet_Refresh_Interval\">
            <option>".$tsettings["interval"]."</option>
                <option>5</option>
                <option>10</option>
                <option>15</option>
                <option>20</option>
                <option>25</option>
                <option>30</option>
                <option>35</option>
                <option>45</option>
                <option>50</option>
                <option>55</option>
                <option>60</option></select> When you create an ad unit , you will need to set the <strong>Refresh Rate</strong>. The refresh rate is the number of seconds until the next ad unit displays. </td> </tr>
    <tr><th><label>Tweet Animation</label></th>
            <td>
            
                  <div class='togglebox'>
                    <input name=\"Lazy_JTweet_Animation\" type='checkbox' value=\"true\" ";
                    if($tsettings["animation"]=="true")
                        echo "checked";
                    echo " id='chkbxa'>
                     <label for='chkbxa'><b></b></label>
                   </div>
                  
            </td>
            <td><select class='small_text' name=\"Lazy_JTweet_Animation_Type\">
                    <option value='".$tsettings["animationtype"]."'>".$tsettings["animationtype"]."</option>
                    <optgroup label=\"Attention Seekers\">
                      <option value=\"bounce\">bounce</option>
                      <option value=\"flash\">flash</option>
                      <option value=\"pulse\">pulse</option>
                      <option value=\"rubberBand\">rubberBand</option>
                      <option value=\"shake\">shake</option>
                      <option value=\"swing\">swing</option>
                      <option value=\"tada\">tada</option>
                      <option value=\"wobble\">wobble</option>
                    </optgroup>
            
                    <optgroup label=\"Bouncing Entrances\">
                      <option value=\"bounceIn\">bounceIn</option>
                      <option value=\"bounceInDown\">bounceInDown</option>
                      <option value=\"bounceInLeft\">bounceInLeft</option>
                      <option value=\"bounceInRight\">bounceInRight</option>
                      <option value=\"bounceInUp\">bounceInUp</option>
                    </optgroup>
                     <optgroup label=\"Fading Entrances\">
                      <option value=\"fadeIn\">fadeIn</option>
                      <option value=\"fadeInDown\">fadeInDown</option>
                      <option value=\"fadeInDownBig\">fadeInDownBig</option>
                      <option value=\"fadeInLeft\">fadeInLeft</option>
                      <option value=\"fadeInLeftBig\">fadeInLeftBig</option>
                      <option value=\"fadeInRight\">fadeInRight</option>
                      <option value=\"fadeInRightBig\">fadeInRightBig</option>
                      <option value=\"fadeInUp\">fadeInUp</option>
                      <option value=\"fadeInUpBig\">fadeInUpBig</option>
                    </optgroup>
                     <optgroup label=\"Flippers\">
                      <option value=\"flip\">flip</option>
                      <option value=\"flipInX\">flipInX</option>
                      <option value=\"flipInY\">flipInY</option>
                     </optgroup>
                     <optgroup label=\"Lightspeed\">
                      <option value=\"lightSpeedIn\">lightSpeedIn</option>
                     </optgroup>
            
                    <optgroup label=\"Rotating Entrances\">
                      <option value=\"rotateIn\">rotateIn</option>
                      <option value=\"rotateInDownLeft\">rotateInDownLeft</option>
                      <option value=\"rotateInDownRight\">rotateInDownRight</option>
                      <option value=\"rotateInUpLeft\">rotateInUpLeft</option>
                      <option value=\"rotateInUpRight\">rotateInUpRight</option>
                    </optgroup>
                        
                    <optgroup label=\"Specials\">
                      <option value=\"rollIn\">rollIn</option>
                    </optgroup>
            
                    <optgroup label=\"Zoom Entrances\">
                      <option value=\"zoomIn\">zoomIn</option>
                      <option value=\"zoomInDown\">zoomInDown</option>
                      <option value=\"zoomInLeft\">zoomInLeft</option>
                      <option value=\"zoomInRight\">zoomInRight</option>
                      <option value=\"zoomInUp\">zoomInUp</option>
                    </optgroup>
            </select><td class='msg' colspan='2'>Set Yor <strong>Animation</strong> and <strong>Animation type</strong> for Tweet Movement. </td></td>
            </tr>
            <tr><th><label>Follow Button</label></th><td>
            <div class='togglebox'>
                    <input name=\"Lazy_JTweet_FollowButton\" type='checkbox' value=\"true\" ";
                    if($tsettings["followbutton"]=="true")
                        echo "checked";
                    echo " id='chkbxaf'>
                     <label for='chkbxaf'><b></b></label>
            </div>
            </td><td colspan=\"3\" class='msg'>Display  <strong> Follow Us Button </strong> at bottom of Tweet Display.</td></tr>
            
    ";
    echo "</table>";
    echo "</td></tr></table>";  
    
    
                            
						break;
						case 'theme' : 
							
							
                            
                                echo "<table><tr><td>";
    echo "<h3><font color='gray'>Tweet Theme Designing</font></h3>";
    echo "<table class='Lazy_JTweet_Table'>
    <tr><th><label>Background Color</label></th><td><input type=\"text\" value='".$tsettings["background"]."' class=\"wp-color-picker-field\" data-default-color=\"#ffffff\" name='Lazy_JTweet_Background' /></td><td colspan='3' class='msg'>The hexadecimal color chosen by the user for their <strong>tweet background</strong>.</td></tr>
    <tr><th><label>Tweet Text Color</label></th><td><input type=\"text\" value='".$tsettings["fontcolor"]."' class=\"wp-color-picker-field1\" data-default-color=\"#ffffff\" name='Lazy_JTweet_FontColor' /></td><td colspan='3' class='msg'>The hexadecimal color the user has chosen to display text with in their <strong>Tweet</strong>.</td></tr>
    <tr><th><label>Time Zone Color</label></th><td><input type=\"text\" value='".$tsettings["timecolor"]."' class=\"wp-color-picker-field1\" data-default-color=\"#ffffff\" name='Lazy_JTweet_TimeColor' /></td><td colspan='3' class='msg'>The hexadecimal color the user has chosen to display text with in <strong>Timestamp<strong>.</td></tr>
    <tr><th><label>Border</label></th><td><select class='small_text' name=\"Lazy_JTweet_Border\"><option>".$tsettings["borderstyle"]."</option><option>solid</option><option>dotted</option><option>double</option><option>dashed</option></select></td><td><input class='small_text' type='text' name='Lazy_JTweet_Border_Size' value='".$tsettings["bordersize"]."' /></td><td><input type=\"text\" value='".$tsettings["bordercolor"]."' class=\"wp-color-picker-field\" data-default-color=\"#ffffff\" name='Lazy_JTweet_Border_Color' /></td></tr>
    <tr><th><label>Box</label></th><td>X&nbsp;<input class='small_box' type='text' name='Lazy_JTweet_Box_X' value='".$tsettings["boxx"]."' />&nbsp;&nbsp;&nbsp;Y&nbsp;<input class='small_box' type='text' name='Lazy_JTweet_Box_Y' value='".$tsettings["boxy"]."' /></td><td><input class='small_text' type='text' name='Lazy_JTweet_Box_Spred_Size' value='".$tsettings["boxspred"]."' /></td><td><input type=\"text\" value='".$tsettings["boxscolor"]."' class=\"wp-color-picker-field\" data-default-color=\"#ffffff\" name='Lazy_JTweet_Box_Shadow_Color' /></td><td></td></tr>
    <tr><th>Retweet Button</th>
    <td><div class='togglebox'>
        <input name=\"Lazy_JTweet_Retweet\" type='checkbox' value=\"true\" ";
        if($tsettings["retweet"]=="true")
            echo "checked";
        echo " id='retweet'>
         <label for='retweet'><b></b></label>
       </div></td>
    <td><input type=\"text\" value='".$tsettings["retweetcolor"]."' class=\"wp-color-picker-field\" data-default-color=\"#ffffff\" name='Lazy_JTweet_Retweet_Background' /></td><td class='msg' colspan='2'>Indicates whether this Tweet has been <strong>Retweeted</strong> by the authenticating user. </td></tr>
    <tr><th>Share Button</th>
    <td><div class='togglebox'>
        <input name=\"Lazy_JTweet_Share\" type='checkbox' value=\"true\" ";
        if($tsettings["share"]=="true")
            echo "checked";
        echo " id='share'>
         <label for='share'><b></b></label>
       </div></td>
    <td><input type=\"text\" value='".$tsettings["sharecolor"]."' class=\"wp-color-picker-field\" data-default-color=\"#ffffff\" name='Lazy_JTweet_Share_Background' /></td><td class='msg' colspan='2'>Indicates whether this Tweet has been <strong>Shared</strong> by the authenticating user. </td></tr>
    <tr><th>Favorite Button</th>
    <td><div class='togglebox'>
        <input name=\"Lazy_JTweet_Fevorite\" type='checkbox' value=\"true\" ";
        if($tsettings["fevorite"]=="true")
            echo "checked";
        echo " id='fevorite'>
         <label for='fevorite'><b></b></label>
       </div></td>
    <td><input type=\"text\" value='".$tsettings["fevoritecolor"]."' class=\"wp-color-picker-field\" data-default-color=\"#ffffff\" name='Lazy_JTweet_Fevorite_Background' /></td><td class='msg' colspan='2'>Indicates whether this Tweet has been <strong>Favorited</strong> by the authenticating user. </td></tr>
    <tr><th>Retweet Show Count</th>
         <td><div class='togglebox'>
                    <input name=\"Lazy_JTweet_Retweet_Count\" type='checkbox' value=\"true\" ";
                    if($tsettings["retweetcount"]=="true")
                        echo "checked";
                    echo " id='rcount'>
                     <label for='rcount'><b></b></label>
                   </div></td>
    <td><input type=\"text\" value='".$tsettings["retweetcountcolor"]."' class=\"wp-color-picker-field\" data-default-color=\"#ffffff\" name='Lazy_JTweet_Retweet_TextColor' /></td><td class='msg' colspan='2'>The Number of times this Tweet has been <strong>Retweeted</strong>.</td></tr>
    <tr><th>Favorite Show Count</th>
        <td><div class='togglebox'>
                    <input name=\"Lazy_JTweet_Favorite_Count\" type='checkbox' value=\"true\" ";
                    if($tsettings["favoritecount"]=="true")
                        echo "checked";
                    echo " id='fcount'>
                     <label for='fcount'><b></b></label>
                   </div></td>
    <td><input type=\"text\" value='".$tsettings["favoritecountcolor"]."' class=\"wp-color-picker-field\" data-default-color=\"#ffffff\" name='Lazy_JTweet_Favorite_TextColor' /></td><td colspan=\"2\" class='msg'>The number of tweets this user has <strong>Favorited</strong> in the account's lifetime. </td></tr>
    <tr><th>Avatar Button</th>
    <td><div class='togglebox'>
        <input name=\"Lazy_JTweet_Avatar\" type='checkbox' value=\"true\" ";
        if($tsettings["avatar"]=="true")
            echo "checked";
        echo " id='avatar'>
         <label for='avatar'><b></b></label>
       </div></td>
    <td><select class='small_text' name=\"Lazy_JTweet_Avatar_Shape\"><option>".$tsettings["avatarshape"]."</option><option>square</option><option>round</option></select></td><td class='msg' colspan='2'>Set Your <strong>Avatar in Tweet</strong>, indicates that the user has not uploaded their own avatar and a default egg avatar is used instead. </td></tr>
    ";
    
    echo "</table>";
    echo "</td></tr></table>
    
    <script>
    jQuery(document).ready(function($){
    $('.wp-color-picker-field').wpColorPicker();
    $('.wp-color-picker-field1').wpColorPicker();
    
});
    </script>
    ";  
   
                            
						break;
                        case 'custom' : 
							echo "<table><tr><td>";
                            echo "<h3><font color='gray'>Tweet Theme Designing</font></h3>";
                            echo "<table class='Lazy_JTweet_Table'>";
                            echo "<tr><td>Custom CSS</td><td>
                            <select id='css-name'>
                            <option value='.username'>User Name</option>
                            <option value='.tweet img.avatar'>Avatar Image</option>
                            <option value='.tweet p.content'>Tweet Text</option>
                            <option value='.retweet'>Retweet Icon</option>
                            <option value='.favorite'>Favorite Icon</option>
                            <option value='.share'>Share Icon</option>
                            <option value='.time'>Tweet Time</option>
                            <option value='.retcount'>Retweet Counts</option>
                            <option value='.favcount'>Favorite Counts</option>
                            <option value='.entry-content'>Main Display Area</option>
                            <option value='.entry-content li'>Tweet Box Layout</option>
                            </select><input type='text' name='css-value' id='css-value' placeholder='css : value; css : value' /><button id='add-css' type='button' >Add Css</button>
                            <textarea  name='customtheme' id='customtheme' class='bigarea'>".$tsettings["customtheme"]."</textarea></td><td>Select inbuit css tags and add your custome css as your choise. <br/> also can add your custome tags for custome design and set CSS.</td></tr>";
                            echo "<tr><td>Custom Template</td><td><textarea type='text' name='customtemplate' class='bigarea'>".$tsettings["customtemplate"]."</textarea></td><td>Our Template formate : <br/>";
                            echo "<xmp><li class=\"tweet bounce animated\">
    <img class=\" avatar \" />
    <a href=\"\" class=\"username\"></a>
    <a href=\"\" class=\"time\"></a>
    <p class=\"content\"></p>
    <a href=\"\"  class=\" retcount retweetcount \"></a>
    <a href=\"\"  class=\"favcount favouritescount \"></a>
    <a class=\"favorite share_left\" href=\"\"><i class=\"fa fa-star fa-2\"></i></a>
    <a class=\"retweet share_left\" href=\"\"><i class=\"fa fa-retweet fa-2\"></i></a>
    <a href=\"\" class=\"reaply share_left\"><i class=\"fa fa-share-alt  fa-2 \"></i></a>
</li>
Copy and past this code into edito and add or append custom tags in it.
Note: please maintain class and tage you can change sequence and add your custome tag in it also add custome CSS above for change design 
</xmp>";
                            echo "</td></tr>";
                            echo "</table></td></tr></table>";
                            
                        break;    
					}
					echo "</table>
                    <script>
                    jQuery(document).ready(function($){
                    $('#add-css').click(function(){
                       
                        var cls =  $('#css-name').val();
                        var clsval = $('#css-value').val();
                        if(cls!='' && clsval!='')
                        {
                            
                            $('#customtheme').val($('#customtheme').val()+''+cls+'{'+clsval+'}');    
                        }
                    });
                    });
                    </script>
                    ";
				}
				?>
				<p class="submit" style="clear: both;">
					<input type="submit" name="savedata"  class="button-primary" value="Update Settings" />
					<input type="hidden" name="ilc-settings-submit" value="Y" />
				</p>
			</form>
			
			<div>
            <a href="https://twitter.com/wayanimtweet" target="_blank">follow Way Tweet</a> | <a href="http://waywebsolution.com/plugins/lazytweet/" target="_blank">Demo</a> |  <a href="http://waywebsolution.com/plugins/lazytweet/" target="_blank">Video Tutorial</a> | <a href="http://waywebsolution.com/plugins/lazytweet/animdoc/documentation/" target="_blank">Documents</a>
            </div>
		<table>
                <tr><td><? echo getPayuMoney();  ?></td><td><? echo getPaypalPayment(); ?></td></tr>
            </table>
            
		</div>

	</div>
<?php
}

function getPaypalPayment()
{
    $return = '<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="EGAML2CECP5H6">
<input type="image" src="'.TWT_PLUGIN_PATH.'img/paypal_donate_button.jpg" border="0" name="submit" alt="PayPal – The safer, easier way to pay online.">
<img alt="" border="0" src="https://www.paypalobjects.com/en_GB/i/scr/pixel.gif" width="1" height="1">
</form>';
    return $return;
}
function getPayuMoney()
{
    $return = '<div class="pm-button"><a href="https://www.payumoney.com/paybypayumoney/#/BD846772260A1B5625E1BF846988A1A6"><img src="https://www.payumoney.com//media/images/payby_payumoney/buttons/111.png" /></a></div>';
    return $return;
}
?>
