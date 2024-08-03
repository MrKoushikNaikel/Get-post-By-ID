<?php
/**
 * Plugin Name: Get post By ID
 * Plugin URI: https://www.koushiknaikel.in/get-post-by-id
 * Description: This plagin will play those vedios which is on your vewport
 * Version: 1.9
 * Author: Koushik Naikel
 * Author URI: https://www.koushiknaikel.in
 */
add_action( 'init', 'get_post_by_id' );
 
function get_post_by_id() {
    add_shortcode( 'post', 'getpostbyid' );
} 
function getpostbyid( $atts ) {
    //return "foo = {$atts['foo']}";
	$html='<div class="row expanded thb-portfolio masonry thb-portfolio-text thb-loaded" id="portfolio-section-427" data-filter="thb-filter-427" data-layoutmode="packery" data-thb-animation="thb-fade" data-preload="nobg">';
	if(isset($atts['postid']) && is_numeric($atts['postid']) && false){
			$link = get_permalink($id);
			$title = get_the_title($id);
			$html= '<a href="'.$link.'">'.$title.'</a>' ;
	}else{
		 if(isset($atts['postid']) && $atts['postid']!="")
			$args['include']=explode(",",$atts['postid']);
		 if(isset($atts['categoryid']) && $atts['categoryid']!="" && is_numeric($atts['categoryid']))
			 $args['category']=$atts['categoryid'];
		 if(isset($atts['limit']) && $atts['limit']!="" && is_numeric($atts['limit']))
			 $args['numberposts']=(int)$atts['limit'];
		  if(isset($atts['order']) && $atts['order']!=""){
			 $args['order']=($atts['order']=="latest") ? "DESC":"ASC";
		  }
		  if(isset($atts['type']) && $atts['type']!=""){
			 $args['post_type']=$atts['type'];
		  }  
		/* $args = array(
		  'numberposts' => $args['numberposts'],
		  'post_type'   => $args['post_type'],
		   'category'  => $args['category'],
           'orderby'          => 'date',
           'order'            => $args['order'],
			'post_type' => $args['post_type']
		); */

		//$latest_books = get_posts( $args );
		 //print_r($latest_books,true);
		$posts = get_posts( $args );
		wp_reset_postdata();
		//$posts = get_posts( $args );
		// return print_r($posts, true);
		foreach ( $posts as $eachpost ) {
			$number = $eachpost->ID;
			$lastDigit = $number % 1000;
			if($lastDigit>255)
				$lastDigit=$lastDigit%100;
				//$link=get_permalink($eachpost->ID);
			//$title = $eachpost->post_title;
			//$html .= '<a href="'.$link.'">'.$title.'</a>' ;
			$html .= '<div class="thb-cat-inspiration style6 small-12 columns portfolio type-portfolio status-publish has-post-thumbnail hentry portfolio-category-inspiration thb-added" id="'.$eachpost->post_type.'-'.$eachpost->ID.'" data-id="'.$eachpost->ID.'" >
				<h2>
					<a class="'.$eachpost->post_type.'-holder portfolio-holder" href="'.get_permalink($eachpost->ID).'" style="opacity: 1;">'.$eachpost->post_title.'</a>
					<div class="style6-box" data-id="'.$eachpost->ID.'">
									<p>'. $eachpost->post_excerpt .'</p>
									<div class="portfolio-attributes
							">
									<div class="attribute"><strong>By:</strong> '.get_the_author_meta('display_name', $eachpost->post_author).'</div>
															<div class="attribute"><strong>Date:</strong> '. $eachpost->post_date .'</div>
												<div class="attribute"><strong>Services:</strong> Design, Art Direction, Website</div>
											</div>
							</div>
				</h2>
			</div>
			<style> 
			.thb-portfolio #'.$eachpost->post_type.'-'.$eachpost->ID.' .portfolio-holder:after {
				border-color: rgba(194,198,'.$lastDigit.',0.95);
			</style>
			';
		}
		
	}
	$html .='</div>';
		return $html;
}