<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="X-Frame-Options" content="SAMEORIGIN">
	<meta http-equiv="Content-Security-Policy" content="media-src 'self'">
    <title>Miti Magazine | Better Globe Forestry LTD</title>
</head>

<body class="text-gray-800 antialiased font-sans" onload="postForm()" oncontextmenu="return false;">
    <form action="https://payments.ipayafrica.com/v3/ke" id="paymentForm" method="POST" style="display: none !important; visibility: none;"> 
        @foreach ($fields as $key => $value)
            <input name="{{ $key }}" type="hidden" value="{{ $value }}"></br>
        @endforeach
        <input style="display: none !important; visibility: none;" type="submit">Pay with iPay</button>   
    </form>
    <p>Redirecting you to iPay checkout page...</p>

    <script>
        function postForm() {
            document.getElementById("paymentForm").submit();
        }

        document.onkeydown = function (e) {
            if (event.keyCode == 123) {
                return false;
            }
            if (e.ctrlKey && e.shiftKey && (e.keyCode == 'I'.charCodeAt(0) || e.keyCode == 'i'.charCodeAt(0))) {
                return false;
            }
            if (e.ctrlKey && e.shiftKey && (e.keyCode == 'C'.charCodeAt(0) || e.keyCode == 'c'.charCodeAt(0))) {
                return false;
            }
            if (e.ctrlKey && e.shiftKey && (e.keyCode == 'J'.charCodeAt(0) || e.keyCode == 'j'.charCodeAt(0))) {
                return false;
            }
            if (e.ctrlKey && (e.keyCode == 'U'.charCodeAt(0) || e.keyCode == 'u'.charCodeAt(0))) {
                return false;
            }
            if (e.ctrlKey && (e.keyCode == 'S'.charCodeAt(0) || e.keyCode == 's'.charCodeAt(0))) {
                return false;
            }
        }
    </script>
</body>
</html> 