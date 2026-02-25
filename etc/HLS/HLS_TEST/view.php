<a href="./ex.html"><IMG src="/Asset/VIDEOTUBE/vt.png" width="500"></a><BR>

<link rel="stylesheet" href="./view_CSS.CSS">

<script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
<video id="HLS_video" class="HLS_VIDEO" controls></video>

<script>
if(Hls.isSupported()) {
	var video = document.getElementById('HLS_video');
	var hls = new Hls();
	hls.loadSource('./video/<?php echo $_GET["ID"]; ?>/<?php echo $_GET["ID"]; ?>.m3u8');
	hls.attachMedia(video);
}
</script>
<div style="padding: 10px; margin-bottom: 10px; border: 1px solid #333333;" class="ETC_VIDEO">
<H1>その他の動画</H1>
<a href="./view.php?ID=RM_aadjwfioW_SIN" class="other_video_Thumbnail"><IMG src="/Asset/SINch/R_W.png"><BR>かわいい動画！！！！</a><BR>
</div>