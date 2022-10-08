<?= $renderer->render('header') ?>
<h1>Welcome to the blog</h1>
<ul>
    <li><a href="<?= $router->generateUri('blog_show', ['slug' => 'article-1'])?>">Article 1</a></li>
</ul>
<?= $renderer->render('footer') ?>