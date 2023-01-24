<?php
header("HTTP/1.0 404 Not Found");
$headtitle='エラー！';
include("./header.php");?>

<div class="container-fluid" style="height: 480px;
    background-color: #dbdbdb;">
    <div class="container" style="height: 100%">
        <div class="row" style="height: 100%">
 <div class="col-12 justify-content-center align-self-center text-center">
     <img src="//wx3.sinaimg.cn/large/b0738b0agy1fm04l0cw4ej203w02s0sl.jpg" class="p-2" >
      <h2>リクエストされた内容、存在しないっぽい</h2>
      <p>ごめんだけどリクエストされた内容を読み込めなかったよ</p>
      <p>あり得る原因:</p>
      <p>1.入力したリンクが間違っている</p>
      <p>2.著作権で保護されてるコンテンツだった(著作権保護があると読み込めないんだ…)</p>
      <p>3.動画自体が存在しない</p>
      <p>4.サーバーにエラーがある</p>
  </div>

  </div>
    </div>
  
</div>


<?php
include("./footer.php"); 
?>