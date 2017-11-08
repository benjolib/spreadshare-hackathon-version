# Add a new Volt function

To add a new function, create a FunctioName.php file within this directory and add a static parse method:

````
public static function parse($text)
{
    return preg_replace('/(?<=\s|^)@(\S+)/', '<a href="/user/$1">$0</a>', $text);
}
````

Then add this function to Volt/VoltAdapter.php:

````
$compiler->addFunction(
    'parseUser',
    function ($key) {
        return "\\DS\\Component\\View\\Functions\\FunctionName::parse({$key})";
    }
);
````