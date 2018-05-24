<?php
    $title = 'Сообщение с сайта: kalininsk.sarmo.ru';
    $to = "sergeymichkov@gmail.com" . ", ";
    $from = 'sergeymichkov@gmail.com';
    $addr = '';

    if (!empty($_POST['f_city'])) $addr = 'Населенный пункт: ' . $_POST['f_city'] . "\n";
    if (!empty($_POST['f_street'])) $addr .= 'Улица, дом, квартира: ' . $_POST['f_street'] . "\n";
    if (!empty($_POST['f_code'])) $addr .= 'Индекс: ' . $_POST['f_code'];

    $_POST['f_answer'] == '1' ? 
        $answer = 'по электронной почте отправителю' : 
        $answer = 'по почтовому адресу, (на бумажном носителе)';

    $message =  'Имя: ' . $_POST['f_name']. "\n" .
            'E-mail: ' . $_POST['f_email'] . "\n" .
            'Сообщение: ' . $_POST['f_message'] . "\n\n" .
            'Способ ответа: ' . $answer . "\n" .
            $addr ."\n";

    if (!empty($_FILES['files']['name'][0])) $message .= 'Приложенный фаил:';

    $boundary = md5(date('r', time()));
    $filesize = '';
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "From: " . $from . "\r\n";
    $headers .= "Reply-To: " . $from . "\r\n";
    $headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n";
    $message="
Content-Type: multipart/mixed; boundary=\"$boundary\"

--$boundary
Content-Type: text/plain; charset=\"utf-8\"
Content-Transfer-Encoding: 7bit

$message";
    for($i=0;$i<count($_FILES['files']['name']);$i++) {
        if(is_uploaded_file($_FILES['files']['tmp_name'][$i])) {
            $attachment = chunk_split(base64_encode(file_get_contents($_FILES['files']['tmp_name'][$i])));
            $filename = $_FILES['files']['name'][$i];
            $filetype = $_FILES['files']['type'][$i];
            $filesize += $_FILES['files']['size'][$i];
            $message.="

--$boundary
Content-Type: \"$filetype\"; name=\"$filename\"
Content-Transfer-Encoding: base64
Content-Disposition: attachment; filename=\"$filename\"

$attachment";
        }
    }
    $message.="
--$boundary--";

    if ($filesize < 100000000) { // проверка на общий размер всех файлов. Многие почтовые сервисы не принимают вложения больше 10 МБ
        mail($to, $title, $message, $headers);
        echo $_POST['f_name'].', Ваше сообщение получено, спасибо!';
    } else {
        echo 'error';
    }
?>