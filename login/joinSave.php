<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>회원가입</title>

    <?php include "../include/style.php"; ?>
</head>
<body>

    <?php include "../include/skip.php"; ?>
    <?php include "../include/header.php"; ?>

    <main id="contents">
        <h2 class="ir_so">컨텐츠 영역</h2>
        <section class="join-type gray">
            

        <?php
            include "../connect/connect.php";

            $youEmail = $_POST['youEmail'];
            $youPass = $_POST['youPass'];
            $youPassC = $_POST['youPassC'];
            $youName = $_POST['youName'];
            $youBirth = $_POST['youBirth'];
            $youPhone = $_POST['youPhone'];
            $regTime = time();

            //echo $youEmail, $youPass, $youPassC, $youName, $youBirth, $youPhone;

            // $sql = "INSERT INTO hwangMember(youEmail, youPass, youName, youBirth, youPhone, regTime);
            // VALUES('$youEmail', '$youPass', '$youName', '$youBirth', '$youPhone', '$regTime')";

            // $result = $connect -> query($sql);

            // if($result){
            //     echo "INSERT INTO ture";
            // } else {
            //     echo "INSERT INTO false";
            // }

            //메세지 출력
            function msg($alert){
                echo "<p class='alert'>{$alert}</p>";
            }

            // if($youPass == null || $youPass == ''){
            //     msg("비밀번호를 다시 작성해 주세요!!");
            // }

            //유효성 검사 : 내장 함수
            // $check_email = filter_var($youEmail, FILTER_VALIDATE_EMAIL);

            // if($check_email == false){
            //     echo "이메일이 잘못되었습니다.<br>올바른 이메일을 적어주세요!!";
            //     exit;
            // }

            //이메일 유효성 검사
            //$check_email = preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $youEmail);

            //비밀번호 유효성 검사
            if($youPass !== $youPassC){
                msg("비밀번호가 일치하지 않습니다.<br> 다시 한번 확인해주세요!!!!");
            }

            //이름 유효성 검사
            $check_name = preg_match("/^[가-힣]{1,}$/", $youName);
            
            if($check_name == false){
                msg("이름이 정확하지 않습니다. <br>한글로만 적어주세요!");
            }

            //생년월일 유효성 검사  
            $check_birth = preg_match("/^(19[0-9][0-9]|20\d{2})-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $youBirth);
            
            if($check_birth == false){
                msg("생일이 정확하지 않습니다. <br>올바른 생년월인(YYYY-MM-DD) 적어주세요!");
            }

            //휴대폰 번호 유효성 검사
            $check_number = preg_match("/^(010|011|016|017|018|019)-[0-9]{3,4}-[0-9]{4}$/", $youPhone);

            if($check_number == false){
                msg("번호가 정확하지 않습니다. <br>올바른 생년월인(000-0000-0000) 적어주세요!");
            }

            // 회원가입-- 자격O --> 이메일주소 && 핸드폰번호 중복검사 X --> 회원가입
            // 회원가입-- 자격O --> 이메일주소 && 핸드폰번호 중복검사 O --> 로그인
            
            // 이메일 데이터 중복검사
            $isEmailCheck = false;

            $sql = "SELECT youEmail FROM myMember WHERE youEmail = '$youEmail'"; 
            $result = $connect -> query($sql);

            if($result) {
                $count = $result -> num_rows;
                if($count ==0) {
                    // 회원가입 가능
                    $isEmailCheck = true;
                } else {
                    msg("이미 회원가입 되어 있습니다. 로그인을 해주세요!");
                    exit;
                }
            } else {
                msg("에러발생01 : 관리자에게 문의하세요!");
                exit;
            }

            // 핸드폰 데이터 중복검사
            $isPhoneCheck = false;

            $sql = "SELECT youPhone FROM myMember WHERE youPhone = '$youPhone'"; 
            $result = $connect -> query($sql);

            if($result) {
                $count = $result -> num_rows;
                if($count == 0) {
                    // 회원가입 가능
                    $isPhoneCheck = true;
                } else {
                    msg("이미 회원가입 되어 있습니다. 로그인을 해주세요!");
                    exit;
                }
            } else {
                msg("에러발생02 : 관리자에게 문의하세요!");
                exit;
            }

            // 회원가입
            if ($isEmailCheck == true && $isEmailCheck == true) {
                $sql = "INSERT INTO myMember(youEmail, youPass, youName, youBirth, youPhone, regTime) VALUES('$youEmail', '$youPass', '$youName', '$youBirth', '$youPhone', '$regTime')";
                $result = $connect -> query($sql);
                if($result) {
                    msg("회원가입을 축하합니다. 로그인해주세요!");
                } else {
                    msg("에러발생03 : 관리자에게 문의하세요!");
                }

            } else {
                msg("이메일 또는 핸드폰 번호가 틀렸습니다. 다시 한번 확인해주세요!");
                exit;
            }
        ?>
    
         
        </section>
    </main>
    <!— //main —->

    <?php include "../include/footer.php"; ?>
</body>
</html>