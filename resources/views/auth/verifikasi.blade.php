<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="verification.css">
    <title>Verifikasi OTP</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .verification-container {
            text-align: center;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            padding: 20px;
            max-width: 400px;
            width: 100%;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        p {
            font-size: 14px;
            margin-bottom: 20px;
        }

        .otp-input {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 5px;
            margin-bottom: 20px;
            justify-content: center;
        }

        .otp-input input {
            width: 40px;
            height: 40px;
            text-align: center;
            font-size: 18px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-right: 5px;
        }

        button,
        .resend-button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 18px;
            margin-left: 5px;
            margin-right: 5px;
            transition: background-color 0.2s ease;
        }

        .button-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .resend-button {
            background-color: #4caf50;
        }

        .logout-link {
            color: #007bff;
            text-decoration: none;
            font-size: 16px;
            margin-top: 10px;
            display: block;
        }

        .logout-link:hover {
            text-decoration: underline;
        }

        @media (max-width: 500px) {
            .otp-input {
                grid-template-columns: repeat(3, 1fr);
            }
        }
    </style>
</head>

<body>
    <div class="verification-container">
        <h1>Verifikasi OTP</h1>
        @if (session('message'))
            <div class="alert alert-danger alert-sm">
                {{ session('message') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <p>Masukkan kode verifikasi 6 digit yang telah dikirimkan ke email {{ Auth::user()->email }}.</p>
        <form action="{{ Route('verif') }}" method="POST" onsubmit="combineInputs()">
            @csrf
            <div class="otp-input">
                <input type="text" id="digit1" maxlength="1" required>
                <input type="text" id="digit2" maxlength="1" required>
                <input type="text" id="digit3" maxlength="1" required>
                <input type="text" id="digit4" maxlength="1" required>
                <input type="text" id="digit5" maxlength="1" required>
                <input type="text" id="digit6" maxlength="1" required>
            </div>
            <input type="hidden" name="verification_code" id="verification_code" required>
            <div class="button-container">
                <button type="submit" class="verify-button">Verifikasi</button>
                <a href="{{ route('resended') }}" style="text-decoration: none" class="resend-button">Kirim Ulang
                    OTP</a>
            </div>
        </form>
        <a class="logout-link" href="{{ route('logout') }}"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Click untuk log Out</a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>
    <script>
        function validateInput(event) {
            var keyCode = event.keyCode;
            if (keyCode < 48 || keyCode > 57) {
                event.preventDefault();
            }
        }

        // Menetapkan event listener untuk setiap input
        document.getElementById("digit1").addEventListener("keypress", validateInput);
        document.getElementById("digit2").addEventListener("keypress", validateInput);
        document.getElementById("digit3").addEventListener("keypress", validateInput);
        document.getElementById("digit4").addEventListener("keypress", validateInput);
        document.getElementById("digit5").addEventListener("keypress", validateInput);
        document.getElementById("digit6").addEventListener("keypress", validateInput);

        function combineInputs() {
            var digit1 = document.getElementById("digit1").value;
            var digit2 = document.getElementById("digit2").value;
            var digit3 = document.getElementById("digit3").value;
            var digit4 = document.getElementById("digit4").value;
            var digit5 = document.getElementById("digit5").value;
            var digit6 = document.getElementById("digit6").value;

            var verificationCode = digit1 + digit2 + digit3 + digit4 + digit5 + digit6;

            // Set nilai kombinasi sebagai nilai input tersembunyi
            document.getElementById("verification_code").value = verificationCode;
        }

        document.addEventListener('DOMContentLoaded', function() {
            const otpInputs = document.querySelectorAll('.otp-input input');

            // Fungsi untuk membatasi panjang input menjadi 1 karakter
            otpInputs.forEach(function(input, index) {
                input.addEventListener('input', function() {
                    if (this.value.length > 1) {
                        this.value = this.value.slice(0, 1);
                    }

                    // Pindahkan fokus ke input berikutnya jika karakter telah diisi
                    if (this.value.length === 1 && index < otpInputs.length - 1) {
                        otpInputs[index + 1].focus();
                    }
                });

                // Pindahkan fokus ke input sebelumnya jika tombol Backspace ditekan
                input.addEventListener('keydown', function(event) {
                    if (event.key === 'Backspace' && index > 0 && !this.value) {
                        otpInputs[index - 1].focus();
                    }
                });
            });

            // Fungsi untuk mengizinkan hanya input angka
            otpInputs.forEach(function(input) {
                input.addEventListener('keypress', function(event) {
                    const charCode = event.charCode;
                    if (charCode < 48 || charCode > 57) {
                        event.preventDefault();
                    }
                });
            });
        });
    </script>
</body>

</html>
