<?php

class Calcul {

    public $montant;
    public $tva;
    public $montant_ttc;
    public $montant_ht;

    public function ttc($montant, $tva) {
        $this->montant = $montant * (($tva/100) +1);
        return $this->montant;
    }

    public function ht($montant, $tva) {
        $this->montant = $montant / (($tva/100) +1);
        return $this->montant;
    }

    public function tva($montant_ttc, $montant_ht) {
        $this->montant = $montant_ttc - $montant_ht;
        return $this->montant;
    }

}

