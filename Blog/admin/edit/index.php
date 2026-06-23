<?php
require(__DIR__."/../session_login.php");

$stmt = $sql->prepare("SELECT * FROM `BLOG_ARTICLE` WHERE `ID` = :id;");
$stmt->bindValue(":id", $_GET["ID"], PDO::PARAM_STR);
$stmt->execute();
$article = $stmt->fetch();
if ($article == false) {
	http_response_code(404);
	exit;
}

$is_public = false;
if ($article["IS_PUBLIC"] == 1) $is_public = true;
?>
<!DOCTYPE html>
<HTML>
	<HEAD>
		<TITLE>るみさんのブログ 編集</TITLE>

		<LINK REL="stylesheet" HREF="https://cdn.rumia.me/CSS/reset.css">
		<LINK REL="stylesheet" HREF="https://cdn.rumia.me/CSS/DEFAULT.css">

		<STYLE>
			:root{
				--MARGIN: 10px;
				--METADATA_EDITOR_HEIGHT: 150px;
			}

			body{
				margin: 0px;
			}

			.METADATA_EDITOR{
				width: 100%;
				height: var(--METADATA_EDITOR_HEIGHT);

				border-bottom: solid 1px;

				padding: var(--MARGIN);
			}

			.METADATA_EDITOR > .TITLE{
				font-size: 40px;

				width: calc(100% - (var(--MARGIN) * 4));
			}

			.TEXT_EDITOR{
				width: 100%;
				height: calc(100vh - var(--METADATA_EDITOR_HEIGHT));

				padding: var(--MARGIN);

				display: flex;
				flex-direction: row;
			}

			.TEXT_EDITOR > *{
				width: 50%;
			}
		</STYLE>
	</HEAD>
	<BODY>
		<DIV CLASS="METADATA_EDITOR">
			<INPUT TYPE="text" ID="TITLE" CLASS="TITLE" VALUE="<?=htmlspecialchars($article["TITLE"])?>">
			<BR>
			<INPUT TYPE="checkbox" ID="IS_PUBLIC" CLASS="IS_PUBLIC" <?php
				if ($is_public) echo "checked";
			?>><LABEL FOR="IS_PUBLIC">公開</LABEL>
			<DIV ID="SAVE_DATE"></DIV>
			<DIV>
				<INPUT TYPE="file" ID="FILE_SELECT"><BUTTON ID="FILE_UPLOAD">アップロード</BUTTON>
			</DIV>
		</DIV>

		<DIV CLASS="TEXT_EDITOR">
			<TEXTAREA ID="TEXT" VALUE="<?=htmlspecialchars($article["TEXT"])?>"></TEXTAREA>
			<DIV ID="VIEWER"></DIV>
		</DIV>
	</BODY>

	<SCRIPT>
		const id = "<?=$article["ID"]?>";
		let mel = {
			title: document.getElementById("TITLE"),
			is_public: document.getElementById("IS_PUBLIC"),
			text_input: document.getElementById("TEXT"),
			viewer: document.getElementById("VIEWER"),
			save_date: document.getElementById("SAVE_DATE"),
			file_upload: {
				select: document.getElementById("FILE_SELECT"),
				upload: document.getElementById("FILE_UPLOAD")
			}
		};

		//最後の入力から0.5秒後に画面更新をするシステム
		let viewer_reflesh_timer = null;
		let viewer_reflesh_last_update_text = "";
		async function viewer_reflesh() {
			clearTimeout(viewer_reflesh_timer);
			viewer_reflesh_timer = setTimeout(async function() {
				const now_text = mel.text_input.value;
				if (viewer_reflesh_last_update_text == now_text) return;
				viewer_reflesh_last_update_text = now_text;

				let fd = new FormData();
				fd.set("TEXT", now_text);

				let ajax = await fetch("rml_decode.php", {
					method: "POST",
					body: fd
				});
				const result = await ajax.text();
				mel.viewer.innerHTML = result;
			}, 500);
		}

		window.addEventListener("load", viewer_reflesh);
		mel.text_input.addEventListener("keyup", viewer_reflesh);

		window.addEventListener("keydown", async function(e) {
			if (e.ctrlKey && e.key == "s") {
				e.preventDefault();
				mel.save_date.innerText = "保存: " + new Date().toISOString();

				let fd = new FormData();
				fd.set("ID", id);
				fd.set("TITLE", mel.title.value);
				fd.set("TEXT", mel.text_input.value);
				if (mel.is_public.checked) {
					fd.set("IS_PUBLIC", "T");
				} else {
					fd.set("IS_PUBLIC", "F");
				}

				let ajax = await fetch("save.php", {
					method: "POST",
					body: fd
				});
				const result = await ajax.text();
			}
		});

		mel.file_upload.upload.addEventListener("click", async function() {
			const file_list = mel.file_upload.select.files;
			for (const file of file_list) {
				const fd = new FormData();
				fd.set("FILE", file);

				let ajax = await fetch(`upload.php?ID=${id}`, {
					method: "POST",
					body: fd
				});
				const result = await ajax.json();
				if (result.STATUS == false) {
					return;
				}

				//入力欄に突っ込む
				const cur_start = mel.text_input.selectionStart;
				const cur_end = mel.text_input.selectionEnd;
				const text = mel.text_input.value;
				mel.text_input.value = text.substring(0, cur_start) + result.URL + text.substring(cur_end);

				const pos = cur_start + result.URL.length;
				textarea.selectionStart = pos;
				textarea.selectionEnd = pos;

				textarea.focus();
			}
		});
	</SCRIPT>
</HTML>