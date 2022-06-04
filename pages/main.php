<?php
    include "../connect/connect.php";
    include "../connect/session.php";
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>메인</title>

    <?php include "../include/style.php"; ?>
</head>
<body>
    <?php include "../include/skip.php"; ?>
    <?php include "../include/header.php"; ?>

    <main id="contents">
        <h2 class="ir_so">컨텐츠 영역</h2>
        <?php
            // echo "<pre>";
            // var_dump($_SESSION);
            // echo "</pre>";
        ?>

            <section id="blog-type" class="section center type">
                <div class="container">
                    <h3 class="section__title">FE 블로그</h3>
                    <p class="section__desc">코딩에 관련된 블로그입니다. 다양한 정보를 확인하세요!</p>
                    <div class="blog__inner">
                        <div class="blog__cont">
                            <?php   
                                $sql = "SELECT * FROM myBlog ORDER BY blogRegTime DESC LIMIT 3";
                                $result = $connect -> query($sql);

                                if($result) {
                                    $count = $result -> num_rows;

                                if($count > 0){
                                    for($i = 1; $i <= $count; $i++){
                                        $blogInfo = $result -> fetch_array(MYSQLI_ASSOC);

                                        echo"<article class='blog'>";
                                        echo   "<figure class='blog__header' aria-hidden='true'>";
                                        echo     "<a href='../blog/blogView.php?blogID=".$blogInfo['blogID']."' style='background-image: url(../assets/img/blog/".$blogInfo['blogImgFile'].");'></a>";
                                        echo   "</figure>";
                                        echo    "<div class='blog__body'>";
                                        echo        "<span class='blog__cate'>".$blogInfo['blogCategory']."</span>";
                                        echo        "<a href='../blog/blogView.php?blogID=".$blogInfo['blogID']."'>";
                                        echo            "<div class='blog__title'>".$blogInfo['blogTitle']."</div>";
                                        echo        "</a>";
                                        echo        "<div class='blog__desc'>".$blogInfo['blogContents']."</div>";
                                        echo        "<div class='blog__info'>";
                                        echo            "<span class='author'>".$blogInfo['blogAuthor']."</span>";
                                        echo            "<span class='date'>".date('Y-m-d',$blogInfo['blogRegTime'])."</span>";
                                        echo            "<div class='blog__att'>";
                                        echo                "<span class='view'>VIEW : ".$blogInfo['blogView']."</span>";
                                        echo                "<span class='like'>LIKE : ".$blogInfo['blogLike']."</span>";
                                        echo            "</div>";
                                        echo        "</div>";
                                        echo    "</div>";
                                        echo"</article>";
                                    }
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </section>
            <!-- //blog-type -->

            <section id="notice-type" class="section center">
                <div class="container">
                    <h3 class="section__title">코딩 게시판</h3>
                    <p class="section__desc">코딩과 관련된 게시판입니다. 다양한 정보를 확인하세요!</p>
                    <div class="notice__inner">
                        <article class="notice">
                            <h4>공지사항</h4>
                            <ul>
                                <?php
                                    $sql = "SELECT boardID, boardTitle, regTime FROM myBoard ORDER BY regTime DESC LIMIT 4";
                                    $result = $connect -> query($sql);

                                    if($result) {
                                        $count = $result -> num_rows;

                                        if($count > 0) {
                                            for($i = 1; $i <= $count; $i++) {
                                                $boardInfo = $result -> fetch_array(MYSQLI_ASSOC);
                                                echo "<li>";
                                                echo "<a href='../board/boardView.php?boardID={$boardInfo['boardID']}'>".$boardInfo['boardTitle']."</a>";
                                                echo "<span>".date('Y-m-d',$boardInfo['regTime'])."</span>";
                                                echo "</li>";
                                            }
                                        }
                                    }
                                ?>
                                <!-- <li>
                                    <a href="../board/boardView.php?boardID=302">
                                        검색제목
                                    </a>
                                    <span class="time">2022-03-24</span>
                                </li>
                                <li>
                                    <a href="../board/boardView.php?boardID=301">
                                        검색 결과가 없을 때 다음/마지막 페이지 안뜨게 어떻게 하지
                                    </a>
                                    <span class="time">2022-03-24</span>
                                </li>
                                <li>
                                    <a href="../board/boardView.php?boardID=300">
                                        게시판 타이틀300입니다.
                                    </a>
                                    <span class="time">
                                        2022-03-24
                                    </span>
                                </li>
                                <li>
                                    <a href="../board/boardView.php?boardID=299">
                                        게시판 타이틀299입니다.
                                    </a>
                                    <span class="time">
                                        2022-03-24
                                    </span>
                                </li> -->
                            </ul>
                            <a href="../board/board.php" class="more">더보기</a>
                        </article>
                        <article class="notice">
                            <h4>댓글</h4>
                            <ul>
                                <?php
                                    $sql = "SELECT youText, regTime FROM myComment ORDER BY regTime DESC LIMIT 4";
                                    $result = $connect -> query($sql);

                                    if($result) {
                                        $count = $result -> num_rows;

                                        if($count > 0) {
                                            for($i = 1; $i <= $count; $i++) {
                                                $boardInfo = $result -> fetch_array(MYSQLI_ASSOC);
                                                echo "<li>";
                                                echo "<a href='../comment/comment.php'>".$boardInfo['youText']."</a>";
                                                echo "<span>".date('Y-m-d',$boardInfo['regTime'])."</span>";
                                                echo "</li>";
                                            }
                                        }
                                    }
                                ?>
                                <!-- <li><a href="../comment/comment.php">맛집 괜찮은데좀 알려주세요 왜냐면</a><span class="time">2022-03-31</span></li>
                                <li><a href="../comment/comment.php">시리얼 맛있나요 궁금해요</a><span class="time">2022-03-30</span></li>
                                <li><a href="../comment/comment.php">해외시리얼 두 개 산걸 왜 여기다 말하죠?</a><span class="time">2022-03-30</span></li>
                                <li><a href="../comment/comment.php">샌드위치가 나을까 밥이 나을까 고민중</a><span class="time">2022-03-30</span></li> -->
                            </ul>
                            <a href="../comment/comment.php" class="more">더보기</a>
                        </article>
                    </div>
                </div>
            </section>
            <!-- //notice-type -->
    </main>

    <?php include "../include/footer.php"; ?>
</body>
</html>