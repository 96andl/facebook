<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Raleway', sans-serif;
            font-weight: 100;
            height: 100vh;
            margin: 0;
        }
        .facebook-info img {
            max-width: 100%;
        }
        .infoblock {
            width: 100%;
        }

    </style>
</head>
<body>

@if(session()->get('user_name') !== null or session()->get('user_name') !== '')
    <p>{{session()->get('user_name')}}</p>
    @else
    <a href="{{route('auth-facebook')}}">Connect To Facebook</a>
    @endif

<div class="facebook-info">
    <div class="container-fluid">
        @foreach($data as $key => $item)
            @if(($key+1) % 3 == 0)
                <div class="row">
                    <div class="col-md-4">
                        <p>{{date('Y-m-d H:i:s',strtotime($item['created_time']))}}</p>
                        <img src="{{$item['full_picture']}}" alt="">
                        <p>{{   isset($item['message']) ? $item['message'] : '' }}</p>
                        <div class="infoblock">
                            <div class="row">
                                <p class="col-md-4">
                                    {{isset($item['likes']['data']) ? count($item['likes']['data']) : '0' }}
                                </p>
                                <p class="col-md-4">
                                    {{isset($item['shared']) and !is_array($item['shared']) ? $item['shared'] : 'Нужно исправить'}}
                                    @if(!isset($item['shared']))
                                        {{  "Нету shared"  }}
                                    @endif
                                </p>
                                <p class="col-md-4">
                                    @if(isset($item['link']))
                                        <a href="{{$item['link']}}">Перейти...</a>
                                    @else
                                        {{"Ссылка отсутствует"}}
                                    @endif
                                </p>
                            </div>

                        </div>
                    </div>
                </div>
            @else
                <div class="col-md-4">
                    <p>{{date('Y-m-d H:i:s',strtotime($item['created_time']))}}</p>
                    <img src="{{$item['full_picture']}}" alt="">
                    <p>{{   isset($item['message']) ? $item['message'] : '' }}</p>
                    <div class="infoblock">
                        <div class="row">
                            <p class="col-md-4">
                                {{isset($item['likes']['data']) ? count($item['likes']['data']) : '0' }}
                            </p>
                            <p class="col-md-4">
                                {{isset($item['shared']) and !is_array($item['shared']) ? $item['shared'] : 'Нужно исправить'}}
                                @if(!isset($item['shared']))
                                    {{  "Нету shared"  }}
                                @endif
                            </p>
                            <p class="col-md-4">
                                @if(isset($item['link']))
                                    <a href="{{$item['link']}}">Перейти...</a>
                                @else
                                    {{"Ссылка отсутствует"}}
                                @endif
                            </p>
                        </div>

                    </div>
                </div>
            @endif
        @endforeach
    </div>
</div>
</div>




<script
        src="https://code.jquery.com/jquery-3.2.1.min.js"
        integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
        crossorigin="anonymous"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script type="text/javascript">
    if (window.location.hash == "#_=_")
        window.location.hash = "";
</script>
</body>
</html>
