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
        <section class="join-type gray">
            <div class="member-form">
                <h3>회원 정보</h3>
                
                <div class="join-intro">
                    <?php 
                        $memberID = $_SESSION['memberID'];

                        // echo $memberID;
                        
                        $sql = "SELECT * FROM myMember WHERE memberID = {$memberID}";
                        $result = $connect -> query($sql);
                        
                        // echo "<pre>";
                        // var_dump($result);
                        // echo "</pre>";

                        if($result) {
                            $memberInfo = $result -> fetch_array(MYSQLI_ASSOC);

                            echo "<div class='face' style='background-image: url(../assets/img/mypage/{$memberInfo['youImgFile']}); background-size: cover;'></div>";
                            echo "<div class='intro'>".$memberInfo['youName']."의 자기소개 : </div>";
                            echo "<div class='intro'>".$memberInfo['youIntro']."</div>";
                        }
                    ?>
                </div>

                <div class="join-info">
                    <ul>
                        <?php
                            $memberID = $_SESSION['memberID'];

                            // echo $memberID;

                            $sql = "SELECT * FROM myMember WHERE memberID = {$memberID}";
                            $result = $connect -> query($sql);

                            // echo "<pre>";
                            // var_dump($result);
                            // echo "</pre>";

                            if($result) {
                                $memberInfo = $result -> fetch_array(MYSQLI_ASSOC);

                                echo "<li><strong>이메일</strong><span>".$memberInfo['youEmail']."</span></li>";
                                echo "<li><strong>이름</strong><span>".$memberInfo['youName']."</span></li>";
                                echo "<li><strong>비밀번호</strong><span>".$memberInfo['youPass']."</span></li>";
                                echo "<li><strong>생일</strong><span>".$memberInfo['youBirth']."</span></li>";
                                echo "<li><strong>번호</strong><span>".$memberInfo['youPhone']."</span></li>";
                            }
                        ?>
                    </ul>
                </div>

                <div class="join-btn">
                    <a href="mypageModify.php">수정하기</a>
                    <a href="../login/logout.php">로그아웃</a>
                    <a href="mypageLeave.php" onclick="if(!confirm('정말 탈퇴하시겠습니까?')) {return false;}">탈퇴하기</a>
                </div>
            </div>
        </section>
    </main>
    <!-- //main -->


    <?php include "../include/footer.php"; ?>
</body>
</html>