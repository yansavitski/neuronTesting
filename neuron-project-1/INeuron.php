<?php

/**
 * Created by PhpStorm.
 * User: savitski
 * Date: 29.08.2017
 * Time: 15:11
 */
interface INeuron
{
    public function setWeights($value);
    public function setActivationFunction(IActivationFunction $function);
    //public function educateUp();
    public function setInputData($values);
}