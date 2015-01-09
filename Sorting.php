<?php
/**
 * Created by PhpStorm.
 * User: Howard Wu
 * Date: 2014/12/15
 * Time: 下午 02:36
 * 各種排序法實做
 */

class Sorting {

    function Sorting() {
        // constructor...
    }

    // Bubble Sort
    // stable(同值順序維持)
    // array 做法
    public static function bubbleSort( $arr ) {

        $flag = true;
        for( $i = 0; $i < sizeof($arr)-1 AND $flag ; $i++ ) {

            //$this->output($arr);      // 可得知排序過程

            $flag = false;
            for( $j = 0; $j < sizeof($arr)-1 ; $j++ ) {

                if ( $arr[$j] > $arr[$j+1] ) {
                    Sorting::swap($arr, $j, $j+1);
                    $flag = true;
                }
            }
        }

        return $arr;
    }

    // Heap Sort
    // unstable
    // array 做法
    public static function heapSort( $arr ) {

        // 父結點 最多到 陣列長度的一半
        for( $i = floor(count($arr)/2)-1;$i >= 0;$i-- ) {
            Sorting::heapify($arr, $i, count($arr));
        }

        // Sort
        // 從最後一個結點開始做對調排序
        for( $i = count($arr) - 1;$i > 0;$i-- ) {
            Sorting::swap($arr, 0, $i);
            Sorting::heapify($arr, 0, $i);
        }

        return $arr;
    }
    public static function heapify( &$arr, $rootIndex, $length ) {

        //Sorting::outputBinaryTree($arr);      // 可取得二元樹調整過程

        $leftIndex = $rootIndex * 2 + 1;
        $rightIndex = $rootIndex * 2 + 2;

        // 判斷 root, left child, right child 最大值
        if ( $leftIndex < $length AND $arr[$leftIndex] > $arr[$rootIndex] ) {
            $maxIndex = $leftIndex;
        } else {
            $maxIndex = $rootIndex;
        }

        if ( $rightIndex < $length AND $arr[$rightIndex] > $arr[$maxIndex] ) {
            $maxIndex = $rightIndex;
        }

        // 做swap & heapify
        // 最大值不是 root 才有需要 swap and heapify
        if ( $maxIndex != $rootIndex ) {
            Sorting::swap($arr, $maxIndex, $rootIndex);
            Sorting::heapify($arr, $maxIndex, $length);
        }
    }


    // Merge Sort
    // 使用 SplQueue
    // recursive 做法
    public static function mergeSort( $queue ) {

        // recursive 終止
        if ( $queue->count() == 1 ) {
            return $queue;
        }

        // Depart Queue's first and second half
        $left = new SplQueue();
        $right = new SplQueue();
        $listCount = $queue->count();
        $halfCount = $listCount / 2;

        $i = 0;
        while($queue->count() > 0) {
            if ( $i < $halfCount ) {
                // left Queue
                $left->enqueue($queue->dequeue());
            } else {
                // right Queue
                $right->enqueue($queue->dequeue());
            }

            $i++;
        }

        return Sorting::merge(Sorting::mergeSort($left), Sorting::mergeSort($right));
    }
    // 負責合併, 且排序
    private static function merge($left, $right) {

        $result = new SplQueue();

        // 2個 queue 比較大小
        while ( $left->count() > 0 AND $right->count() > 0 ) {
            if ( $left->offsetGet(0) < $right->offsetGet(0)) {
                $result->enqueue($left->dequeue());
            } else {
                $result->enqueue($right->dequeue());
            }
        }

        // 剩餘沒得比較的
        while( $left->count() > 0 ) {
            $result->enqueue($left->dequeue());
        }
        while( $right->count() > 0 ) {
            $result->enqueue($right->dequeue());
        }
        return $result;
    }


    // array swap
    private static function swap(&$arr, $i, $j) {
        $tmp = $arr[$i];
        $arr[$i] = $arr[$j];
        $arr[$j] = $tmp;
    }


    // 展列array
    public static function outputArr( $arr ) {
        echo '<pre>';
        print_r($arr);
        echo '</pre>';
        echo '<br/>';
    }

    // queue展列
    public static function outputQueue( SplQueue $queue ) {
        while ( $queue->count() > 0 ) {
            echo $queue->dequeue() . '<br/>';
        }
        echo '//======================//<br/>';
    }

    // Print array in Binary Tree Type (二元樹)
    public static function outputBinaryTree( $arr) {
        $lastRoot = -1;
        foreach( $arr AS $index => $val ) {

            echo '|' . $val . '|';

            if ( ($index == ($lastRoot * 2) + 2) OR $lastRoot == -1) {
                echo '<br/>';
                $lastRoot = $index;
            }
        }
        echo '<br/>//==========//<br/>';
    }
}