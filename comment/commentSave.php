<?php
    include "../connect/connect.php";

    $youName = $_POST['youName'];
    $youText = $_POST['youText'];
    $regTime = time();

    // echo $youName, $youText, $regTime;

    $sql = "INSERT INTO myComment(youName, youText, regTime) VALUES('$youName', '$youText', '$regTime')";
    $result = $connect -> query($sql);

    if($result){
        echo "INSERT INTO True";
    } else {
        echo "INSERT INTO False";
    }

?>

<script>
    location.href = "../comment/comment.php#comment-type";
</script>