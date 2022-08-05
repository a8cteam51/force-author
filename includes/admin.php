<?php

namespace ForceAdmin\Admin;

add_action( 'admin_init', __NAMESPACE__ . '\add_settings' );
add_filter( 'wp_insert_post_data', __NAMESPACE__ . '\maybe_set_author', 99 );

/**
 * Adds settings to the Writing admin page.
 */
function add_settings() {
	register_setting(
		'writing',
		'force_author_options',
	);
	add_settings_field(
		'default_author',
		esc_html__( 'Default Author', 'force-author' ),
		__NAMESPACE__ . '\setting_input',
		'writing'
	);
}

/**
 * Callback for echoing the settings field.
 */
function setting_input() {
	$options = get_option( 'force_author_options', array() );
	$users   = get_users(
		array(
			'capability__in' => 'edit_posts',
		)
	)
	?>
	<select name="force_author_options[default_author]" id="default-author">
		<option value=""><?php esc_html_e( 'No Default Author', 'force-author' ); ?></option>
		<?php foreach ( $users as $user ) : ?>
			<option value="<?php echo esc_attr( $user->ID ); ?>" <?php selected( $user->ID, $options['default_author'] ); ?>><?php echo esc_html( $user->user_login ); ?></option>
		<?php endforeach; ?>
	</select>
	<p class="description" id="default-author"><?php esc_html_e( 'This user will be the author of all new posts.', 'force-author' ); ?></strong></p>
	<?php
}

/**
 * Sets the authors to the default author setting, if one is selected in Settings > Writing.
 *
 * @param array $data An array of slashed, sanitized, and processed post data.
 *
 * @return array
 */
function maybe_set_author( $data ) {
	$options = get_option( 'force_author_options' );

	// If a default author isn't set, bail early.
	if ( empty( $options['default_author'] ) ) {
		return $data;
	}

	// If this post doesn't support authors, don't set one.
	if ( ! post_type_supports( $data['post_type'], 'author' ) ) {
		return $data;
	}

	// Allow conditional to skip setting the author.
	if ( apply_filters( 'force_author_skip_set_default_author', false, $data ) ) {
		return $data;
	}

	$data['post_author'] = apply_filters( 'force_author_default_author', $options['default_author'], $data );

	return $data;
}