<?php session_start();
/**
 * Plugin Name: Way Tweet
 * Plugin URI: http://www.waywebsolution.com/plugins/lazytweet
 * Description: Way Animation Tweet for your wordpress website. Easy to customize and use.
 * Version: 1.0
 * Author: Way Web Solution
 * Author URI: http://www.waywebsolution.com
 * License: A "Slug" license name e.g. GPL2
 */
register_activation_hook(__FILE__,'wtp_admin_init');
add_action( 'init', 'wtp_admin_init' );
function wtp_admin_init() {
	$settings = get_option( "wtp_theme_settings" );
	if ( empty( $settings ) ) {
		$settings = array(
			'wtp_intro' => 'Some intro text for the home page',
			'wtp_tag_class' => false,
			'wtp_ga' => false
		);
		add_option( "wtp_theme_settings", $settings, '', 'yes' );
    }
      $tweetoptions = get_option( "wtp_tweet_settings" );
     if ( empty( $tweetoptions ) ) {   
        $tweetoptions = array(
'apikey'=>'',
'apisecret'=>'',
'accesstoken'=>'',
'accesssecret'=>'',
'username'=>'',
'count'=>3,
'searchapi'=>"statuses/user_timeline",
'query'=>"",
'filter'=>"",
'background'=>"#ffffff",
'frontcolor'=>"#484848",
'timecolor'=>"#282828",
'borderstyle'=>"slid",
'bordersize'=>"1",
'bordercolor'=>"#e5e5e5",
'boxx'=>"1",
'boxy'=>"1",
'boxspred'=>"3",
'boxscolor'=>"#484848",
'retweet'=>true,
'retweetcolor'=>"#484848",
'share'=>true,
'sharecolor'=>"#484848",
'fevorite'=>true,
'fevoritecolor'=>"#484848",
'avatar'=>true,
'avatarshape'=>"square",
'geolatitude'=>"",
'geolongitude'=>"",
'geoarea'=>"",
'refresh'=>true,
'interval'=>5,
'animation'=>true,
'animationtype'=>"bounce",
'retweetcount'=>true,
'retweetcountcolor'=>"#484848",
'favoritecount'=>true,
'favoritecountcolor'=>"#484848",
'customtheme'=>"",
'customtemplate'=>"",
'followbutton'=>true
);
add_option( "wtp_tweet_settings", $tweetoptions, '', 'yes' );
	}	
}

if(!function_exists('wtp_admin_jquery')) {
	function wtp_admin_jquery() { 	

		wp_register_style('wtp_admin_css' , plugins_url('css/style.css' , __FILE__)) ; 
		wp_enqueue_style('wtp_admin_css');
       
	}
	add_action('admin_head' , 'wtp_admin_jquery');
}
if ( is_admin() )
	require_once dirname( __FILE__ ) . '/admin/settings.php';
 
 
function way_tweet_load_script(){
  wp_register_style ('wattweetcss', plugin_dir_url( __FILE__ )."animation/css/animate.css", array(),'2','all');
  wp_register_style ('font-awesome', "//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css", array(),'2','all');
  wp_enqueue_script( 'tweet', plugin_dir_url( __FILE__ )."js/tweetMachine.js",array(),'1.0.0',true);  
  wp_enqueue_style( 'wattweetcss');
  wp_enqueue_style( 'font-awesome');
}
add_action( 'wp_enqueue_scripts', 'way_tweet_load_script' );

add_shortcode( "WayTweet" , 'short_code_waytweet' );

