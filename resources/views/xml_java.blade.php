<!DOCTYPE html>
<html lang="es">
<head>
    <title>XML to JAVA </title>
    <meta property="timecb" content="12:13:54 PM"/>
    <meta http-equiv="content-language" content="en-US">
    <meta http-equiv="X-UA-Compatible" content="IE=9,chrome=1"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta charset="utf-8"/>
    <meta name="msvalidate.01" content="084CD6E483AD51F958E3681A39B9165D"/>
    <meta name="google-site-verification" content="vlLARRChVnQgehr8KorYtZVny9K7NQPzKNQ3A3g-42k"/>
    <meta name="description" content="Best Online XML to JAVA Converter: Convert XML to JAVA format"/>
    <meta name="author" content="Jimmy"/>
    <meta name="keywords" content="xml to java, XML to JAVA Converter"/>
    <meta property="og:image" content="https://codebeautify.org/img/cb/logo.png"/>
    <meta property="og:url" content="https://codebeautify.org/xml-to-java-converter"/>
    <meta name="twitter:card" content="summary"/>
    <meta name="twitter:title" content="XML to JAVA Converter: Convert XML to JAVA format"/>
    <meta name="twitter:description" content="Best Online XML to JAVA Converter: Convert XML to JAVA format"/>
    <meta name="twitter:image" content="https://codebeautify.org/img/cb/logo.png"/>
    <meta name="twitter:url" content="https://codebeautify.org/xml-to-java-converter"/>
    <meta name="twitter:creator" content="@codebeautify"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="X-UA-Compatible" content="IE=10"/>


    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.10.4/css/jquery-ui.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <link href="https://plus.google.com/111146553686540738855" rel="publisher">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="/img/cb.png" rel="icon"/>
    <link rel="stylesheet" type="text/css" href="css/formatter.css">


    <input type="hidden" id="isFavTool" value="not-fav"/>
    <script>
        var globalurl = "/";
        function getCookie(cname) {
            var name = cname + "=";
            var ca = document.cookie.split(';');
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ') c = c.substring(1);
                if (c.indexOf(name) == 0) {
                    name = c.substring(name.length, c.length);
                    return name.replace(/\+/g, ' ');
                }
            }
            return "";
        }

        function loadJs(jsName) {
            var script = document.createElement('script');
            script.type = 'text/javascript';
            script.src = globalurl + "js/" + jsName + ".js";
            script.onload = function () {
                console.log('Loaded script');
                console.log(this);
            };
            document.head.appendChild(script);
        }

        //local use
        function loginWithSocial(provider, tempLogin) {
            $("#logFail").text("");

            if (tempLogin != true) {
            }

            hello(provider).login({
                display: 'page',
                scope: 'email',
                redirect_uri: '/codebeautify_redirect'
            }).then(function () {
            }, function (e) {
                openErrorDialog('Signin error: ' + e.error.message);
            });
        }
        var online = function (session) {
            var currentTime = (new Date()).getTime() / 1000;
            return session && session.access_token && session.expires > currentTime;
        };

        function check_login() {
            var provider = getProvider();
            if (provider != null) {
                getLogindata(provider);
                $("#loggedin").show();
            } else {
                $("#loggedin").hide();
                $("#notloggedin").show();
                $("#user_id").val("0");
                createFavouriteImg();
            }
        }

        function getProvider() {

            // online
            hello.init({
                facebook: '1379987838916043',
                google: '1029680282693-o1r44fbtem67h8op2l8g6kiq82cr679c.apps.googleusercontent.com',
                github: '971a8d9e78fda16f9a30',
            });


            var provider = null;

            var facebook = hello('facebook').getAuthResponse();
            var google = hello('google').getAuthResponse();
            var github = hello('github').getAuthResponse();

            if (online(facebook)) {
                provider = 'facebook';
            } else if (online(google)) {
                provider = 'google';
            } else if (online(github)) {
                provider = 'github';
            }

            return provider;
        }

        function getLogindata(provider) {
            hello(provider).api('me').then(function (json) {

                if (json.email == null || json.email.length == 0) {
                    openErrorDialog("Email id required for login,please try again");
                    return;
                }
                if (json.name == null || json.name.length == 0) {
                    json.name = json.email;
                }

                $.ajax({
                    url: "/service/saveLoginData",
                    dataType: "text",
                    type: "post",
                    data: {
                        name: json.name,
                        email: json.email,
                        provider: provider
                    },
                    success: function (response) {
                        window.location.href = "/codebeautify_redirect";
                    },
                    error: function (e, s, a) {
                        openErrorDialog("Failed to Login, Pls Try Again");

                    }
                });
            }, function (e) {
                console.log('getLogindata ' + e.error.message);
            });
        }
        // logout
        function logout() {
            document.cookie = "loggedinuser=; expires=Thu, 01 Jan 1970 00:00:00 UTC";

            if (getProvider() != null) {
                hello(getProvider()).logout().then(function () {
                }, function (e) {
                });
            }

            $.ajax({
                url: "/service/logout",
                success: function (res) {
                    window.location.href = "/codebeautify_redirect";
                }
            });
        }

        function createFavouriteImg() {

            $("#favToolImg").remove();

            var isFav = $("#isFavTool").val();


            var favView = $("<i>");
            favView.attr("id", "favToolImg");
            $(favView).css("cursor", "pointer");
            favView.attr("aria-hidden", true);

            if (isFav == "fav") {
                favView.addClass("fa fa-star");
                favView.attr("title", "make it not favourite");
            }
            else {
                favView.addClass("fa fa-star-o");
                favView.attr("title", "make it favourite");

                if (isFav.trim().length == 0) {
                    $("#isFavTool").val("not-fav");
                }
            }

            $(favView).click(function () {
                if ($("#notloggedin").is(':visible')) {
                    login();
                }
                else {
                    saveMyfavourite();
                }
            });
            $("#subTitle").append(favView);
        }

        function saveMyfavourite() {
            $.ajax({
                url: "/service/saveFavouriteTool",
                dataType: "text",
                type: "post",
                data: {
                    view: $("#viewName").val(),
                    title: $("#subTitle").text(),
                    isFav: $("#isFavTool").val()
                },
                success: function (response) {
                    var msg = "This tool added to favourite.";
                    $("#favToolImg").attr("src", "../img/icons/fav.png");
                    if ($("#isFavTool").val() == "fav") {
                        msg = "This tool remove from favourite.";
                        $("#favToolImg").attr("src", "../img/icons/not-fav.png");
                        $("#isFavTool").val("not-fav");
                    }
                    else {
                        $("#isFavTool").val("fav");
                    }

                    $("#copy-note-msg").html(msg);
                    $('#copy-note-msg').removeClass("hide");
                    $('#copy-note-msg').fadeIn().delay(10000).fadeOut();
                },
                error: function (e, s, a) {
                    openErrorDialog("Failed to save favourite tool, Pls Try Again");
                }
            });
        }

        function isfavourite() {
            $.ajax({
                url: "/service/isFavouriteTool",
                dataType: "text",
                type: "post",
                data: {
                    view: $("#viewName").val(),
                },
                success: function (response) {
                    $("#isFavTool").val(response);
                    createFavouriteImg();
                },
                error: function (e, s, a) {
                    console.log(e);
                }
            });
        }


        //Login
        function toggleOpenClass() {
            $("#loggedin").toggleClass("open");
        }
        // login dialog
        function login(msg) {

            if (msg == undefined) {
                $("#logFail").text("");

                $("#username_txt1").val("");
                $("#email_txt1").val("");
                $("#pass_txt1").val("");
                $("#pass_txt").val("");
                $("#email_txt").val("");

                $("#signinDiv").show();
                $("#signupDiv").hide();
            } else {
                $("#logFail").text(msg);
            }

            $("#customLogin").dialog({
                modal: true,
                width: "auto",
                draggable: false,
                height: "auto",
                title: "LOGIN",
                autoOpen: true,
                resizable: false,
            });
            $("#customLogin1").dialog({
                modal: true,
                width: "auto",
                draggable: false,
                height: "auto",
                title: "LOGIN",
                autoOpen: true,
                resizable: false,
            });
            $(".ui-dialog-titlebar-close").hide();
            $(".ui-dialog .ui-dialog-titlebar").hide();

        }

        // custom login
        function customLogin() {
            var email = $("#email_txt").val();
            var pass = $("#pass_txt").val();
            var is_cblogin = $("#is_cblogin").val();
            if (email.trim() == "" || pass.trim() == "") {
                openErrorDialog("Please Enter the Email and Password");
                return false;
            } else {
                $("#logFail").text("");
                if (is_cblogin != '1') {
                    $("#customLogin").dialog('destroy');
                }

                $.ajax({
                    url: "/service/login",
                    dataType: "text",
                    type: "post",
                    data: {
                        email: email,
                        password: pass,
                    },
                    success: function (response) {

                        if (response == "success") {
                            if (!is_cblogin) {
                                location.reload();
                            }
                            else {
                                location.href = '/';
                            }

                        } else {
                            var msg = "Invalid username and password";
                            login(msg);
                        }

                    },
                    error: function (e, s, a) {

                        openErrorDialog("Failed to Login Pls Try Again");

                    }
                });
            }
        }

        // sign up with codebeautify
        function customSignup() {
            var email = $("#email_txt1").val();
            var password = $("#pass_txt1").val();
            var username = $("#username_txt1").val();
            if (email.trim() == "" || password.trim() == "" && username.trim() == "") {
                openErrorDialog("Please Enter the required information");
                return false;
            } else {
                $("#logFail").text("");
                $("#customLogin").dialog('destroy');
                $.ajax({
                    url: "/service/signup",
                    dataType: "text",
                    type: "post",
                    data: {
                        username: username,
                        email: email,
                        password: password
                    },
                    success: function (response) {

                        if (response == "success") {
                            location.reload();
                        } else if (response.trim() == "duplicateEmail") {
                            var msg = "Email Id is already registered....";
                            login(msg);
                        } else {
                            var msg = "Failed to Create an Account, Pls Try Again";
                            login(msg);
                        }

                    },
                    error: function (e, s, a) {

                        openErrorDialog("Failed to Login, Pls Try Again");

                    }
                });
            }
        }


        function signupView() {
            $("#signinDiv").hide();
            $("#signupDiv").show();
        }

        function checkEmail(id) {
            if ($("#" + id).val() != null && $("#" + id).val() != "") {
                var email = document.getElementById(id);
                var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

                if (!filter.test(email.value)) {
                    $("#logFail").text('Please provide a valid email address');
                    $("#" + id).focus();
                } else {
                    $("#logFail").text('');
                }
                return false;
            }
        }

        function ylogin() {
            $("#yloginsection").dialog({
                modal: true,
                title: "Why you need to Login Or Register ?",
                zIndex: 10000,
                autoOpen: true,
                width: 'auto',
                resizable: false,

            });
        }


        if (typeof(window.google_jobrunner) === "undefined") {
            $("#adBlock_dialog").removeClass("hide");
            $("#adBlock_dialog").dialog({
                modal: true,
                zIndex: 10000,
                autoOpen: true,
                width: '500',
                resizable: false,
                closeOnEscape: false
            });
            $(".ui-dialog-titlebar-close").remove();
        }

        $(document).ready(function () {
            var user = getCookie("loggedinuser");
            var userid = getCookie("loggedinuserid");

            if (user != "" && userid != "") {
                $("#usernamelable").text(user.substring(0, 5) + "..");
                $("#notloggedin").hide();
                $("#loggedin").show();
                loadJs("dropdown");
                updateUserSession(userid);
                isfavourite();
            } else {
                check_login();
            }
        });

        function updateUserSession(id) {
            $.ajax({
                type: "post",
                url: "/service/updateSession",
                data: {
                    id: id
                },
                success: function (response) {
                    console.log("/service/updateSession ->" + response);
                }
            });
        }
    </script>
