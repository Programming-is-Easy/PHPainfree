## View-specific JS Directory
These JS files can be automatically loaded by PHPainfree (if you keep that
code in the `app.php` template.

### Usage
Any file with a `.js` extension in this folder can be loaded by name using
the `$Painfree->load_js($view)` method.

```php
<!-- load {$App->view}.js -->
<?= $Painfree->load_js($App->view); ?>
```
