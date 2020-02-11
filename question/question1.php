<?php

    /**
     * 計算 N 層的樓梯有幾種登頂方式
     * 
     * @param integer;
     * @return integer;
     */
    function calculateClimbingStairsWay(int $n)
    {
        if ($n > 2) {
            return calculateClimbingStairsWay($n - 1) + calculateClimbingStairsWay($n - 2);
        } 
        
        return $n;
    }

    /**
     * 請輸入階梯共有 N 層
     * @inputExampleUrl: "http://localhost/question1.php?stairs=20" 
     * 
     * @param integer $stairs
     * @return integer;
     */

    echo calculateClimbingStairsWay($_GET["stairs"]);
?>
