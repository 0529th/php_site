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
        $blogID = $_POST['blogID'];
        $blogCate = $_POST['blogCategory'];
        $blogTitle = $_POST['blogTitle'];
        $blogContents = $_POST['blogContents'];
        $youPass = $_POST['youPass'];
        $memberID = $_SESSION['memberID'];
        $blogModTime = time();

        $blogImgFile = $_FILES['blogFile'];
        $blogImgSize = $_FILES['blogFile']['size'];
        $blogImgType = $_FILES['blogFile']['type'];
        $blogImgName = $_FILES['blogFile']['name'];
        $blogImgTmp = $_FILES['blogFile']['tmp_name'];

        $blogCate = $connect -> real_escape_string($blogCate);
        $blogTitle = $connect -> real_escape_string($blogTitle);
        $blogCont = $connect -> real_escape_string($blogCont);

        //이미지 파일명 확인
        $fileTypeExtension = explode("/", $blogImgType);
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
                if($blogImgSize > 1000000){
                    echo "<script>alert('이미지 용량이 1메가를 초과합니다. 수정해주세요!'); history.back(1)</script>";
                    exit;
                }
                if($fileType == "image"){
                    if($fileExtension == "jpg" || $fileExtension == "jpeg" || $fileExtension == "png" || $fileExtension == "gif"){
                        $blogImgDir = "../assets/img/blog/";
                        $blogImgName = "Img_".time().rand(1,99999)."."."{$fileExtension}";
                        echo "이미지 파일이 맞습니다.";
                        $sql = "UPDATE myBlog SET blogCategory = '{$blogCate}', blogTitle = '{$blogTitle}', blogContents = '{$blogContents}', blogModTime='{$blogModTime}', blogImgFile = '{$blogImgName}', blogImgSize = '{$blogImgSize}' WHERE blogID = '{$blogID}'";
                        // echo "<pre>";
                        // var_dump($sql);
                        // echo "<pre>";
                    } else {
                        echo "<script>alert('지원하는 이미지 파일 형식이 아닙니다. jpg, png, gif 사진 파일만 지원 합니다.'); history.back(1)</script>";
                        exit;
                    }
                } else if($fileType == "" || $fileType == null){
                    echo "이미지를 첨부하지 않았습니다.";
                    $sql = "UPDATE myBlog SET blogCategory = '{$blogCate}', blogTitle = '{$blogTitle}', blogContents = '{$blogContents}', blogModTime='{$blogModTime}' WHERE blogID = '{$blogID}'";
                    // echo "<pre>";
                    // var_dump($sql);
                    // echo "<pre>";
                } else {
                    echo "<script>alert('지원하는 이미지 파일 형식이 아닙니다. jpg, png, gif 사진 파일만 지원 합니다.'); history.back(1)</script>";
                    exit;
                }
                
                $save = $connect -> query($sql);
                $save = move_uploaded_file($blogImgTmp, $blogImgDir.$blogImgName);

                // echo "<pre>";
                // var_dump($save);
                // echo "<pre>";

            } else {
                echo "<script>alert('비밀번호가 일치하지 않습니다. 다시 한번 확인해주세요!'); history.back(1)</script>";
                exit;
            }
        } else {
            echo "관리자에게 문의하세요!";
               
        }

    ?>

    <script>
        location.href = "blog.php";
    </script>
</body>
</html>