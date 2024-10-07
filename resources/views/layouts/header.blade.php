<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    
    <title>@yield('title')</title>
</head>
<body>
    <div class="outer">
        <div class="box">
            <h2>{{AppInfo('name')}} - @yield('title')</h2>