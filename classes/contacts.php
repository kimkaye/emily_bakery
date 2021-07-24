<?php
class Contacts
{
    public $id;
    public $name;
    public $email;
    public $message;

    public function __get($property){
        if (property_exists($this,$property))
            return $this->$property;
    }
    public function get_id()
    {
        return $this->id;
    }
    private function has_attribute($attribute){
        $object_properties=get_object_vars($this);
        return array_key_exists($attribute,$object_properties);
    }
    private function  instantation($user_array){
        foreach ($user_array as $attribute=>$value){
            if ($result=$this->has_attribute($attribute))
                $this->$attribute=$value;
        }
    }
    public static function add_contact($name,$email,$message){
        global $database;
        $error=null;
        $sql="INSERT INTO contacts(name, email, message ) VALUES ('$name', '$email', '$message')";
        $result=$database->query($sql);
        if (!$result)
            $error='Can not add contact.  Error is:'. $database->get_connection()->error;
        return $error;
    }
}