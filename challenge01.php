<?php
// php 5.4.4

    //引数で与えた配列と最大値を利用して
    //2分探索で最も高い配列添え字を返す
    function getMaxPoint($targetArr,$searchMax,$current){
    //既に比較してるものは候補に含めない
        $low = $current;
                $high = count($targetArr) -1;

                if($targetArr[$high] <= $searchMax){
                    return $high;
                }

                while (($high - $low) > 1) {
                        $mid = ceil(($low + $high) / 2);
                        if($targetArr[$mid] > $searchMax){
                                //目標値が中央添え字より小さいなら、今確認した値を最大添え字にする
                                $high = $mid;
                        } else {
                                //目標値が中央添え字と同じか大きいなら、今確認した値を最小添え字にする
                                $low = $mid;
                        }
                }
                //同じ商品同士を比較した場合、一つ低い値を返す
                if($current == $low){
                    return $high -2;
                }
                return $high-1;
    }


    //標準入力を変数に格納
    $s = trim(fgets(STDIN));
    $s = explode(" ", $s);
    //商品数
    $N = intval($s[0]);
    //日数
    $D = intval($s[1]);
    //商品価格
    $p = array();
    for ( $i = 0; $i < $N; $i++) {
        $s = trim(fgets(STDIN));
        array_push($p,intval($s));
    }
    sort($p);
    //目標価格
    $m = array();
    for ( $i = 0; $i < $D; $i++) {
        $s = intval(trim(fgets(STDIN)));
        $max = 0;
        //目標金額の最大値の添え字
        $last = getMaxPoint($p,$s);
        for( $j =0; $j < $last; $j++){
            //目標金額より低い全商品の数だけ繰り返す
            $target = $s - $p[$j];
            //足し合わせて最大になる値を取得する
            $temp = $p[$j] + $p[getMaxPoint($p,$target,$j)];

            if($temp == $s){
                $max = $temp;
                break;
            }

            if($temp < $s && $temp > $max){
                $max = $temp;
            }
        }
        echo $max . "\n";
    }


?>
