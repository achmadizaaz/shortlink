<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redirecting...</title>
    <script type="text/javascript">
        window.location.href = "{{ $destination }}";
    </script>
</head>
<body>
    <p>If you are not redirected, <a href="{{ $destination }}">click here</a>.</p>
</body>
</html>
