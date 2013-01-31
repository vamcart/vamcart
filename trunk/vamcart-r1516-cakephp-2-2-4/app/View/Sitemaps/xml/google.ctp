<?php echo "<?xml version='1.0' encoding='UTF-8'?>\n" ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
<?php foreach ($content_list as $item) { ?>
	<url>
		<loc><?php echo Router::url($item['url'], true) ?></loc>
		<priority><?php echo $item['priority'] ?></priority>
		<lastmod><?php echo $this->Time->toAtom($item['lastmod']) ?></lastmod>
		<changefreq><?php echo $item['changefreq'] ?></changefreq>
	</url>
<?php } ?>
</urlset>

