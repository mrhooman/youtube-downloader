<?php
$YouTube_Folder = "video/";
$YouTube_id = $_GET['id']; //the youtube video ID
$YouTube_format = "mp4"; //the MIME type of the video. e.g. video/mp4, video/webm, etc.
parse_str(file_get_contents("http://youtube.com/get_video_info?video_id=".$YouTube_id),$YouTube_info); //decode the data
$YouTube_streams = $YouTube_info['url_encoded_fmt_stream_map']; //the video's location info
$YouTube_streams = explode(',',$YouTube_streams);
foreach($YouTube_streams as $YouTube_stream){
    parse_str($YouTube_stream,$YouTube_data); //decode the stream
    if(stripos($YouTube_data['type'],$YouTube_format) !== false){ //We've found the right stream with the correct format
        $YouTube_video = fopen($YouTube_data['url'],'r'); //the video
        $YouTube_file = fopen($YouTube_Folder.$YouTube_id.".mp4",'w');
        stream_copy_to_stream($YouTube_video,$YouTube_file); //copy it to the file
        fclose($YouTube_video);
        fclose($YouTube_file);
        echo 'Download finished!';
        break;
    }
}
?>
