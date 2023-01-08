<script>

    $(document).ready(function () {
        $('#loader').hide();
    });

    var ResetPasswordButton = $('#ResetPasswordButton');

    ResetPasswordButton.click(function () {
        var email = $('#email').val();

        if (!email) {
            toastr.warning('E-posta Adresi Boş Olamaz!');
        } else {
            $('#loader').show();
            ResetPasswordButton.attr('disabled', true);
            $.ajax({
                type: 'post',
                url: '{{ route('api.user.sendPasswordResetEmail') }}',
                headers: {
                    'Accept': 'application/json',
                },
                data: {
                    email: email,
                },
                success: function (response) {
                    toastr.success('Şifre Sıfırlama Linki Mail Adresinize Gönderildi!');
                    $('#email').val('');
                    ResetPasswordButton.attr('disabled', false);
                    $('#loader').hide();
                },
                error: function (error) {
                    console.log(error);
                    ResetPasswordButton.attr('disabled', false);
                    $('#loader').hide();
                    if (parseInt(error.status) === 404) {
                        toastr.error('Bu E-posta Adresi ile Kayıtlı Bir Kullanıcı Bulunamadı!');
                    } else if (parseInt(error.status) === 406) {
                        toastr.error('Bu E-posta Adresi ile Daha Önce Şifre Sıfırlama İsteği Gönderilmiş!');
                    } else {
                        toastr.error('E-posta Sıfırlama Servisinde Hata Oluştu! Lütfen Daha Sonra Tekrar Deneyin.');
                    }
                }
            });
        }
    });

    $('#email').on('keypress', function (e) {
        if (e.which === 13) {
            ResetPasswordButton.click();
        }
    });

</script>
