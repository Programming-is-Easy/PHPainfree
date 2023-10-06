## View-specific CSS Directory
These CSS files can be automatically loaded by PHPainfree (if you keep that
code in the `app.php` template.

### Usage
Any file with a `.css` extension in this folder can be loaded by name using
the `$Painfree->load_css($view)` method.

```php
<!-- load {$App->view}.css -->
<?= $Painfree->load_css($App->view); ?>
```
