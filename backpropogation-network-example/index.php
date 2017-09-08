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
    '2' => 'Прятаться',
    '3' => 'Бежать',
];

$learningData = [
    [[0.5, 1, 1], 1],
    [[0.9, 1, 2], 1],
    [[0.8, 0, 1], 1],
    [[0.3, 1, 1], 2],
    [[0.6, 1, 2], 2],
    [[0.4, 0, 1], 2],
    [[0.9, 1, 7], 3],
    [[0.6, 1, 4], 3],
    [[0.1, 0, 1], 3],
    [[0.6, 1, 0], 0],
    [[1, 0, 0], 0]
];
$testLearningData = [
    [[1, 0, 1], 1],
    [[0.9, 1, 3], 2],
    [[0.3, 0, 8], 3],
    [[1, 1, 8], 3],
    [[0.1, 0, 0], 0],
]; ?>
<html>
    <head>
        <link rel="stylesheet" href="/css/bootstrap.min.css" />
    </head>
    <body>
        <div class="container text-center">
            <?php
            $networkMap = [3, 1];
            $neuronNetwork = new PerceptronNetwork($networkMap);
            $learningNetwork = new BackPropogation();
            $learningNetwork->setLayers($neuronNetwork->getLayers());
            ?>
            <h1>Сеть создана </h1></br>
            <h1>Сеть обучается </h1></br>

            <h3>Всего вопросов в эпохе: <?= count($learningData) ?></h3>
            <table class="table table-sm table-hover table-striped">
                <thead class="thead-default">
                    <tr>
                        <th>№</th>
                        <th>Неправильных ответов  в эпохе</th>
                        <th> </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $maxRepeat = 500;
                    for ($i=0; $i < $maxRepeat; $i++) :
                        $count = count($learningData);
                        $table = <<<TABLEHTML
                            <table class="table table-sm table-striped" style="
                                display: none;
                                position: absolute;
                                left: 40px;
                                right: 40px;
                                border: 2px solid;
                                width: calc(100% - 80px);">
                                <tr>
                                    <th>№</th>
                                    <th>Ответ Сети</th>
                                    <th>Правильный ответ</th>
                                </tr>

TABLEHTML;
                        foreach ($learningData as $key => $data) {
                            $outputVector = $neuronNetwork->handleData($data[0]);
                            $learningNetwork->study([($data[1] + 1) / 4]);
                            $index = ceil(($outputVector[0] * 4)) - 1;
                            if ($index == $data[1])
                                $count--;
                            $index = $index < 0 ? 0 : $index;
                            $table .= "
                                <tr " . ($index != $data[1] ? : 'class="table-success"') . ">
                                    <td>" . ($key + 1) . "</td>
                                    <td>" . OUTPUTVAL[$index] . "</td>
                                    <td>" . OUTPUTVAL[$data[1]] . "</td>
                                </tr>
                            ";


                        }
                        $table .= "</table>";
                        ?>
                        <?php if($i + 10 >= $maxRepeat) : ?>
                            <tr <?= $count != 0 ? :  'class="table-success"' ?> >
                                <td>
                                    <?= $i+1 ?>
                                </td>
                                <td>
                                    <?= $count ?>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-danger"
                                            onclick="showHideTable(this)">Подробнее</button>
                                    <?= $table ?>
                                </td>
                            </tr>
                        <?php endif;
                        if($i == ($maxRepeat-1)) {
                            $lol = 1;
                        }
                        ?>
                    <?php endfor; ?>
                </tbody>
            </table>

            <h1>Сеть вроде обучилась</h1></br>
            <h1>Запускаем тест</h1></br>

            <table class="table table-hover table-striped">
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
                        echo '<td>' . ($key+1) . '</td>';
                        echo "<td>" . OUTPUTVAL[$index] . "</td>";
                        echo "<td>" . OUTPUTVAL[$input[1]] . "</td>";
                        echo "</tr>";
                    } ?>
                </tbody>
            </table>
        </div>
        <script>
            function showHideTable(e)
            {
                var table = e.nextElementSibling;
                if (table.style.display == "none") {
                    table.style.display = 'table';
                } else {
                    table.style.display = 'none';
                }
            }
        </script>
    </body>
</html>
