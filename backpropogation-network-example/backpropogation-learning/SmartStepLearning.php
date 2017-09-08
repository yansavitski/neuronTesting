<?php
/**
 * Created by PhpStorm.
 * User: savitski
 * Date: 08.09.2017
 * Time: 17:12
 */

namespace NeuronLearning;


class SmartStepLearning
{
    private $stepLearning;
    private $firstStep;

    function __construct($stepLearning, $firstStep)
    {
        $this->firstStep = $firstStep;
        $this->stepLearning = $stepLearning;
    }

    public function getStepLearning($epoch)
    {
        // y(x) = k/x + b;
        return $this->firstStep/$epoch + $this->stepLearning;
    }

}