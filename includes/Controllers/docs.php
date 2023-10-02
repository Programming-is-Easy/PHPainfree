<?php

/**
 * docs.php - Special htmx-capable controller example.
 *
 * This controller defines a template-specific variable, stored in
 * `$App->data['doc']` to allow a template to be fetched fully loaded
 * in the documentation template as a normal browser-based HTTP request,
 * or via a partial HTML snippet when requested with the htmx framework.
 *
 * In a normal request to /docs, we'll define a default "sub-view" of 
 * `quickstart` that will load /templates/views/docs/quickstart.php inside
 * the priamry template. Any "id" passed in the URL request like /docs/install
 * will place that value into `$App->data['doc']` instead of the default.
 *
 * When the template loads, it looks at this value to decide what sub-view
 * template to render.
 *
 * In an htmx-based request, this application has defined a folder structure
 * for the templates to automatically load a small snippet page using the 
 * `$App->id` value.
 *
 * ## Folder Structure in Templates
 * `templates/views/{$App->view}.php` - top-level template
 * `templates/views/{$App->view}/{$App->id}.php` - sub-view template
 */

// default sub-view to render for empty requests to /docs
$this->data['doc'] = 'quickstart'; 

if ( ! empty($this->id) ) {
	$this->data['doc'] = $this->id;
}
