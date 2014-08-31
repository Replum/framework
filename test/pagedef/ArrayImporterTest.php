<?php

namespace nexxes\widgets\pagedef;

use \nexxes\widgets\PageTraitMock;
use \nexxes\widgets\WidgetContainer;
use \nexxes\widgets\html\Text;

/**
 * @author Dennis Birkholz <dennis.birkholz@nexxes.net>
 * @coversDefaultClass \nexxes\widgets\pagedef\ArrayImporter
 */
class ArrayImporterTest extends \PHPUnit_Framework_TestCase {
	/**
	 * Create a very simple widget structure and verify that the generated codes evaluates without syntax errors
	 * 
	 * @covers ::generateWidgetInitialization
	 * @test
	 */
	public function testSimpleWidgetStructure() {
		$text = 'This is just some lirum larum text, bla blubb whatever.';
		$widgetStructure = [
			'class' => Text::class,
			'properties' => [
				'type' => 'p',
				'text' => $text,
			],
		];
		
		$page = new PageTraitMock();
		$generatedCode = (new ArrayImporter())->generateWidgetInitialization(['page'], 'child0', $widgetStructure);
		eval($generatedCode);
		
		$this->assertSame($page, $page_child0->getParent());
		$this->assertSame($page, $page_child0->getPage());
		$this->assertSame($text, $page_child0->getText());
		$this->assertSame('p', $page_child0->getType());
	}
	
	/**
	 * Create a complex structure with nesting and test it
	 * 
	 * @covers ::generateWidgetInitialization
	 * @test
	 */
	public function testComplexWidgetStructure() {
		$text1 = 'This is the main content';
		$text2 = 'This is just some lirum larum text, bla blubb whatever.';
		$class1 = 'col-lg-9';
		
		$widgetStructure = [
			'class' => WidgetContainer::class,
			'properties' => [
				'class' => $class1,
			],
			'children' => [
				[
					'class' => Text::class,
					'properties' => [
						'type' => 'h1',
						'text' => $text1,
					],
				],
				[
					'class' => Text::class,
					'properties' => [
						'type' => 'h2',
						'text' => $text2,
					],
				],
			],
		];
		
		$page = new PageTraitMock();
		$generatedCode = (new ArrayImporter())->generateWidgetInitialization(['page'], 'child0', $widgetStructure);
		eval($generatedCode);
		
		$this->assertInstanceOf(WidgetContainer::class, $page_child0);
		$this->assertSame($page, $page_child0->getParent());
		$this->assertSame($page, $page_child0->getPage());
		$this->assertTrue($page_child0->hasClass($class1));
		
		$textWidget1 = $page_child0[0];
		$this->assertInstanceOf(Text::class, $textWidget1);
		$this->assertSame($text1, $textWidget1->getText());
		$this->assertSame('h1', $textWidget1->getType());
		
		$textWidget2 = $page_child0[1];
		$this->assertInstanceOf(Text::class, $textWidget2);
		$this->assertSame($text2, $textWidget2->getText());
		$this->assertSame('h2', $textWidget2->getType());
	}
	
	/**
	 * Test a complete page structure
	 * 
	 * @covers ::run
	 * @covers ::generateWidgetInitialization
	 * @test
	 */
	public function testPageStructure() {
		$pageStructure = include(__DIR__ . '/defs/ComplexPage1.php');
		
		$text1 = $pageStructure['children'][0]['children'][0]['children'][0]['properties']['text'];
		$text2 = $pageStructure['children'][0]['children'][1]['children'][0]['properties']['text'];
		$text3 = $pageStructure['children'][0]['children'][1]['children'][1]['properties']['text'];
		
		$class1 = $pageStructure['children'][0]['properties']['class'];
		$class2 = $pageStructure['children'][0]['children'][0]['properties']['class'];
		$class3 = $pageStructure['children'][0]['children'][1]['properties']['class'];
		
		$page = new PageTraitMock();
		$importer = new ArrayImporter([
			'\\nexxes\\widgets\\bootstrap',
			'\\nexxes\\widgets\\html',
			'\\nexxes\\widgets',
		]);
		$initializer = $importer->import($page, $pageStructure);
		$func = eval($initializer);
		$func($page);
		
		$this->assertInstanceOf(WidgetContainer::class, $page[0]);
		$this->assertTrue($page[0]->hasClass($class1));
		
		$this->assertInstanceOf(WidgetContainer::class, $page[0][0]);
		$this->assertTrue($page[0][0]->hasClass($class2));
		
		$this->assertInstanceOf(Text::class, $page[0][0][0]);
		$this->assertSame($text1, $page[0][0][0]->getText());
		
		$this->assertInstanceOf(WidgetContainer::class, $page[0][1]);
		$this->assertTrue($page[0][1]->hasClass($class3));
		
		$this->assertInstanceOf(Text::class, $page[0][1][0]);
		$this->assertSame($text2, $page[0][1][0]->getText());
		
		$this->assertInstanceOf(Text::class, $page[0][1][1]);
		$this->assertSame($text3, $page[0][1][1]->getText());
	}
	
	/**
	 * Verify a widget that does not implement WidgetContainerInterface can not have a 'children' definition
	 * 
	 * @covers ::generateWidgetInitialization
	 * @test
	 * @expectedException \RuntimeException
	 */
	public function testInvalidChildren() {
		$initializer = new ArrayImporter();
		
		$widgetStructure = [
			'class' => WidgetTraitMock::class,
			'children' => [
			],
		];
		
		$initializer->generateWidgetInitialization([], 'widget', $widgetStructure);
	}
	
	/**
	 * Verify a widget that does not implement WidgetCompositeInterface can not have a 'slots' definition
	 * 
	 * @covers ::generateWidgetInitialization
	 * @test
	 * @expectedException \RuntimeException
	 */
	public function testInvalidSlot() {
		$initializer = new ArrayImporter();
		
		$widgetStructure = [
			'class' => WidgetTraitMock::class,
			'slots' => [
			],
		];
		
		$initializer->generateWidgetInitialization([], 'widget', $widgetStructure);
	}
}
