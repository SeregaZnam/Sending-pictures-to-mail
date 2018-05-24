<link rel="stylesheet" href="style.css">
<div class="block-feedback">
    <form id="f_form" action="" method="post" enctype="multipart/form-data">

        <div class="block-feedback-sect">
            <label class="label-text" for="">Ваше имя *</label><input type="text" name="f_name" required>
        </div>

        <div class="block-feedback-sect">
            <label class="label-text" for="">Ваш E-mail *</label><input type="email" name="f_email" required>
        </div>

        <div class="block-feedback-sect">
            <label class="label-text" for="">Ваше сообщенние</label><textarea type="text" name="f_message"></textarea>
        </div>

        <div class="block-feedback-sect">
            <span class="span-text">Получить ответ</span>
            <select name="f_answer" id="otherFieldOption">
                <option value="1">по электронной почте отправителю</option>
                <option value="2">по почтовому адресу, (на бумажном носителе)</option>
            </select>
        </div>

        <div class="block-feedback-email">
            <div class="block-feedback-sect">
                <label class="label-text" for="">Населенный пункт</label><input type="text" name="f_city">
            </div>

            <div class="block-feedback-sect">
                <label class="label-text" for="">Улица, дом, квартира</label><input type="text" name="f_street">
            </div>

            <div class="block-feedback-sect">
                <label class="label-text" for="">Индекс</label><input type="text" id="uploadimage" name="f_code">
            </div>
        </div>

        <div class="block-feedback-sect">
            <label class="label-text" for=""></label><input type="file" name="files[]">
        </div>

        <input id="f_form_do" type="submit" value="Отправить">

    </form>
</div>

<script>
    $( document ).ready(function() {
        $("#otherFieldOption").click( function () {
            if ($("#otherFieldOption").val() == '2') {
                $('.block-feedback-email').show();
            } else {
                $('.block-feedback-email').hide();
            }
        });

        $('#f_form').submit(function(event){

            var that = this;
            event.preventDefault();

            $.ajax({
                url: '/feedback.php',
                type: 'POST',
                data: new FormData(that),
                processData: false,
                contentType: false,
                success: function (data) {
                    if (data === 'error')
                        $('.block-feedback').append('<div>Извините, письмо не отправлено. Размер всех файлов превышает 10 МБ.</div>')
                    else $('.block-feedback').html(data);
                }
            })
        })
    });
</script>