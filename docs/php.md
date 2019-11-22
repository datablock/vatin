# VAT Identification Number (for PHP)

VAT rates lists, syntax rules and validator by countries.


## Installation

### Composer

```
composer require datablock/vatin
```


## Getting Started

### Import

```
use Datablock\Vatin\Vatin;
```

### Instanciate

A simple instance :

```
$vatin = new Vatin();
```


### Database

Database method don't need a country definition.

Getting database as an Object :
```
$vatin->database();
```

Getting database as an Array :
```
$vatin->database(true);
```


### Country definition

Define country on instance :
```
$vatin = new Vatin("FR");
```

Define country after instance :
```
$vatin->country("FR");
```

Country definition by the `country()` method will override the country definition by the instance.


### data

Return the data for a defined country :
```
$vatin->data();
```

```
Array
(
    [label] => Array
        (
            [fr] => Array
                (
                    [longname] => Numéro de TVA intracommunautaire
                    [shortname] => N° TVA
                )

        )
    [pattern] => (?:FR)?(\d{2})(\d{9})
    [validator] => $1==12+3*($2%97)%97
    [rates] => Array
        (
            [0] => Array
                (
                    [isStandard] => 1
                    [rate] => 20
                )
            [1] => Array
                (
                    [isStandard] => 
                    [rate] => 10
                )
            [2] => Array
                (
                    [isStandard] => 
                    [rate] => 5.5
                )
            [3] => Array
                (
                    [isStandard] => 
                    [rate] => 2.1
                )
        )
)
```


### label

Getting the locale name of VAT Identification Number :
```
$vatin->label();
```
```
Numéro de TVA intracommunautaire
```

Getting the locale **_short_** name of VAT Identification Number :
```
$vatin->label(true);
```
```
N° TVA
```

Getting the locale name with language choice.  
_e.g.: For Belgium, the language can be **fr** or **nl**._
```
$vatin->label(false, "nl");
```
```
BTW identificatienummer
```

### rates

Getting rates values only :
```
$vatin->rates();
```
```
Array
(
    [0] => 20
    [1] => 10
    [2] => 5.5
    [3] => 2.1
)
```

Getting rates values and info :
```
$vatin->rates(true);
```
```
Array
(
    [0] => Array
        (
            [isStandard] => 1
            [rate] => 20
        )
    [1] => Array
        (
            [isStandard] => 
            [rate] => 10
        )
    [2] => Array
        (
            [isStandard] => 
            [rate] => 5.5
        )
    [3] => Array
        (
            [isStandard] => 
            [rate] => 2.1
        )
)
```


### standardRate

Getting standard rate only :
```
$vatin->standardRate();
```
```
20
```


### pattern

Getting the regular expression how can use to validate the VAT Identification Number :
```
$vatin->pattern()
```
```
(?:FR)?(\\d{2})(\\d{9})
```


### validator

Return true if the VAT Identification Number is valid :
```
$vatin->validator("FR32439351354"); // Valid
$vatin->validator("32439351354"); // Valid
$vatin->validator("31439351354"); // Not Valid
```

