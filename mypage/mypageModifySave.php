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

        $memberID = $_SESSION['memberID'];
        $youEmail = $_POST['youEmail'];
        $youName = $_POST['youName'];
        $youBirth = $_POST['youBirth'];
        $youPhone = $_POST['youPhone'];
        $youPass = $_POST['youPass'];
        $youIntro = $_POST['youIntro'];
        // $chk_delete = $_POST['chk_delete'];

        $youImgFile = $_FILES['youFile'];
        $youImgSize = $_FILES['youFile']['size'];
        $youImgType = $_FILES['youFile']['type'];
        $youImgName = $_FILES['youFile']['name'];
        $youImgTmp = $_FILES['youFile']['tmp_name'];

        $youEmail = $connect -> real_escape_string($youEmail);
        $youName = $connect -> real_escape_string($youName);
        $youIntro = $connect -> real_escape_string($youIntro);

        echo "<pre>";
        var_dump($youImgFile);
        echo "</pre>";



        //이미지 파일명 확인
        $fileTypeExtension = explode("/", $youImgType);
        $fileType = $fileTypeExtension[0];  //image
        $fileExtension = $fileTypeExtension[1];  //jpeg


        //쿼리문 작성
        $sql = "SELECT youPass, memberID FROM myMember WHERE memberID = {$memberID}";
        $result = $connect -> query($sql);

        $memberInfo = $result -> fetch_array(MYSQLI_ASSOC);


        if($result){
            echo "<pre>";
            var_dump($memberInfo);
            echo "<pre>";

            //아이디 비밀번호 확인
            if($memberInfo['youPass'] == $youPass && $memberInfo['memberID'] == $memberID) {

                // if($old_filename != "") {
                //     @unlink($youImgdir.$old_filename);
                // }

                if($youImgSize > 1000000){
                    echo "<script>alert('이미지 용량이 1메가를 초과합니다. 수정해주세요!'); history.back(1)</script>";
                    exit;
                }
                if($fileType == "image"){
                    if($fileExtension == "jpg" || $fileExtension == "jpeg" || $fileExtension == "png" || $fileExtension == "gif"){
                        $youImgDir = "../assets/img/mypage/";
                        $youImgName = "Img_".time().rand(1,99999)."."."{$fileExtension}";
                        echo "이미지 파일이 맞습니다.";
                        //$sql = "INSERT INTO myMember(memberID, youEmail, youName, youBirth, youPhone, youPass, regTime, youIntro, youImgFile, youImgSize) VALUES('$memberID', '$youEmail', '$youName', '$youBirth', '$youPhone', '$youPass', '$regTime', '$youIntro', '$youImgName', '$youImgSize')";
                        $sql = "UPDATE myMember SET youEmail = '{$youEmail}', youName = '{$youName}', youBirth = '{$youBirth}', youPhone = '{$youPhone}', youIntro = '{$youIntro}', youImgFile = '{$youImgName}', youImgSize = '{$youImgSize}'WHERE memberID = '{$memberID}'";
                    } else {
                        echo "<script>alert('지원하는 이미지 파일 형식이 아닙니다. jpg, png, gif 사진 파일만 지원 합니다.'); history.back(1)</script>";
                        exit;
                    }
                } else if($fileType == "" || $fileType == null){
                    echo "이미지를 첨부하지 않았습니다.";
                    //$sql = "INSERT INTO myMember(memberID, youEmail, youName, youBirth, youPhone, youPass, regTime, youIntro, youImgFile, youImgSize) VALUES('$memberID', '$youEmail', '$youName', '$youBirth', '$youPhone', '$youPass', '$regTime', '$youIntro', 'default.svg')";
                    $sql = "UPDATE myMember SET youEmail = '{$youEmail}', youName = '{$youName}', youBirth = '{$youBirth}', youPhone = '{$youPhone}', youIntro = '{$youIntro}' WHERE memberID = '{$memberID}'";
                } else {
                    echo "<script>alert('지원하는 이미지 파일 형식이 아닙니다. jpg, png, gif 사진 파일만 지원 합니다.'); history.back(1)</script>";
                    exit;
                }
                
                
                $save = $connect -> query($sql);
                $save = move_uploaded_file($youImgTmp, $youImgDir.$youImgName);

                echo "<pre>";
                var_dump($save);
                echo "<pre>";

            } else {
                echo "<script>alert('비밀번호가 일치하지 않습니다. 다시 한번 확인해주세요!'); history.back(1)</script>";
            }
        } else {
            echo "관리자에게 문의하세요!";
        }

    ?>

<script>
        location.href = "mypage.php";
</script>

</body>
</html>