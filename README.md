# Primary Categories

A WordPress plugin for allowing users to designate a primary category for their content.

## For users

Using the plugin is a snap - just select categories as usual, then use the drop-down at the bottom of the categories meta box to designate a primary category.

## For developers

The primary category ID is stored as the value of the `_pc_primary_category` meta key, so it can be queried on the front end via meta query.

The plugin also provides the `pc_primary_categories_post_types` filter for extending the primary category feature to other content types.
