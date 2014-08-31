<?php

namespace nexxes\widgets\pagedef;

/**
 * @author Dennis Birkholz <dennis.birkholz@nexxes.net>
 */
class XMLImporterTest extends \PHPUnit_Framework_TestCase {
	public function testComplexPage1() {
		$importer = new XMLImporter();
		
		$this->assertEquals(
			include(__DIR__ . '/defs/ComplexPage1.php'), 
			$importer->createArrayStructure(file_get_contents(__DIR__ . '/defs/ComplexPage1.xml'))
		);
	}
	
	/**
	 * Verify that a property element must contain a name attribute
	 * 
	 * @test
	 * @expectedException \Exception
	 * @expectedExceptionMessage No attributes available but "name" attribute required for "property" tag
	 */
	public function testPropertyNameMissing1() {
		$importer = new XMLImporter();
		$importer->createArrayStructure(<<<EOF
			<page>
					<property>test</property>
			</page>
EOF
 );
	}
	
	/**
	 * Verify that a property element must contain a name attribute
	 * 
	 * @test
	 * @expectedException \Exception
	 * @expectedExceptionMessage Missing "name" attribute of "property" tag
	 */
	public function testPropertyNameMissing2() {
		$importer = new XMLImporter();
		$importer->createArrayStructure(<<<EOF
			<page>
					<property value="test" />
			</page>
EOF
 );
	}
	
	/**
	 * Empty property not allowed
	 * 
	 * @test
	 * @expectedException \Exception
	 * @expectedExceptionMessage No property value set
	 */
	public function testPropertyEmpty() {
		$importer = new XMLImporter();
		$importer->createArrayStructure(<<<EOF
			<page>
					<property name="test" />
			</page>
EOF
 );
	}
	
	/**
	 * Not allowed to use plain text and widget as a property value
	 * 
	 * @test
	 * @expectedException \Exception
	 * @expectedExceptionMessage Property should not contain both text and widgets block
	 */
	public function testPropertyTextAndWidget() {
		$importer = new XMLImporter();
		$importer->createArrayStructure(<<<EOF
			<page>
					<property name="test">
						Hello World
						<Text>
							<property name="text" value="Foobar" />
						</Text>
					</property>
			</page>
EOF
 );
	}
	
	/**
	 * Not allowed to assign multiple widgets to a property, enclose in a container instead.
	 * 
	 * @test
	 * @expectedException \Exception
	 * @expectedExceptionMessage "Can only assign a single widget to a property"
	 */
	public function testPropertyMultiWidget() {
		$importer = new XMLImporter();
		$importer->createArrayStructure(<<<EOF
			<page>
					<property name="test">
						<Text><property name="text" value="Foo" /></Text>
						<Text><property name="text" value="Bar" /></Text>
					</property>
			</page>
EOF
 );
	}
}
