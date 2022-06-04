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
                <h3 class="section__title">강의 게시판</h3>
                <p class="section__desc">강의와 관련된 게시판입니다. 게시글을 작성해주세요!</p>
                <div class="board__inner">
                    <div class="board__table">
                        <table>
                            <colgroup>
                                <col style="width: 30%">
                                <col style="width: 70%">
                            </colgroup>
                            <tbody>

                                <?php
                                    $boardID = $_GET['boardID'];

                                    //echo $boardID;

                                    $sql = "SELECT b.boardTitle, m.youName, b.regTime, b.boardView, b.boardCont FROM myBoard b JOIN myMember m ON(b.memberID = m.memberID) WHERE b.boardID = {$boardID}";
                                    $result = $connect -> query($sql);


                                    $view = "UPDATE myBoard SET boardView = boardView + 1 WHERE boardID = {$boardID}";
                                    $connect ->query($view);

                                    if($result){
                                        $boardInfo = $result -> fetch_array(MYSQLI_ASSOC);

                                        echo "<tr><th>제목</th><td class='left'>".$boardInfo['boardTitle']."</td></tr>";
                                        echo "<tr><th>글쓴이</th><td class='left'>".$boardInfo['youName']."</td></tr>";
                                        echo "<tr><th>등록일</th><td class='left'>".date('Y-m-d H:i', $boardInfo['regTime'])."</td></tr>";
                                        echo "<tr><th>조회수</th><td class='left'>".$boardInfo['boardView']."</td></tr>";
                                        echo "<tr><th>내용</th><td class='height left'>".$boardInfo['boardCont']."</td></tr>";
                                    }
                                ?>                  
                            </tbody>
                        </table>
                    </div>
                    <div class="board__btn">
                        <a href="board.php">목록보기</a>
                        <a href="boardRemove.php?boardID=<?=$_GET['boardID']?>" onclick="if(!confirm('정말 삭제하시겠습니까?')) return false">삭제하기</a>
                        <a href="boardModify.php?boardID=<?=$_GET['boardID']?>">수정하기</a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include "../include/footer.php"; ?>

</body>
</html>