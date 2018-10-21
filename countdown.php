<?php
if(!defined('IN_INDEX')) exit();
?>
<html>
    <head>
        <meta charset="utf-8">
        <title>Start <?php echo $start; ?></title>
        <style>
            *{
                font-family:'Helvetica', sans-serif;
            }
            body{
                margin:0;
                padding:0;
                background-color:#000;
                color:#fff;
            }
            #count-down{
                margin-top:calc((100vh / 2) - 100px);
                text-align:center;
                font-size:20pt;
            }
            #timer{
                color:orange;
                font-size:50pt;
                text-shadow:0 0 10px orange;
            }
        </style>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script>
            $(document).ready(function(){
                var t = $('#timer');
                var countDownDate = Date.parse("<?php echo $start; ?>");
                //
                var _second = 1000;
                var _minute = _second * 60;
                var _hour = _minute * 60;
                var _day = _hour *24;
                //
                var r = setInterval(function(){
                    var now = new Date().getTime();
                    var dist = countDownDate - now;
                    
                    if(dist <= 0){
                        clearTimeout(r);
                        x = "Jej serwer wystartował ! Odśwież stronę !<br/>Yay server started ! Refresh page !";
                    }else{
                    
                        var days = Math.floor(dist / _day);
                        var hours = ("0"+Math.floor( (dist % _day ) / _hour )).substr(-2);
                        var minutes = ("0"+Math.floor( (dist % _hour) / _minute )).substr(-2);
                        var seconds = ("0"+Math.floor( (dist % _minute) / _second )).substr(-2);
                        var milliseconds = dist % _second;
                    
                        
                        var x = days + " days " + hours + ":" + minutes + ":" + seconds + "." + Math.floor(milliseconds/100);
                    }
                    t.html(x);
                }, 100);
            });
        </script>
    </head>
    <body>
        <div id="count-down">
            <div>Odliczanie do startu<br/>Countdown</div>
            <div id="timer">-days --:--:--.-</div>
        </div>
    </body>
</html>