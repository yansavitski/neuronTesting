<?php
/**
 * Created by PhpStorm.
 * User: savitski
 * Date: 08.09.2017
 * Time: 17:18
 */

namespace NeuronLearning;


class StepLearning implements IStepLearning
{
    private $stepLearning;

    function __construct($stepLearning)
    {
        $this->stepLearning = $stepLearning;
    }

    public function getStepLearning($key = null)
    {
        return $this->stepLearning;
    }
}