<?php
//namespace ExistDB;
class CI_DOMResultSet extends CI_ResultSet
{
	function init($client, $resultId, $options)
	{
		parent::init($client, $resultId, $options);
	}
	
	public function getNextResult()
	{
		$result = $this->client->retrieve(
				$this->resultId,
				$this->currentHit,
				$this->options
		);
		
		$this->currentHit++;
		$this->hasMoreHits = $this->currentHit < $this->hits;
		
		$doc = new \DOMDocument();
		$doc->loadXML($result->scalar);
		return $doc;
	}

	public function current()
	{
		$doc = new \DOMDocument();
		$doc->loadXML($this->retrieve());
		return $doc;
	}
}