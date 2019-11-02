<?php
/**
 * Abstract Crud class
 *
 * @package PostCRUD.
 */

namespace Silvanus\PostCrud;

/**
 * --> Link class to post type
 * --> Handle create, read, update and delete methods
 */
abstract class AbstractCrud {

	/**
	 * ID of post
	 *
	 * @var int|null
	 */
	protected $id = null;

	/**
	 * Post fields
	 * Key / value pairs
	 * Should match Post table columns.
	 *
	 * @var array
	 */
	protected $fields;

	/**
	 * Updated Post fields
	 * Key / value pairs
	 * Used to define which values to insert into DB
	 *
	 * @var array
	 */
	protected $updated_fields;

	/**
	 * Post Meta fields
	 * Key / value pairs
	 * Should match Post Meta Table key / values.
	 *
	 * @var array
	 */
	protected $meta_fields;

	/**
	 * Post type
	 *
	 * @var string
	 */
	protected $post_type;

	/**
	 * Class constructor
	 *
	 * @param mixed $id of post
	 */
	public function __construct( $id = null ) {
		$this->set_id( $id );

		// If given ID, fetch post from DB
		if( $id ):
			$this->read( $id );
		endif;
	}

	/**
	 * Set ID property
	 * Matches post ID in Posts table
	 *
	 * @param mixed $id of post.
	 */
	public function set_id( $id ) {
		$this->id = $id;
	}

	/**
	 * Get id property
	 *
	 * @return int $id of post.
	 */
	public function get_id() {
		return $this->id;
	}

	/**
	 * Set post type property
	 * Defines which post type to handle
	 *
	 * @param string $post_type of post.
	 */
	public function set_post_type( string $post_type ) {
		$this->post_type = $post_type;
	}

	/**
	 * Get post type property
	 *
	 * @return string $post_type of post.
	 */
	public function get_post_type() {
		return $this->post_type;
	}

	/**
	 * Set key / value field
	 *
	 * @param string $key that matches Post DB column.
	 * @param mixed $value to be later saved.
	 * @param bool $initial checker for update_fields
	 */
	public function set_field( string $key, $value, $initial = false ) {
		$this->fields[$key] = $value;

		if( !$initial ):
			$this->updated_fields[$key] = $value;
		endif;
	}

	/**
	 * Get field value
	 *
	 * @param string $key that matches Post DB column.
	 */
	public function get_field( string $key  ) {
		return $this->fields[$key];
	}

	/**
	 * Get fields array property
	 *
	 * @return array $fields of instance.
	 */
	public function get_fields() {

		// Changed fields.
		$fields = $this->fields;

		// Append ID and post type.
		$fields['id'] = $this->get_id();
		$fields['post_type'] = $this->get_post_type();

		// Append meta fields, if any.
		if( !empty( $this->meta_fields ) ):
			foreach( $this->meta_fields as $meta_key => $meta_value ):
				$fields['meta_input'][$meta_key] = $meta_value;
			endforeach;
		endif;

		return $fields;
	}

	/**
	 * Get updated fields array property
	 *
	 * @return array $fields of instance.
	 */
	public function get_updated_fields() {

		// Changed fields.
		$fields = $this->updated_fields;

		// Check if we have fields to update
		if( !empty( $fields ) ):
			// Append ID and post type.
			$fields['ID'] = $this->get_id();
			$fields['post_type'] = $this->get_post_type();
		endif;

		return $fields;
	}

	/**
	 * Set meta key / value field
	 *
	 * @param string $key that matches Post DB column.
	 * @param mixed $value to be later saved.
	 */
	public function set_meta( string $key, $value ) {
		$this->meta_fields[$key] = $value;
	}

	/**
	 * Get meta value
	 * --> See if key exists on props
	 * --> If not, return from DB
	 *
	 * @param string $key that matches Post Meta DB key column.
	 * @return mixed $meta from props or DB.
	 */
	public function get_meta( string $key  ) {

		if( array_key_exists( $key , $this->meta_fields) ):
			$meta = $this->meta_fields['key'];
		else:
			$meta = \get_post_meta( $this->get_id(), $key, true );
		endif;

		return $meta;
	}

	/**
	 * Persist changes to database
	 * --> If given ID, update post
	 * --> If no ID, create new post
	 */
	public function save() {
		$id = $this->get_id();

		if( !$id ):
			$this->create();
		else:
			$this->update();
		endif;
	}

	/**
	 * Create a post
	 */
	public function create() {
		var_dump( $this->get_fields() );
		$result = \wp_insert_post( $this->get_fields() );
	}

	/**
	 * Read / get a post
	 */
	public function read() {
		$post = \get_post( $this->get_id() );

		if( !is_wp_error( $post ) ):

			// Get post fields from response to instance.
			$this->set_field( 'post_author', $post->post_author, true );
			$this->set_field( 'post_date', $post->post_date, true );
			$this->set_field( 'post_date_gmt', $post->post_date_gmt, true );
			$this->set_field( 'post_content', $post->post_content, true );
			$this->set_field( 'post_title', $post->post_title, true );
			$this->set_field( 'post_excerpt', $post->post_excerpt, true );
			$this->set_field( 'post_status', $post->post_status, true );
			$this->set_field( 'comment_status', $post->comment_status, true );
			$this->set_field( 'ping_status', $post->ping_status, true );
			$this->set_field( 'post_password', $post->post_password, true );
			$this->set_field( 'post_name', $post->post_name, true );
			$this->set_field( 'to_ping', $post->to_ping, true );
			$this->set_field( 'pinged', $post->pinged, true );
			$this->set_field( 'post_modified', $post->post_modified, true );
			$this->set_field( 'post_modified_gmt', $post->post_modified_gmt, true );
			$this->set_field( 'post_content_filtered', $post->post_content_filtered, true );
			$this->set_field( 'post_parent', $post->post_parent, true );
			$this->set_field( 'guid', $post->guid, true );
			$this->set_field( 'menu_order', $post->menu_order, true );
			$this->set_field( 'comment_count', $post->comment_count, true );
		endif;
	}

	/**
	 * Update a post
	 */
	public function update() {
		$fields = $this->get_updated_fields();

		if( !empty( $fields ) ):
			$result = \wp_update_post( $fields );
		endif;

		// Update meta fields.
		if( !empty( $this->meta_fields ) ):
			var_dump('updating fields');
			foreach( $this->meta_fields as $meta_key => $meta_value ):
				update_post_meta( $this->get_id(), $meta_key, $meta_value );
			endforeach;
		endif;
	}

	/**
	 * Delete a post
	 */
	public function delete() {
		$result = \wp_delete_post( $this->get_id(), true );
	}

}