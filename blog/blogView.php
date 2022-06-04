<?php
    include "../connect/connect.php";
    include "../connect/session.php";
    include "../connect/sessionCheck.php";
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>blogView</title>
    <?php include "../include/style.php"; ?>
    <style>
        .like_area {
            margin-top: 10em;
            margin-bottom: 10em;
            position: relative;
            height: 30px;
        }
        #like {
            position: absolute;
            left: 52%;
            top: 25%;
        }
        @media (max-width: 1180px){
            .like_area {
                margin-top: 5em;
                margin-bottom: 5em;
                height: 60px;
            }

            #like {
                position: absolute;
                left: 41%;
                top: 80%;
            }

            .button {
                left: 40%;
            }
        }
        .button {
            --color: #1E2235;
            --color-hover: #1E2235;
            --color-active: #fff;
            --icon: #BBC1E1;
            --icon-hover: #8A91B4;
            --icon-active: #fff;
            --background: #fff;
            --background-hover: #fff;
            --background-active: #362A89;
            --border: #E1E6F9;
            --border-active: #362A89;
            --shadow: rgba(0, 17, 119, 0.025);
            display: block;
            outline: none;
            cursor: pointer;
            position: absolute;
            left: 38%;
            border: 0;
            background: none;
            padding: 8px 20px 8px 24px;
            border-radius: 9px;
            line-height: 27px;
            font-family: inherit;
            font-weight: 600;
            font-size: 14px;
            color: var(--color);
            -webkit-appearance: none;
            -webkit-tap-highlight-color: transparent;
            transition: color 0.2s linear;
        }
        .button.dark {
            --color: #F6F8FF;
            --color-hover: #F6F8FF;
            --color-active: #fff;
            --icon: #8A91B4;
            --icon-hover: #BBC1E1;
            --icon-active: #fff;
            --background: #1E2235;
            --background-hover: #171827;
            --background-active: #275EFE;
            --border: transparent;
            --border-active: transparent;
            --shadow: rgba(0, 17, 119, 0.16);
        }
        .button:hover {
            --icon: var(--icon-hover);
            --color: var(--color-hover);
            --background: var(--background-hover);
            --border-width: 2px;
        }
        .button:active {
            --scale: .95;
        }
        .button:not(.liked):hover {
            --hand-rotate: 8;
            --hand-thumb-1: -12deg;
            --hand-thumb-2: 36deg;
        }
        .button.liked {
            --span-x: 2px;
            --span-d-o: 1;
            --span-d-x: 0;
            --icon: var(--icon-active);
            --color: var(--color-active);
            --border: var(--border-active);
            --background: var(--background-active);
        }
        .button:before {
            content: "";
            min-width: 103px;
            position: absolute;
            left: 0;
            top: 0;
            right: 0;
            bottom: 0;
            border-radius: inherit;
            transition: background 0.2s linear, transform 0.2s, box-shadow 0.2s linear;
            transform: scale(var(--scale, 1)) translateZ(0);
            background: var(--background);
            box-shadow: inset 0 0 0 var(--border-width, 1px) var(--border), 0 4px 8px var(--shadow), 0 8px 20px var(--shadow);
        }
        .button .hand {
            width: 11px;
            height: 11px;
            border-radius: 2px 0 0 0;
            background: var(--icon);
            position: relative;
            margin: 10px 8px 0 0;
            transform-origin: -5px -1px;
            transition: transform 0.25s, background 0.2s linear;
            transform: rotate(calc(var(--hand-rotate, 0) * 1deg)) translateZ(0);
        }
        .button .hand:before,
        .button .hand:after {
            content: "";
            background: var(--icon);
            position: absolute;
            transition: background 0.2s linear, box-shadow 0.2s linear;
        }
        .button .hand:before {
            left: -5px;
            bottom: 0;
            height: 12px;
            width: 4px;
            border-radius: 1px 1px 0 1px;
        }
        .button .hand:after {
            right: -3px;
            top: 0;
            width: 4px;
            height: 4px;
            border-radius: 0 2px 2px 0;
            background: var(--icon);
            box-shadow: -0.5px 4px 0 var(--icon), -1px 8px 0 var(--icon), -1.5px 12px 0 var(--icon);
            transform: scaleY(0.6825);
            transform-origin: 0 0;
        }
        .button .hand .thumb {
            background: var(--icon);
            width: 10px;
            height: 4px;
            border-radius: 2px;
            transform-origin: 2px 2px;
            position: absolute;
            left: 0;
            top: 0;
            transition: transform 0.25s, background 0.2s linear;
            transform: scale(0.85) translateY(-0.5px) rotate(var(--hand-thumb-1, -45deg)) translateZ(0);
        }
        .button .hand .thumb:before {
            content: "";
            height: 4px;
            width: 7px;
            border-radius: 2px;
            transform-origin: 2px 2px;
            background: var(--icon);
            position: absolute;
            left: 7px;
            top: 0;
            transition: transform 0.25s, background 0.2s linear;
            transform: rotate(var(--hand-thumb-2, -45deg)) translateZ(0);
        }
        .button .hand,
        .button span {
            display: inline-block;
            vertical-align: top;
        }

        .button .hand span,
        .button span span {
            opacity: var(--span-d-o, 0);
            transition: transform 0.25s, opacity 0.2s linear;
            transform: translateX(var(--span-d-x, 4px)) translateZ(0);
        }

        .button>span {
            transition: transform 0.25s;
            transform: translateX(var(--span-x, 4px)) translateZ(0);
        }
    </style>

