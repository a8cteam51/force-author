# force-author
Force Author plugin for WordPress

## What's this?

This plugin gives you the ability to define which user should always be the author for new posts. This is particularly useful if sites that have multiple contributors, but the posts should look like they're coming from one person.

The default author can be set under *Settings > Writing* in the admin.

![Screen Shot](https://user-images.githubusercontent.com/8797898/183119175-9e6de0bd-92e1-4f24-a676-47ac8a39703f.png)

## Notes on functionality

1. The author will **always** be the default set, even if you try to select something else when editing a post.
2. Only new posts will be affected after the plugin is installed. Current posts that have a different author will not be affected.

## Filters

### `force_author_skip_set_default_author`

This filter gives you the ability to skip setting a default author. 

For example, if you only want to set the default author when the post is published, but want to keep the real author while it's still in draft:

```
function maybe_skip_set_default_author( $bool, $data ) {
	if ( 'publish' !== $data['post_status'] ) {
		return true;
	}
	
	return $bool;
}
add_filter( 'force_author_skip_set_default_author', 'maybe_skip_set_default_author', 10, 2 );
```

### `force_author_default_author`

With this filter you can override who the default author should be.

For example, if you want a different default author based on the post type:

```
function set_default_author( $author, $data ) {
	switch ( $data['post_type'] ) {
		case 'post':
			return 1;
		case 'page':
			return 2;
		default:
			return $author;
	}
}
add_filter( 'force_author_default_author', 'set_default_author', 10, 2 );
```
