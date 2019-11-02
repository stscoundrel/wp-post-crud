# WP Post Crud

Provides CRUD class for handling WP Post Types in Actice Recordish way. Includes classes for detault WordPress types Post/Page and is extendable to include custom post types.

Aim is to abstract away awkward parts of creating, handling and deleting Posts programmatically in WordPress.

## Installation

Via Composer:

`composer require stscoundrel/wp-post-crud`

To use autoloading mechanism, you must include `vendor/autoload.php` file in your code.

## Issues & Contributing

If you find a bug or feel something is wrong, submit an issue or a pull request. Read the instructions first.

## Usage

Post CRUD gives models that have create, read, update and delete methods. Main methods: `set_field()`, `get_field()`, `save()` and `delete()`

#### Creating new post

```php
<?php

// Default post model.
use Silvanus\PostCrud\Models\Post as Model;

// Create new post instance.
$model = new Model();

// Set some values
$model->set_field('post_title', 'Lorem ipsum dolor sit amet');
$model->set_field('post_content', 'Dolor sit igitur.');

// Persist the data in database.
$model->save();
```
All fields values should match WP Post table columns.

#### Edit existing post

Models will automatically load WP Post data if you instantiate them with ID.

```php
<?php

// Default post model.
use Silvanus\PostCrud\Models\Post as Model;

// Pass ID of post to model.
$model = new Model(89);

// Use existing data.
echo $model->get_field('post_title');
echo $model->get_field('post_content');
echo $model->get_field('post_name');

// Not a fan of that slug, change it.
$model->set_field('post_name', 'sluggity_slug');

// Persist the changes.
$model->save();
```

#### Delete post

```php
<?php

// Default post model.
use Silvanus\PostCrud\Models\Post as Model;

// Post IDs to be deleted.
$post_ids = array(1995, 2011, 2019);

// These posts have been particularly silly.
foreach( $post_ids as $post_id ) {
    $model = new Model($post_id);
    $model->delete();
}
```

### Custom Post Types

You can create your own classes for your own Custom Post Types. You only need to extend AbstractCrud class and provide name of post type.


```php
<?php

// AbstractCrud class for all the heavy lifting.
use Silvanus\PostCrud\AbstractCrud;

/**
 * Minimal implementation for your post type.
 */
class Book extends AbstractCrud
{

    /**
     * Slug of post type you have already registered elsewhere.
     */
    protected $post_type = 'book';
}
```

Your class will have access to all the same methods.

```php
<?php

// Your Book class
use YourName\YourNamespace\Book;

// Create new post book.
$book = new Book();

// Set up book data.
$book->set_field('post_title', 'Revelation Space');
$book->set_field('post_status', 'published');

// Persist.
$book->save();
```

## Meta fields

Models can also handle metadata. Use `set_meta()` and `get_meta()` methods.

```php
<?php

// Our book could use some meta data.
$book->set_meta('author', 'Alastair Reynolds');
$book->set_meta('rating', 5);

// Persist.
$book->save();
```
