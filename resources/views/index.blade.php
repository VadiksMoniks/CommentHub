<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @vite(['resources/js/app.js','resources/css/app.css'])
</head>
<body>
<div id="app">
    <example-component :session='@json(session()->has("user"))' :user='@json(session("user"))'></example-component>
</div>
</body>
</html>