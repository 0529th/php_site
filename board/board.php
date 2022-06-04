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

        <section id="board-type" class="section center">
            <div class="container">
                <h3 class="section__title">게시판</h3>
                <p class="section__desc">강의와 관련된 게시판입니다. 궁금한 점은 여기를 확인하세요!</p>
                <div class="board__inner">
                    <div class="board__search">
                        <form action="boardSearch.php" name="boardSearch" method="GET">
                            <fieldset>
                                <legend class="ir_so">게시판 검색 영역</legend>
                                <div>
                                    <input type="search" name="searchKeyword" class="search-form" placeholder="검색어를 입력하세요!" aria-label="search" required="">
                                </div>
                                <div>
                                    <select name="searchOption" class="search-option">
                                        <option value="title">제목</option>
                                        <option value="content">내용</option>
                                        <option value="name">등록자</option>
                                    </select>
                                </div>
                                <div>
                                    <button type="submit" class="search-btn">검색</button>
                                </div>
                                <div>
                                    <a href="boardWrite.php" class="search-btn black">글쓰기</a>
                                </div>
                            </fieldset>
                        </form>

                    </div>
                    <div class="board__table">
                        <table class="hover">
                            <colgroup>
                                <col style="width: 5%;">
                                <col>
                                <col style="width: 10%;">
                                <col style="width: 12%;">
                                <col style="width: 7%;">
                            </colgroup>
                            <thead>
                                <tr>
                                    <th>번호</th>
                                    <th>제목</th>
                                    <th>등록자</th>
                                    <th>등록일</th>
                                    <th>조회수</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if(isset($_GET['page'])){
                                        $page = (int) $_GET['page'];
                                    } else {
                                        $page = 1;
                                    }
                                   
                                    $numView = 10;
                                    $viewLimit = ($numView * $page) - $numView;
                                    //1~20: DESC (맨마지막거 위로)
                                    //DESC LIMIT 0, 20 --> page = 1 ($numView * page) - $numView
                                    //DESC LIMIT 20, 20 (20번 부터 20개) --> page = 2
                                    //DESC LIMIT 40, 20 (20번 부터 20개) --> page = 3
                                    //DESC LIMIT 60, 20 (20번 부터 20개) --> page = 4
 

                                    $sql = "SELECT b.boardID, b.boardTitle, m.youName, b.regTime, b.boardView FROM myBoard b JOIN myMember m ON(b.memberID = m.memberID) ORDER BY boardID DESC LIMIT {$viewLimit}, {$numView}";
                                    $result = $connect -> query($sql);

                                    if($result) {
                                        $count = $result -> num_rows;

                                        if($count > 0) {
                                            for($i = 1; $i <= $count; $i++) {
                                                $boardInfo = $result -> fetch_array(MYSQLI_ASSOC);
                                                echo "<tr>";
                                                echo "<td>".$boardInfo['boardID']."</td>";
                                                echo "<td class='left'><a href='boardView.php?boardID={$boardInfo['boardID']}'>".$boardInfo['boardTitle']."</a></td>";
                                                echo "<td>".$boardInfo['youName']."</td>";
                                                echo "<td>".date('Y-m-d',$boardInfo['regTime'])."</td>";
                                                echo "<td>".$boardInfo['boardView']."</td>";
                                                echo "</tr>";
                                            }
                                        }
                                    }
                                ?>              
                            </tbody>
                        </table>
                    </div>
                    <div class="board__pages">
                        <ul>
                            <?php
                                $sql = "SELECT count(boardID) FROM myBoard";
                                $result = $connect -> query($sql);

                                $boardTotalCount = $result -> fetch_array(MYSQLI_ASSOC);
                                $boardTotalCount = $boardTotalCount['count(boardID)'];
                                
                                // echo $boardTotalCount;
                                
                                // 총페이지 수
                                $boardTotalPage = ceil($boardTotalCount / $numView);
                                // echo $boardTotalPage;
                                // 몇개 보여줄건지
                                $pageView = 4;
                                $startPage = $page - $pageView;
                                $endPage = $page + $pageView;
                                // 처음 페이지 초기화
                                if($startPage < 1) $startPage = 1;

                                // 마지막 페이지 초기화
                                if($endPage >= $boardTotalPage) $endPage = $boardTotalPage;

                                // 처음으로 
                                if($page != 1) {
                                    echo "<li><a href='board.php?page=1'>처음으로</a></li>";
                                }
                                // 이전으로
                                if($page != 1) {
                                    $prevPage = $page - 1;
                                    echo "<li><a href='board.php?page={$prevPage}'>이전으로</a></li>";
                                }
                                for($i=$startPage; $i<=$endPage; $i++) {
                                    $active ="";
                                    if($i == $page) $active = "active";
                                    echo "<li class='{$active}'><a href='board.php?page={$i}'>{$i}</a></li>";
                                }


                                // 다음으로
                                if($page != $endPage) {
                                    $nextPage = $page + 1;
                                    echo "<li><a href='board.php?page={$nextPage}'>다음으로</a></li>";
                                }
                                // 마지막으로
                                if($page != $endPage) {
                                    $nextPage = $page + 1;
                                    echo "<li><a href='board.php?page={$boardTotalPage}'>마지막으로</a></li>";
                                }

                            ?>
                            <!-- <li><a href="#">1</a></li>
                            <li><a href="#">2</a></li>
                            <li><a href="#">3</a></li>
                            <li><a href="#">4</a></li>
                            <li><a href="#">5</a></li>
                            <li><a href="#">6</a></li>
                            <li><a href="#">다음</a></li>
                            <li><a href="#">마지막으로</a></li> -->
                        </ul>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include "../include/footer.php"; ?>
</body>
</html>