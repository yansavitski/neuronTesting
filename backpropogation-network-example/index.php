<?php
use NeuronNetwork\PerceptronNetwork;
use NeuronLearning\BackPropogation;

requireAllFilesFromFolder('interfaces');
requireAllFilesFromFolder('network');
requireAllFilesFromFolder('backpropogation-learning');
//require "\\interfaces\\INeuronNetwork.php";
//require "\\network\\PerceptronNetwork.php";
function requireAllFilesFromFolder($name)
{
    foreach (scandir(__DIR__."\\$name") as $filename) {
        $path = __DIR__."\\$name" . '/' . $filename;
        if (is_file($path)) {
            require $path;
        }
    }
}

/**
 * Created by PhpStorm.
 * User: yansa
 * Date: 06.09.2017
 * Time: 0:30
 */
CONST OUTPUTVAL = [
    '0' => 'Ничего не делать',
    '1' => 'Атаковать',
    '2' => 'Бежать',
    '3' => 'Прятаться'
];

$learningData = [
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
    [[1, 0, 0], 0]
];
$testLearningData = [
    [[1, 0, 1], 1],
    [[0.9, 1, 3], 3],
    [[0.3, 0, 8], 2],
    [[1, 1, 8], 2],
    [[0.1, 0, 0], 0],
];

$networkMap = [3, 1];
$neuronNetwork = new PerceptronNetwork($networkMap);
$learningNetwork = new BackPropogation();
$learningNetwork->setLayers($neuronNetwork->getLayers());
echo "<h1>Сеть создана </h1></br>";
echo "<h1>Сеть обучается </h1></br>";

for ($i=0; $i < 100; $i++) {
    foreach ($learningData as $data) {
        $neuronNetwork->handleData($data[0]);
        $learningNetwork->study(($data[1] + 1) / 4);
    }
}

echo "<h1>Сеть вроде обучилась</h1></br>";
echo "<h1>Запускаем тест</h1></br>";

foreach($testLearningData as $input) {
    $output = $neuronNetwork->handleData($input[0]);
    $index = ceil(($output[0] * 4)) - 1;
    $index = $index < 0 ? 0 : $index;
    echo "Сеть считает что ответ: ".OUTPUTVAL[$index]. "</br>";
    echo "Правильный ответ: ".OUTPUTVAL[$input[1]] . "</br>";
}




?>