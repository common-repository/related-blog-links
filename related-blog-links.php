<?php
/*
Plugin Name: Related Blog Links
Plugin URI: http://www.wphelpforum.com/
Description: This wordpress plugin will display the blog links related to your posts and pages.
Author: Thamizhchelvan
Version: 1.0
Author URI: http://thamizhchelvan.com/
*/



//you need simplexml_load configured in php config
function add_related_blog_links($content)
{
if(function_exists('simplexml_load_file') && (is_page() || is_single()))
{
	global $post;
	$file = "http://blogsearch.google.com/blogsearch_feeds?hl=en&q=".$post->post_title."&ie=utf-8&num=10&output=rss";
	$related_links = simplexml_load_file($file);
	
	$related_data = '<FIELDSET><LEGEND>Related Blog Links</LEGEND><UL>';
	//process links
	foreach($related_links->channel->item as $linkdata)
	{
		$related_data .= '<LI><a rel="nofollow" target="_blank" title="'.strip_tags($linkdata->description).'" href="'.$linkdata->link.'">'.strip_tags($linkdata->title)."</a></LI>";
	}
	
	$related_data .= '</UL></FIELDSET>';
	$content .= $related_data;	
}
return $content;
}
add_action('the_content', 'add_related_blog_links');
?>