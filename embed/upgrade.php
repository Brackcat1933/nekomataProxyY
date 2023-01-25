<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <title>更新を確認する</title>
    </head>
    <body>
        <?php
        $version='4.0';
        $Posttime='20171225';
        $ch=curl_init();
        curl_setopt($ch,CURLOPT_URL ,'https://raw.githubusercontent.com/zxq2233/You2php.github.io/master/version.json');
        curl_setopt($ch,CURLOPT_RETURNTRANSFER ,1);
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT ,20);
        curl_setopt($ch,CURLOPT_REFERER ,'http://www.youtube.com/');
        curl_setopt($ch,CURLOPT_USERAGENT ,"Mozilla/5.0 (Windows NT 5.1) AppleWebKit/534.30 (KHTML, like Gecko) Chrome/12.0.742.91 Safari/534.30");
        $f=curl_exec($ch);
        curl_close($ch);
        $up=json_decode($f,true);
        if ( (int)$up['time'] > (int)$Posttime ) {
            
            echo 'このプログラムには既に最新バージョンがあります。アップグレードしてください。</br>';
           echo '現行版：v'.$version.'</br>';
           echo '最新バージョン：v'.$up['version'].'</br>';
           echo 'こちらのアドレスから最新版をダウンロードしてください：<a href="'.$up['links'].'" target="_blank">'.$up['links'].'</a></br>';
           echo '更新内容：'.$up['des'];
        } else{
          echo 'このプログラムはすでに最新バージョンです。アップグレードする必要はありません。'; 
        }
        ?>    
</body>
</html>