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
    <title>Document</title>
</head>
<body>
    <?php
        $boardID = $_POST['boardID'];
        $boardTitle = $_POST['boardTitle'];
        $boardCont = $_POST['boardCont'];
        $youPass = $_POST['youPass'];
        $memberID = $_SESSION['memberID'];

        $boardTitle = $connect -> real_escape_string($boardTitle);
        $boardCont = $connect -> real_escape_string($boardCont);

        //쿼리문 작성
        $sql = "SELECT youPass, memberID FROM myMember WHERE memberID = {$memberID}";
        $result = $connect -> query($sql);

        $memberInfo = $result -> fetch_array(MYSQLI_ASSOC);

        if($result){
            // echo "<pre>";
            // var_dump($memberInfo);
            // echo "</pre>";

            //아이디 비밀번호 확인
            if($memberInfo['youPass'] == $youPass && $memberInfo['memberID'] == $memberID) {
                $sql = "UPDATE myBoard SET boardTitle = '{$boardTitle}', boardCont = '{$boardCont}' WHERE boardID = '{$boardID}'"; 
                $connect -> query($sql);
            } else {
                echo "<script>alert('비밀번호가 일치하지 않습니다. 다시 한번 확인해주세요'); history,back(1)</script>";
            } 
        } else {
            echo "관리자에게 문의하세요!";
        }
    ?>
    <script>
        location.href ="board.php";
    </script>
</body>
</html>