function short_code_waytweet($attr){
    
    $ao = get_option("wtp_tweet_settings");
    $_SESSION["apikey"] = $ao["apikey"];
    $_SESSION["apisecret"] = $ao["apisecret"];
    $_SESSION["accesstoken"] = $ao["accesstoken"];
    $_SESSION["accesssecret"] = $ao["accesssecret"];

    
    $a = shortcode_atts( get_option("wtp_tweet_settings",true), $attr );
    
        
   $returnText="<ol class=\"tweets\"></ol>"; 
   if($a["followbutton"]){
    $returnText.="<div class=\"JTbutton\">
            <a href=\"https://twitter.com/".$a["username"]."\" class=\"twitter-follow-button \" data-show-count=\"false\" data-size=\"large\"><i class='fa fa-twitter btn-icon'></i> Follow @".$a["username"]."</a>
    </div>
";
   }
    
   $returnText.= "<script>jQuery(document).ready(function(){";
    if($a["filter"]==""){
        $returnText.="var neglectList = [\"frack\", \"sex\", \"darn\", \"gosh\", \"shucks\", \"shoot\", \"dang\", \"fudge\", \"mother trucker\", \"fuck\", \"nude\"];";    
    }else
    {
       $returnText.="var neglectList = ".json_encode(explode(',',$a["filter"])).";";   
    }
    
    $returnText.="
 
            jQuery('.tweets').tweetMachine('".$a["query"]."' ,{
                backendScript : '".plugin_dir_url( __FILE__ )."ajax/getFromTwitter.php',
                endpoint: '".$a["searchapi"]."',
                user_name: '".$a["username"]."',
                
                geo_enabled: true,
                geocode: '".$a["geolatitude"].",".$a["geolongitude"].",".$a["geoarea"]."',
                limit: '".$a["count"]."',
                autoRefresh: '".$a["refresh"]."',
                rate: '".$a["interval"]."000',
                avatarShape : '".$a["avatarshape"]."',
                tweetFormat: '".Way_JTweet_Template($a)."',
                filter: function(tweet) {
                        var swear, i, leng;
                        // Loop through the swears in the list
                        for ( i = 0, leng = neglectList.length; i < leng; i++ ) {
                            swear = neglectList[i];
                            // If the tweet's text has the swear in it
                            if (tweet.text.indexOf(swear) !== -1) {
                                // Don't show it
                                return false;
                            }
                        }
                        // If it hasn't had any swears, show it
                        return true;
                    }
            });
       });
                </script>
                
     <style type=\"text/css\">
        .JTbutton { text-align:center; }
        
        .JTbutton .twitter-follow-button  {
  position: relative;
  display: inline-block;
  
  padding: 5px 10px;
  border: 1px solid #ccc;
  font-size: 14px;
  color: #333;
  text-decoration: none;
  text-shadow: 0 1px 0 rgba(255, 255, 255, .5);
  font-weight: bold;
  background-color: #F8F8F8;
  background-image: -webkit-gradient(linear,left top,left     bottom,from(#FFF),to(#DEDEDE));
  background-image: -moz-linear-gradient(top,#FFF,#DEDEDE);
  background-image: -o-linear-gradient(top,#FFF,#DEDEDE);
  background-image: -ms-linear-gradient(top,#FFF,#DEDEDE);
  border: #CCC solid 1px;
  -moz-border-radius: 3px;
  -webkit-border-radius: 3px;
  border-radius: 3px;
  cursor: pointer;
  
}

.JTbutton .twitter-follow-button:hover {
  border-color: #BBB;
  background-color: #F8F8F8;
  background-image: -webkit-gradient(linear,left top,left bottom,from(#F8F8F8),to(#D9D9D9));
  background-image: -moz-linear-gradient(top,#F8F8F8,#D9D9D9);
  background-image: -o-linear-gradient(top,#F8F8F8,#D9D9D9);
  background-image: -ms-linear-gradient(top,#F8F8F8,#D9D9D9);
  background-image: linear-gradient(top,#F8F8F8,#D9D9D9);
  -webkit-box-shadow: none;
  -moz-box-shadow: none;
  box-shadow: none;
}
.JTbutton .twitter-follow-button  .btn-icon{
  
  font-size : 18px;
  color :#00acee;
  
  
  
}
.JTbutton .twitter-follow-button  .btn-text{
  display: inline-block;
  padding: 1px 3px 0 20px;
}
           
        ol {
            list-style: none;
            margin: 0;
            padding: 0;
            color : ".$a["frontcolor"].";
        }
        img.round { border-radius:50%; margin-right: 10px; }
        img.square { border-radius:5%; margin-right: 10px; }
        
        .username{ 
            margin-left: 5px;
            font:italic bold 12px/30px Georgia, serif;
            font-weight: bold;
            text-shadow: 0 0 2px #e5e5e5;
        }
        .tweet { 
            
            padding-left: 0px; 
            padding: 5px;
            list-style:none; 
            box-shadow: ".$a["boxx"]."px ".$a["boxy"]."px ".$a["boxspred"]."px ".$a["boxscolor"].";
            border-radius: 6px;
            font-family: sans-serif serif;
            font-size: 15px;
            font-weight: 500;
            }
        .content{ 
            font:  12px/30px Georgia, serif;
          }
        .time{
            float: right;
            color:".$a["timecolor"].";
        }
        .share_left{
            float: right;
            padding-right:5px;
               }
        .reaply{ color: ".$a["sharecolor"]."; }
        .favorite{ color: ".$a["fevoritecolor"]."; }
        .retweet{ color: ".$a["retweetcolor"]."; }
        .retcount{ color:".$a["retweetcount"].";}
        .favcount{ color:".$a["favoritecount"]."; }
        .entry-content li { 
            margin: 7px;
            padding-left: 8px; 
            list-style:none; 
            background: ".$a["background"].";
            border: ".$a["bordersize"]."px ".$a["borderstyle"]." ".$a["bordercolor"].";
            border-radius: 10px;
            }
        .avatar {  float:left; display:block; width:48px; height:48px;  margin-right:8px; margin-top: 5px; margin-bottom: 5px; }
        .avatar img { }
        .twitter-follow-button {  margin:0px auto 10px;  text-align:center; } 
        ".$a["customtheme"]."
                </style>
     
    ";
return $returnText;
    
}

function Way_JTweet_Template($a=null)
{
  if($a["customtemplate"]!=""){
    $template = $a["customtemplate"];
  }else
  {
    

  $template ="<li class=\"tweet ";
   if ($a["animation"]=="true")
           $template.=$a["animationtype"]." animated";

    $template.=" \"><img class=\" ";
         if ($a["avatar"]=="true")
            $template.="avatar";
    $template.=" \" /><div class=\"meta\"><a href=\"\" class=\"username\"></a><a href=\"\" class=\"time\"></a></div><p class=\"content\"></p><a href=\"\"  class=\" retcount ";
        if ($a["retweetcount"]=="true")
            $template.="retweetcount";
    $template.=" \"></a>&nbsp;&nbsp;<a href=\"\"  class=\"favcount ";
        if ($a["favoritecount"]=="true")
            $template.="favouritescount";
    $template.=" \"></a><a class=\"favorite share_left\" href=\"\">";
        if ($a["fevorite"]=="true")
            $template.="<i class=\"fa fa-star fa-2\"></i>";
    $template.="</a><a class=\"retweet share_left\" href=\"\">";
        if ($a["retweet"]=="true")
            $template.="<i class=\"fa fa-retweet fa-2\"></i>";    
    $template.="</a><a href=\"\" class=\"reaply share_left\">";
        if ($a["share"]=="true")
            $template.="<i class=\"fa fa-share-alt  fa-2 \"></i>";    
    $template.="</a></li>";
    }
    return $template;
}


add_action( 'widgets_init', function(){
     register_widget( 'Lazy_JTweet_Widget' );
});


class Lazy_JTweet_Widget extends WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		// widget actual processes
        parent::__construct(
			'Lazy_JTweet_Widget', // Base ID
			__('Way Tweet', 'Way Tweet'), // Name
			array( 'description' => __( 'Way Tweet is a jQuery based Animated Real Tweeter Plugin', 'www.waywebsolution.com' ), ) // Args
		);
	}
    

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		// outputs the content of the widget
        
        $title = apply_filters( 'widget_title', $instance['title'] );

		echo $args['before_widget'];
		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}
        
   $a = get_option("wtp_tweet_settings",true);         
        
   $returnText="";
    $returnText .= "<div class=\"way_widget\">
                <ol class=\"way_widget_tweet\"></ol>";
                if($a["followbutton"]){
    $returnText.="<div class=\"JTbutton\">
            <a href=\"https://twitter.com/".$a["username"]."\" class=\"twitter-follow-button \" data-show-count=\"false\" data-size=\"large\"><i class='fa fa-twitter btn-icon'></i> Follow @".$a["username"]."</a>
    </div>
";
   }
                 
   $returnText.="</div>
    
    <script>";
    if($a["filter"]==""){
        $returnText.="var neglectList2 = [\"frack\", \"sex\", \"darn\", \"gosh\", \"shucks\", \"shoot\", \"dang\", \"fudge\", \"mother trucker\", \"fuck\", \"nude\"];";    
    }else
    {
       $returnText.="var neglectList2 = ".json_encode(explode(',',$a["filter"])).";";   
    }
    
    $returnText.="jQuery(document).ready(function(){
            jQuery('.way_widget_tweet').tweetMachine('".$a["query"]."' ,{
                backendScript : '".plugin_dir_url( __FILE__ )."ajax/getFromTwitter.php',
                endpoint: '".$a["searchapi"]."',
                user_name: '".$a["username"]."',
                
                geo_enabled: true,
                geocode: '".$a["geolatitude"].",".$a["geolongitude"].",".$a["geoarea"]."',
                limit: '".$a["count"]."',
                autoRefresh: '".$a["refresh"]."',
                rate: '".$a["interval"]."000',
                avatarShape : '".$a["avatarshape"]."',
                tweetFormat: '".Way_JTweet_Template($a)."',
                filter: function(tweet) {
                        var swear, i, len;
                        // Loop through the swears in the list
                        for ( i = 0, len = neglectList2.length; i < len; i++ ) {
                            swear = neglectList2[i];
                            // If the tweet's text has the swear in it
                            if (tweet.text.indexOf(swear) !== -1) {
                                // Don't show it
                                return false;
                            }
                        }
                        // If it hasn't had any swears, show it
                        return true;
                    }
            });
            });
                </script>";
   
    echo $returnText;

        
		//echo short_code_jTweet();
		echo $args['after_widget'];
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
		// outputs the options form on admin
        
        if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'New title', 'text_domain' );
		}
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<?php 
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 */
	public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved
        $instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

		return $instance;
	}
}
add_action('init', 'lazy_jtweet_button_init');
 function lazy_jtweet_button_init() {

      //Abort early if the user will never see TinyMCE
      if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') && get_user_option('rich_editing') == 'true')
           return;

      //Add a callback to regiser our tinymce plugin   
      add_filter("mce_external_plugins", "lazy_jtweet_register_tinymce_plugin"); 

      // Add a callback to add our button to the TinyMCE toolbar
      add_filter('mce_buttons', 'lazy_jtweet_add_tinymce_button');
}


//This callback registers our plug-in
function lazy_jtweet_register_tinymce_plugin($plugin_array) {
    $plugin_array['lazy_jtweet_button'] = plugin_dir_url( __FILE__ ).'js/shortcode.js';
    return $plugin_array;
}

//This callback adds our button to the toolbar
function lazy_jtweet_add_tinymce_button($buttons) {
            //Add the button ID to the $button array
    $buttons[] = "lazy_jtweet_button";
    return $buttons;
}


?>