<?php
/**
 * Default post model class
 *
 * @package PostCRUD.
 */

namespace Silvanus\PostCrud\Models;

use Silvanus\PostCrud\AbstractCrud;

/**
 * Default "post" model
 */
class Post extends AbstractCrud {

	/**
	 * Post type to be associated with class
	 *
	 * @var string
	 */
	protected $post_type = 'post';
}