<?php

namespace twhiston\simplexml_debug\tests;

require_once __DIR__.'/SxmlTestBase.php';

use twhiston\simplexml_debug\SxmlDebug;

class DumpTest extends SxmlTestBase {

  protected $expected;

  protected $expected_default_NS;

  protected $expected_named_NS;

  public function setUp() {
    $this->expected = "SimpleXML object (1 item)
[
	Element {
		Name: 'movies'
		String Content: '
				
			'
		Content in Default Namespace
			Children: 1 - 1 'movie'
			Attributes: 0
	}
]
";

    $this->expected_default_NS = "SimpleXML object (1 item)
[
	Element {
		Namespace: 'https://github.com/IMSoP/simplexml_debug'
		(Default Namespace)
		Name: 'movies'
		String Content: '
				
			'
		Content in Default Namespace
			Namespace URI: 'https://github.com/IMSoP/simplexml_debug'
			Children: 1 - 1 'movie'
			Attributes: 0
	}
]
";

    $this->expected_named_NS = "SimpleXML object (1 item)
[
	Element {
		Name: 'movies'
		String Content: '
				
			'
		Content in Namespace test
			Namespace URI: 'https://github.com/IMSoP/simplexml_debug'
			Children: 1 - 1 'movie'
			Attributes: 0
	}
]
";

    parent::setUp();
  }

  public function testDumpReturn() {
    $return = SxmlDebug::dump($this->simpleXML);
    $this->assertEquals($this->expected, $return);
  }

  public function testDumpWithDefaultNS() {
    $return = SxmlDebug::dump($this->simpleXML_default_NS);
    $this->assertEquals($this->expected_default_NS, $return);
  }

  public function testDumpWithNamedNS() {
    $return = SxmlDebug::dump($this->simpleXML_named_NS);
    $this->assertEquals($this->expected_named_NS, $return);
  }

  public function testDumpAttributeWithNamedNS() {
    $xml = '<parent xmlns:ns="ns"><ns:child ns:foo="bar" /></parent>';
    $sxml = simplexml_load_string($xml);

    $return = SxmlDebug::dump($sxml->children('ns',
                                              TRUE)->child->attributes('ns'));

    $expected = "SimpleXML object (1 item)
[
	Attribute {
		Namespace: 'ns'
		Namespace Alias: 'ns'
		Name: 'foo'
		Value: 'bar'
	}
]
";

    $this->assertEquals($expected, $return);
  }

  public function testDumpMultipleAttributes() {
    $xml = '<parent xmlns:ns="ns"><child ns:one="1" ns:two="2" ns:three="3" /></parent>';
    $sxml = simplexml_load_string($xml);

    $return = SxmlDebug::dump($sxml->child);

    $expected = "SimpleXML object (1 item)
[
	Element {
		Namespace: 'ns'
		Namespace Alias: 'ns'
		Name: 'child'
		String Content: ''
		Content in Namespace ns
			Namespace URI: 'ns'
			Children: 0
			Attributes: 3 - 'one', 'two', 'three'
	}
]
";

    $this->assertEquals($expected, $return);
  }
}

?>
