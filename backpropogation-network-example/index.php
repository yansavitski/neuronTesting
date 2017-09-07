<?php
use NeuronNetwork\PerceptronNetwork;
use NeuronLearning\BackPropogation;

requireAllFilesFromFolder('interfaces');
require_once "\\network\\Neuron.php";
require_once "\\network\\NeuronLayer.php";
require_once "\\network\\FirstLayer.php";
requireAllFilesFromFolder('network');
requireAllFilesFromFolder('backpropogation-learning');

function requireAllFilesFromFolder($name)
{
    foreach (scandir(__DIR__."\\$name") as $filename) {
        $path = __DIR__."\\$name" . '/' . $filename;
        if (is_file($path)) {
            require_once $path;
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
]; ?>
<html>
    <head>
        <link rel="stylesheet" href="/css/bootstrap.min.css" />
    </head>
    <body>
        <div class="container text-center">
            <?php
            $networkMap = [3, 3, 1];
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
            ?>
            <table class="table table-hover">
                <thead class="thead-default">
                    <tr>
                        <th>№</th>
                        <th>Ответ Сети</th>
                        <th>Правильный ответ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach($testLearningData as $key => $input) {
                        $output = $neuronNetwork->handleData($input[0]);
                        $index = ceil(($output[0] * 4)) - 1;
                        $index = $index < 0 ? 0 : $index;
                        echo '<tr class="' . ($index == $input[1] ? 'table-success' : 'table-danger') . '">';
                        echo "<td>$key</td>";
                        echo "<td>" . OUTPUTVAL[$index] . "</td>";
                        echo "<td>" . OUTPUTVAL[$input[1]] . "</td>";
                        echo "</tr>";
                    } ?>
                </tbody>
            </table>
        </div>
    </body>
</html>
