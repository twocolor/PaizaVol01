<?php
// php 5.4.4

    /**
     * 引数で与えた配列と目標値を利用して2分探索で最も高い配列添え字を返す
     * @param targetArr 探索対象の配列
     * @param searchMax 目標値。これより値が低い中から最も値が高い配列添字を探す
     * @param current 現在の配列添字。ここよりも値が高くなる添字を対象とする
     * @return targetArrの添字
     */
    function getMaxIndex($targetArr, $searchMax, $current = 0){
        // 探索対象の最小添字
        $low = $current;
        $high = count($targetArr) - 1;
        if($targetArr[$high] <= $searchMax){
            return $high;
        }
        while (($high - $low) > 1) {
                $mid = ceil(($low + $high) / 2);
                if($targetArr[$mid] > $searchMax){
                        //目標値が中央添え字より低いなら、今確認した値を最大添え字にする
                        $high = $mid;
                } else {
                        //目標値が中央添え字と同じか高いなら、今確認した値を最小添え字にする
                        $low = $mid;
                }
        }
        //同じ商品同士を比較した場合、一つ低い値を返す
        if($current == $low){
            return $high - 2;
        }
        return $high - 1;
    }

    // 標準入力から今回のキャンペーンに関する情報を取得
    $input = trim(fgets(STDIN));
    $input = explode(" ", $input);
    // 全商品数
    $N = intval($input[0]);
    // キャンペーン日数
    $D = intval($input[1]);
    // 商品価格の配列
    $p = array();
    for ( $i = 0; $i < $N; $i++) {
        $input = trim(fgets(STDIN));
        array_push($p, intval($input));
    }
    sort($p);

    // 目標価格（$N, $D, $p, $mという変数名は問題に準拠してつけた）
    $m = array();
    for ($i = 0; $i < $D; $i++) {
        // 目標金額の値をひとつずつ取得する
        $m = intval(trim(fgets(STDIN)));
        // 目標金額に最も近い組み合わせ金額
        $max = 0;
        // 目標金額に最も近い商品価格の添え字
        $lastIndex = getMaxIndex($p, $m);
        // 目標金額より低い全商品の数だけ繰り返す（処理回数を減らすため）
        for($j =0; $j < $lastIndex; $j++) {
            $target = $m - $p[$j];
            $sum = $p[$j] + $p[getMaxIndex($p, $target, $j)];
            if($sum == $m){
                $max = $sum;
                break;
            }
            if($sum < $m && $sum > $max){
                $max = $sum;
            }
        }
        echo $max . "\n";
    }


?>