</head>
<body>
    <?php include "../include/skip.php"; ?>
    <?php include "../include/header.php"; ?>
    
    <main id="contents">
        <h2 class="ir_so">컨텐츠 영역</h2>
        <section id="blog-type" class="center">
            <?php
                $blogID = $_GET['blogID'];

                $sql = "SELECT * FROM myBlog WHERE blogID = {$blogID}";
                $result = $connect -> query($sql);


                $view = "UPDATE myBlog SET blogView = blogView + 1 WHERE blogID = {$blogID}";
                $connect -> query($view);

                if($result){
                    $blogInfo = $result -> fetch_array(MYSQLI_ASSOC);
                    echo "<div class='blog__label' style='background-image: url(../assets/img/blog/".$blogInfo['blogImgFile'].")'>";
                    echo "<h3 class='section__title'>".$blogInfo['blogTitle']."</h3>";
                    echo "<div>";
                    echo "<span class='author'><a href='#'>".$blogInfo['blogAuthor']."</a></span>";
                    echo "<span class='date'>".date('Y-m-d H:i', $blogInfo['blogRegTime'])."</span><br><br>";
                    echo "<span class='modify'><a href='blogModify.php?blogID=".$blogInfo['blogID']."'>수정 </a></span>";
                    echo "<span class='delete'><a href='blogRemove.php?blogID=".$blogInfo['blogID']."' onclick=\"if(!confirm('정말 삭제하시겠습니까?')) {return false;}\">삭제</a></span>";
                    echo "</div>";
                    echo "<div class='modDateWrap'>";
                    echo "<span class='modiDate'>(수정 : ".date('Y-m-d', $blogInfo['blogModTime']).")</span><br>";
                    echo "</div></div>";
                }
            ?>       

            <div class="container">
                <div class="blog__layout">
                    <div class="blog__left">
                        <h4><?= $blogInfo['blogTitle'] ?></h4>
                        <?= $blogInfo['blogContents'] ?>
                        <div class="like_area">
                            <button class="button"  onclick="blogLike()">
                                <div class="hand">
                                    <div class="thumb"></div>
                                </div>
                                <span>Like<span>d</span></span>
                            </button>
                            <span id="like">좋아요 : <?=$blogInfo['blogLike']?></span>
                        </div>
                    </div>
                    <div class="blog__right">
                        <div class="ad">
                        <iframe src="https://ads-partners.coupang.com/widgets.html?id=581861&template=banner&trackingCode=AF3133746&subId=&width=320&height=480" width="320" height="480" frameborder="0" scrolling="no" referrerpolicy="unsafe-url"></iframe>                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include "../include/footer.php"; ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.10.4/gsap.min.js"></script>
    <script>
        var youlikeCheck = ""
        function blogLike(){
            var blogID = "<?= $blogID ?>";
            var blogLike = "<?=$blogInfo['blogLike']?>";
            document.write(blogLike);



            if(youlikeCheck == false){
                $.ajax({
                type : "POST",           
                // url : "likeCheck.php",
                data : {"blogID": blogID, "check": 1},
                // dataType : "json",
                success : function(data){ 
                    $("#like").text("좋아요 : " + data.result);
                    youlikeCheck = true;
                },
                error : function(request, status, error){
                    console.log("request" + request);
                    console.log("status" + status);
                    console.log("error" + error);
                }
                });
            } else if(youlikeCheck == true){
                $.ajax({
                type : "POST",
                // url : "likeCheck.php",
                data : {"blogID": blogID, "check": 2},     
                // dataType : "json",
                success : function(data){ 
                    $("#like").text("좋아요 : "  );
                    youlikeCheck = false;
                },
                error : function(request, status, error){
                    console.log("request" + request);
                    console.log("status" + status);
                    console.log("error" + error);
                }
                });
            } else if(youlikeCheck == 'logout'){
                alert("로그인을 해야 좋아요를 누를 수 있습니다.");
            } 
        }
        document.querySelectorAll(".button").forEach((button) => {
            if(youlikeCheck == true) {
                button.classList.add("liked");
                button.addEventListener("click", (e) => {
                    button.classList.toggle("liked");
                });
            } else if(youlikeCheck == false){
                button.addEventListener("click", (e) => {
                    button.classList.toggle("liked");
                    if (button.classList.contains("liked")) {
                        gsap.fromTo(
                            button, {
                                "--hand-rotate": 8
                            }, {
                                ease: "none",
                                keyframes: [{
                                        "--hand-rotate": -45,
                                        duration: 0.16,
                                        ease: "none"
                                    },
                                    {
                                        "--hand-rotate": 15,
                                        duration: 0.12,
                                        ease: "none"
                                    },
                                    {
                                        "--hand-rotate": 0,
                                        duration: 0.2,
                                        ease: "none",
                                        clearProps: true
                                    }
                                ]
                            }
                        );
                    }
                });
            }
        });
    </script> -->
</body>
</body>
</html>

    
