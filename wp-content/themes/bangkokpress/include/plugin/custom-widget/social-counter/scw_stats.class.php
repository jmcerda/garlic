<?php
function get_url_contents($url){
        $crl = curl_init();
        $timeout = 5;
        curl_setopt ($crl, CURLOPT_URL,$url);
        curl_setopt ($crl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($crl, CURLOPT_CONNECTTIMEOUT, $timeout);
        $ret = curl_exec($crl);
        curl_close($crl);
        return $ret;
}

class SubscriberStats{

	public	$twitter,$rss,$facebook;
	public	$services = array();

	public function __construct($arr){

		$this->services = $arr;

		// Building an array with queries:

		if(trim($arr['feedBurnerURL'])) {
            $query = 'http://feedburner.google.com/api/awareness/1.0/GetFeedData?uri='.end(split('/',trim($arr['feedBurnerURL'],'/')));
            $xml = get_url_contents($query);
            $profile = new SimpleXmlElement($xml, LIBXML_NOCDATA);
			$new_rss = $profile->feed->entry['circulation'];
			
			if( empty($new_rss) || $new_rss == 0 || $new_rss == '0' ){ $this->rss = $arr['rss'];
			}else{ $this->rss = (string) $new_rss; }
        }
		if(trim($arr['twitterName'])) {
			$query = 'http://api.twitter.com/1/users/show.json?screen_name='.$arr['twitterName'];
            $result = json_decode(get_url_contents($query));
			$new_twitter = $result->followers_count;		
			
			if( empty($new_twitter) || $new_twitter == 0 || $new_twitter == '0' ){ $this->twitter = $arr['twitter'];
			}else{ $this->twitter = $new_twitter; }			
        }
		if(trim($arr['facebookFanPageURL'])) {
            $fb_id = basename($arr['facebookFanPageURL']);
			$query = 'http://graph.facebook.com/'.urlencode($fb_id);
			$result = json_decode(get_url_contents($query));
			$new_facebook = $result->likes;
			
			if( empty($new_facebook) || $new_facebook == 0 || $new_facebook == '0' ){ $this->facebook = $arr['facebook'];
			}else{ $this->facebook = $new_facebook; }			
            
        }

        //Grab Delicious
       /* $url = 'www.queness.com'; 
        $api_page = 'http://feeds.delicious.com/v2/json/urlinfo/data?url=%20www.queness.com';
        $json = file_get_contents ( $api_page );
        $json_output = json_decode($json, true);
        $data['delicious'] = $json_output[0]['total_posts'];*/
	}

	public function generate(){
		$total = number_format($this->rss+$this->twitter+$this->facebook);

		//echo '<div class="bkp-frame-wrapper">';
		//echo '<div class="bkp-frame p0">';		
        ?>
        <div id="socialCounterWidget" class="socialCounterWidget">
            <?php if($this->services['feedBurnerURL']) { ?>
        	<a id="sc_rss" class="socialCounterBox gdl-divider" href="<?php echo $this->services['feedBurnerURL']; ?>" target="_blank">
            	<span class="icon"></span>
				<span class="count gdl-title sidebar-title-color"><?php echo number_format($this->rss); ?></span>
                <span class="title sidebar-content-color"><?php _e('Subscribers', 'gdl_front_end'); ?></span>
				<span class="clear"></span>
            </a>
			
            <?php } ?>
            <?php if($this->services['twitterName']) { ?>
            <a id="sc_twitter" class="socialCounterBox gdl-divider" href="http://twitter.com/<?php echo $this->services['twitterName']?>" target="_blank">
            	<span class="icon"></span>
				<span class="count gdl-title sidebar-title-color"><?php echo number_format($this->twitter); ?></span>
                <span class="title sidebar-content-color"><?php _e('Followers', 'gdl_front_end'); ?></span>   
				<span class="clear"></span>
            </a>
            <?php } ?>
            <?php if($this->services['facebookFanPageURL']) {
            ?>
            <a id="sc_facebook" class="socialCounterBox gdl-divider" href="<?php echo $this->services['facebookFanPageURL']?>" target="_blank" >
            	<span class="icon"></span>
				<span class="count gdl-title sidebar-title-color"><?php echo number_format($this->facebook); ?></span>
                <span class="title sidebar-content-color"><?php _e('Fans', 'gdl_front_end'); ?></span>
				<span class="clear"></span>
            </a>
            <?php } ?>
        </div>
		
       <?php
		//echo '</div>'; // bkp-frame
		//echo '</div>'; // bkp-frame-wrapper			   
	}
}
?>