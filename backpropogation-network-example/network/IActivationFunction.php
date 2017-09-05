<?php
namespace NeuronNetwork;
/**
 * Created by PhpStorm.
 * User: savitski
 * Date: 05.09.2017
 * Time: 16:20
 */
interface IActivationFunction
{
    public function calculateExit($value);
}