<?php
/**
 * Created by PhpStorm.
 * User: savitski
 * Date: 29.08.2017
 * Time: 18:35
 */
include("NeuronNetwork.php");
$arr = [
    [[0.5, 1, 1], 1],
    [[0.9, 1, 2], 1],
    [[0.8, 0, 1], 1],
    [[0.3, 1, 1], 3],
    [[0.6, 1, 2], 3],
    [[0.4, 0, 1], 3],
    [[0.9, 1, 7], 2],
    [[0.6, 1, 4], 2],
    [[0.1, 0, 1], 2],
    [[0.6, 1, 0], 0],
    [[1, 0, 0], 0],
    //[[0.09, 0, 0], 0],
];
$test_arr = [
    [[1, 0, 1], 1],
    [[0.9, 1, 3], 3],
    [[0.3, 0, 8], 2],
    [[1, 1, 8], 2],
    [[0.1, 0, 0], 0],
];
printf($arr);
echo "Данные для обучения </br>";
$network = new NeuronNetwork();
$network->creteNetwork();
 echo "Сеть создана </br>";
study($network, $arr);

echo "<h1>Сеть вроде обучилась</h1></br>";
echo "<h1>Запускаем тест</h1></br>";
test($network, $test_arr);

function test($network, $arr) {
    foreach($arr as $input) {
        $output = $network->transfer($input[0]);
        $indexAnswerNetwork = array_keys($output, max($output))[0];
        echo "Сеть считает что ответ: ".NeuronNetwork::OUTPUTVAL[$indexAnswerNetwork]. "</br>";
        echo "Правильный ответ: ".NeuronNetwork::OUTPUTVAL[$input[1]] . "</br>";
    }
}

function study($network, $arr) {
    for($i=0; $i < 10000; $i++) {
        $true_count = 0;
        $else_count = 0;
        foreach ($arr as $data) {
            $answer = $network->study($data[1], $data[0]);
            if($answer == true) {
                $true_count++;
            } else {
                $else_count++;
            }
        }
        //echo "Праивльно отгаданно $true_count</br>";
       // echo "Неверных ответов $else_count</br>";
        //echo "Цикл $i завершен</br>";
    }
    echo "End";
}
