<?php
namespace NeuronNetwork;
/**
 * Created by PhpStorm.
 * User: savitski
 * Date: 05.09.2017
 * Time: 16:20
 */
class SigmoidFunction implements IActivationFunction
{
    public function calculateExit($value)
    {
        return 1 / (1 + exp( - $value));
    }
}