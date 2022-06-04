<?php
    include "../connect/connect.php";
    include "../connect/session.php";
    include "../connect/sessionCheck.php";

    $memberID = $_SESSION['memberID'];
    $memberID = $connect -> real_escape_string($memberID);
    $sql = "DELETE FROM myMember WHERE memberID = {$memberID}";
    $connect -> query($sql);
?>

<script>
    location.href = "../login/logout.php";
</script>