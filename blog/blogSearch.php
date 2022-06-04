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
    <title>PHP</title>
    <?php include "../include/style.php"; ?>
</head>
<body>
    <?php include "../include/skip.php"; ?>
    <?php include "../include/header.php"; ?>
    <main id="contents">
        <h2 class="ir_so">컨텐츠 영역</h2>
        <section id="blog-type" class="section center">
            <div class="container">
                <h3 class="section__title">블로그 검색결과</h3>
                <p class="section__desc">음식에 관련된 블로그입니다. 다양한 정보를 확인하세요!</p>
                <div class="blog__inner">
                    <div class="blog__search">
                        <form action="blogSearch.php" method="get">
                            <fieldset>
                                <legend class="ir_so">검색 영역</legend>
                                <input type="search" name="blogSearch" id="blogSearch" class="search" placeholder="검색어를 입력해주세요!">
                                <label for="blogSearch" class="ir_so">검색</label>
                                <button type="submit" class="button">검색버튼</button>
                            </fieldset>
                        </form>
                    </div>
                    <?php
                        function msg($alert){
                            echo "<p>총 " .$alert. " 건이 검색되었습니다. </p>";
                        }

                        $blogSearch = $_GET['blogSearch'];
                        $blogSearch = $connect -> real_escape_string(trim($blogSearch));


                        // $sql = "SELECT b.boardID, b.boardTitle, b.boardCont, m.youName, b.regTime, b.boardView FROM myBoard b JOIN myMember m ON(b.memberID = m.memberID) WHERE b.boardTitle LIKE '%{$searchKeyword}%' ORDER BY boardID DESC LIMIT 10";
                        // $sql = "SELECT b.boardID, b.boardTitle, b.boardCont, m.youName, b.regTime, b.boardView FROM myBoard b JOIN myMember m ON(b.memberID = m.memberID) WHERE b.boardCont LIKE '%{$searchKeyword}%' ORDER BY boardID DESC LIMIT 10";
                        // $sql = "SELECT b.boardID, b.boardTitle, b.boardCont, m.youName, b.regTime, b.boardView FROM myBoard b JOIN myMember m ON(b.memberID = m.memberID) WHERE m.youName LIKE '%{$searchKeyword}%' ORDER BY boardID DESC LIMIT 10";


                        $sql = "SELECT b.blogID, b.blogCategory, b.blogTitle, b.blogContents, m.youName, b.blogRegTime, b.blogView, b.blogLike, b.blogImgFile FROM myBlog b JOIN myMember m ON(b.memberID = m.memberID) WHERE b.blogTitle LIKE '%{$blogSearch}%' ORDER BY blogID";

                        $total = $connect -> query($sql);


                        if($total){
                            $count = $total -> num_rows;

                            msg($count);
                        }
                    ?>         
                    <div class="blog__btn">
                        <a href="blogWrite.php">글쓰기</a>
                    </div>
                    <div class="blog__cont">
                        <?php
                            if(isset($_GET['page'])){
                                $page = (int) $_GET['page'];
                            } else {
                                $page = 1;
                            }

                            $numView = 5;
                            $viewLimit = ($numView * $page) - $numView;

                            $sql2 = "SELECT b.blogID, b.blogCategory, b.blogTitle, b.blogContents, m.youName, b.blogRegTime, b.blogView, b.blogLike, b.blogImgFile FROM myBlog b JOIN myMember m ON(b.memberID = m.memberID) WHERE b.blogTitle LIKE '%{$blogSearch}%' ORDER BY blogID DESC LIMIT {$viewLimit}, {$numView}";
                            $result = $connect -> query($sql2);

                            if($result){
                                $count = $result -> num_rows;
                                if($count > 0){
                                    for($i=1; $i<=$count; $i++){
                                        $blogInfo = $result -> fetch_array(MYSQLI_ASSOC);
                                        echo "<article class='blog'>";
                                        echo "<figure class='blog__header' aria-hidden='true'><a href='blogView.php?blogID={$blogInfo['blogID']}' style='background-image: url(../assets/img/blog/{$blogInfo['blogImgFile']});'></a></figure>";
                                        echo "<div class='blog__body'>";
                                        echo "<span class='blog__cate' style='display:none;'>".$blogInfo['blogID']."</span>";
                                        echo "<span class='blog__cate'>".$blogInfo['blogCategory']."</span>";
                                        echo "<a href='blogView.php?blogID={$blogInfo['blogID']}'>";
                                        echo "<div class='blog__title'>".$blogInfo['blogTitle']."</div>";
                                        echo "<div class='blog__att'>";
                                        echo "<span class='view'>VIEW : ".$blogInfo['blogView']." </span>";
                                        echo "<span class='view'>LIKE : ".$blogInfo['blogLike']."</span>";
                                        echo "</div>";
                                        echo "</a>";
                                        echo "<div class='blog__desc'>".$blogInfo['blogContents']."</div>";
                                        echo "<div class='blog__info'>";
                                        echo "<span class='author'>".$blogInfo['youName']." </span>";
                                        echo "<span class='date'>".date('Y-m-d', $blogInfo['blogRegTime'])."</span>";
                                        echo "<span class='modify'><a href='blogModify.php?blogID={$blogInfo['blogID']}'>수정</a></span>";
                                        echo "<span class='delete'><a href='blogRemove.php?blogID={$blogInfo['blogID']}'>삭제</a></span>";
                                        echo "</div>";
                                        echo "</div>";
                                        echo "</article>";
                                    }
                                } 
                            }
                        ?>             
                    </div>
                    <div class="blog__pages">
                        <ul>
                            <?php
                                $result = $connect -> query($sql);

                                $blogTotalCount = $result -> num_rows;

                                // 총 페이지 수
                                $blogTotalPage = ceil($blogTotalCount/$numView);

                                //echo $blogTotalPage;

                                // 페이지 보여주는 갯수
                                $pageView = 5;
                                $startPage = $page - $pageView; 
                                $endPage = $page + $pageView;

                                // 처음 페이지 초기화
                                if($startPage < 1) $startPage = 1;

                                // 마지막 페이지 초기화
                                if($endPage >= $blogTotalPage) $endPage = $blogTotalPage;

                                // 처음으로
                                if($page != 1) {
                                    echo "<li><a href='blogSearch.php?page=1'><<</a></li>";
                                }

                                // 이전으로
                                if($page != 1) {
                                    $prevPage = $page - 1;
                                    echo "<li><a href='blogSearch.php?blogSearch={$blogSearch}?page={$prevPage}'><</a></li>";
                                }
                            
                                // active
                                for($i=$startPage; $i<=$endPage; $i++) {
                                    $active = "";
                                    if($i == $page) $active = "active";

                                    echo "<li class='{$active}'><a href='blogSearch.php?page={$i}&blogSearch={$blogSearch}'>{$i}</a></li>";
                                }

                                // 다음으로
                                if($page != $endPage) {
                                    $nextPage = $page + 1;
                                    echo "<li><a href='blogSearch.php?page={$i}&blogSearch={$blogSearch}'>></a></li>";
                                }

                                // 마지막으로
                                if($page != $endPage) {
                                    echo "<li><a href='blogSearch.php?page={$blogTotalPage}'>>></a></li>";
                                }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include "../include/footer.php"; ?>
</body>
</html>