jQuery(document).ready(function($) {

    tinymce.create('tinymce.plugins.lazy_jtweet_plugin', {
        init : function(ed, url) {
                // Register command for when button is clicked
                ed.addCommand('lazy_jtweet_insert_shortcode', function() {
/*                    selected = tinyMCE.activeEditor.selection.getContent();

                    if( selected ){
                        //If text is selected when button is clicked
                        //Wrap shortcode around it.
                        content =  '[shortcode]'+selected+'[/shortcode]';
                    }else{
                        content =  '[shortcode]';
                    }

                    tinymce.execCommand('mceInsertContent', false, content);
                    */
/*                    ed.windowManager.open( {
    title: 'Container',
    body: [{
        type: 'listbox',
        name: 'style',
        label: 'Style',
        'values': [
            {text: 'Clear', value: 'clear'},
            {text: 'White', value: 'white'},                
            {text: 'Colour 1', value: 'colour1'},
            {text: 'Colour 2', value: 'colour2'},
            {text: 'Colour 3', value: 'colour3'},
        ]
    },{ type: 'text', name: 'background', label : 'Background' }],
    onsubmit: function( e ) {
        ed.insertContent( '[container style="' + e.data.style + '"]<br /><br />[/container]');
    }
}); */

	var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
						W = W - 80;
						H = H - 84;
						tb_show( 'Lazy Tweet Shortcode', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=lazy-tweet-form' );
                });

            // Register buttons - trigger above command when clicked
            ed.addButton('lazy_jtweet_button', {title : 'Insert shortcode', cmd : 'lazy_jtweet_insert_shortcode', image: url + '/../css/icons-34.png' });
        },   
    });

    // Register our TinyMCE plugin
    // first parameter is the button ID1
    // second parameter must match the first parameter of the tinymce.create() function above
    tinymce.PluginManager.add('lazy_jtweet_button', tinymce.plugins.lazy_jtweet_plugin);
    
    
    jQuery(function(){
		// creates a form to be displayed everytime the button is clicked
		// you should achieve this using AJAX instead of direct html code like this
		var form = jQuery('<div id="lazy-tweet-form"><table id="lazy-tweet-table" class="form-table">\
            <tr>\
				<th><label for="lazy-tweet-searchapi">Api Resource</label></th>\
				<td><select name="searchapi" id="lazy-tweet-searchapi">\
                <option value="search/tweets">Search Tweet</option>\
                <option value="statuses/user_timeline">Time Line</option>\
                </select></td>\
				<td><small>specify the of Tweets to show.</small></td>\
			</tr>\
            <tr>\
				<th><label for="lazy-tweet-query">Search Query</label></th>\
				<td><input type="text" id="lazy-tweet-query" name="query" /></td>\
				<td><small>specify filter on search.</small></td>\
			</tr>\
			<tr>\
				<th><label for="lazy-tweet-count">Feed Count</label></th>\
				<td><input type="text" id="lazy-tweet-count" name="count" /></td>\
				<td><small>specify the number of Tweets to show.</small></td>\
			</tr>\
            <tr>\
				<th><label for="lazy-tweet-refresh">Auto Refresh</label></th>\
				<td><input type="checkbox" id="lazy-tweet-refresh" name="refresh" value="true" /></td>\
				<td><small>automatically refresh tweet or not.</small></td>\
			</tr>\
            <tr>\
				<th><label for="lazy-tweet-interval">Refresh Second</label></th>\
				<td><input type="number" id="lazy-tweet-interval" name="interval" /></td>\
				<td><small>specify the number of Refreshing tweet interval.</small></td>\
			</tr>\
            <tr>\
				<th><label for="lazy-tweet-animation">Need Animation</label></th>\
				<td><input type="checkbox" id="lazy-tweet-animation" name="animation" value="true"  /></td>\
				<td><small>Animation with tweet refresh</small></td>\
			</tr>\
            <tr>\
				<th><label for="lazy-tweet-animationtype">Animation Type</label></th>\
				<td><select class="small_text" name="animationtype" id="lazy-tweet-animationtype">\
                    <optgroup label="Attention Seekers">\
                      <option value="bounce">bounce</option>\
                      <option value="flash">flash</option>\
                      <option value="pulse">pulse</option>\
                      <option value="rubberBand">rubberBand</option>\
                      <option value="shake">shake</option>\
                      <option value="swing">swing</option>\
                      <option value="tada">tada</option>\
                      <option value="wobble">wobble</option>\
                    </optgroup>\
                    <optgroup label="Bouncing Entrances">\
                      <option value="bounceIn">bounceIn</option>\
                      <option value="bounceInDown">bounceInDown</option>\
                      <option value="bounceInLeft">bounceInLeft</option>\
                      <option value="bounceInRight">bounceInRight</option>\
                      <option value="bounceInUp">bounceInUp</option>\
                    </optgroup>\
                     <optgroup label="Fading Entrances">\
                      <option value="fadeIn">fadeIn</option>\
                      <option value="fadeInDown">fadeInDown</option>\
                      <option value="fadeInDownBig">fadeInDownBig</option>\
                      <option value="fadeInLeft">fadeInLeft</option>\
                      <option value="fadeInLeftBig">fadeInLeftBig</option>\
                      <option value="fadeInRight">fadeInRight</option>\
                      <option value="fadeInRightBig">fadeInRightBig</option>\
                      <option value="fadeInUp">fadeInUp</option>\
                      <option value="fadeInUpBig">fadeInUpBig</option>\
                    </optgroup>\
                     <optgroup label="Flippers">\
                      <option value="flip">flip</option>\
                      <option value="flipInX">flipInX</option>\
                      <option value="flipInY">flipInY</option>\
                     </optgroup>\
                     <optgroup label="Lightspeed">\
                      <option value="lightSpeedIn">lightSpeedIn</option>\
                     </optgroup>\
                    <optgroup label="Rotating Entrances">\
                      <option value="rotateIn">rotateIn</option>\
                      <option value="rotateInDownLeft">rotateInDownLeft</option>\
                      <option value="rotateInDownRight">rotateInDownRight</option>\
                      <option value="rotateInUpLeft">rotateInUpLeft</option>\
                      <option value="rotateInUpRight">rotateInUpRight</option>\
                    </optgroup>\
                    <optgroup label="Specials">\
                      <option value="rollIn">rollIn</option>\
                    </optgroup>\
                    <optgroup label="Zoom Entrances">\
                      <option value="zoomIn">zoomIn</option>\
                      <option value="zoomInDown">zoomInDown</option>\
                      <option value="zoomInLeft">zoomInLeft</option>\
                      <option value="zoomInRight">zoomInRight</option>\
                      <option value="zoomInUp">zoomInUp</option>\
                    </optgroup>\
            </select></td>\
				<td><small>specify the number of Refreshing tweet interval.</small></td>\
			</tr>\
            <tr>\
				<th><label for="lazy-tweet-retweet">Retweet Icon</label></th>\
				<td><input type="checkbox" id="lazy-tweet-retweet" name="retweet" value="true"  /></td>\
				<td><small>Animation with tweet refresh</small></td>\
			</tr>\
            <tr>\
				<th><label for="lazy-tweet-share">Share Icon</label></th>\
				<td><input type="checkbox" id="lazy-tweet-share" name="share" value="true"  /></td>\
				<td><small>Animation with tweet refresh</small></td>\
			</tr>\
            <tr>\
				<th><label for="lazy-tweet-fevorite">Favorite Icon</label></th>\
				<td><input type="checkbox" id="lazy-tweet-fevorite" name="fevorite" value="true"  /></td>\
				<td><small>Animation with tweet refresh</small></td>\
			</tr>\
            <tr>\
				<th><label for="lazy-tweet-retweetcount">Retweet Count</label></th>\
				<td><input type="checkbox" id="lazy-tweet-retweetcount" name="retweetcount" value="true"  /></td>\
				<td><small>Animation with tweet refresh</small></td>\
			</tr>\
            <tr>\
				<th><label for="lazy-tweet-favoritecount">Favourite Count</label></th>\
				<td><input type="checkbox" id="lazy-tweet-favoritecount" name="favoritecount" value="true"  /></td>\
				<td><small>Animation with tweet refresh</small></td>\
			</tr>\
            <tr>\
				<th><label for="lazy-tweet-avatar">Avatar Image</label></th>\
				<td><input type="checkbox" id="lazy-tweet-avatar" name="avatar"  value="true" /></td>\
				<td><small>Animation with tweet refresh</small></td>\
			</tr>\
            <tr>\
				<th><label for="lazy-tweet-avatarshape">Avatar Shape</label></th>\
				<td><select name="avatarshape" id="lazy-tweet-avatarshape">\
                <option value="square">Square</option>\
                <option value="round">Round</option>\
                </select></td>\
				<td><small>specify the of Tweets to show.</small></td>\
			</tr>\
		</table>\
		<p class="submit">\
			<input type="button" id="lazy-tweet-submit" class="button-primary" value="Insert Gallery" name="submit" />\
		</p>\
		</div>');
		
		var table = form.find('table');
		form.appendTo('body').hide();
		
		// handles the click event of the submit button
		form.find('#lazy-tweet-submit').click(function(){
			// defines the options and their default values
			// again, this is not the most elegant way to do this
			// but well, this gets the job done nonetheless
			var options = {
                'searchapi' : 'statuses/user_timeline',
                'query' : '',
				'count'    : '3',
				'refresh': false,
				'interval': '5',
				'animation': false,
				'animationtype' : 'bounce',
                'retweet' : false,
                'share': false,
				'fevorite': false,
				'avatar': false,
                'avatarshape' : 'round',
                'retweetcount' : false,
                'favoritecount' : false
				};
			var shortcode = '[WayTweet ';
			
			for(var index in options) {
				var value = table.find('#lazy-tweet-' + index).val();
				// attaches the attribute to the shortcode only if it's different from the default value
               
                if(table.find('#lazy-tweet-' + index).attr('type') == "checkbox")
                {
                   
                    if(table.find('#lazy-tweet-' + index).is(':checked'))
                    {
                        shortcode += ' ' + index + '="' + value + '"';
                    }else
                    {
                        shortcode += ' ' + index + '="false"';
                    } 
                }else{
				if ( value !== options[index] && value!='' )
				shortcode += ' ' + index + '="' + value + '"';
                }
			}			
			shortcode += ']';
			
			// inserts the shortcode into the active editor
			tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);
			
			// closes Thickbox
			tb_remove();
		});
	});
    
    
});