<?php

interface ISubject{
    public function attach($obs);
    public function dettach($obs);
    public function notifyObs();
}

interface IObserver{
    public function update($subject);
}
?>