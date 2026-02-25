<DIV CLASS="COMMENT_ITEM" data-id="<?=$comment["ID"]?>">
	<DIV CLASS="USER"><IMG SRC="https://account.rumiserver.com/api/Icon?UID=<?=htmlspecialchars("0")?>"><?=htmlspecialchars($comment["UID"])?></DIV>
	<DIV CLASS="TEXT">
		<?=nl2br(htmlspecialchars($comment["TEXT"]))?><BR>
		<A HREF="comment.php?ID=<?=$comment["ID"]?>&BLOG=<?=$comment["BLOG_ID"]?>">--------リプライ--------</A>
	</DIV>
</DIV>