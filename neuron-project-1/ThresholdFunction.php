<?php

/**
 * Created by PhpStorm.
 * User: savitski
 * Date: 29.08.2017
 * Time: 15:31
 */
include("IActivationFunction.php");
class ThresholdFunction implements IActivationFunction
{

    public function calculateExit($value)
    {
        //echo $value. " </br>";
        return 1/(1+exp(-$value));
        //return $value;
    }
}