<?php
/**
 * Page model class
 *
 * @package PostCRUD.
 */

namespace Silvanus\PostCrud\Models;

use Silvanus\PostCrud\AbstractCrud;

/**
 * WP "page" model
 */
class Page extends AbstractCrud {

	/**
	 * Post type to be associated with class
	 *
	 * @var string
	 */
	protected $post_type = 'page';
}