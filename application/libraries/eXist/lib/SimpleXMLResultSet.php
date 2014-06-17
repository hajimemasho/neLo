<?php
//namespace ExistDB;
class CI_SimpleXMLResultSet extends CI_ResultSet
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
		$doc = simplexml_load_string($result->scalar);
		return $doc;
	}
	
	public function current()
	{
		$doc = simplexml_load_string($this->retrieve()->scalar);
		return $doc;
	}
}