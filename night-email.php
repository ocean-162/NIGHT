<?php
ini_set(“display_errors”, “On”);
error_reporting(E_ERROR);
header(“Content-type: text/html; charset=utf-8”);

$mailServer = ‘imap.qq.com’; //IMAP server address
$mailLink = “{{$mailServer}:143}INBOX”; // 143 is the port when not SSL
$mailUser = $_GET[’email’];  // email address
$mailPass = $_GET[‘pwd’];// client authorization code
$mail_i = intval($_GET[‘index’]);

if($mailUser != ” && $mailPass != ”) {
    $Email = new Email();
    $conn = $Email->mailConnect($mailServer, 143, $mailUser, $mailPass);
}

function decode_title($str) {
    $arr = imap_mime_header_decode($str);
    return $arr[0]->text;
}

function decode_attach($str) {
    $arr = imap_mime_header_decode($str);
    return iconv($arr[0]->charset, “utf-8”, $arr[0]->text);
}
?>

<!doctype html>
<html lang=”zh-CN”>
    <head>
        <meta charset=”utf-8″>
        <meta http-equiv=”X-UA-Compatible” content=”IE=edge”>
        <meta name=”viewport” content=”width=device-width, initial-scale=1″>
        <!– 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ –>
        <title>方维网络-接收邮件测试</title>
    </head>
    <body>
        <div style=”padding:40px;width:400px;”>
            <form method=”get” action=””>
                <div class=”input-group”>
                    <span class=”input-group-addon” id=”basic-addon1″>邮箱账号：</span>
                    <input type=”text” class=”form-control” value=”<?php echo $mailUser;?>” name=”email” placeholder=”输入QQ邮箱账号：” aria-describedby=”basic-addon1″>
                </div>
                <div class=”input-group”>
                    <span class=”input-group-addon” id=”basic-addon1″>邮箱密码：</span>
                    <input type=”text” class=”form-control” value=”<?php echo $mailPass;?>” name=”pwd” placeholder=”QQ邮箱密码：” aria-describedby=”basic-addon1″>

                </div>
                <div class=”input-group”>
                    <span class=”input-group-addon” id=”basic-addon1″>邮件开始数：</span>
                    <input type=”number” class=”form-control” value=”<?php echo $mail_i;?>” name=”index” placeholder=”邮件开始数” value=”1″ aria-describedby=”basic-addon1″>

                </div>
                <button type=”submit” class=”btn btn-default”>获取邮件</button>
                <input type=”hidden” name=”action” value=”get” />
            </form>
            邮箱密码是邮箱设置的imap密码,一次获取6封邮件
        </div>
<?php
if($conn) {
echo ‘总邮件数:’ . $Email->mailTotalCount() . ‘<br>’;
for ($i = $mail_i; $i < $mail_i+6; $i++) {
    $mailHeader = $Email->mailHeader($i);
    $attach_list = $Email->getAttach($i, “attach/”);
    $subject = decode_title($mailHeader[‘subject’]);
    // print_r($mailHeader);
    echo ‘<table border=1><tr><td><b>日期：</b>’ . date(‘Y-m-d H:i:s’, strtotime($mailHeader[‘date’])) . ‘</td></tr><tr><td><b>发件人：</b>’ . $mailHeader[‘from’] . ‘</td></tr><tr><td><b>标题：</b>’ . $subject . ‘</td></tr>’;
    echo ‘<tr><td>正文：</td></tr><tr><td>’ . $Email->getBody($i) . ‘</td></tr><tr><td>是否已读：’ . $Email->mailRead($i) . ‘  ID：’ . $mailHeader[‘id’] . ‘ </td></tr>’;
    echo ‘<tr><td>附件：’;
    foreach ($attach_list as $attach) {
        echo ‘<a href=”attach/’ . decode_attach($attach) . ‘” target=”_blank”>’ . decode_attach($attach) . ‘</a>’;
    }
    if (count($attach_list) == 0) {
        echo ‘无附件’;
    }
    echo ‘</td></tr>’;
    echo ‘</table>’;
}
}