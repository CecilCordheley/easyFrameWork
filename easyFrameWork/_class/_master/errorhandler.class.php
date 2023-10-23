<?php
    class errorHandler extends Exception
    {
        // Redéfini l'exception pour que le message ne soit pas facultatif.
        public function __construct($message, $code = 0, Throwable $previous = null) {
            // du code
    
            // s'assurer que tout est correctement assigné
            parent::__construct($message, $code, $previous);
        }
    
        // Représentation personnalisée de l'objet sous forme de chaîne de caractères.
        public function __toString() {
            return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
        }
    
        public function customFunction() {
            echo "Une fonction personnalisée pour ce type d'exception\n";
        }
    }
?>