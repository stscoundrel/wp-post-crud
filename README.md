# WP Post Crud

Provides CRUD class for handling WP Post Types in Actice Recordish way. Includes classes for detault WordPress types Post/Page and is extendable to include custom post types.

## Installation

Via Composer:

`composer require stscoundrel/wp-post-crud`

To use autoloading mechanism, you must include `vendor/autoload.php` file in your code.

## Usage

### Creating new post

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

### Edit existing post

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

### Delete post

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
