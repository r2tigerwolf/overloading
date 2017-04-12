<?php
    /*
        Overloading in PHP provides means to dynamically "create" properties and methods. 
        These dynamic entities are processed via magic methods one can establish in a 
        class for various action types.
        __set()
        __get()
        __isset()
        __unset()
    */
    
    class Overloading
    {
        private $str;
        
        public function __set($name, $value)
        {
            echo "Setting '$name' to '$value'<br/>";
            $this->str[$name] = $value;
        }
        public function __get($name)
        {
            echo "Getting '$name'<br/>";
            return $this->str[$name];
        }
        
        public function __construct()
        {
            echo "Coming from the constructor";
        }
      
        public static function __callStatic($method_name, $parameter){
            echo "Magic method invoked while method overloading with static access<br/>";
        }
        
        public function __call($method_name , $parameter)
        {
            if($method_name == "overloadedFunction") //Function overloading logic for function name overlodedFunction
            {
                $count = count($parameter);
                switch($count)
                {
                    case "1":
                        var_dump($method_name);
                        echo "<br />";
                        var_dump($parameter);
                        break;
                    case "2": //Incase of 2 parameter
                        var_dump($method_name);
                        echo "<br />";
                        var_dump($parameter);
                        break;
                    default:
                        throw new exception("Bad argument");
                }
            }
            else
            {
                throw new exception("Function $method_name does not exists ");
            }
        }
        
        public function __isset($name){
            if(isset($this->str[$name])){
                echo "Property \$$name is set.<br/>";		
            } else {
                echo "Property \$$name is not set.<br/>";
            }
        }
        public function __unset($name){
            unset($this->str[$name]);
            echo "\$$name is unset <br/>";
        }       
    }
    
    $obj = new Overloading();
    echo "<br/><br/>";
    $obj->overloaded_property = "Using __set method";
    echo $obj->overloaded_property; // uses __get method
    echo "<br/><br/>";
    $obj->overloadedFunction("parameter1");
    echo "<br/><br/>";
    $obj->overloadedFunction("parameter1" , "parameter2");
    echo "<br/><br/>";
    $obj::overloaded_property();
    echo "<br/><br/>";
    isset($obj->overloaded_property);
    unset($obj->overloaded_property); //unset will invoke __unset method
    isset($obj->overloaded_property);
    
    /*
    Coming from the constructor

    Setting 'overloaded_property' to 'Using __set method'
    Getting 'overloaded_property'
    Using __set method
    
    string(18) "overloadedFunction" 
    array(1) { [0]=> string(10) "parameter1" } 
    
    string(18) "overloadedFunction" 
    array(2) { [0]=> string(10) "parameter1" [1]=> string(10) "parameter2" } 
    
    Magic method invoked while method overloading with static access

    Property $overloaded_property is set.
    $overloaded_property is unset 
    Property $overloaded_property is not set.
    */
?>