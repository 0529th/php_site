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
        <section id="board-type" class="section center mb100">
            <div class="container">
                <h3 class="section__title">검색 결과 게시판</h3>
                <p class="section__desc">강의와 관련된 검색 결과입니다.</p>
                <div class="board__inner">
                    <div class="board__search">
                        <?php
                            function msg($alert){
                                echo "<p>총 " .$alert. " 건이 검색되었습니다. </p>";
                            }

                            $searchKeyword = $_GET['searchKeyword'];
                            $searchOption = $_GET['searchOption'];

                            $searchKeyword = $connect -> real_escape_string(trim($searchKeyword));
                            $searchOption = $connect -> real_escape_string(trim($searchOption));

                            $sql = "SELECT b.boardID, b.boardTitle, b.boardCont, b.boardView, m.youName, b.regTime FROM myBoard b JOIN myMember m ON (m.memberID = b.memberID) ";

                            switch($searchOption){
                                case 'title':
                                    $sql .= "WHERE b.boardTitle LIKE '%{$searchKeyword}%' ORDER BY boardID";
                                    break;
                                case 'content':
                                    $sql .= "WHERE b.boardCont LIKE '%{$searchKeyword}%' ORDER BY boardID";
                                    break;
                                case 'name':
                                    $sql .= "WHERE m.youName LIKE '%{$searchKeyword}%' ORDER BY boardID";
                                    break;
                            }
                            


                            $total = $connect -> query($sql);

                            if($total){
                                $count = $total -> num_rows;

                                msg($count);
                            }


                        ?>
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

                                $numView = 20;
                                $viewLimit = ($numView * $page) - $numView;


                                $sql2 = "SELECT b.boardID, b.boardTitle, b.boardCont, b.boardView, m.youName, b.regTime FROM myBoard b JOIN myMember m ON (m.memberID = b.memberID) ";

                                    switch($searchOption){
                                        case 'title':
                                            $sql2 .= "WHERE b.boardTitle LIKE '%{$searchKeyword}%' ORDER BY boardID DESC LIMIT {$viewLimit}, {$numView}";
                                            break;
                                        case 'content':
                                            $sql2 .= "WHERE b.boardCont LIKE '%{$searchKeyword}%' ORDER BY boardID DESC LIMIT {$viewLimit}, {$numView}";
                                            break;
                                        case 'name':
                                            $sql2 .= "WHERE m.youName LIKE '%{$searchKeyword}%' ORDER BY boardID DESC LIMIT {$viewLimit}, {$numView}";
                                            break;
                                    }

                                    $result = $connect -> query($sql2);

                                    if($result) {
                                        $count = $result -> num_rows;

                                        if($count > 0) {
                                            for( $i = 1; $i <= $count; $i++ ){
                                                $info = $result -> fetch_array(MYSQLI_ASSOC);
                                                echo "<tr>";
                                                echo "<td>".$info['boardID']."</td>";
                                                echo "<td class='left'><a href='boardView.php?boardID={$info['boardID']}'>".$info['boardTitle']."</a></td>";
                                                echo "<td>".$info['youName']."</td>";
                                                echo "<td>".date('Y-m-d', $info['regTime'])."</td>";
                                                echo "<td>".$info['boardView']."</td>";
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
                                $sql3 = "SELECT b.boardID, b.boardTitle, b.boardCont, b.boardView, m.youName, b.regTime FROM myBoard b JOIN myMember m ON (m.memberID = b.memberID) ";

                                switch($searchOption){
                                    case 'title':
                                        $sql3 .= "WHERE b.boardTitle LIKE '%{$searchKeyword}%' ORDER BY boardID";
                                        break;
                                    case 'content':
                                        $sql3 .= "WHERE b.boardCont LIKE '%{$searchKeyword}%' ORDER BY boardID";
                                        break;
                                    case 'name':
                                        $sql3 .= "WHERE m.youName LIKE '%{$searchKeyword}%' ORDER BY boardID";
                                        break;
                                }

                                $result = $connect -> query($sql3);

                                $boardTotalCount = $result -> num_rows;
                                // echo $boardTotalCount;

                                // 총 페이지 수
                                $boardTotalPage = ceil($boardTotalCount/$numView);

                                // echo $boardTotalPage;

                                // 페이지 보여주는 갯수
                                $pageView = 5;
                                $startPage = $page - $pageView; 
                                $endPage = $page + $pageView;

                                // 처음 페이지 초기화 
                                if($startPage < 1) $startPage = 1;

                                // 마지막 페이지 초기화
                                if($endPage >= $boardTotalPage) $endPage = $boardTotalPage;

                                //처음으로
                                if($page != 1) {
                                    echo "<li><a href='boardSearch.php?page=1&searchKeyword={$searchKeyword}&searchOption={$searchOption}'>처음으로</a></li>";
                                }

                                //이전으로
                                if($page != 1) {
                                    $prevPage = $page - 1;
                                    echo "<li><a href='boardSearch.php?searchKeyword={$searchKeyword}&searchOption={$searchOption}?page={$prevPage}'>이전으로</a></li>";
                                }

                                // active
                                for($i=$startPage; $i<=$endPage; $i++) {
                                    $active = "";
                                    if($i == $page) $active = "active";

                                    echo "<li class='{$active}'><a href='boardSearch.php?page={$i}&searchKeyword={$searchKeyword}&searchOption={$searchOption}'>{$i}</a></li>";
                                }

                                // 다음으로
                                if($page != $endPage) {
                                    $nextPage = $page + 1;
                                    echo "<li><a href='boardSearch.php?page={$i}&searchKeyword={$searchKeyword}&searchOption={$searchOption}'>다음</a></li>";
                                }

                                // 마지막으로
                                if($page != $endPage) {
                                    echo "<li><a href='boardSearch.php?page={$boardTotalPage}&searchKeyword={$searchKeyword}&searchOption={$searchOption}'>마지막으로</a></li>";
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