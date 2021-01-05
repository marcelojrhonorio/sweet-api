<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <title>Sweet Media: Recuperar senha</title>
</head>
<body>
  <b>Link:</b> <a href="{{ env('STORE_URL') }}/password/reset/{{ $token }}">mudar senha</a>.
  <img src="https://api.sweetmedia.com.br/pixeis-opened-email?email=##nm_email##&id=##nm_id##" width="1" height="1" />
</body>
</html>
