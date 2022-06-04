<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php include "../include/style.php"; ?>
</head>
<body>
    <?php include "../include/skip.php"; ?>
    <?php include "../include/header.php"; ?>
        
    <?php
        include "../connect/connect.php";
        include "../connect/session.php";



        $youEmail = $_POST['youEmail'];
        $youPass = $_POST['youPass'];

        // echo $youEmail, $youPass;


        // 메세지 출력
        function msg($alert) {
            echo "<p class='alert'>{$alert}</p>";
        }

        // 이메일 유효성 검사
        if(!filter_var($youEmail, FILTER_VALIDATE_EMAIL)){
            msg("이메일이 잘못되었습니다.");
        }

        // 비밀번호 유효성 검사
        $youPass = trim($youPass);
        if($youPass == null || $youPass == '') {
            msg("비밀번호를 입력해주세요!");
        }

        // 비밀번호 암호화
        // $youPass = sha1("web".$youPass);

        // 로그인 -> 데이터 유무O --> 로그인
        // 로그인 -> 데이터 유무X --> 회원가입

        $sql = "SELECT memberID, youName, youEmail, youPass FROM myMember WHERE youEmail = '$youEmail' AND youPass = '$youPass'"; // 가져오기 select
        $result = $connect -> query($sql);

        if($result) {
            $count = $result -> num_rows; // 개수확인

            if($count == 0) {
                echo "<script>alert('이메일 또는 비밀번호가 잘못되었습니다. 다시한번 확인해주세요!') location href = 'login.php';</script>";
            } else {    
                //로그인 성공했으면
                $memberInfo = $result -> fetch_array(MYSQLI_ASSOC);

                echo "<pre>";
                var_dump ($memberInfo);
                echo "</pre>";

                echo "<script>alert('로그인이 성공하였습니다.')</script>";
                $_SESSION['memberID'] = $memberInfo['memberID'];
                $_SESSION['youEmail'] = $memberInfo['youEmail'];
                $_SESSION['youName'] = $memberInfo['youName'];

                Header("Location: ../pages/main.php");
            }
        }



    ?>
    <?php include "../include/footer.php"; ?>
</body>
</html>