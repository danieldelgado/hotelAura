<?php
	/*	
	*	Goodlayers Room Option file
	*	---------------------------------------------------------------------
	*	This file creates all hotel options and attached to the theme
	*	---------------------------------------------------------------------
	*/
	
	// add action to create room post type
	add_action( 'init', 'gdlr_create_room' );
	if( !function_exists('gdlr_create_room') ){
		function gdlr_create_room() {
			global $theme_option;
			
			if( !empty($theme_option['room-slug']) ){
				$room_slug = $theme_option['room-slug'];
				$room_category_slug = $theme_option['room-category-slug'];
				$room_tag_slug = $theme_option['room-tag-slug'];
			}else{
				$room_slug = 'room';
				$room_category_slug = 'room_category';
				$room_tag_slug = 'room_tag';
			}
			
			register_post_type( 'room',
				array(
					'labels' => array(
						'name'               => __('Rooms', 'gdlr-hotel'),
						'singular_name'      => __('Room', 'gdlr-hotel'),
						'add_new'            => __('Add New', 'gdlr-hotel'),
						'add_new_item'       => __('Add New Room', 'gdlr-hotel'),
						'edit_item'          => __('Edit Room', 'gdlr-hotel'),
						'new_item'           => __('New Room', 'gdlr-hotel'),
						'all_items'          => __('All Rooms', 'gdlr-hotel'),
						'view_item'          => __('View Room', 'gdlr-hotel'),
						'search_items'       => __('Search Room', 'gdlr-hotel'),
						'not_found'          => __('No rooms found', 'gdlr-hotel'),
						'not_found_in_trash' => __('No rooms found in Trash', 'gdlr-hotel'),
						'parent_item_colon'  => '',
						'menu_name'          => __('Rooms', 'gdlr-hotel')
					),
					'public'             => true,
					'publicly_queryable' => true,
					'show_ui'            => true,
					'show_in_menu'       => true,
					'query_var'          => true,
					'rewrite'            => array( 'slug' => $room_slug  ),
					'capability_type'    => 'post',
					'has_archive'        => true,
					'hierarchical'       => false,
					'menu_position'      => 5,
					'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'custom-fields' )
				)
			);
			
			// create room categories
			register_taxonomy(
				'room_category', array("room"), array(
					'hierarchical' => true,
					'show_admin_column' => true,
					'label' => __('Room Categories', 'gdlr-hotel'), 
					'singular_label' => __('Room Category', 'gdlr-hotel'), 
					'rewrite' => array( 'slug' => $room_category_slug  )));
			register_taxonomy_for_object_type('room_category', 'room');
			
			// create custom taxonomy for room category
			if( is_admin() && class_exists('gdlr_tax_meta') ){
				global $gdlr_sidebar_controller;
				
				new gdlr_tax_meta( 
					array(
						'taxonomy'=>'room_category',
						'slug'=>'gdlr_hotel_branch'
					),
					array(
						'upload' => array(
							'title'=> __('Hotel Thumbnail', 'gdlr-song'),
							'type'=> 'upload'
						),
						'content' => array(
							'title'=> __('Hotel Location', 'gdlr-song'),
							'type'=> 'textarea'
						)
					)
				);
			}
			
			
			// create room tag
			register_taxonomy(
				'room_tag', array('room'), array(
					'hierarchical' => false, 
					'show_admin_column' => true,
					'label' => __('Room Tags', 'gdlr-hotel'), 
					'singular_label' => __('Room Tag', 'gdlr-hotel'),  
					'rewrite' => array( 'slug' => $room_tag_slug  )));
			register_taxonomy_for_object_type('room_tag', 'room');	

			// add filter to style single template
			add_filter('single_template', 'gdlr_register_room_template');
		}
	}

	if( !function_exists('gdlr_register_room_template') ){
		function gdlr_register_room_template($single_template) {
			global $post;

			if ($post->post_type == 'room') {
				$single_template = dirname(dirname( __FILE__ )) . '/single-room.php';
			}
			return $single_template;	
		}
	}
	
	// add a room option to room page
	if( is_admin() ){ add_action('after_setup_theme', 'gdlr_create_room_options'); }
	if( !function_exists('gdlr_create_room_options') ){
	
		function gdlr_create_room_options(){

			if( !class_exists('gdlr_page_options') ) return;
			new gdlr_page_options( 
				
				// page option attribute
				array(
					'post_type' => array('room'),
					'meta_title' => __('Goodlayers Room Option', 'gdlr-hotel'),
					'meta_slug' => 'goodlayers-page-option',
					'option_name' => 'post-option',
					'position' => 'normal',
					'priority' => 'high',
				),
					  
				// page option settings
				array(
					'page-layout' => array(
						'title' => __('Page Layout', 'gdlr-hotel'),
						'options' => array(
							'page-title' => array(
								'title' => __('Page Title' , 'gdlr-hotel'),
								'type' => 'text'
							),
							'page-caption' => array(
								'title' => __('Page Caption' , 'gdlr-hotel'),
								'type' => 'textarea'
							),							
							'header-background' => array(
								'title' => __('Header Background Image' , 'gdlr-hotel'),
								'button' => __('Upload', 'gdlr-hotel'),
								'type' => 'upload',
							),					
						)
					),
					
					'page-option' => array(
						'title' => __('Page Option', 'gdlr-hotel'),
						'options' => array(
							'room-amount' => array(
								'title' => __('Room Amount' , 'gdlr-hotel'),
								'type' => 'text',
								'default' => '1',
								'custom_field' => 'gdlr_room_amount',
								'description' => __('Number of room available on the same period of time. Only fill number here.', 'gdlr-hotel')
							),
							'bed' => array(
								'title' => __('Bed' , 'gdlr-hotel'),
								'type' => 'text'
							),	
							'max-people' => array(
								'title' => __('Max People' , 'gdlr-hotel'),
								'type' => 'text',
								'custom_field' => 'gdlr_max_people',
							),	
							'view' => array(
								'title' => __('View' , 'gdlr-hotel'),
								'type' => 'text'
							),		
							'room-size' => array(
								'title' => __('Room Size' , 'gdlr-hotel'),
								'type' => 'text'
							),
							'wifi' => array(
								'title' => __('Wifi' , 'gdlr-hotel'),
								'type' => 'text'
							),	
							'breakfast-included' => array(
								'title' => __('Breakfast Included' , 'gdlr-hotel'),
								'type' => 'text'
							),	
							'room-service' => array(
								'title' => __('Room Service' , 'gdlr-hotel'),
								'type' => 'text'
							),	
							'airport-pickup-service' => array(
								'title' => __('Airport Pickup Service' , 'gdlr-hotel'),
								'type' => 'text'
							),	
							'room-base-price' => array(
								'title' => __('Room Base Price Weekday' , 'gdlr-hotel'),
								'type' => 'text',
								'default' => 0,
								'description' => __('Only fill number here.', 'gdlr-hotel')
							),	
							'room-base-price-weekend' => array(
								'title' => __('Room Base Price Weekend' , 'gdlr-hotel'),
								'type' => 'text',
								'default' => 0,
								'description' => __('Only fill number here.', 'gdlr-hotel')
							),	
							'room-base-price-number-people' => array(
								'title' => __('Room Base Price Number ( People )' , 'gdlr-hotel'),
								'type' => 'text',
								'default' => '2',
								'description' => __('Only fill number here.', 'gdlr-hotel')
							),		
							'adult-price-weekday' => array(
								'title' => __('Adult Price Weekday' , 'gdlr-hotel'),
								'type' => 'text',
								'default' => 0,
								'description' => __('Only fill number here.', 'gdlr-hotel')
							),			
							'adult-price-weekend' => array(
								'title' => __('Adult Price Weekend' , 'gdlr-hotel'),
								'type' => 'text',
								'default' => 0,
								'description' => __('Only fill number here.', 'gdlr-hotel')
							),			
							'children-price-weekday' => array(
								'title' => __('Children Price Weekday' , 'gdlr-hotel'),
								'type' => 'text',
								'default' => 0,
								'description' => __('Only fill number here.', 'gdlr-hotel')
							),			
							'children-price-weekend' => array(
								'title' => __('Children Price Weekend' , 'gdlr-hotel'),
								'type' => 'text',
								'default' => 0,
								'description' => __('Only fill number here.', 'gdlr-hotel')
							),
							
							// SPECIAL SEASON
							'special-season-title' => array(
								'title' => __('Special Season' , 'gdlr-hotel'),
								'type' => 'title',
								'wrapper-class' => 'gdlr-top-divider gdlr-title-text'
							),	
							'ss-room-base-price' => array(
								'title' => __('Special Season Room Base Price Weekday' , 'gdlr-hotel'),
								'type' => 'text',
								'default' => 0,
								'description' => __('Only fill number here.', 'gdlr-hotel')
							),	
							'ss-room-base-price-weekend' => array(
								'title' => __('Special Season Room Base Price Weekend' , 'gdlr-hotel'),
								'type' => 'text',
								'default' => 0,
								'description' => __('Only fill number here.', 'gdlr-hotel')
							),	
							'ss-adult-price-weekday' => array(
								'title' => __('Special Season Adult Price Weekday' , 'gdlr-hotel'),
								'type' => 'text',
								'default' => 0,
								'description' => __('Only fill number here.', 'gdlr-hotel')
							),			
							'ss-adult-price-weekend' => array(
								'title' => __('Special Season Adult Price Weekend' , 'gdlr-hotel'),
								'type' => 'text',
								'default' => 0,
								'description' => __('Only fill number here.', 'gdlr-hotel')
							),			
							'ss-children-price-weekday' => array(
								'title' => __('Special Season Children Price Weekday' , 'gdlr-hotel'),
								'type' => 'text',
								'default' => 0,
								'description' => __('Only fill number here.', 'gdlr-hotel')
							),			
							'ss-children-price-weekend' => array(
								'title' => __('Special Season Children Price Weekend' , 'gdlr-hotel'),
								'type' => 'text',
								'default' => 0,
								'description' => __('Only fill number here.', 'gdlr-hotel')
							),
							
							'thumbnail-type' => array(
								'title' => __('Thumbnail Type' , 'gdlr-hotel'),
								'type' => 'combobox',
								'options' => array(
									'feature-image'=> __('Feature Image', 'gdlr-hotel'),
									'video'=> __('Video', 'gdlr-hotel'),
									'slider'=> __('Slider', 'gdlr-hotel')
								),
								'wrapper-class' => 'gdlr-top-divider'
							),						
							'thumbnail-video' => array(
								'title' => __('Video Url' , 'gdlr-hotel'),
								'type' => 'text',
								'wrapper-class' => 'video-wrapper thumbnail-type-wrapper'
							),		
							'thumbnail-slider' => array(
								'title' => __('Slider' , 'gdlr-hotel'),
								'type' => 'slider',
								'wrapper-class' => 'slider-wrapper thumbnail-type-wrapper'
							),								
							'inside-thumbnail-type' => array(
								'title' => __('Inside Room Thumbnail Type' , 'gdlr-hotel'),
								'type' => 'combobox',
								'options' => array(
									'thumbnail-type'=> __('Same As Thumbnail Type', 'gdlr-hotel'),
									'image'=> __('Image', 'gdlr-hotel'),
									'video'=> __('Video', 'gdlr-hotel'),
									'slider'=> __('Slider', 'gdlr-hotel'),
									'stack-image'=> __('Stack Images', 'gdlr-hotel')
								),
								'wrapper-class' => 'gdlr-top-divider'
							),		
							'inside-thumbnail-image' => array(
								'title' => __('Image Url' , 'gdlr-hotel'),
								'type' => 'upload',
								'wrapper-class' => 'image-wrapper inside-thumbnail-type-wrapper'
							),							
							'inside-thumbnail-video' => array(
								'title' => __('Video Url' , 'gdlr-hotel'),
								'type' => 'text',
								'wrapper-class' => 'video-wrapper inside-thumbnail-type-wrapper'
							),		
							'inside-thumbnail-slider' => array(
								'title' => __('Slider' , 'gdlr-hotel'),
								'type' => 'slider',
								'wrapper-class' => 'stack-image-wrapper slider-wrapper inside-thumbnail-type-wrapper'
							),								
						)
					),

				)
			);
			
		}
	}	
	
	// add room in page builder area
	add_filter('gdlr_page_builder_option', 'gdlr_register_room_item');
	if( !function_exists('gdlr_register_room_item') ){
		function gdlr_register_room_item( $page_builder = array() ){
			global $gdlr_spaces;
		
			$page_builder['content-item']['options']['room'] = array(
				'title'=> __('Room', 'gdlr-hotel'), 
				'type'=>'item',
				'options'=>array_merge(gdlr_page_builder_title_option(__('View all rooms', 'gdlr-hotel')), array(					
					'category'=> array(
						'title'=> __('Category' ,'gdlr-hotel'),
						'type'=> 'multi-combobox',
						'options'=> gdlr_get_term_list('room_category'),
						'description'=> __('You can use Ctrl/Command button to select multiple categories or remove the selected category. <br><br> Leave this field blank to select all categories.', 'gdlr-hotel')
					),	
					'tag'=> array(
						'title'=> __('Tag' ,'gdlr-hotel'),
						'type'=> 'multi-combobox',
						'options'=> gdlr_get_term_list('room_tag'),
						'description'=> __('Will be ignored when the room filter option is enabled.', 'gdlr-hotel')
					),					
					'room-style'=> array(
						'title'=> __('Room Style' ,'gdlr-hotel'),
						'type'=> 'combobox',
						'options'=> array(
							'classic' => __('Classic', 'gdlr-hotel'),
							'modern' => __('Modern', 'gdlr-hotel'),
							'medium' => __('Medium Thumbnail', 'gdlr-hotel'),
						),
					),
					'enable-carousel'=> array(
						'title'=> __('Room Carousel' ,'gdlr-hotel'),
						'type'=> 'checkbox',
						'wrapper-class'=> 'room-style-wrapper modern-wrapper classic-wrapper'
					),
					'room-size'=> array(
						'title'=> __('Room Column Size' ,'gdlr-hotel'),
						'type'=> 'combobox',
						'options'=> array('1'=>'1', '2'=>'2', '3'=>'3', '4'=>'4'),
						'default'=> 3,
						'wrapper-class'=>'room-style-wrapper classic-wrapper modern-wrapper'
					),					
					'num-fetch'=> array(
						'title'=> __('Num Fetch' ,'gdlr-hotel'),
						'type'=> 'text',	
						'default'=> '8',
						'description'=> __('Specify the number of rooms you want to pull out.', 'gdlr-hotel')
					),	
					'num-excerpt'=> array(
						'title'=> __('Num Excerpt' ,'gdlr-hotel'),
						'type'=> 'text',	
						'default'=> '20',
						'wrapper-class'=>'room-style-wrapper medium-wrapper'
					),				
					'thumbnail-size'=> array(
						'title'=> __('Thumbnail Size' ,'gdlr-hotel'),
						'type'=> 'combobox',
						'options'=> gdlr_get_thumbnail_list(),
						'description'=> __('Only effects to <strong>standard and gallery post format</strong>','gdlr-hotel')
					),	
					'orderby'=> array(
						'title'=> __('Order By' ,'gdlr-hotel'),
						'type'=> 'combobox',
						'options'=> array(
							'date' => __('Publish Date', 'gdlr-hotel'), 
							'title' => __('Title', 'gdlr-hotel'), 
							'rand' => __('Random', 'gdlr-hotel'), 
						)
					),
					'order'=> array(
						'title'=> __('Order' ,'gdlr-hotel'),
						'type'=> 'combobox',
						'options'=> array(
							'desc'=>__('Descending Order', 'gdlr-hotel'), 
							'asc'=> __('Ascending Order', 'gdlr-hotel'), 
						)
					),			
					'pagination'=> array(
						'title'=> __('Enable Pagination' ,'gdlr-hotel'),
						'type'=> 'checkbox'
					),					
					'margin-bottom' => array(
						'title' => __('Margin Bottom', 'gdlr-hotel'),
						'type' => 'text',
						'default' => $gdlr_spaces['bottom-blog-item'],
						'description' => __('Spaces after ending of this item', 'gdlr-hotel')
					),				
				))
			);
			
			$page_builder['content-item']['options']['room-category'] = array(
				'title'=> __('Room Category / Branches', 'gdlr-hotel'), 
				'type'=>'item',
				'options'=>array_merge(gdlr_page_builder_title_option(__('View All Branches', 'gdlr-hotel')), array(									
					'category'=> array(
						'title'=> __('Select Category to Display' ,'gdlr-hotel'),
						'type'=> 'multi-combobox',
						'options'=> gdlr_get_term_id_list('room_category'),
						'description'=> __('Will be ignored when the room filter option is enabled.', 'gdlr-hotel')
					),
					'item-size'=> array(
						'title'=> __('Item Column Size' ,'gdlr-hotel'),
						'type'=> 'combobox',
						'options'=> array('1'=>'1', '2'=>'2', '3'=>'3', '4'=>'4'),
						'default'=> 3,
						'wrapper-class'=>'room-style-wrapper classic-wrapper modern-wrapper'
					),				
					'thumbnail-size'=> array(
						'title'=> __('Thumbnail Size' ,'gdlr-hotel'),
						'type'=> 'combobox',
						'options'=> gdlr_get_thumbnail_list(),
						'description'=> __('Only effects to <strong>standard and gallery post format</strong>','gdlr-hotel')
					),				
					'margin-bottom' => array(
						'title' => __('Margin Bottom', 'gdlr-hotel'),
						'type' => 'text',
						'default' => $gdlr_spaces['bottom-blog-item'],
						'description' => __('Spaces after ending of this item', 'gdlr-hotel')
					),				
				))
			);
			return $page_builder;
		}
	}
	
?>