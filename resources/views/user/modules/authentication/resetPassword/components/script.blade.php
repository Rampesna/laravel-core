<script>

    $(document).ready(function () {
        $('#loader').hide();
    });

    var ResetPasswordButton = $('#ResetPasswordButton');

    ResetPasswordButton.click(function () {
        var newPassword = $('#new_password').val();
        var confirmPassword = $('#confirm_new_password').val();
        var resetPasswordToken = '{{ $token }}';

        if (!newPassword) {
            toastr.warning('Yeni Şifre Boş Olamaz!');
        } else if (!confirmPassword) {
            toastr.warning('Yeni Şifre Tekrarı Boş Olamaz!');
        } else if (newPassword !== confirmPassword) {
            toastr.warning('Yeni Şifreler Eşleşmiyor!');
        } else {
            ResetPasswordButton.attr('disabled', true);
            $.ajax({
                type: 'post',
                url: '{{ route('api.user.resetPassword') }}',
                headers: {
                    'Accept': 'application/json',
                },
                data: {
                    newPassword: newPassword,
                    confirmPassword: confirmPassword,
                    resetPasswordToken: resetPasswordToken,
                },
                success: function () {
                    toastr.success('Şifreniz Başarıyla Değiştirildi!');
                    window.location.href = '{{ route('user.web.authentication.login.index') }}';
                },
                error: function (error) {
                    console.log(error);
                    toastr.error('Şifre Değiştirme Servisinde Hata Oluştu! Lütfen Daha Sonra Tekrar Deneyin.');
                    ResetPasswordButton.attr('disabled', false);
                }
            });
        }
    });

</script>
