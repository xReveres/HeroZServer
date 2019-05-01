<?php
if(!defined('IN_INDEX')) exit();
//
define('IN_ENGINE',TRUE);
$cfg = include(__DIR__.'/server/config.php');
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title><?php echo $cfg['site']['title']; ?></title>
        <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="styles/game.css" type="text/css">
        <link rel="stylesheet" href="styles/heroz.css" type="text/css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="js/swfobject.js"></script>
        <script src="js/js.cookie.js"></script>
    </head>
    <body>
        <div class="gameContainer">
            <div class="topPanel">
                <span class="logo">HeroZ</span>
                <div class="language" id="Language">
                    <div class="btn" lang="pl_PL" default>PL</div>
                    <div class="btn" lang="en_GB">EN</div>
                    <div class="btn" lang="pt_BR">BR</div>
                </div>
            </div>
            <div class="rightPanel">
                <div class="gameBtn gameBtn-Basement"></div>
            </div>
            <div id="flashContainer" class="midPanel overflowHide">
                <div id="flashGame">
                    <script type="text/javascript">
                        var gameLang = Cookies.get('web-lang') || $('#Language').find('div[default]').attr('lang');
                        appCDNUrl = "<?php echo $cfg['site']['resource_cdn']; ?>";
                        appConfigPlatform = "standalone";
                        appConfigLocale = gameLang;
                        appConfigServerId = "heroz";
                        
                        var flashVars = {
                            applicationTitle: "<?php echo $cfg['site']['title'];?>",
                            urlPublic: "<?php echo $cfg['site']['public_url']; ?>",
                            urlRequestServer: "<?php echo $cfg['site']['request_url'].(isset($_GET['d'])?'?d':''); ?>",
                            urlSocketServer: "<?php echo $cfg['site']['socket_url'] ?>",
                            urlSwfMain: "<?php echo $cfg['site']['swf_main'] ?>",
                            urlSwfCharacter: "<?php echo $cfg['site']['swf_character'] ?>",
                            urlSwfUi: "<?php echo $cfg['site']['swf_ui'] ?>",
                            urlCDN: "<?php echo $cfg['site']['resource_cdn'] ?>",
                            userId: "0",
                            userSessionId: "0",
                            testMode: "<?php echo isset($_GET['d'])?'true':'false'; ?>",
                            debugRunTests: "<?php echo isset($_GET['d'])?'true':'false'; ?>",
                            registrationSource: "",
                            startupParams: "",
                            platform: "standalone",
                            ssoInfo: "",
                            uniqueId: "",
                            server_id: "<?php echo $cfg['site']['server_id'] ?>", //Original pl18
                            default_locale: gameLang,
                            localeVersion: "",
                            blockRegistration: "false",
                            isFriendbarSupported: "false"
                        };
                        
                        var params = {
                            menu: "true",
                            allowFullscreen: "false",
                            allowScriptAccess: "always",
                            bgcolor: "#6c5bb7"
                        };
                        
                        var isChrome = navigator.userAgent.toLowerCase().indexOf('chrome') != -1;
                        var isOpera = (navigator.userAgent.match(/Opera|OPR\//) ? true : false);
                        var isWin = navigator.appVersion.indexOf("Win") != -1;
                        var isMac = navigator.appVersion.indexOf("Mac") !=-1;
                        var isLinux = navigator.appVersion.indexOf("Linux") !=-1;
                        
                        if (isChrome && (isWin || isMac)) {
                            params.wmode = "opaque";
                            flashVars["browser"] = "chrome";
                        }
                        
                        var attributes = {
                            id:"swfClient"
                        };
        
                        swfobject.embedSWF("<?php echo $cfg['site']['swf_preloader'] ?>", "altContent", "900", "630", "10.1.0", "<?php echo $cfg['site']['swf_install'] ?>", flashVars, params, attributes);
                    </script>
                    <div id="altContent">
                        <div id="content">
                            Wszystko prawie gotowe, jeszcze potrzeba zezwolić na załadowanie gry.</br>
                            Kliknij poniższe "Graj teraz !", a następnie w nowym oknie "Zezwalaj".
                            <a href="http://www.adobe.com/go/getflashplayer">Graj teraz !</a>
                        </div>
                    </div>
                </div>
                <div id="HeroZ">
                    <div class="HeroZ-Basement-Panel">
                        <div class="HeroZ-Alert">
                            <div class="Title">Coming soon / Wkrótce</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>