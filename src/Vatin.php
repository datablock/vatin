<?php
namespace Datablock\Vatin;

class Vatin
{
    const database = __DIR__.'/../database/database.json';

    private $_country;
    private $_data;

    public function __construct(?string $country=null)
    {
        $this->_country = $country;
        $this->_data = \file_get_contents(self::database);
    }

    public function database(bool $asArray=false)
    {
        return \json_decode($this->_data, $asArray);
    }

    public function country(string $country): self
    {
        $this->_country = $country;

        return $this;
    }

    public function data()
    {
        $database = $this->database(true);

        if (!isset($database[$this->_country])) 
        {
            return null;
        }

        return $database[$this->_country];
    }

    public function label(bool $shortname=false, string $language="en")
    {
        $data = $this->data();
        $default = "VAT Identification Number";

        if (!isset($data['label']))
        {
            return $default;
        }

        if (isset($data['label'][$language]))
        {
            $label = $data['label'][$language];
        }
        else
        {
            $label = $data['label'][array_key_first($data['label'])];
        }

        if ($shortname)
        {
            return $label['shortname'];
        }
        else
        {
            return $label['longname'];
        }
    }

    public function rates(bool $withInfo=false): array
    {
        $rates = [];
        $data = $this->data();

        if (!isset($data['rates']))
        {
            return [];
        }

        foreach ($data['rates'] as $value)
        {
            if ($withInfo)
            {
                array_push($rates, $value);
            }
            else
            {
                array_push($rates, $value['rate']);
            }
        }

        return $rates;
    }

    public function standardRate()
    {
        $rates = $this->rates(true);

        foreach ($rates as $value)
        {
            if ($value['isStandard']) 
            {
                return $value['rate'];
            }
        }

        return null;
    }

    public function pattern()
    {
        $data = $this->data();

        if (!isset($data['pattern']))
        {
            return null;
        }

        return $data['pattern'];
    }

    public function validator()
    {
        $data = $this->data();

        if (!isset($data['validator']))
        {
            return null;
        }

        return $data['validator'];
    }

    public function isValid(string $value)
    {
        $validator = false;
        $pattern = null;
        $data = $this->data();

        // Get Validator exeption
        if (isset($data['validator']))
        {
            $validator = $data['validator'];
        }

        // Get Pattern
        if (isset($data['pattern']))
        {
            $pattern = $data['pattern'];
        }

        // Check Pattern
        if ($pattern == null)
        {
            return false;
        }

        // Define the pattern Regex
        $regex = "/^".$pattern."$/";

        // Check VAT number syntax by pattern
        $syntax = \preg_match($regex, $value, $sections) ? true : false;

        if ($validator)
        {
            $validator = preg_replace_callback(
                "/\\$([0-9])/is", 
                function($m) use($sections) { return $sections[$m[1]]; }, 
                $validator
            );

            return eval("return $validator;");            
        }

        return $syntax;
    }
}