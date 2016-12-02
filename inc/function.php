<?php

/**
	METABOXES
*/
	// Add metaboxes
	function initialization_metaboxes(){

		add_meta_box( 'id_ma_meta', __( 'Estimation of the reading time', 'reading_time_domain' ), 'metaboxes_function', 'post', 'normal', 'high' );

	}
	add_action( 'add_meta_boxes', 'initialization_metaboxes' );


	// Creation of metaboxes
	function metaboxes_function( $post ) {

		$time = get_post_meta( $post->ID, '_my_field', true );

		echo '<label for="reading_time_value">' . __( 'Value in minute(s) ', 'reading_time_domain' ) . '</label>';

		echo '<input id="reading_time_value" type="text" name="_my_field" value="' . esc_attr( $time ) . ' " disabled />';

		wp_nonce_field( '_my_meta_box_save', '_meta_box_nonce' );
	}


/**
	FUNCTION
*/

	function _reading_time_function($post_id, $post)  {

		// The code is not executed when it is a revision
		if(wp_is_post_revision($post_id)) {
			return;
		}

		// Only for articles
		if ($post->post_type != 'post') {
	    	return;
		}

		// Avoiding automatic backups
		if ( defined( 'DOING_AUTOSAVE' ) and DOING_AUTOSAVE ) {
			return;
		}

		// Calculate the reading time
		$word_count = str_word_count(strip_tags($post->post_content));

		// The basis is 300 words per minute
		$minutes = ceil($word_count / 300);

		// The value of the metabox is saved
		update_post_meta( $post_id, '_my_field', $minutes);

	}
	add_action('save_post', '_reading_time_function', 10, 3);


	// Display value in frontoffice
	function display_value_time($content) {

		global $post;

		$value_time = get_post_meta($post->ID, '_my_field' , true);

		if($value_time != ''){
			if ($value_time < 2){
				$text = __( 'You will take less than a minute to read the article ', 'reading_time_domain' );
			}
			else{
				$text = __( 'Approximate length of article reading time : ', 'reading_time_domain' ). "<strong>" . $value_time." minutes </strong>";
			}

		$new_content = "<div class='reading-time'>". $text. "</div>" . $content;

		}

		return $new_content;
	}
	add_filter('the_content', 'display_value_time');