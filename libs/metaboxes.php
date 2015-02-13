<?php
add_filter( 'cmb2_meta_boxes', 'cmb2_tmthree_metaboxes' );
/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */
function cmb2_tmthree_metaboxes( array $meta_boxes ) {

    // Start with an underscore to hide fields from custom fields list
    $prefix = '_cmb_';

    // Add other metaboxes as needed
    
    $meta_boxes['team'] = array(
        'id'            => 'team_show',
        'title'         => __( 'Team Member Information', 'cmb2' ),
        'object_types'  => array( 'team' ), // Post type
        'context'       => 'normal',
        'priority'      => 'high',
        'show_names'    => true, // Show field names on the left
        'fields'        => array(
            array(
                'name' => 'Profile Image',
                'desc' => 'Upload an image or enter an URL for Profile.',
                'id' => $prefix . 'profile_img',
                'type' => 'file',
            ),

        ),
    );

    /// for page 
    $meta_boxes['team'] = array(
        'id'            => 'teammember_display',
        'title'         => __( 'Select Team Member', 'cmb2' ),
        'object_types'  => array( 'page' ), // Post type
        'context'       => 'normal',
        'priority'      => 'high',
        'show_names'    => true, // Show field names on the left
        'fields'        => array(
            array(
                'name' => 'Team Member',
                'desc' => 'Selcet Team Member',
                'id' => $prefix . 'teamid',
                'type'    => 'select',
                'options' => 'get_team_member_select_opt',
                'repeatable' => true ,
            ),

        ),
    );


    return $meta_boxes;
}