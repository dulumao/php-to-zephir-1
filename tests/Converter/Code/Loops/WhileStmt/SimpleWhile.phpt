--TEST--
Test continue stmt
--DESCRIPTION--
Lowlevel basic test
--FILE--
<?php

require __DIR__ . '/../../../../Bootstrap.php';

use PhpToZephir\EngineFactory;
use PhpToZephir\Logger;
use Symfony\Component\Console\Output\NullOutput;
use PhpToZephir\Render\StringRender;
use PhpToZephir\CodeCollector\StringCodeCollector;

$engine = EngineFactory::getInstance(new Logger(new NullOutput(), false));
$code   = <<<'EOT'
<?php
namespace Code\Loops\WhileStmt;

class SimpleWhile
{
    public function test()
    {
        while (true) {
            break;
        }
    }

    public function whileWithAssign()
    {
        $pos = 0;
        $input = 'mySuperString';

        while (($pos = strpos($input, '@', $pos)) !== false) {
			echo $pos;
        }
    }
}
EOT;
$render = new StringRender();
$codeValidator = new PhpToZephir\CodeValidator();

foreach ($engine->convert(new StringCodeCollector(array($code))) as $file) {
	$zephir = $render->render($file);
	$codeValidator->isValid($zephir);
	echo $zephir;
}

?>
--EXPECT--
namespace Code\Loops\WhileStmt;

class SimpleWhile
{
    public function test() -> void
    {
        
        while (true) {
            break;
        
        }
    }
    
    public function whileWithAssign() -> void
    {
        var pos, input;
    
        let pos = 0;
        let input = "mySuperString";
        let pos =  strpos(input, "@", pos);
        while (pos !== false) {
            echo pos;
        let pos =  strpos(input, "@", pos);
        }
    }

}