</head>
<body id="cbBody">
<script type="text/javascript">

    $(document).ready(function () {
        $("body").addClass("intro");
    });

</script>
<script>
    (function (i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function () {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
        a = s.createElement(o),
            m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
    })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

    ga('create', 'UA-51765955-1', 'codebeautify.org');
    ga('send', 'pageview');

</script>
<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container-fluid">
            <div class='mainheader'>
                <div class='logo'>
                    <a href="/" class="brand">
                        <div class="cblogoimage" title="Code Beautify"></div>
                    </a>
                </div>
                <div class='headerMenu'>
                    <div class="nav-collapse collapse">
                        <ul class="nav pull-right rightsidemenusitem li-right">
                            <li id="notloggedin" class="dropdown pull-right liFirstChild">
                                <a href="#" onclick="login()" class="dropdown-toggle firstchild" data-toggle="dropdown"
                                   rel="nofollow">Sign in</a>
                                <a class="lastchield firstchild" href="#" onclick="ylogin()"
                                   title="Why Sign In?">(?)</a>
                            </li>
                            <li id="loggedin" class="dropdown pull-right" onclick="toggleOpenClass()">
                                <a id="username" class="dropdown-toggle" data-toggle="dropdown">
                                    <b id="usernamelable"></b>
                                    <b class="caret"></b>
                                </a>
                                <ul class="dropdown-menu pull-right">
                                    <li><a href="https://codebeautify.org/userSaveLinkPage" class="leftText"
                                           rel="nofollow">My Links</a></li>
                                    <li><a href="https://codebeautify.org/userSaveOldLinkPage" class="leftText"
                                           rel="nofollow">My Archived Links</a></li>
                                    <li><a href="/profile" class="leftText" rel="nofollow">My Profile</a></li>
                                    <li><a href="/myFavouriteTools" class="leftText" rel="nofollow">My Favourite
                                            Tools</a></li>
                                    <li><a href="#logout" onclick="logout();" class='leftText' rel="nofollow">Logout</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown pull-right" id="moreMenu">
                                <a href='#' id='more'>More <b class="caret"></b></a>
                            </li>
                            <li class="dropdown pull-right">
                                <a href="/code" class="dropdown-toggle" data-toggle="dropdown">Sample</a>
                            </li>
                            <li class="dropdown pull-right">
                                <a href="/recentLinksPage">Recent Links</a>
                            </li>
                            <li class="dropdown pull-right">
                                <a href="/search">Search</a>
                            </li>
                            <li class="dropdown pull-right">
                                <a href="/ipcheck-weatherinfo-latestnews">&nbsp;My Ip</a>
                            </li>
                            <li class="dropdown pull-right margin-last-li">
                                <a href="https://jsonformatter.org" target="_blank" title="JSON Formatter">&nbsp;JSON
                                    Formatter</a>
                            </li>
                        </ul>
                        <div id="copy-note-msg" class="hide">
                            Copied to Clipboard.
                        </div>
                    </div>
                </div>
                <div id="adBlock_dialog" title="Hi Coder" class="hide">
                    <p><b>It looks like you're blocking ads.</b>
                        Ads help me pay the bills. Can I ask that you <a href="http://www.wikihow.com/Disable-Adblock"
                                                                         target="_blank"
                                                                         style="color: #0088cc!important;">disable
                            Adblocker just for this site</a>? I promise the ads aren't obnoxious.
                        Please disable adBlocker and <a href="#" style="color: #0088cc!important;"
                                                        onclick="javascript:document.location.reload(true);">refresh</a>
                        page.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="some_other_box"></div>
<div class="containe-fluid headerEditorContainer">
    <div class="row-fluid">
        <div class="span12 subTitleDiv">
            <div class="span6">
                <h1 id="subTitle" title="XML to JAVA Converter">XML to JAVA Converter</h1>
            </div>
            <div class="span6" id="permalinkDiv">
                <div class='permalinkButtonDiv'>
                    <input type="button" value="Save & Share" class="btn permalinkButton btn-inverse "
                           onclick="openSavedialog(true);" id='plinkBtn'/>
                </div>
                <div class='permalinkDiv'>
                    <label id="permalink" class='permaLinkLabel'> </label>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="fbpost" class='hide'>
    <div id="shareDiv">
    </div>
</div>

<div id="yloginsection" class='yLoginSection'>
    <div class="span7 yLoginDiv">
        <p>If you use Codebeautify regularly, registering for an account can be useful for some reasons.</p>
        <ul>
            <li>Your options are tied to your account, so you only have to change them once rather than every time you
                visit Codebeautify.
            </li>
            <li>All of your shared Code can be viewed in a <b>Saved Links</b> dialog, so you don't have to worry about
                losing the report URLs.
            </li>
            <li>You can also title your Codew reports when you save them, for more convenient organization.</li>
        </ul>
        <p>Registration only takes a minute and is of course perfectly free. We are also planning on adding more
            features to user accounts in the future, such as more advanced comparison options. Be sure to let us know if
            you have any feature suggestions using the Feedback link on the left side.</p>
    </div>
</div>
<div id="customLogin" class='customLogin'>
    <style>
        .simple_login {
            color: white !important;
        }
    </style>
    <div class="span7 loginDiv">
        <h3 class='loginDivTitle'>LOGIN <label class="close1 loginDivCloseButton">X</label></h3>
        <div class="center logindiv">
            <label class="span6 logFail" id="logFail"></label>
            <table id="signinDiv" class='center'>
                <tr>
                    <td>
                        <button onclick="loginWithSocial('facebook')" class="btn btn-success">Facebook</button>
                    </td>
                </tr>
                <tr>
                <tr>
                    <button onclick="loginWithSocial('google')" class="btn btn-success">Google</button>
                    </td>
                </tr>
                <tr>
                    <td class="simple_login">
                        If you want to login with email id & password? <a class="simple_login" href="/cblogin">Click
                            here</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div id="savedialog" class="hide">
        <input type="hidden" id="edit_link_id" value=""/>
        <table>
            <tr>
                <td>Title</td>
                <td><input type="text" maxlength="60" id="save_link_title" value=""/></td>
            </tr>
            <tr>
                <td>Description</td>
                <td><textarea id="save_link_description" placeholder="optional"></textarea></td>
            </tr>
            <tr>
                <td>Tags</td>
                <td><textarea id="save_link_tags" placeholder="optional"></textarea></td>
            </tr>
        </table>
    </div>

    <input type="hidden" id="viewName" value="xml-to-java-converter">
    <input type="hidden" id="isLogin" value="">
</div>
<div id="innerBody" class="innerBody setBgImage">
    <div class="containe-fluid viewerInnerBodyDiv">
        <div class="row-fluid back">
            <div class="span12 viewerInnerBodyDiv1">
                <div class="span5 mainLeftInputDiv" id="mainLeftDiv">
                    <div class="span12 mainLeftInputDiv1">Input
                        <a id="fs" class="fullScreen" href="#" onclick="fullScreenLeft();">Full Screen</a>
                        <a id="clearImg" class='clearImage' href="#">Clear</a>
                    </div>
                    <div class="span12 viewerInnerBodyDiv1">
                        <div id="editor" class='viewerEditor'></div>
                    </div>
                </div>
                <div class="span2 center buttonSection">
                    <input type="button" title="Load From Url" value="Load Url" onclick="loadFromURL('xml');"
                           class="btn"><br>
                    <input type="button" value="open" id="me" onclick="openFile('me','xml')" class="btn"
                           title="OpenFile"><br>
                    <input type="button" value="XML a Java" title="Convert XML TO JAVA" onclick="convertXMLToJava();"
                           class="btn"><br>
                    <input type="button" value="Descargar" onclick="createFile('java');" class="btn"
                           title="Download Result">
                    <div style="text-align:center;" class="adsense">
                        <script async src="js/adsbygoogle.js"></script>

                        <ins class="adsbygoogle" style="display:inline-block;width:200px;height:200px"
                             data-ad-client="ca-pub-4125058781634690" data-ad-slot="8168901167"></ins>
                        <script>
                            (adsbygoogle = window.adsbygoogle || []).push({});
                        </script>
                    </div>
                </div>
                <div class="span5 mainLeftInputDiv" id="mainRightDiv">
                    <div class="span12 mainLeftInputDiv1">
                        <span id="outputMsg">Resultado</span>
                        <a id="fs1" class='fullScreen' href="#" onclick="fullScreenRight();">Full Screen</a>
                    </div>
                    <div class="span12 mainRightInputDiv2">
                        <div id="result" class='viewerEditor'></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div style="text-align:center;" class="adsense">
    <script async src="js/adsbygoogle.js"></script>

    <ins class="adsbygoogle" style="display:inline-block;width:728px;height:90px"
         data-ad-client="ca-pub-4125058781634690" data-ad-slot="2203092761"></ins>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
</div>
<div class="container-fluid infoSection">
    <div class="row-fluid footerpart">
        <div class="span12">
            <div class="span6 infoDiv">
                <h3>What can you do with XML TO JAVA CONVERTER ?</h3>
                <ul class='infoFeatureDiv'>
                    <li>This tool will help you to convert your XML String/Tags to
                        JAVA Class Object
                    </li>
                    <li>To Save and Share this code, use Save and Share button</li>
                </ul>
            </div>
            <div class="span6 infoTools" id="relatedTools">
                <h3>Related Tools</h3>
                <ul>
                    <li>
                        <a href="
               /json-to-java-converter">JSON to JAVA Converter
                        </a>
                    </li>
                    <li>
                        <a href="
               /yaml-to-json-xml-csv">YAML to JSON-XML-CSV Converter
                        </a>
                    </li>
                    <li>
                        <a href="
               /xml-to-yaml">XML to YAML Converter
                        </a>
                    </li>
                    <li>
                        <a href="
               /json-to-yaml">JSON to YAML Converter
                        </a>
                    </li>
                    <li>
                        <a href="
               /xmltojson">XML to JSON Converter
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/hellojs/1.13.4/hello.all.js"></script>
<script type="text/javascript" src="js/filedrop.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.3.1/ace.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="js/ajaxupload.3.5.js"></script>
<script src="js/common_load.js" type="text/javascript"></script>


<script data-cfasync="true" src="js/xml2json.js" type="text/javascript"></script>
<script data-cfasync="true" type="text/javascript" src="js/beautify.js"></script>


<script src="https://apis.google.com/js/platform.js" async defer></script>
<script data-cfasync="true" type="text/javascript" src="js/vkbeautify.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
<script data-cfasync="true" type="text/javascript" src="js/convertToCsv.js"></script>
<script data-cfasync="true" type="text/javascript" src="js/viewer/json2convert.js"></script>
<script data-cfasync="true" type="text/javascript" src="js/convertToJava.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
<script data-cfasync="true" type="text/javascript" src="js/convertToCsv.js"></script>
<script data-cfasync="true" type="text/javascript" src="js/viewer/xmlviewer.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/1.3.8/FileSaver.min.js"></script>
<script type="text/javascript" src="js/footer.js"></script>
<div class="container-fluid">
    <div class="row-fluid footerpart">
        <div class='footer_container'>
            <div class='footer_map' id='footer_map'>
                <div class='footerhead'>
                    <div class='footerheadimg'>
                        <div class='logo'>
                            <a href="/" class="brand">
                                <div class="cblogoimage"></div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class='footersub1'>
                    <h4>Unit Converter</h4>
                    <ul>
                        <li><a href="/length-converter">Length
                                Converter</a></li>
                        <li><a href="/weight-converter">Weight
                                Converter</a></li>
                        <li><a href="/volume-converter">Volume
                                Converter</a></li>
                        <li><a href="/area-converter">Area
                                Converter</a>
                        </li>
                        <li><a href="/temperature-converter">Temperature
                                Converter</a></li>
                        <li><a href="/density-converter">Density
                                Converter</a></li>
                        <li><a href="/electric-current-converter">Electric
                                Current Converter</a></li>
                        <li><a href="/speed-converter">Speed
                                Converter</a></li>
                        <li><a href="/angle-converter">Angle
                                Converter</a></li>
                        <li><a href="/bytes-converter">Bytes/Bits
                                Converter</a></li>
                        <li><a href="/energy-converter">Energy
                                Converter</a></li>
                        <li><a href="/force-converter">Force
                                Converter</a></li>
                        <li><a href="/fuel-converter">Fuel
                                Converter</a>
                        </li>
                        <li><a href="/mass-converter">Mass
                                Converter</a>
                        </li>
                        <li><a href="/power-converter">Power
                                Converter</a></li>
                        <li><a href="/pressure-converter">Pressure
                                Converter</a></li>
                        <li><a href="/time-converter">Time
                                Converter</a>
                        </li>
                        <li><a href="/astronomical-converter">Astronomical
                                Converter</a></li>
                        <li><a href="/frequency-converter">Frequency
                                Converter</a></li>
                        <li><a href="/unix-time-stamp-converter">Unix
                                Timestamp Converter</a></li>
                    </ul>
                </div>
                <div class='footersub1'>
                    <h4>Converters</h4>
                    <ul>
                        <li><a href="/word-to-html-converter">Word to HTML Converter</a><span class='blink'>New</span>
                        </li>
                        <li><a href="/json-to-java-converter">JSON to JAVA Converter</a><span class='blink'>New</span>
                        </li>
                        <li><a href="/xml-to-java-converter">XML to JAVA Converter</a><span class='blink'>New</span>
                        </li>
                        <li><a href="/tableizer">Online Tableizer</a></li>
                        <li><a href="/html-to-csv-converter">HTML to CSV Converter</a></li>
                        <li><a href="/html-to-tsv-converter">HTML to TSV Converter</a></li>
                        <li><a href="/html-to-php-converter">HTML to PHP Converter</a></li>
                        <li><a href="/xml-xsl-transformation">XML-XSL Transform</a></li>
                        <li><a href="/xmltojson">XML to JSON</a>
                        </li>
                        <li><a href="/jsontoxml">JSON to XML</a></li>
                        <li><a href="/csv-to-xml-json">CSV to XML/JSON</a></li>
                        <li><a href="/yaml-to-json-xml-csv">YAML Converter</a><span class='blink'>New</span>
                        </li>
                        <li><a href="/image-to-base64-converter">Image to
                                Base64</a>
                        </li>
                        <li><a href="/base64-to-image-converter">Base64 to
                                Image</a><span class='blink'>New</span></li>
                        <li><a href="/date-time-calculater">Date
                                Calculater</a>
                        </li>
                        <li><a href="/excel-to-html">EXCEL to HTML</a>
                        </li>
                        <li><a href="/excel-to-xml">EXCEL to XML</a>
                        </li>
                        <li><a href="/excel-to-json">EXCEL to JSON</a></li>
                        <li><a href="/json-to-yaml">JSON to YAML</a><span class='blink'>New</span>
                        </li>
                        <li><a href="/xml-to-yaml">XML to YAML</a><span class='blink'>New</span>
                        </li>
                        <li><a href="/csv-to-xml-converter">CSV to XML</a><span class='blink'>New</span>
                        </li>
                        <li><a href="/csv-to-json-converter">CSV to JSON</a><span class='blink'>New</span>
                        </li>
                        <li><a href="/csv-to-html-converter">CSV to HTML</a><span class='blink'>New</span>
                        </li>
                        <li><a href="/json-to-csv">JSON to CSV</a><span class='blink'>New</span>
                        <li><a href="/json-to-tsv-converter">JSON to TSV</a><span class='blink'>New</span>
                        </li>
                        <li><a href="/xml-to-csv-converter">XML to CSV</a><span class='blink'>New</span>
                        </li>
                        <li><a href="/html-to-csv-converter">HTML to CSV</a><span class='blink'>New</span>
                        </li>
                        <li><a href="/csv-to-multi-line-converter">CSV to
                                MULTILINE DATA</a><span class='blink'>New</span>
                        </li>
                        <li><a href="/csv-to-sql-converter">CSV to SQL</a><span class='blink'>New</span>
                        </li>
                        <li><a href="/sql-to-csv-converter">SQL to CSV Converter</a><span class='blink'>New</span></li>
                        <li><a href="/sql-to-json-converter">SQL to JSON
                                Converter</a><span class='blink'>New</span></li>
                        <li><a href="/sql-to-xml-converter">SQL to XML Converter</a><span class='blink'>New</span></li>
                        <li><a href="/sql-to-yaml-converter">SQL to YAML
                                Converter</a><span class='blink'>New</span></li>
                        <li><a href="/sql-to-html-converter">SQL to HTML
                                Converter</a><span class='blink'>New</span></li>
                        <li><a href="/opml-to-json-converter">OPML to JSON</a><span class='blink'>New</span>
                        </li>
                        <li><a href="/hex-to-pantone-converter">HEX to Pantone Converter</a><span
                                    class='blink'>New</span></li>
                        <li><a href="/rgb-to-pantone-converter">RGB to Pantone Converter</a><span
                                    class='blink'>New</span></li>
                        <li><a href="/hsv-to-pantone-converter">HSV to Pantone Converter</a><span
                                    class='blink'>New</span></li>
                        <li><a href="/cmyk-to-pantone-converter">CMYK to Pantone Converter</a><span
                                    class='blink'>New</span></li>
                        <li><a href="/cmyk-to-hex-converter">CMYK to HEX Converter</a><span class='blink'>New</span>
                        </li>
                        <li><a href="/cmyk-to-rgb-converter">CMYK to RGB Converter</a><span class='blink'>New</span>
                        </li>
                        <li><a href="/cmyk-to-hsv-converter">CMYK to HSV Converter</a><span class='blink'>New</span>
                        </li>
                        <li><a href="/hsv-to-hex-converter">HSV to HEX Converter</a><span class='blink'>New</span></li>
                        <li><a href="/hsv-to-rgb-converter">HSV to RGB Converter</a><span class='blink'>New</span></li>
                        <li><a href="/hsv-to-cmyk-converter">HSV to CMYK Converter</a><span class='blink'>New</span>
                        </li>
                        <li><a href="/hex-to-hsv-converter">HEX to HSV Converter</a><span class='blink'>New</span></li>
                        <li><a href="/rgb-to-hex-converter">RGB to HEX Converter</a><span class='blink'>New</span></li>
                        <li><a href="/rgb-to-hsv-converter">RGB to HSV Converter</a><span class='blink'>New</span></li>
                        <li><a href="/rgb-to-cmyk-converter">RGB to CMYK
                                Converter</a><span class='blink'>New</span></li>
                        <li><a href="/hex-to-rgb-converter">HEX to RGB Converter</a><span class='blink'>New</span></li>
                        <li><a href="/hex-to-cmyk-converter">HEX to CMYK
                                Converter</a><span class='blink'>New</span></li>
                        <li><a href="/json-to-html-converter">JSON to HTML</a><span class='blink'>New</span>
                        </li>
                        <li><a href="/xml-to-html-converter">XML to HTML</a><span class='blink'>New</span>
                        </li>
                        <li><a href="/json-to-excel-converter">JSON to Excel</a><span class='blink'>New</span></li>
                        <li><a href="/xml-to-excel-converter">XML to Excel</a><span class='blink'>New</span></li>
                        <li><a href="/csv-to-excel-converter">CSV to Excel</a><span class='blink'>New</span></li>
                        <li><a href="/yaml-to-excel-converter">YAML to Excel</a><span class='blink'>New</span></li>
                    </ul>
                </div>
                <div class='footersub1'>
                    <h4>Web Viewer / Editor</h4>
                    <ul>
                        <li><a href="/jsonviewer" class="firstchild">JSON
                                VIEWER</a>
                        </li>
                        <li><a href="/xmlviewer">XML VIEWER</a>
                        </li>
                        <li><a href="/mxmlviewer">MXML VIEWER</a>
                        </li>
                        <li><a href="/htmlviewer/">HTML VIEWER </a>
                        </li>
                        <li><a href="/css-beautify-minify">CSS BEAUTIFY AND MINIFY</a>
                        </li>
                        <li><a href="/jsviewer">JAVASCRIPT VIEWER</a>
                        </li>
                        <li><a href="/rssviewer">RSS VIEWER</a>
                        </li>
                        <li><a href="/source-code-viewer">SOURCE CODE
                                VIEWER</a><span class='blink'>New</span>
                        </li>
                        <li><a href="/opmlviewer">OPML VIEWER</a><span class='blink'>New</span>
                        </li>
                        <li><a href="/collabe-code">Collabe On Code</a><span class='blink'>New</span>
                        </li>
                    </ul>
                    <h4>Programming Editors</h4>
                    <ul>
                        <li><a href="/online-xml-editor">XML EDITOR</a><span class='blink'>New</span></li>
                        <li><a href="/online-json-editor">JSON
                                EDITOR</a><span class='blink'>New</span></li>
                        <li><a href="/alleditor">ONLINE EDITOR</a>
                        </li>
                        <li><a href="/javaviewer">JAVA EDITOR</a></li>
                        <li><a href="/csharpviewer">C# EDITOR</a></li>
                        <li><a href="/actionscript">Action Script
                                EDITOR</a></li>
                        <li><a href="/sqlformatter">SQL EDITOR</a></li>
                    </ul>
                    <h4>Escape Unescape Tools</h4>
                    <ul>
                        <li><a href="/html-escape-unescape" title="HTML Escape Unescape">HTML Escape Unescape</a></li>
                        <li><a href="/xml-escape-unescape" title="XML Escape Unescape">XML Escape Unescape</a></li>
                        <li><a href="/java-escape-unescape" title="Java Escape Unescape">Java Escape Unescape</a></li>
                        <li><a href="/csharp-escape-unescape" title="C# Escape Unescape">C# Escape Unescape</a></li>
                        <li><a href="/javascript-escape-unescape" title="Javascript Escape Unescape">Javascript Escape
                                Unescape</a></li>
                        <li><a href="/csv-escape-unescape" title="CSV Escape Unescape">CSV Escape Unescape</a></li>
                        <li><a href="/sql-escape-unescape" title="SQL Escape Unescape">SQL Escape Unescape</a></li>
                        <li><a href="/un-google-link" title="Un-Google Link">Un-Google Link</a></li>
                    </ul>
                    <h4>CryptoGraphy Tools</h4>
                    <ul>
                        <li><a href="/encrypt-decrypt">Encryption-Decryption</a>
                        </li>
                    </ul>
                    <h4>Other Tools</h4>
                    <ul>

                        <li><a href="/lorem-ipsum">Lorem-Ipsum</a></li>
                        <li><a href="/share-link-generator">Sharelink
                                Generator</a></li>
                        <li><a href="/hostname-to-ip" title="Hostname to IP">Hostname to IP</a></li>
                        <li><a href="/ip-to-hostname" title="IP to Hostname">IP to Hostname</a></li>
                        <li><a href="/dns-lookup" title="DNS Lookup">DNS Lookup</a></li>
                        <li><a href="/mx-lookup" title="MX Lookup">MX Lookup</a></li>
                        <li><a href="/name-server-lookup" title="name-server-lookup">Nameserver Lookup</a></li>
                        <li><a href="/website-to-ip-address" title="Website to IP Address">Website to IP Address</a>
                        <li>

                    </ul>
                </div>
                <div class='footersub1'>
                    <h4>Utility</h4>
                    <ul>
                        <li><a href="/send-snap-message">Send Snap
                                Message</a><span class='blink'>New</span>
                        </li>
                        <li><a href="/responsive-website-tester">Responsive Website
                                Tester</a><span class='blink'>New</span>
                        </li>
                        <li><a href="/credit-card-validate">Credit
                                Card Validator</a><span class='blink'>New</span>
                        </li>
                        <li><a href="/credit-card-fake-number-generator">Credit
                                Card Fake Number Generator</a><span class='blink'>New</span>
                        </li>
                        <li><a href="/Xpath-Tester">XPath Tester</a><span class='blink'>New</span>
                        </li>
                        <li><a href="/jsonpath-tester" title="Json Path Tester">Json Path Tester</a><span class='blink'>New</span>
                        <li><a href="/jsonminifier" title="JSON Minifier">Json Minifier</a><span
                                    class='blink'>New</span>
                        </li>
                        <li><a href="/file-diff">File Difference</a><span class='blink'>New</span>
                        </li>
                        <li><a href="/json-diff">JSON Diff</a><span class='blink'>New</span>
                        <li><a href="/xml-diff">XML Diff</a><span class='blink'>New</span>
                        </li>
                        <li><a href="/broken-link-checker">Broken
                                Link Checker</a><span class='blink'>New</span>
                        </li>
                    </ul>
                    <h4>String Utilities</h4>
                    <ul>
                        <li><a href="/random-word-generator">Random Word Generator</a><span class='blink'>New</span>
                        </li>
                        <li><a href="/ntlm-hash-generator">NTLM Hash Generator</a><span class='blink'>New</span>
                        </li>
                        <li><a href="/password-generator">Password Generator</a><span class='blink'>New</span>
                        </li>
                        <li><a href="/string-builder">String Builder</a><span class='blink'>New</span>
                        </li>
                        <li><a href="/number-to-word-converter">NUMBER to WORD
                                Converter</a><span class='blink'>New</span></li>
                        <li><a href="/wordcounter">WORD COUNTER</a>
                        </li>
                        <li><a href="/reverse-string">Reverse String</a>
                        </li>
                        <li><a href="/html-encode-string">HTML Encode</a>
                        </li>
                        <li><a href="/html-decode-string">HTML Decode</a>
                        </li>
                        <li><a href="/base64-encode">Base64-Encode</a>
                        </li>
                        <li><a href="/base64-decode">Base64-Decode</a>
                        </li>
                        <li><a href="/url-encode-string">URL-Encode A
                                String</a>
                        </li>
                        <li><a href="/url-decode-string">URL-Decode A
                                String</a>
                        </li>
                        <li><a href="/string-hex-converter">String to Hex
                                Converter</a>
                        </li>
                        <li><a href="/hex-string-converter">Hex to String
                                Converter</a>
                        </li>
                        <li><a href="/string-binary-converter">String to Binary Converter</a>
                        </li>
                        <li><a href="/binary-string-converter">Binary to String Converter</a>
                        </li>
                        <li><a href="/case-converter">Case Converter </a><span class='blink'>New</span></li>
                        <li><a href="/delimited-text-extractor">Delimited Text Extractor </a><span
                                    class='blink'>New</span></li>
                        <li><a href="/remove-accents">Remove Accents </a><span class='blink'>New</span></li>
                        <li><a href="/remove-duplicate-lines">Remove Duplicate Lines</a><span class='blink'>New</span>
                        </li>
                        <li><a href="/remove-empty-lines">Remove Empty Lines</a><span class='blink'>New</span></li>
                        <li><a href="/remove-extra-spaces">Remove Extra Spaces </a><span class='blink'>New</span></li>
                        <li><a href="/remove-line-breaks">Remove Line Breaks</a><span class='blink'>New</span></li>
                        <li><a href="/remove-lines-containing">Remove Lines Containing</a><span class='blink'>New</span>
                        </li>
                        <li><a href="/sort-text-lines">Sort Text Lines</a><span class='blink'>New</span></li>
                    </ul>
                </div>
                <div class='footersub1'>
                    <h4>Validators</h4>
                    <ul>
                        <li><a href="/cssvalidate">CSS VALIDATOR</a>
                        </li>
                        <li><a href="/jsvalidate">JAVASCRIPT
                                VALIDATOR</a>
                        <li><a href="/jsonvalidator">JSON VALIDATOR</a>
                        <li><a href="/xmlvalidator">XML VALIDATOR</a>
                        <li><a href="/credit-card-validate">CREDIT
                                CARD VALIDATOR</a>
                        </li>
                        <li><a href="/api-test">API Test</a>
                        </li>
                        <li><a href="/yaml-validator">YAML VALIDATOR</a><span class='blink'>New</span>
                        </li>
                    </ul>
                    <h4>Number Utilities</h4>
                    <ul>
                        <li><a href="/all-number-converter">All Numbers
                                Converter</a>
                        </li>
                        <li><a href="/decimal-binary-converter">Decimal to
                                Binary Converter</a>
                        </li>
                        <li><a href="/decimal-hex-converter">Decimal to Hexa Converter</a>
                        </li>
                        <li><a href="/decimal-octal-converter">Decimal to Octal Converter</a>
                        </li>
                        <li><a href="/binary-decimal-converter">Binary to Decimal Converter</a>
                        </li>
                        <li><a href="/binary-hex-converter">Binary to Hex Converter</a>
                        </li>
                        <li><a href="/binary-octal-converter">Binary to Octal
                                Converter</a>
                        </li>
                        <li><a href="/hex-decimal-converter">Hex to Decimal Converter</a>
                        </li>
                        <li><a href="/hex-binary-converter">Hex to Binary Converter</a>
                        </li>
                        <li><a href="/hex-octal-converter">Hex to Octal
                                Converter</a>
                        </li>
                        <li><a href="/octal-decimal-converter">Octal to Decimal Converter</a>
                        </li>
                        <li><a href="/octal-binary-converter">Octal to Binary
                                Converter</a>
                        </li>
                        <li><a href="/octal-hex-converter"> Octal to Hex
                                Converter </a>
                        </li>
                    </ul>
                    <h4>Image Tools</h4>
                    <ul>
                        <li><a href="/jpg-to-png-converter">JPG to PNG Converter</a></li>
                        <li><a href="/bmp-to-png-converter">BMP to PNG Converter</a></li>
                        <li><a href="/gif-to-png-converter">GIF to PNG Converter</a></li>
                        <li><a href="/png-to-jpg-converter">PNG to JPG Converter</a></li>
                        <li><a href="/bmp-to-jpg-converter">BMP to JPG Converter</a></li>
                        <li><a href="/gif-to-jpg-converter">GIF to JPG Converter</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="span12 footerLinkDiv">
            <div class='center'>
                <a class="footermenu1" href="https://goo.gl/1oWmPe" target="_blank" title="Buy us a Coffee">Buy us a
                    Coffee</a>
                <a class="footermenu1" href="https://jsonformatter.org" target="_blank" title="JSON Formatter">JSON
                    Formatter</a>
                <a class="footermenu1" href="/faq">FAQ</a>
                <a class="footermenu1" href="/aboutus">About</a>
                <a class="footermenu1" href="/contactus">Contact</a>
                <a class="footermenu1" href="/history">History</a>
                <a class="footermenu1" href="/sitemap">Sitemap</a>
                <a class="footermenu1" href="/where-am-i-right-now">My Current Location</a>
                <a class="footermenu1" href="https://codeblogmoney.com">Blog</a>
            </div>
        </div>
    </div>
    <p id="back-top">
        <a href="#top" title='Scroll to Top'><span></span>&nbsp;</a>
    </p>
</div>
<input id="fContent" type="hidden" value=""/>
<input id="inputvalue" name="xmlinput" type="hidden" value="" />

<script src="https://www.gstatic.com/firebasejs/4.13.0/firebase.js"></script>

<script>
    // Initialize Firebase
    var config = {
        apiKey: "AIzaSyCF_egN6ffUTsN5kzdOYolwtCbhhXOc1Kc",
        authDomain: "diagramsecuencia.firebaseapp.com",
        databaseURL: "https://diagramsecuencia.firebaseio.com",
        projectId: "diagramsecuencia",
        storageBucket: "",
        messagingSenderId: "31340697665"
    };
    firebase.initializeApp(config);
    var xml;
    firebase.database().ref('dia_sec')
        .on('value', function (snapshot) {
                xml = snapshot.val().sec;
                console.log(xml);

            //$("#inputvaluew").val(xml);
                //document.getElementById('inputvalue').value=xml;
        });

</script>

<input id="fUrl" type="hidden" value=""/>
<input id="fTitle" type="hidden" value="XML to JAVA Converter: Convert XML to JAVA format"/>
<input id="fValue" type="hidden" value=""/>
<input id="loginWith" type="hidden" value=""/>
<div id="openError" class='hide'></div>
<div id="loadUrlPathDiv" class='hide'>
    <input type="text" id="path" class='urlPath' placeholder="Paste your url">
</div>
<div id="gdriveDialog" class='hide'>
    <div id="savetodrive-div"></div>
</div>
<div style="display: none" id="exportToExcelDiv">
</div>
</body>
</html>