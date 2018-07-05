<?php

namespace App\Classes\CToolBox;

use \DOMXPath;
use \DOMDocument;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;

/**
 * Class Scrape
 * @package Scrape
 */
class CScrapperTool {

	/**
	 * @var Client
	 */
	private $webClient;

	private $response;


	/**
	 * @var DOMDocument
	 */
	private $dom;


	/**
	 * @param $site
	 * @param int $requestTimeout
	 * @return CScrapperTool
	 */
	public static function instance( $site, $requestTimeout=3) {
		static $instance;
		if ( !$instance ) {
			$instance = new CScrapperTool( $site, $requestTimeout);
		}

		return $instance;
	}


	/**
	 * CScrapperTool constructor.
	 * @param $site
	 * @param int $requestTimeout
	 */
	public function __construct( $site, $requestTimeout = 3 ) {
		$this->webClient = new Client(
			[
				'base_uri' => $site,
				'timeout'  => $requestTimeout
			]
		);
	}


	/**
	 * Load sub page to site.
	 * E.g, '/' loads the site root page
	 * @param string $page Page to load
	 * @return $this
	 */
	public function load( $page ) {

		try {
			$this->response = $this->webClient->get( $page );
		} catch ( ConnectException $e ) {
			throw new \RuntimeException(
				$e->getHandlerContext()[ 'error' ]
			);
		}

		$this->dom = new DOMDocument;

		// Ignore errors caused by unsupported HTML5 tags
		libxml_use_internal_errors( true );
		$this->dom->loadHTML( $this->response->getBody()->getContents() );
		libxml_clear_errors();

		return $this;
	}

	public function loadFile( $file ) {

		if ( !file_exists($file) ) {
			throw new \RuntimeException('File not found:' . $file);
		}

		$this->dom = new DOMDocument;

		// Ignore errors caused by unsupported HTML5 tags
		libxml_use_internal_errors( true );
		$this->dom->loadHTML( file_get_contents( $file ) );
		libxml_clear_errors();

		return $this;
	}



	/**
	 * @return \GuzzleHttp\Psr7\Response
	 */
	public function getResponse() {
		return $this->response;
	}


	/**
	 * @return mixed
	 */
	public function getContents() {
		return $this->response->getBody()->getContents();
	}


	/**
	 * Get first nodes matching xpath query
	 * below parent node in DOM tree
	 * @param $xpath string selector to query the DOM
	 * @param $parent \DOMNode to use as query root node
	 * @return \DOMNode
	 */
	public function getNode( $xpath, $parent = null ) {
		$nodes = $this->getNodes( $xpath, $parent );

		if ( $nodes->length === 0 ) {
			throw new \RuntimeException( "No matching node found" );
		}

		return $nodes[ 0 ];
	}


	/**
	 * Get all nodes matching xpath query
	 * below parent node in DOM tree
	 * @param $xpath string selector to query the DOM
	 * @param $parent \DOMNode to use as query root node
	 * @return \DOMNodeList
	 */
	public function getNodes( $xpath, $parent = null ) {
		$DomXpath = new DOMXPath( $this->dom );
		$nodes = $DomXpath->query( $xpath, $parent );

		return $nodes;
	}

}