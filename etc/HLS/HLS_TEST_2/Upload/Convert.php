<?php
echo "動画ファイル".$VIDEO_ID.".mp4をHLSに変換しています....";
try{
    echo "変換開始：".$path.$VIDEO_ID."/".$VIDEO_ID;
    shell_exec('ffmpeg -i '.$path.$VIDEO_ID.'/'.$VIDEO_ID.'.mp4 -c:v copy -c:a copy -f hls -hls_time 10 -hls_playlist_type vod -hls_segment_filename "'.$path.$VIDEO_ID.'/'.$VIDEO_ID.'%3d.ts" '.$path.$VIDEO_ID.'/'.$VIDEO_ID.'.m3u8');
}catch (Exception $ex){
    echo "変換エラー".$ex;
}
?>