<?php
use NeuronNetwork;
use NeuronNetwork\PerceptronNetwork;
use NeuronLearning\BackPropogation;
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

for ($i=0; $i < 10000; $i++) {
    foreach ($learningData as $data) {
        $neuronNetwork->handleData($data[0]);
        $learningNetwork->study();
    }
}




?>