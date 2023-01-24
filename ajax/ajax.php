<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
//将出错信息输出到一个文本文件
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');  
    if(!is_array($_GET)&&count($_GET)<=0){
       exit();
    }
    include('../lib.php');
    $type=$_GET['type'];
    @$q=urlencode($_GET['q']);
    $ptk= isset($_GET['ptk']) ? $_GET['ptk'] : '';
    $order=isset($_GET['order'])?$_GET['order']:'relevance';
    $sortid=$_GET['sortid'];
    switch($type){
    	case 'video':
            	   $videodata=get_search_video($q,APIKEY,$ptk,'video',$order,GJ_CODE);
            	   	if($videodata['pageInfo']['totalResults']<=1){
    		    echo'<div class="alert alert-danger h4 p-3 m-2" role="alert">申し訳ございませんが、該当するものはございませんでした。<strong>'.urldecode($q).'</strong>関連動画</div>';
    		    exit;
    		}
            	   echo '<ul  class="list-unstyled  video-list-thumbs row pt-1">';
            	   foreach($videodata["items"] as $v) {
                echo '<li class="col-xs-6 col-sm-6 col-md-4 col-lg-4" ><a href="./watch.php?v='.$v["id"]["videoId"].'" target="_black" class="hhh" title="'.$v["snippet"]["title"].'" >
            			<img src="./thumbnail.php?type=mqdefault&vid='.$v["id"]["videoId"].'" class="img-responsive" />
            			<p class="fa fa-play-circle-o kkk" ></p>
            			<span class="text-dark text-overflow font2 my-2">'.$v["snippet"]["title"].'</span></a>
            		
            		<div class="pull-left pull-left1 icontext"><i class="fa fa-user icoys"></i><span class="pl-1"><a href="./channel.php?channelid='.$v["snippet"]["channelId"].'" class="icoys" title="'.$v["snippet"]["channelTitle"].'" >'.$v["snippet"]["channelTitle"].'</a>
            		</span></div>
            		
            		<div class="pull-right pull-right1 icontext">
            		    <i class="fa fa-clock-o pl-1 icoys "></i><span class="pl-1 icoys">'.format_date($v["snippet"]["publishedAt"]).'</span></div>
            </li>';
            }
                echo '</ul> ';
                echo '<div class="col-md-12">';
            if (array_key_exists("nextPageToken",$videodata) && array_key_exists("prevPageToken",$videodata) ) {
               
                echo'<a class="btn btn-outline-primary  w-25 pull-left" href="./search.php?q='.$_GET["q"].'&order='.$_GET["order"].'&type='.$_GET['type'].'&pageToken='.$videodata["prevPageToken"].'" data-toggle="">前のページへ</a>
                      <a class="btn btn-outline-primary  w-25 pull-right" href="./search.php?q='.$_GET["q"].'&order='.$_GET["order"].'&type='.$_GET['type'].'&pageToken='.$videodata["nextPageToken"].'" data-toggle="">次のページ</a>
                    ';
            } elseif (array_key_exists("nextPageToken",$videodata) && !array_key_exists("prevPageToken",$videodata)) {
                echo '<a class="btn btn-outline-primary btn-block" href="./search.php?q='.$_GET["q"].'&order='.$_GET["order"].'&type='.$_GET['type'].'&pageToken='.$videodata["nextPageToken"].'" data-toggle="">次のページ</a>
                    ';
            } elseif (!array_key_exists("nextPageToken",$videodata) && !array_key_exists("prevPageToken",$videodata)) {} else {
                echo '<a class="btn btn-outline-primary btn-block" href="./search.php?q='.$_GET["q"].'&order='.$_GET["order"].'&type='.$_GET['type'].'&pageToken='.$videodata["prevPageToken"].'" data-toggle="">前のページへ</a>' ;
            }
            echo'</div>';
    		break;
        case 'recommend':
    $random=random_recommend();
    foreach($random as $v) {
    echo '<span class="txt2 ricon h5">'.$v['t'].'</span>';
     echo'<ul class="list-unstyled video-list-thumbs row pt-1">';
        foreach ($v['dat'] as $value) {
          
    echo '<li class="col-xs-6 col-sm-6 col-md-4 col-lg-4" ><a href="./watch.php?v='. $value['id'].'" class="hhh" >
    			<img src="./thumbnail.php?type=mqdefault&vid='.$value['id'].'" class=" img-responsive" /><p class="fa fa-play-circle-o kkk" ></p>
    			<span class="text-dark text-overflow font2 my-2" title="'.$value['title'].'">'.$value['title'].'</span></a>';
    		
        }
    echo '</ul>';
    		} 
      break;
    	case 'channel':
                  $videodata=get_search_video($q,APIKEY,$ptk,'channel',$order,GJ_CODE);
                  echo'<div class="row">';
            	   foreach($videodata['items'] as $v) {
            	    echo '<div class="col-md-6 col-sm-12 col-lg-6 col-xs-6 p-3 offset"><div class="media">
      <img class="col-4 d-flex align-self-center mr-3  mtpd" src="./thumbnail.php?type=photo&vid='.$v['snippet']['channelId'].'">
      <div class="media-body col-8 chaneelit">
        <a href="./channel.php?channelid='.$v['snippet']['channelId'].'" class="mtpda"><h5 class="mt-0">'.$v['snippet']['channelTitle'].'</h5></a>
        <p class="mb-0">'.$v['snippet']['description'].'</p>
      </div>
    </div></div>';
    }
    	            echo'</div>';
    	            echo '<div class="col-md-12 pt-3">';
            if (array_key_exists("nextPageToken",$videodata) && array_key_exists("prevPageToken",$videodata) ) {
               
                echo'<a class="btn btn-outline-primary  w-25 pull-left" href="./search.php?q='.$_GET["q"].'&order='.$_GET["order"].'&type='.$_GET['type'].'&pageToken='.$videodata["prevPageToken"].'" data-toggle="">前のページへ</a>
                      <a class="btn btn-outline-primary  w-25 pull-right" href="./search.php?q='.$_GET["q"].'&order='.$_GET["order"].'&type='.$_GET['type'].'&pageToken='.$videodata["nextPageToken"].'" data-toggle="">次のページ</a>
                    ';
            } elseif (array_key_exists("nextPageToken",$videodata) && !array_key_exists("prevPageToken",$videodata)) {
                echo '<a class="btn btn-outline-primary btn-block" href="./search.php?q='.$_GET["q"].'&order='.$_GET["order"].'&type='.$_GET['type'].'&pageToken='.$videodata["nextPageToken"].'" data-toggle="">次のページ</a>
                    ';
            } elseif (!array_key_exists("nextPageToken",$videodata) && !array_key_exists("prevPageToken",$videodata)) {} else {
                echo '<a class="btn btn-outline-primary btn-block" href="./search.php?q='.$_GET["q"].'&order='.$_GET["order"].'&type='.$_GET['type'].'&pageToken='.$videodata["prevPageToken"].'" data-toggle="">前のページへ</a>' ;
            }
            echo'</div>';
    		break;
    	case 'channels':
    		$video=get_channel_video($_GET['channelid'],$ptk,APIKEY,GJ_CODE);
    		if($video['pageInfo']['totalResults']<=1){
    		    echo'<p>コンテンツ取得に失敗しました。このチャンネルのユーザーによってアップロードされたコンテンツがない、またはこのチャンネルのコンテンツは著作権によって保護されており、現時点では閲覧することができません</p>';
    		    exit;
    		}
    		foreach($video['items'] as $v) {
        echo ' <div class="media height1 py-3 pt-3">
    		<div class="media-left" style="width:30%;min-width:30%;">
    		<a href="./watch.php?v='. $v['id']['videoId'].'" target="_blank" class="d-block" style="position:relative">
    		<img src="./thumbnail.php?type=mqdefault&vid='. $v['id']['videoId'].'" width="100%">
    		<p class="small smallp"><i class="fa fa-clock-o pr-1 text-white"></i>'.format_date($v['snippet']['publishedAt']).'</p>
    		</a>
    		</div>
    		<div class="media-body pl-2"  style="width:70%;max-width:70%;">
    			<h5 class="media-heading listfont">
    				<a href="./watch.php?v='. $v['id']['videoId'].'" target="_blank" class="font30" title="'.$v["snippet"]["title"].'">'.$v["snippet"]["title"].'</a>
    			</h5>
    			<p class="listfont1">'.$v['snippet']['description'].'</p>
    			
    		</div>
    	</div>';
     }
     
    
    if (array_key_exists("nextPageToken",$video) && array_key_exists("prevPageToken",$video) ) {
       
        echo'<a class="btn btn-outline-primary m-1 w-25 pull-left" href="./channel.php?channelid='.$_GET['channelid'].'&pageToken='.$video['prevPageToken'].'" data-toggle="">前のページへ</a>
              <a class="btn btn-outline-primary m-1 w-25 pull-right" href="./channel.php?channelid='.$_GET['channelid'].'&pageToken='.$video['nextPageToken'].'" data-toggle="">次のページ</a>
            ';
    } elseif (array_key_exists("nextPageToken",$video) && !array_key_exists("prevPageToken",$video)) {
        echo '<a class="btn btn-outline-primary m-1 btn-block" href="./channel.php?channelid='.$_GET['channelid'].'&pageToken='.$video['nextPageToken'].'" data-toggle="">次のページ</a>
            ';
    } elseif (!array_key_exists("nextPageToken",$video) && !array_key_exists("prevPageToken",$video)) {} else {
        echo '<a class="btn btn-outline-primary m-1 btn-block" href="./channel.php?channelid='.$_GET['channelid'].'&pageToken='.$video['prevPageToken'].'" data-toggle="">前のページへ</a>' ;
    }
    echo'</div>';
    break;
    	case 'related':
    	 $related=get_related_video($_GET['v'],APIKEY);
    	 
     foreach($related["items"] as $v) {
       echo'<div class="media height1">
    		<div class="media-left" style="width:40%">
    		<a href="./watch.php?v='.$v["id"]["videoId"].'" >
    		<img src="./thumbnail.php?type=mqdefault&vid='.$v["id"]["videoId"].'" width="100%">
    		</a>
    		</div>
    		<div class="media-body pl-2">
    			<h5 class="media-heading height2">
    				<a href="./watch.php?v='.$v["id"]["videoId"].'" class="text-dark">'.$v["snippet"]["title"].'</a>
    			</h5>
    			<p class="small mb-0 pt-2">'
    			.format_date($v["snippet"]["publishedAt"]).
    			'</p>
    		</div>
    	</div>';  
     }	
    		break;
    case 'menu':
        $vica=videoCategories(APIKEY,GJ_CODE);
        
        echo '<ul class="list-group text-dark">
        <li class="list-group-item font-weight-bold"><i class="fa fa-home fa-fw pr-4"></i><a href="./" class="text-dark">ホーム</a></li>
        <li class="list-group-item"><i class="fa fa-fire fa-fw pr-4"></i><a href="./content.php?cont=trending" class="text-dark">流行の動画</a></li>
        <li class="list-group-item"><i class="fa fa-history fa-fw pr-4"></i><a href="./content.php?cont=history" class="text-dark">歴史</a></li>
        <li class="list-group-item"><i class="fa fa-gavel fa-fw pr-4"></i><a href="./content.php?cont=DMCA"class="text-dark">DMCA</a></li>
        <li class="list-group-item"><i class="fa fa-cloud-download fa-fw pr-4"></i><a href="./content.php?cont=video" class="text-dark">ビデオのダウンロード</a></li>
        <li class="list-group-item"><i class="fa fa-file-code-o fa-fw pr-4 pr-4"></i><a href="./content.php?cont=api" class="text-dark">API</a></li>
        </ul>
        <ul class="list-group pt-3">
        <li class="list-group-item font-weight-bold"></i>ユーチューブ機能</li>
        ';
        foreach($vica['items'] as $v){
        echo '<li class="list-group-item"><a href="./content.php?cont=category&sortid='.$v['id'].'" class="text-dark">'.$v['snippet']['title'].'</a></li>';    
        }
        echo '</ul>';
        break;
    
    case 'trending':
    $home_data=get_trending(APIKEY,'18','',GJ_CODE);
    echo'<ul class="list-unstyled video-list-thumbs row pt-1">';
    foreach($home_data["items"] as $v) {
    echo '<li class="col-xs-6 col-sm-6 col-md-4 col-lg-4" ><a href="./watch.php?v='. $v["id"].'" class="hhh" >
    			<img src="./thumbnail.php?type=mqdefault&vid='.$v["id"].'" class=" img-responsive" /><p class="fa fa-play-circle-o kkk" ></p>
    			<span class="text-dark text-overflow font2 my-2" title="'.$v["snippet"]["title"].'">'.$v["snippet"]["title"].'</span></a>
    			<div class="pull-left pull-left1 icontext"><i class="fa fa-user icoys"></i><span class="pl-1"><a href="./channel.php?channelid='.$v["snippet"]["channelId"].'"  class=" icoys" title="'.$v["snippet"]["channelTitle"].'">'.$v["snippet"]["channelTitle"].'</a></span></div>
    		
    		<div class="pull-right pull-right1 icontext icoys">
    		    <i class="fa fa-clock-o pl-1"></i><span class="pl-1">'.format_date($v["snippet"]["publishedAt"]).'</span></div>
    		<span class="duration">'.covtime($v["contentDetails"]["duration"]).'</span></li>';
    		}  
    echo '</ul>';
      break;
    
    
      
    case 'DMCA':
        echo '<div class="font-weight-bold h6 pb-1">DMCAと免責事項</div>';
        echo '<h6><b>DMCA：</b><h6>';
        echo '<p class="h6" style="line-height: 1.7">This site video content from the Internet.<br>
If inadvertently violate your copyright.<br>
Send copyright complaints to '.EMAIL.'! We will response within 48 hours!<br></p>';
echo '<h6 class="pt-3"><b>ユーザーへの通知：</b><h6>';
        echo '<p class="h6" style="line-height: 1.7">このサイトはYou2PHPと言うツールを利用して作られています。以下の条件は全てYou2PHPの規約です。この契約の条件に同意しない場合は、このウェブサイトを使用しないことを選択できます。このサイトを閲覧すると、意図的または意図的でないにかかわらず、この契約のすべての条件に完全に同意したことになります。<br>
        1.このサイトは非手動検索を使用しており、リクエストされたコンテンツの著作権は第三者サイトのコンテンツに属しています。このサイトのウェブページから情報を取得し、サービスを楽しむことができますが、このサイトは合法性について責任を負いません。また、いかなる法的責任も負わないものとします。<br>
        2.このサイトのすべてのコンテンツは第三者のサイトからのものです。このサイトは技術的手段を使用して、有害で違法なコンテンツを最大限にフィルタリングおよびブロックします。これらのコンテンツを誤って閲覧した場合は、すぐに閉じてください。<br>
        3.このサイトを使用する場合、ユーザーはこのサイトのコンテンツを使用して、中国の法律および社会道徳に違反する行為を直接的または間接的に行わないことを約束する必要があり、このサイトは上記の約束に違反するコンテンツを削除する権利を有します。<br>
        4.個人または組織は、このサイトのコンテンツを使用して、次のコンテンツを作成、アップロード、コピー、公開、流布、または転載することはできません: 憲法によって確立された基本原則に反するもの、国家安全保障を危険にさらすもの、国家機密を漏洩するもの、国家を転覆するもの、国の統一を弱体化させるもの、国家の名誉と利益、民族的憎悪、民族差別を扇動し、国家の統一を弱体化させるもの、国家の宗教政策を弱体化させ、カルトと封建的迷信を助長する噂を広め、社会秩序を乱し、社会的安定を弱体化させるもの、わいせつ、ポルノを広める賭博、暴力、殺人、恐怖または犯罪の幇助をするもの、他者を侮辱または誹謗中傷するもの、他者の正当な権利と利益を侵害するもの、法律および行政法規により禁止されているその他の内容を含むもの。<br></p>';
        echo '<h6 class="pt-3"><b>免責事項：</b><h6>';
         echo '<p class="h6" style="line-height: 1.7">1.このサイトは、インデックスを作成するサードパーティのWebサイトのコンテンツの正確性を保証するものではありません。<br>
         2.第三者のウェブサイトに掲載されている内容は、個人の立場や意見を表明するものであり、本サイトは検索ツールとしてのみ使用されており、本サイトの立場や意見を代表するものではありません。 このサイトは、コンテンツの作成者ではなく、第三者のウェブサイトのコンテンツについて責任を負いません. 第三者のウェブサイトのコンテンツに起因するすべての紛争については、コンテンツの作成者がすべての法的および連帯責任を負うものとします。このサイトは、法的および連帯責任を負いません。<br>
         
         </p>';
       break;
     case 'api':
         echo '<div class="font-weight-bold h6 pb-1">API</div>';
         echo '<p>インターフェイスアドレス:</p>
         <div class="alert table-inverse" role="alert">'.dirname('http://'.$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"]).'/api.php</div><p>リクエスト方法 : GET</p><table class="table table-bordered table-active"><thead><tr><th>パラメータ名</th><th>パラメータの説明</th></tr> </thead><tbody><tr><td>type</td><td>リクエストの種類(パラメータが info の場合はビデオ情報を取得し、パラメータがdownlinkの場合はビデオのダウンロードリンクを取得します。)</td></tr><tr><td>v</td><td>YouTube動画ID</td></tr></tbody></table>'
               ;
         echo '<h5>動画情報取得：（動画コンテンツ、動画紹介、制作者等の情報）</h5>';
         echo '<p>リクエスト例：'.dirname('http://'.$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"]).'/api.php?type=info&v=LsDwn06bwjM</p>
               <p>戻り値： JSON</p>';
         
         echo '<h5>ビデオソースのダウンロードリンクを取得する:</h5>';
         echo '<p>リクエスト例：'.dirname('http://'.$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"]).'/api.php?type=downlink&v=LsDwn06bwjM</p>
               <p>戻り値： JSON</p>';
         break;
    case 'videos':
        echo '<div class="font-weight-bold h6 pb-1">ビデオのダウンロード</div>';
        echo '<form  onsubmit="return false" id="ipt">
  <div class="form-group text-center" >
  <input name="type" value="videodownload" style="display: none;">
      <input type="text" name="link"  placeholder="Youtubeビデオリンクを入力してください" id="soinpt"  autocomplete="off" /><button type="submit" id="subu" style="width: 24%;vertical-align:middle;border: none;height: 50px;background-color: #e62117;color: #fff;font-size: 18px;display: inline-block;" ><i class="fa fa-download fa-lg pr-1"></i>ダウンロード</button>
  </div>
    </form>';
    if(isset($_GET['type']) && isset($_GET['v'])){
        echo '<div id="videoslist" class="text-center">';
       $viddata=get_video_info($_GET['v'],APIKEY);
        echo '<h5>'.$viddata['items']['0']['snippet']['title'].'</h5>';
        echo '<div class="p-3"><img src="./thumbnail.php?type=0&vid='.$_GET['v'].'" class="rounded img-fluid"></div>';
        echo video_down($_GET['v'],$viddata['items']['0']['snippet']['title']);  
        echo '</div>';
    }else{
        echo '<div id="videoslist" class="text-center"><p>ヒント: ダウンロードできない場合は、右クリックして名前を付けて保存してください。<p></div>'; 
    }
    echo '<script>
     $("#subu").click(function() {$("#videoslist").load(\'./ajax/ajax.php\',$("#ipt").serialize());});
 </script>
';
       break;
       
       
    case 'trendinglist':
    $home=get_trending(APIKEY,'48',$ptk,GJ_CODE);
        echo '<div class="font-weight-bold h6 pb-1">最近の流行</div> ';
    echo'<ul class="list-unstyled video-list-thumbs row pt-1">';
    foreach($home["items"] as $v) {
    echo '<li class="col-xs-6 col-sm-6 col-md-4 col-lg-4" ><a href="./watch.php?v='. $v["id"].'" class="hhh" >
    			<img src="./thumbnail.php?type=mqdefault&vid='.$v["id"].'" class=" img-responsive" /><p class="fa fa-play-circle-o kkk" ></p>
    			<span class="text-dark text-overflow font2 my-2">'.$v["snippet"]["title"].'</span></a>
    			<div class="pull-left pull-left1 icontext"><i class="fa fa-user icoys"></i><span class="pl-1"><a href="./channel.php?channelid='.$v["snippet"]["channelId"].'"  class="icoys">'.$v["snippet"]["channelTitle"].'</a></span></div>
    		
    		<div class="pull-right pull-right1 icoys icontext">
    		    <i class="fa fa-clock-o"></i><span class="pl-1">'.format_date($v["snippet"]["publishedAt"]).'</span>
    		</div>
    		<span class="duration">'.covtime($v["contentDetails"]["duration"]).'</span>
    		</li>';
    		}  
    echo '</ul>';
    if (array_key_exists("nextPageToken",$home) && array_key_exists("prevPageToken",$home) ) {
       
        echo'<a class="btn btn-outline-primary m-1 w-25 pull-left" href="./content.php?cont=trending&pageToken='.$home['prevPageToken'].'" data-toggle="">前のページ</a>
              <a class="btn btn-outline-primary m-1 w-25 pull-right" href="./content.php?cont=trending&pageToken='.$home['nextPageToken'].'" data-toggle="">次のページ</a>
            ';
    } elseif (array_key_exists("nextPageToken",$home) && !array_key_exists("prevPageToken",$home)) {
        echo '<a class="btn btn-outline-primary m-1 btn-block" href="./content.php?cont=trending&pageToken='.$home['nextPageToken'].'" data-toggle="">次のページ</a>
            ';
    } elseif (!array_key_exists("nextPageToken",$home) && !array_key_exists("prevPageToken",$home)) {} else {
        echo '<a class="btn btn-outline-primary m-1 btn-block" href="./content.php?cont=trending&pageToken='.$home['prevPageToken'].'" data-toggle="">前のページ</a>' ;
    }
    break;
    
    
    
    case 'history':
    $hisdata=Hislist($_COOKIE['history'],APIKEY);
    echo '<div class="font-weight-bold h6 pb-1">履歴</div> ';
       if($hisdata['pageInfo']['totalResults'] ==0){echo '<div class="alert alert-warning" role="alert"><h4 class="alert-heading">履歴</h4>
  <p>まだ動画見てないよん</p>
  <p class="mb-0">このサイトでは、Cookie を使用して、履歴をブラウザに一時的に保存します。このサイトでは、閲覧履歴は保存されませんが、最近 30 回の閲覧履歴のみが記録されます。ブラウザの Cookie をクリアすると、履歴もリセットされます!</p>
</div>';exit();}           
                foreach($hisdata["items"] as $v) {
                $description = strlen($v['snippet']['description']) > 250 ? substr($v['snippet']['description'],0,250)."...." : $v['snippet']['description'];
                echo '<div class="media height1 py-3 pt-3 ">
    		<div class="media-left" style="width:30%;min-width:30%;">
    		<a href="./watch.php?v='.$v['id'].'" target="_blank" class="d-block" style="position:relative">
    		<img src="./thumbnail.php?type=mqdefault&vid='.$v["id"].'" width="100%">
    		<p class="small smallp"><i class="fa fa-clock-o pr-1 text-white"></i>'.covtime($v['contentDetails']['duration']).'</p>
    		</a>
    		</div>
    		<div class="media-body pl-2"  style="width:70%;max-width:70%;">
    			<h5 class="media-heading listfont">
    				<a href="./watch.php?v='.$v['id'].'" target="_blank" class="font30">'.$v["snippet"]["title"].'</a>
    			</h5>
    			<p class="listfont1">'.$description.'</p>
    			
    		</div> 
    		</div>';    
                    
                } 
     break;
     
     
    case 'videodownload': 
        if(stripos($_GET['link'],'youtu.be') !== false || stripos($_GET['link'],'youtube.com') !== false || stripos($_GET['link'],'watch?v=') !== false  ){}else{echo '<h6>違法な要求</h6>';break;exit();}
        preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $_GET['link'], $mats);
        $viddata=get_video_info($mats[1],APIKEY);
        echo '<h5>'.$viddata['items']['0']['snippet']['title'].'</h5>';
        echo '<div class="text-center p-3"><img src="./thumbnail.php?type=0&vid='.$mats[1].'" class="rounded img-fluid"></div>';
        echo video_down($mats[1],$viddata['items']['0']['snippet']['title']);
     break;
     
    case 'category':   
    $category=Categories($sortid,APIKEY,$ptk,$order,GJ_CODE);
    if($category['pageInfo']['totalResults']=='0'){
        echo '<div class="alert alert-danger m-2" role="alert">
                <strong>ごめんね</strong> 著作権の制限により、このタイプのコンテンツは一時的に閲覧できません!
              </div>';
              exit();
    }
    echo'<ul class="list-unstyled video-list-thumbs row pt-1">';
    foreach($category['items'] as $v) {
    echo '<li class="col-xs-6 col-sm-6 col-md-4 col-lg-4" ><a href="./watch.php?v='. $v['id']['videoId'].'" class="hhh" >
    			<img src="./thumbnail.php?type=mqdefault&vid='.$v['id']['videoId'].'" class=" img-responsive" /><p class="fa fa-play-circle-o kkk" ></p>
    			<span class="text-dark text-overflow font2 my-2">'.$v['snippet']['title'].'</span></a>
    			<div class="pull-left pull-left1 icontext"><i class="fa fa-user"></i><span class="pl-1 icoys"><a href="./channel.php?channelid='.$v['snippet']['channelId'].'" class="icoys">'.$v['snippet']['channelTitle'].'</a></span></div>
    		
    		<div class="pull-right pull-right1 icontext icoys">
    		<i class="fa fa-clock-o pl-1"></i><span class="pl-1">'.format_date($v["snippet"]["publishedAt"]).'</span>
            </div>
    		';
    		}  
    echo '</ul>';
    if (array_key_exists("nextPageToken",$category) && array_key_exists("prevPageToken",$category) ) {
       
        echo'<a class="btn btn-outline-primary m-1 w-25 pull-left" href="./content.php?cont=category&sortid='.$sortid.'&order='.$_GET["order"].'&pageToken='.$category['prevPageToken'].'" data-toggle="">前のページ</a>
              <a class="btn btn-outline-primary m-1 w-25 pull-right" href="./content.php?cont=category&sortid='.$sortid.'&order='.$_GET["order"].'&pageToken='.$category['nextPageToken'].'" data-toggle="">次のページ</a>
            ';
    } elseif (array_key_exists("nextPageToken",$category) && !array_key_exists("prevPageToken",$category)) {
        echo '<a class="btn btn-outline-primary m-1 btn-block" href="./content.php?cont=category&sortid='.$sortid.'&order='.$_GET["order"].'&pageToken='.$category['nextPageToken'].'" data-toggle="">次のページ</a>
            ';
    } elseif (!array_key_exists("nextPageToken",$category) && !array_key_exists("prevPageToken",$category)) {} else {
        echo '<a class="btn btn-outline-primary m-1 btn-block" href="./content.php?cont=category&sortid='.$sortid.'&order='.$_GET["order"].'&pageToken='.$category['prevPageToken'].'" data-toggle="">前のページ</a>' ;
    }
    
    break;    
    }
    
?>