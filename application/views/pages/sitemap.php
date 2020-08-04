<?php
	header('Content-type: application/xml');
 
	// configuration
	$blog_timezone = 'UTC';
	$timezone_offset = '+03:00';
	$W3C_datetime_format_php = 'Y-m-d\Th:i:s';
	$null_sitemap = '<urlset><url><loc></loc></url></urlset>';
 
	echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
	echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

	echo "<url>";
		echo "<loc>".site_url()."</loc>";
		echo "<changefreq>daily</changefreq>";
	echo "</url>\n";

	echo "<url>";
		echo "<loc>".site_url("pages/nosotros")."</loc>";
	echo "</url>\n";

	echo "<url>";
		echo "<loc>".site_url("pages/mundo")."</loc>";
	echo "</url>\n";

	echo "<url>";
		echo "<loc>".site_url("pages/servicio")."</loc>";
	echo "</url>\n";

	echo "<url>";
		echo "<loc>".site_url("pages/privacidad")."</loc>";
	echo "</url>\n";

	echo "<url>";
		echo "<loc>".site_url("pages/contacto")."</loc>";
	echo "</url>\n";

	echo "</urlset>";
?>