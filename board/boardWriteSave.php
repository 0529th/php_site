<?php
    include "../connect/connect.php";
    include "../connect/session.php";
    include "../connect/sessionCheck.php";

    $boardTitle = $_POST['boardTitle'];
    $boardCont = $_POST['boardCont'];

    $memberID = $_SESSION['memberID'];
    $boardTitle = $connect -> real_escape_string($boardTitle);
    $boardCont = $connect -> real_escape_string($boardCont);
    $boardView = 1;
    $regTime = time();
    

    //데이터 입력
    $sql = "INSERT INTO myBoard(memberID, boardTitle, boardCont, boardView, regTime) VALUES('$memberID', '$boardTitle', '$boardCont', '$boardView', $regTime)";

    $connect -> query($sql);
?>

<script>
    location.href = "board.php";
</script>