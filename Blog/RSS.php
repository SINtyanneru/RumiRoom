<?php
require(__DIR__."/env.php");
header("Content-Type: application/rss+xml; charset=UTF-8");

echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
?>
<rss version="2.0">
	<channel>
		<title>るみさんのブログ</title>
		<link><?="https://".$__DOMAIN."/".$__URL_PREFIX."/"?></link>
		<description>RSSなのだ</description>
		<language>ja</language>
		<lastBuildDate><?php echo date(DATE_RSS); ?></lastBuildDate>
		<?php
		$stmt = $PDO->prepare(<<<TEXT
			SELECT
				`ID`,
				`DATE`,
				`TITLE`,
				`PUBLIC`,
				`LOCK`,
				`TAG`,
				`UPDATE`,
				LENGTH(TEXT) AS BYTE_LENGTH
			FROM
				`BLOG`
			WHERE
				`PUBLIC` = 1
			ORDER BY
				`BLOG`.`DATE` DESC LIMIT 20;
		TEXT);

		//SQL実行
		$stmt->execute();
		$blog_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($blog_list as $row) {
			echo "		<item>\n";
			echo "			<title>".htmlspecialchars($row["TITLE"])."</title>\n";
			echo "			<link>https://".$__DOMAIN."/".$__URL_PREFIX."/view.php?ID=".$row["ID"]."</link>\n";
			echo "			<description>".htmlspecialchars("記事")."</description>\n";
			echo "			<pubDate>".date(DATE_RSS, strtotime($row["DATE"]))."</pubDate>\n";
			echo "			<guid>https://".$__DOMAIN."/".$__URL_PREFIX."//view.php?ID=".$row["ID"]."</guid>\n";
			echo "		</item>\n";
		}
		?>
	</channel>
</rss>